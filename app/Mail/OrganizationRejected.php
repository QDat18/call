<?php

namespace App\Mail;

use App\Models\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganizationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $organization;
    public $reason;

    public function __construct(Organization $organization, $reason)
    {
        $this->organization = $organization;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Update on Your Organization Registration - VolunteerConnect')
                    ->view('emails.organization.rejected');
    }
}