<?php

namespace ModMyPages\Redirects\Handlers;

use ModMyPages\Repository\Types\Cookie;
use ModMyPages\Redirects\Types\IRedirectHandler;

class ProtectedPage implements IRedirectHandler
{
    private int $currentPostId;

    private array $protectedPageIds;

    private bool $isEnabled;

    public function __construct(array $protectedPageIds, int $currentPostId, bool $enabled = false)
    {
        $this->protectedPageIds = $protectedPageIds;
        $this->currentPostId = $currentPostId;
        $this->isEnabled = $enabled;
    }

    public function shouldRedirect(array $args): bool
    {
        return $this->isEnabled && in_array($this->currentPostId, $this->protectedPageIds);
    }

    public function redirectUrl(array $args): string
    {
        return home_url('/not-authorized');
    }
}
