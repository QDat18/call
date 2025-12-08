<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http; // ✅ Import chuẩn

class DonationController extends Controller
{
    /**
     * Hiển thị trang chi tiết chiến dịch và form quyên góp.
     */
    public function show($id)
    {
        $campaign = DonationCampaign::findOrFail($id);

        // Lấy danh sách người quyên góp thành công gần đây
        $recentDonations = $campaign->donations()
            ->where('status', 'Success')
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('campaigns.show', compact('campaign', 'recentDonations'));
    }

    /**
     * Tạo giao dịch MoMo và chuyển hướng người dùng.
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'campaign_id' => 'required|exists:donation_campaigns,id',
            'message' => 'nullable|string|max:255',
        ]);

        $campaign = DonationCampaign::findOrFail($request->campaign_id);

        // Kiểm tra chiến dịch còn active không
        if ($campaign->status != 'Active' || $campaign->end_date < now()) {
            return redirect()->back()->with('error', 'Chiến dịch này đã kết thúc hoặc không còn hoạt động.');
        }

        // 1. Tạo giao dịch 'Pending'
        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'user_id'     => auth()->id(),
            'amount'      => $request->amount,
            'message'     => $request->message ?? 'Ung ho chien dich',
            'status'      => 'Pending',
        ]);

        // 2. Cấu hình momo từ config (Đã tạo file config/momo.php)
        $endpoint = config('momo.endpoint');
        $partnerCode = config('momo.partner_code');
        $accessKey = config('momo.access_key');
        $secretKey = config('momo.secret_key');

        // Kiểm tra config
        if (empty($partnerCode) || empty($secretKey) || empty($accessKey)) {
            Log::error('MoMo config missing', ['partnerCode' => $partnerCode]);
            return redirect()->back()->with('error', 'Cấu hình MoMo chưa đầy đủ. Vui lòng liên hệ quản trị viên.');
        }

        // 3. Chuẩn bị dữ liệu
        $requestId = (string) Str::uuid();
        $orderId = $donation->id . '_' . time(); // ID_Time để đảm bảo unique
        $amount = (string)$request->amount;
        $orderInfo = "Ung ho Campaign " . $campaign->id;

        // Route callback
        $redirectUrl = route('donation.momoReturn');
        $ipnUrl = route('donation.momoIpn');

        $extraData = "";
        $requestType = "captureWallet";

        // 4. Tạo chữ ký (Signature) - BẮT BUỘC ĐÚNG THỨ TỰ A-Z
        $rawHash = "accessKey=" . $accessKey .
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl .
            "&requestId=" . $requestId .
            "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Volunteer Connect",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        // try {
        //     $response = Http::post($endpoint, $data);
        //     $json = $response->json();

        //     // Nếu thành công, MoMo trả về payUrl
        //     if (isset($json['payUrl'])) {
        //         return redirect($json['payUrl']);
        //     } else {
        //         Log::error('MoMo Create Error', $json);
        //         return back()->with('error', $json['message'] ?? 'Lỗi tạo giao dịch MoMo: ' . json_encode($json));
        //     }
        // } catch (\Exception $e) {
        //     Log::error('MoMo Exception: ' . $e->getMessage());
        //     return back()->with('error', 'Lỗi kết nối: ' . $e->getMessage());
        // }
        return view('campaigns.fake_momo', [
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo
        ]);
    }

    /**
     * Xử lý kết quả trả về từ MoMo (Redirect Back)
     */
    public function momoReturn(Request $request)
    {
        // resultCode = 0 là thành công
        if ($request->resultCode == '0') {
            // Tách ID thật từ orderId (format: ID_Time)
            $parts = explode('_', $request->orderId);
            $donationId = $parts[0];

            $donation = Donation::find($donationId);
            if ($donation && $donation->status == 'Pending') {
                $donation->update(['status' => 'Success']);
                $donation->campaign->increment('current_amount', $donation->amount);
            }

            return redirect()->route('campaigns.show', $donation->campaign_id)
                ->with('success', 'Thanh toán thành công! Cảm ơn bạn.');
        }

        return redirect('/')->with('error', 'Giao dịch thất bại: ' . $request->message);
    }

    /**
     * IPN (Webhook) - Server gọi Server
     */
    public function momoIpn(Request $request)
    {
        // Kiểm tra kết quả
        if ($request->resultCode == '0') {
            $parts = explode('_', $request->orderId);
            $donationId = $parts[0];
            $donation = Donation::find($donationId);

            if ($donation && $donation->status == 'Pending') {
                $donation->update(['status' => 'Success']);
                $donation->campaign->increment('current_amount', $donation->amount);
            }
        }
        return response()->json(['message' => 'IPN Received'], 204);
    }
}
