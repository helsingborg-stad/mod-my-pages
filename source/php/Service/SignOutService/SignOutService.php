<?php

namespace ModMyPages\Service\SignOutService;

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

        $request = curl_exec($request);
        $response = json_decode($request, true);

        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('SIGNOUT SERVICE SERVICE ---------' . PHP_EOL);
            error_log('REQUEST ---------');
            error_log(print_r(array_keys($response), true));
            error_log('END SERVICE ---------' . PHP_EOL);
        }
    }
}
