<?php

namespace ModMyPages\Service\ACFService;

class ACFServiceFactory
{
    public static function create(): ACFService
    {
        return new class implements ACFService
        {
            public function getField(string $selector, $postId)
            {
                return get_field($selector, $postId);
            }

            public function getOption(string $selector)
            {
                return get_field($selector, 'options');
            }
        };
    }
}
