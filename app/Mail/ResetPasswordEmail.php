<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;

    public function __construct(User $user, $token)
    {
        $this->user = $user;
        // SỬA: Dùng route name thay vì URL trực tiếp
        $this->resetUrl = url('/reset-password/' . $token);
    }

    public function build()
    {
        return $this->subject('Đặt Lại Mật Khẩu - Volunteer Connect')
                    ->view('emails.reset-password') // Đảm bảo view này tồn tại
                    ->with([
                        'user' => $this->user,
                        'resetUrl' => $this->resetUrl
                    ]);
    }
}