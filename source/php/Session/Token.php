<?php

namespace ModMyPages\Session;

class Token
{
    public static function decode(string $value): array
    {
        $tokenPartials = explode('.', $value);
        return [
            'header' => json_decode(base64_decode($tokenPartials[0]), true),
            'payload' => json_decode(base64_decode($tokenPartials[1]), true),
            'signature' => $tokenPartials[2],
        ];
    }

    public static function isValid(string $token): bool
    {
        try {
            $decoded = self::decode($token);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}


