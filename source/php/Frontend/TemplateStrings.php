<?php

namespace ModMyPages\Frontend;

class TemplateStrings
{
    private static function strings()
    {
        return [
            '{name}' => \ModMyPages\Session\Profile::name(),
        ];
    }

    public static function replace(string $str)
    {
        foreach (self::strings() as $placeholder => $value) {
            $str = str_replace($placeholder, $value, $str);
        }

        return $str;
    }
}
