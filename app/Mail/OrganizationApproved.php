<?php

namespace App\Mail;

use App\Models\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganizationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $organization;

    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function build()
    {
        return $this->subject('Your Organization Has Been Approved - VolunteerConnect')
                    ->view('emails.organization.approved');
    }
}