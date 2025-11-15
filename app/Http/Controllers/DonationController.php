<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * Tạo giao dịch VNPay và chuyển hướng người dùng.
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
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
            'message'     => $request->message,
            'status'      => 'Pending',
        ]);

        // 2. Lấy config từ .env
        $vnp_Url = config('vnpay.vnp_Url');
        $vnp_Returnurl = route('donation.vnpayReturn');
        $vnp_TmnCode = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');

        // Kiểm tra config
        if (empty($vnp_TmnCode) || empty($vnp_HashSecret)) {
            Log::error('VNPay config missing');
            return redirect()->back()->with('error', 'Cấu hình VNPay chưa đầy đủ. Vui lòng liên hệ quản trị viên.');
        }

        // 3. Chuẩn bị dữ liệu
        $vnp_TxnRef = $donation->id;
        $vnp_OrderInfo = "Quyen gop cho chien dich " . $campaign->id;
        $vnp_OrderType = 'other';
        $vnp_Amount = $donation->amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();
        
        // ✅ SỬA: Thêm 1 giờ vào ExpireDate (vì VNPay dùng UTC+7)
        $vnp_CreateDate = date('YmdHis');
        $vnp_ExpireDate = date('YmdHis', strtotime('+1 hour')); // Đổi từ 15 phút -> 1 giờ

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
        ];

        ksort($inputData);

        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnp_SecureHash;

        // Log để debug
        Log::info('VNPay Payment Created', [
            'donation_id' => $donation->id,
            'amount' => $vnp_Amount,
            'txnref' => $vnp_TxnRef
        ]);

        return redirect($vnp_Url);
    }

    /**
     * Xử lý khi người dùng quay về từ VNPay (Trang Cảm ơn).
     */
    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $inputData = $request->all();
        
        // Lấy SecureHash
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);

        // Sắp xếp và tạo hash để verify
        ksort($inputData);
        $i = 0;
        $hashData = "";
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Verify chữ ký
        if ($secureHash != $vnp_SecureHash) {
            Log::warning('VNPay Return: Invalid signature', ['data' => $inputData]);
            return redirect()->route('home')->with('error', 'Dữ liệu không hợp lệ. Vui lòng liên hệ hỗ trợ.');
        }

        // Kiểm tra kết quả thanh toán
        if ($request->vnp_ResponseCode == '00') {
            // Thành công - KHÔNG cập nhật CSDL ở đây, chờ IPN
            return redirect()->route('home')->with('success', 'Quyên góp thành công! Giao dịch đang được xử lý. Cảm ơn bạn rất nhiều!');
        }

        // Thất bại hoặc hủy - Cập nhật trạng thái
        if ($request->vnp_TxnRef) {
            $donation = Donation::find($request->vnp_TxnRef);
            if ($donation && $donation->status == 'Pending') {
                $donation->status = 'Failed';
                $donation->save();
                
                Log::info('VNPay Return: Payment failed', [
                    'donation_id' => $donation->id,
                    'response_code' => $request->vnp_ResponseCode
                ]);
            }
        }

        // Thông báo lỗi chi tiết hơn
        $errorMessages = [
            '07' => 'Giao dịch bị nghi ngờ gian lận',
            '09' => 'Thẻ chưa đăng ký sử dụng dịch vụ',
            '10' => 'Thẻ hết hạn hoặc thông tin không đúng',
            '11' => 'Thẻ bị khóa',
            '12' => 'Thẻ hết hạn',
            '13' => 'Sai mật khẩu thanh toán',
            '24' => 'Giao dịch bị hủy',
            '51' => 'Tài khoản không đủ số dư',
            '65' => 'Vượt quá giới hạn giao dịch',
            '75' => 'Ngân hàng đang bảo trì',
            '79' => 'Nhập sai mật khẩu quá số lần quy định',
        ];

        $responseCode = $request->vnp_ResponseCode;
        $errorMessage = $errorMessages[$responseCode] ?? 'Giao dịch thất bại';

        return redirect()->route('home')->with('error', "Quyên góp không thành công. Lý do: {$errorMessage}");
    }

    /**
     * Xử lý IPN - Server-to-Server (Quan trọng nhất).
     */
    public function vnpayIpn(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret'); // ✅ Dùng config thay vì hardcode
        $inputData = $request->all();
        
        Log::info('VNPay IPN Received', ['data' => $inputData]);

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);

        // Sắp xếp và tạo chuỗi hash
        ksort($inputData);
        $i = 0;
        $hashData = "";
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // 1. Kiểm tra Checksum
        if ($secureHash == $vnp_SecureHash) {
            $donationId = $inputData['vnp_TxnRef'];
            $donation = Donation::find($donationId);

            // 2. Kiểm tra Đơn hàng
            if ($donation) {
                // 3. Kiểm tra Trạng thái Pending (tránh xử lý 2 lần)
                if ($donation->status == 'Pending') {
                    // 4. Kiểm tra Số tiền
                    $vnpAmount = $inputData['vnp_Amount'];
                    $expectedAmount = $donation->amount * 100;
                    
                    if ($vnpAmount != $expectedAmount) {
                        Log::error('VNPay IPN: Amount mismatch', [
                            'donation_id' => $donationId,
                            'expected' => $expectedAmount,
                            'received' => $vnpAmount
                        ]);
                        return response()->json(['RspCode' => '04', 'Message' => 'Invalid Amount']);
                    }

                    // 5. Kiểm tra Mã giao dịch VNPay
                    if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
                        // THÀNH CÔNG
                        try {
                            DB::transaction(function () use ($donation, $inputData) {
                                $donation->status = 'Success';
                                $donation->vnp_TransactionNo = $inputData['vnp_TransactionNo'] ?? null;
                                $donation->save();

                                // Cập nhật tiền cho Chiến dịch
                                $donation->campaign->increment('current_amount', $donation->amount);
                            });

                            Log::info('VNPay IPN: Payment success', [
                                'donation_id' => $donationId,
                                'amount' => $donation->amount,
                                'transaction_no' => $inputData['vnp_TransactionNo'] ?? null
                            ]);

                            return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
                        } catch (\Exception $e) {
                            Log::error('VNPay IPN: Database error', [
                                'donation_id' => $donationId,
                                'error' => $e->getMessage()
                            ]);
                            return response()->json(['RspCode' => '99', 'Message' => 'System Error']);
                        }
                    } else {
                        // THẤT BẠI
                        $donation->status = 'Failed';
                        $donation->save();
                        
                        Log::info('VNPay IPN: Payment failed', [
                            'donation_id' => $donationId,
                            'response_code' => $inputData['vnp_ResponseCode'],
                            'transaction_status' => $inputData['vnp_TransactionStatus']
                        ]);

                        return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
                    }
                }
                // Đã xử lý rồi
                Log::warning('VNPay IPN: Order already confirmed', ['donation_id' => $donationId]);
                return response()->json(['RspCode' => '02', 'Message' => 'Order already confirmed']);
            }
            // Không tìm thấy đơn
            Log::error('VNPay IPN: Order not found', ['donation_id' => $inputData['vnp_TxnRef']]);
            return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
        }
        
        // Sai checksum
        Log::error('VNPay IPN: Invalid checksum', ['data' => $inputData]);
        return response()->json(['RspCode' => '97', 'Message' => 'Invalid Checksum']);
    }
}