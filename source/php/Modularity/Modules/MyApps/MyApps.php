<?php

namespace ModMyPages\Modularity\Modules\MyApps;

/**
 * @psalm-suppress UndefinedClass
 */
class MyApps extends \Modularity\Module
{
    public $slug = 'mod-my-apps';
    public $supports = [];

    public function init()
    {
        $this->nameSingular = __('My Apps', MOD_MY_PAGES_TEXT_DOMAIN);
        $this->namePlural = __('My Apps', MOD_MY_PAGES_TEXT_DOMAIN);
        $this->description = __('Module for listing My Apps', MOD_MY_PAGES_TEXT_DOMAIN);
        $this->ttl = false;
    }

    public function model()
    {
        return (object) [
            'items' => get_field('my_pages_apps', $this->data['ID']) ?: [],
        ];
    }

    public function data(): array
    {
        $model = $this->model();

        return [
            'viewModel' => (object) [
                'items' => array_map(
                    fn($raw) => (object) [
                        'id' => (string) sanitize_title($raw['title']),
                        'title' => $raw['title'],
                        'link' => $raw['link']['url'],
                        'target' => $raw['link']['target'],
                        'content' => $raw['description'],
                        'icon' => $raw['icon'] ?? '',
                        'display' => $raw['display'],
                    ],
                    $model->items
                ),
            ],
        ];
    }

    public function template(): string
    {
        return 'my-apps.blade.php';
    }
}
