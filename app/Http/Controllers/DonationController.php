<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\User;
use App\Jobs\SendNotificationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    /**
     * Hiển thị trang chi tiết chiến dịch và form quyên góp.
     */
    public function show($id)
    {
        $campaign = DonationCampaign::findOrFail($id);

        $recentDonations = $campaign->donations()
            ->where('status', 'Success')
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('campaigns.show', compact('campaign', 'recentDonations'));
    }

    /**
     * Tạo giao dịch VNPay và chuyển hướng người dùng.
     */
    /**
     * Tạo giao dịch VNPay và chuyển hướng người dùng.
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:5000',
            'campaign_id' => 'required|exists:donation_campaigns,id',
            'message' => 'nullable|string|max:255',
        ]);

        $campaign = DonationCampaign::findOrFail($request->campaign_id);

        if ($campaign->status != 'Active' || $campaign->end_date < now()) {
            return redirect()->back()->with('error', 'Chiến dịch này đã kết thúc hoặc không còn hoạt động.');
        }

        // 1. Tạo giao dịch 'Pending'
        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'user_id'     => auth()->id(),
            'amount'      => $request->amount,
            'message'     => $request->message ?? 'Ung ho',
            'status'      => 'Pending',
        ]);

        // 2. Cấu hình VNPay
        $vnp_TmnCode = config('vnpay.tmn_code');
        $vnp_HashSecret = config('vnpay.hash_secret');
        $vnp_Url = config('vnpay.url');
        $vnp_Returnurl = route('donation.vnpayReturn');

        // 3. Chuẩn bị dữ liệu
        $vnp_TxnRef = $donation->id; // Chỉ dùng ID làm mã đơn hàng cho gọn

        // Lưu ý: Nội dung thanh toán nên bỏ ký tự đặc biệt để tránh lỗi encoding
        $vnp_OrderInfo = "Ung ho chien dich " . $campaign->id;

        $vnp_Amount = $request->amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip(); // Lấy IP thực

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        // 4. Tạo URL thanh toán (PHẦN QUAN TRỌNG ĐÃ SỬA)
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                // SỬA: Thêm urlencode vào cả key và value khi tạo chuỗi hash
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    /**
     * Xử lý kết quả trả về từ VNPay (Redirect Back)
     */
    public function vnpayReturn(Request $request)
    {
        try {
            // 1. Lấy và kiểm tra chữ ký (SecureHash) để đảm bảo dữ liệu không bị giả mạo
            $vnp_SecureHash = $request->vnp_SecureHash;
            $inputData = array();
            foreach ($request->all() as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }

            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $vnp_HashSecret = config('vnpay.hash_secret');
            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            // 2. Xác thực chữ ký
            if ($secureHash == $vnp_SecureHash) {

                // Lấy ID đơn hàng (Định dạng: ID_Time)
                $orderParts = explode('_', $request->vnp_TxnRef);
                $donationId = $orderParts[0];
                $donation = Donation::find($donationId);

                if (!$donation) {
                    return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng.');
                }

                // Kiểm tra mã lỗi trả về (00 là thành công)
                if ($request->vnp_ResponseCode == '00') {

                    // Cập nhật trạng thái nếu đang Pending
                    if ($donation->status == 'Pending') {
                        DB::transaction(function () use ($donation, $request) {
                            $donation->update([
                                'status' => 'Success',
                                // Lưu mã giao dịch VNPay nếu cần
                                'vnp_TransactionNo' => $request->vnp_TransactionNo
                            ]);

                            if ($donation->campaign) {
                                $donation->campaign->increment('current_amount', $donation->amount);
                            }
                        });

                        // Notify campaign owner
                        if ($donation->campaign && $donation->campaign->admin_user_id) {
                            $donorName = $donation->user ? ($donation->user->first_name . ' ' . $donation->user->last_name) : 'Người dùng ẩn danh';
                            SendNotificationJob::dispatch($donation->campaign->admin_user_id, [
                                'type' => 'Donation',
                                'title' => 'Quyên góp mới 💰',
                                'content' => "{$donorName} đã quyên góp " . number_format($donation->amount) . "đ cho chiến dịch: {$donation->campaign->title}",
                                'related_id' => $donation->id,
                                'related_type' => 'donation',
                                'priority' => 'medium'
                            ]);
                        }

                        return redirect()->route('campaigns.show', $donation->campaign_id)
                            ->with('success', 'Thanh toán thành công qua VNPay! Cảm ơn tấm lòng của bạn.');
                    }

                    // Đã xử lý trước đó rồi
                    return redirect()->route('campaigns.show', $donation->campaign_id);
                } else {
                    // Thanh toán thất bại hoặc bị hủy
                    return redirect()->route('campaigns.show', $donation->campaign_id)
                        ->with('error', 'Giao dịch không thành công. Mã lỗi: ' . $request->vnp_ResponseCode);
                }
            } else {
                return redirect()->route('home')->with('error', 'Chữ ký không hợp lệ!');
            }
        } catch (\Exception $e) {
            Log::error('VNPay Return Error: ' . $e->getMessage());
            return redirect()->route('home')
                ->with('success', 'Thanh toán thành công qua VNPay! Cảm ơn tấm lòng của bạn.');
        }
    }
}
