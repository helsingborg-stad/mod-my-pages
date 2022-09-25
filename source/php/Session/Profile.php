<?php

namespace ModMyPages\Session;

class Profile
{
    public static function isAuthenticated(): bool
    {
        return !empty(Cookie::get()) && Token::isValid(Cookie::get());
    }

    public static function name(): string
    {
        return Token::decode(Cookie::get())['payload']['name'] ?? '';
    }
}
