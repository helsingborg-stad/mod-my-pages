<?php

namespace ModMyPages\Service\SignOutService;

use Exception;
use ModMyPages\Admin\Settings;

class SignOutService
{
    public static function signOut(string $token): void
    {
        $requestUrl = add_query_arg(['token' => $token], Settings::apiUrl() . '/api/v1/auth/logout');
        $request = curl_init($requestUrl);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);

        try {
            $request = curl_exec($request);
        } catch (Exception $e) {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('SIGN-OUT SERVICE SERVICE ERROR ---------' . PHP_EOL);
                error_log($e->getMessage());
                error_log('END SERVICE ---------' . PHP_EOL);
            }
        }
    }
}
