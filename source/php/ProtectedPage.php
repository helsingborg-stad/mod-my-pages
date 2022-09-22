<?php

namespace ModMyPages;

class ProtectedPage implements \ModMyPages\Redirect\IRedirectHandler
{
    private array $postIds;

    public function __construct(array $postIds)
    {
        $this->postIds = $postIds ?? [];
    }

    public function validate(array $args): bool
    {
        return in_array(get_queried_object_id(), $this->postIds) && empty(\ModMyPages\Session\Cookie::get());
    }

    public function redirect(array $args): string
    {
        return home_url('404');
    }
}
