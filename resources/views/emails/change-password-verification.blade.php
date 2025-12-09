<!DOCTYPE html>
<html>
<head>
    <title>Mã Xác Thực Đổi Mật Khẩu</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #2563eb; text-align: center;">Yêu Cầu Đổi Mật Khẩu</h2>
        
        <p>Xin chào <strong>{{ $user->last_name }} {{ $user->first_name }}</strong>,</p>
        
        <p>Bạn vừa yêu cầu mã xác thực để đổi mật khẩu tại hệ thống <strong>Volunteer Connect</strong>.</p>
        
        <p>Đây là mã xác thực của bạn (có hiệu lực trong 5 phút):</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #333; background: #f3f4f6; padding: 15px 30px; border-radius: 8px; border: 1px dashed #2563eb;">
                {{ $code }}
            </span>
        </div>
        
        <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này hoặc liên hệ với quản trị viên ngay lập tức để bảo vệ tài khoản.</p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        
        <p style="font-size: 12px; color: #666; text-align: center;">
            &copy; {{ date('Y') }} Volunteer Connect. All rights reserved.
        </p>
    </div>
</body>
</html>