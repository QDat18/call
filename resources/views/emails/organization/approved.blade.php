<!DOCTYPE html>
<html>
<head>
    <title>Organization Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #10B981; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { border: 1px solid #ddd; padding: 20px; border-radius: 0 0 5px 5px; }
        .button { display: inline-block; background-color: #10B981; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Chúc mừng! Hồ sơ đã được duyệt</h1>
        </div>
        <div class="content">
            <p>Xin chào <strong>{{ $organization->organization_name }}</strong>,</p>
            
            <p>Chúng tôi vui mừng thông báo rằng hồ sơ tổ chức của bạn trên <strong>VolunteerConnect</strong> đã được xác thực và phê duyệt thành công.</p>
            
            <p>Giờ đây, bạn đã có toàn quyền truy cập để:</p>
            <ul>
                <li>Đăng tải các cơ hội tình nguyện không giới hạn</li>
                <li>Quản lý và tuyển dụng tình nguyện viên</li>
                <li>Nhận huy hiệu "Đã xác thực" (Verified Badge) uy tín</li>
            </ul>
            
            <p>Hãy bắt đầu hành trình kết nối cộng đồng ngay hôm nay!</p>
            
            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="button">Truy cập Dashboard</a>
            </div>
            
            <p style="margin-top: 30px; font-size: 0.9em; color: #666;">Trân trọng,<br>Đội ngũ VolunteerConnect</p>
        </div>
    </div>
</body>
</html>