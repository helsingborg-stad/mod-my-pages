<?php

namespace ModMyPages\Redirect;

class UseRedirect
{
    private array $routes;

    public function __construct(array $routesWithRedirectHandler)
    {
        $this->routes = $routesWithRedirectHandler;
        $this->enable();
    }

    public function enable(): void
    {
        foreach ($this->routes as $route => $handler) {
            $this->attachHandler($route, $handler);
        }
    }

    public function attachHandler(string $route, IRedirectHandler $handler): void
    {
        if ($_SERVER['PHP_SELF'] === $route && $handler->validate($_GET)) {
            wp_redirect($handler->redirect($_GET));
            exit;
        }
    }
}

