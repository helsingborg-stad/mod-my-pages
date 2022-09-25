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
            return self::validatePayload($decoded['payload']);
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function validatePayload(array $payload): bool
    {
        $payloadKeys = ['id', 'name', 'exp'];
        foreach ($payloadKeys as $key) {
            if (!in_array($key, array_keys($payload))) {
                return false;
            }
        }

        return $payload['exp'] > time();
    }
}
