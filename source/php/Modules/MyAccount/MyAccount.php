<?php

namespace ModMyPages\Modules\MyAccount;

class MyAccount extends \Modularity\Module
{

    public $slug = 'mod-my-account';
    public $supports = array();

    public function init()
    {
        $this->nameSingular = __('My Pages: My Account', MOD_MY_PAGES_TEXT_DOMAIN);
        $this->namePlural = __('My Pages: My Account', MOD_MY_PAGES_TEXT_DOMAIN);
        $this->description = __('Displays account details for authenticated user', MOD_MY_PAGES_TEXT_DOMAIN);
    }

    /**
     * Data array
     * @return array $data
     */
    public function data(): array
    {
        return [];
    }

    /**
     * Blade Template
     * @return string
     */
    public function template(): string
    {
        return 'my-account.blade.php';
    }

    /**
     * Style - Register & adding css
     * @return void
     */
    public function style()
    {
    }

    /**
     * Script - Register & adding scripts
     * @return void
     */
    public function script()
    {
    }
}
