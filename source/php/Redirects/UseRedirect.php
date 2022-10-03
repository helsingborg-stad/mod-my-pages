<?php

namespace ModMyPages\Redirects;

class UseRedirect
{
    private array $routes;
    private string $currentRoute;

    public function __construct(
        array $routesWithRedirectHandler,
        string $serverPath,
        callable $redirectCallback
    ) {
        $this->routes = $routesWithRedirectHandler;
        $this->currentRoute = $serverPath;
        $this->enable($redirectCallback);
    }

    public function enable(callable $callback): void
    {
        foreach ($this->routes as $route => $handler) {
            $this->attachHandler($route, $handler, $callback);
        }
    }

    public function attachHandler(string $route, Types\IRedirectHandler $handler, callable $callback): void
    {
        if ($this->matchRoute($route) && $handler->shouldRedirect($_GET)) {
            $callback($handler->redirectUrl($_GET));
        }
    }

    public function matchRoute(string $route)
    {
        return $route === '*' || $route === $this->currentRoute;
    }
}
