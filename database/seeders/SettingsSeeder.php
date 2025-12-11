<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'VolunteerConnect'],
            ['key' => 'site_description', 'value' => 'Nền tảng kết nối tình nguyện viên hàng đầu.'],
            ['key' => 'contact_email', 'value' => 'admin@volunteerconnect.com'],
            ['key' => 'email_notifications', 'value' => '1'],
            ['key' => 'allow_registration', 'value' => '1'],
            ['key' => 'require_email_verification', 'value' => '0'],
            ['key' => 'maintenance_mode', 'value' => '0'],
            ['key' => 'mail_from_name', 'value' => 'VolunteerConnect System'],
            ['key' => 'mail_from_address', 'value' => 'no-reply@volunteerconnect.com'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}