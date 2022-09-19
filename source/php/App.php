<?php

namespace ModMyPages;

class App
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));

        $this->cacheBust = new \ModMyPages\Helper\CacheBust();
    }

    /**
     * Enqueue required style
     * @return void
     */
    public function enqueueStyles()
    {
        wp_register_style(
            'mod-my-pages-css',
            MOD_MY_PAGES_URL . '/dist/' .
            $this->cacheBust->name('css/mod-my-pages.css')
        );

        wp_enqueue_style('mod-my-pages-css');
    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
        wp_register_script(
            'mod-my-pages-js',
            MOD_MY_PAGES_URL . '/dist/' .
            $this->cacheBust->name('js/mod-my-pages.js')
        );

        wp_enqueue_script('mod-my-pages-js');
    }
}
