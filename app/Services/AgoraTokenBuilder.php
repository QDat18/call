<?php

namespace App\Services;

use Peterujah\Agora\Agora;
use Peterujah\Agora\User;
use Peterujah\Agora\Services\Rtc;
use Peterujah\Agora\Tokens\AccessToken;
use Illuminate\Support\Facades\Log;

class AgoraTokenBuilder
{
    /**
     * Generate Agora RTC token
     *
     * @param string $appId
     * @param string $appCertificate
     * @param string $channelName
     * @param int|string $uid
     * @param int $expire Token expiration in seconds
     * @return string
     */
    public static function generateToken($appId, $appCertificate, $channelName, $uid, $expire = 3600)
    {
        // ✅ Ép kiểu để chắc chắn Carbon không báo lỗi
        $expire = (int) $expire;

        // Log debug
        Log::info("🎫 Generating Agora token", [
            'channel' => $channelName,
            'uid' => $uid,
            'expire' => $expire,
            'expire_type' => gettype($expire),
            'has_app_id' => !empty($appId),
            'has_certificate' => !empty($appCertificate),
        ]);

        // Khởi tạo client Agora
        $client = new Agora($appId, $appCertificate);
        $user = new User($uid);

        // Tạo RTC service
        $rtcService = new Rtc($user);
        $rtcService->channelName = $channelName;

        // Thêm privileges
        // 1 = JOIN_CHANNEL, 2 = PUBLISH_AUDIO, 3 = PUBLISH_VIDEO, 4 = PUBLISH_DATA
        $rtcService->addPrivilege(1, $expire);
        $rtcService->addPrivilege(2, $expire);
        $rtcService->addPrivilege(3, $expire);
        $rtcService->addPrivilege(4, $expire);

        // Build access token
        $accessToken = new AccessToken($client, $channelName);
        $accessToken->addService($rtcService);

        $token = $accessToken->build();

        // Log debug token generated
        Log::info("✅ Agora token generated successfully", [
            'channel' => $channelName,
            'uid' => $uid,
            'token_length' => strlen($token)
        ]);

        return $token;
    }
}
