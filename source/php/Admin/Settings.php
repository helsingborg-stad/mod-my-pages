<?php

namespace ModMyPages\Admin;

use ModMyPages\Redirect\UseRedirect;

class Settings
{
    public static function apiUrl(): string
    {
        return get_field('mod_my_pages_api_url', 'options') ?? '';
    }

    public static function sessionLength(): int
    {
        return intval(get_field('mod_my_pages_session_length_in_seconds', 'options') ?? 600);
    }
}
