<?php

namespace ModMyPages\Session;

class User
{
    public static function ssn()
    {
        return Token::decode(Cookie::get())['payload']['id'];
    }

    public static function name()
    {
        return Token::decode(Cookie::get())['payload']['name'];
    }
}
