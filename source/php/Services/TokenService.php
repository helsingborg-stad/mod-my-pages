<?php
namespace ModMyPages\Services;

use ModMyPages\Services\Types\ITokenService;
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
        $response = json_decode(curl_exec($request), true);
        return $response['accessToken'] ?? '';
    }
}