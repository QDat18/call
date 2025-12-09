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
        // Thêm tham số email vào URL
        $this->resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);
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
