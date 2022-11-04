<?php

namespace ModMyPages\UI;

class DropdownMenu
{
    public static function create(array $menuItems, \Closure $loginUrl)
    {
        $withClassNames = fn (array $classNames) => fn ($items) => array_map(
            fn ($item) => array_merge(
                $item,
                ['classes' => array_merge($item['classes'] ?? [], $classNames)]
            ),
            $items
        );
        $withNoEmptyClassNames = fn ($items) => array_map(
            fn ($item) => array_merge(
                $item,
                ['classes' => array_filter($item['classes'] ?? [], fn ($c) => !empty($c))]
            ),
            $items
        );

        $mapDropdownMenuItems = fn ($arr) => array_map(
            fn ($p) => [
                'text' => $p['title'],
                'link' => $p['url'],
                'attributeList' => [],
                'linkAttributeList' => $p['linkAttributeList'] ?? [],
                'classList' => $p['classes'],
            ],
            $arr
        );

        $createLoginButton = fn () => [
            [
                'title'             => __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                'url'               => $loginUrl(),
                'attr_title'        => __('Login', MOD_MY_PAGES_TEXT_DOMAIN),
                'classes'           => [],
            ]
        ];

        $createDropdownMenuItems = fn (array $items) => apply_filters(
            'ModMyPages/UI/DropdownMenu::items',
            $mapDropdownMenuItems(
                $withNoEmptyClassNames(
                    array_merge(
                        $withClassNames(['hide-authenticated'])($createLoginButton()),
                        $withClassNames(['show-authenticated'])($items)
                    )
                )
            )
        );

        return $createDropdownMenuItems($menuItems);
    }
}
