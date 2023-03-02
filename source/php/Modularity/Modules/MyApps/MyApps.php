<?php

namespace ModMyPages\Modularity\Modules\MyApps;

/**
 * @psalm-suppress UndefinedClass
 */
class MyApps extends \Modularity\Module
{
    public $slug = 'mod-my-apps';
    public $supports = array();

    public function init()
    {
        $this->nameSingular = __('My Apps', MOD_MY_PAGES_TEXT_DOMAIN);
        $this->namePlural = __('My Apps', MOD_MY_PAGES_TEXT_DOMAIN);
        $this->description = __('Module for listing My Apps', MOD_MY_PAGES_TEXT_DOMAIN);
    }

    public function data(): array
    {
        return [
            'test' => 'rendered (but not implemented) view: ' . $this->template()
        ];
    }

    public function template(): string
    {
        return 'my-apps.blade.php';
    }
}
