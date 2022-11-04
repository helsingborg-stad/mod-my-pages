<?php

namespace ModMyPages\Service\TokenService;

use ModMyPages\Admin\Settings;

class TokenService implements ITokenService
{
    public function __invoke(string $sessionId): string
    {
        $queryArgs  = ['ts_session_id' => $sessionId];
        $requestUrl = add_query_arg($queryArgs, Settings::apiUrl() . '/api/v1/auth/token');
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
            error_log('TOKEN SERVICE ---------' . PHP_EOL);
            error_log('REQUEST ---------');
            error_log(print_r(array_keys($response), true));
            error_log('END SERVICE ---------' . PHP_EOL);
        }

        return $response['accessToken'] ?? '';
    }
}
