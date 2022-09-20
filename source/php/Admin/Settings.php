<?php

namespace ModMyPages\Admin;

use ModMyPages\Redirect\UseRedirect;

class Settings
{
    public static function apiUrl(): string
    {
        return get_field('mod_my_pages_api_url', 'options') ?? '';
    }
}
