<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ChangePasswordVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $code;

    public function __construct(User $user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('Mã Xác Thực Đổi Mật Khẩu - Volunteer Connect')
                    ->view('emails.change-password-verification')
                    ->with([
                        'user' => $this->user,
                        'code' => $this->code
                    ]);
    }
}