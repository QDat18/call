<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VolunteerContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $organizationName;

    public function __construct($data, $organizationName)
    {
        $this->data = $data;
        $this->organizationName = $organizationName;
    }

    public function build()
    {
        return $this->subject($this->data['subject'])
                    ->markdown('emails.volunteers.contact') 
                    ->with([
                        'messageContent' => $this->data['message'],
                        'organizationName' => $this->organizationName,
                    ]);
    }
}