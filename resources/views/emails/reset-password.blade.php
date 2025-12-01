<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đặt Lại Mật Khẩu - Volunteer Connect</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            margin: 0; 
            padding: 0; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 30px; 
            text-align: center; 
            border-radius: 10px 10px 0 0; 
        }
        .content { 
            background: #ffffff; 
            padding: 30px; 
            border: 1px solid #e0e0e0;
        }
        .button { 
            display: inline-block; 
            padding: 15px 30px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 20px 0; 
            font-weight: bold; 
        }
        .footer { 
            background: #f5f5f5; 
            padding: 20px; 
            text-align: center; 
            font-size: 12px; 
            color: #666; 
            border-radius: 0 0 10px 10px; 
        }
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔑 Yêu Cầu Đặt Lại Mật Khẩu</h1>
            <p>Volunteer Connect</p>
        </div>
        
        <div class="content">
            <h2>Xin chào {{ $user->first_name }}!</h2>
            
            <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản Volunteer Connect của bạn.</p>
            
            <p>Nhấp vào nút bên dưới để đặt lại mật khẩu:</p>
            
            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="button">
                    🔐 Đặt Lại Mật Khẩu
                </a>
            </div>
            
            <div class="warning-box">
                <strong>⏰ Quan trọng:</strong><br>
                • Liên kết này sẽ hết hạn sau 1 giờ<br>
                • Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này<br>
                • Mật khẩu của bạn sẽ không thay đổi cho đến khi bạn tạo mật khẩu mới
            </div>
            
            <p>Nếu nút không hoạt động, hãy sao chép và dán liên kết này vào trình duyệt:</p>
            <p style="word-break: break-all; color: #667eea;">{{ $resetUrl }}</p>
            
            <hr style="margin: 30px 0; border: none; border-top: 1px solid #e0e0e0;">
            
            <p><strong>Mẹo Bảo Mật:</strong></p>
            <ul>
                <li>Sử dụng mật khẩu mạnh và duy nhất</li>
                <li>Bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                <li>Tránh sử dụng thông tin cá nhân</li>
                <li>Không sử dụng lại mật khẩu từ các trang web khác</li>
            </ul>
            
            <p>Nếu bạn không yêu cầu đặt lại mật khẩu, tài khoản của bạn có thể gặp rủi ro. Vui lòng liên hệ với đội ngũ hỗ trợ của chúng tôi ngay lập tức.</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Volunteer Connect. All rights reserved.</p>
            <p>Cần hỗ trợ? Liên hệ với chúng tôi tại support@volunteerconnect.com</p>
        </div>
    </div>
</body>
</html>