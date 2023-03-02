<?php

namespace ModMyPages\Admin;

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

    public static function apiAuthSecret(): string
    {
        return get_field('mod_my_pages_api_auth_secret', 'options') ?: 'random';
    }

    public static function signInRedirectUrl(): string
    {
        return !empty(get_field('after_sign_in_redirect_url', 'options'))
            ? get_field('after_sign_in_redirect_url', 'options')
            : home_url();
    }

    public static function myPagesMenu(): string
    {
        return !empty(get_field('my_pages_menu', 'options'))
            ? get_field('my_pages_menu', 'options')
            : 'enabled';
    }

    public static function signOutRedirectUrl(): string
    {
        return !empty(get_field('after_sign_out_redirect_url', 'options'))
            ? get_field('after_sign_out_redirect_url', 'options')
            : home_url();
    }

    public static function protectedPages(): array
    {
        return get_posts(
            [
                'post_type' => 'page',
                'posts_per_page' => -1,
                'meta_key' => 'mod_my_pages_protected_page',
                'meta_value' => 1,
                'fields' => 'ids'
            ]
        ) ?? [];
    }
}
