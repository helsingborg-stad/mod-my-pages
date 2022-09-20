<?php

namespace ModMyPages\Service;

class AuthService
{
    public static function token($args)
    {
        $queryArgs  = ['ts_session_id' => $args['ts_session_id']];
        $requestUrl = add_query_arg($queryArgs, \ModMyPages\Admin\Settings::apiUrl() . '/auth/token');
        $request = curl_init($requestUrl);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        $response = json_decode(curl_exec($request), true);
        return $response['jwt'];
    }
}
