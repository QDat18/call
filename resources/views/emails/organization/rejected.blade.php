<!DOCTYPE html>
<html>
<head>
    <title>Registration Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #EF4444; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { border: 1px solid #ddd; padding: 20px; border-radius: 0 0 5px 5px; }
        .reason-box { background-color: #FEE2E2; border-left: 4px solid #EF4444; padding: 15px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thông báo về Hồ sơ Đăng ký</h1>
        </div>
        <div class="content">
            <p>Xin chào <strong>{{ $organization->organization_name }}</strong>,</p>
            
            <p>Cảm ơn bạn đã quan tâm đến <strong>VolunteerConnect</strong>. Sau khi xem xét kỹ hồ sơ đăng ký của bạn, chúng tôi rất tiếc phải thông báo rằng tài khoản của bạn <strong>chưa đủ điều kiện</strong> để được phê duyệt vào lúc này.</p>
            
            <p>Lý do từ chối:</p>
            <div class="reason-box">
                <strong>{{ $reason }}</strong>
            </div>
            
            <p>Bạn có thể cập nhật lại thông tin hoặc cung cấp thêm tài liệu cần thiết và gửi yêu cầu xét duyệt lại bất cứ lúc nào.</p>
            
            <p>Nếu bạn có thắc mắc, vui lòng phản hồi email này để được hỗ trợ.</p>
            
            <p style="margin-top: 30px; font-size: 0.9em; color: #666;">Trân trọng,<br>Đội ngũ VolunteerConnect</p>
        </div>
    </div>
</body>
</html>