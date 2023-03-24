<?php

namespace ModMyPages\Notice;

use ModMyPages\Helper\Blade;
use ModMyPages\Plugin\ActionHookSubscriber;

class ModalNotice implements ActionHookSubscriber
{
    public static function addActions(): array
    {
        return [['wp_footer', self::controller(), 10, 1]];
    }

    public static function controller(): string
    {
        $controllers = [
            ModalNoticeCodes::INACTIVE_SIGNOUT => 'showSignOutModal',
        ];

        return $controllers[static::notice()] ?? 'null';
    }

    public static function notice(): string
    {
        return isset($_GET['notice']) && is_string($_GET['notice']) ? $_GET['notice'] : '';
    }

    public function showSignOutModal(): void
    {
        echo Blade::render('source/php/Notice/modal-notice.blade.php', [
            'labels' => [
                'modalTitle' => __(
                    'You have been automatically logged out.',
                    MOD_MY_PAGES_TEXT_DOMAIN
                ),
                'buttonText' => __('Close', MOD_MY_PAGES_TEXT_DOMAIN),
            ],
        ]);
    }

    public function null(): void
    {
    }
}
