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
        $this->currentRoute = $this->normalizePath($serverPath);
        $this->enable($redirectCallback);
    }

    public function enable(callable $callback): void
    {
        foreach ($this->routes as $route => $handler) {
            $this->attachHandler($route, $handler, $callback);
        }
    }

    public function normalizePath($path)
    {
        $removeLeftSlash = fn ($s) => ltrim($s, '/');
        $removeRightSlash = fn ($s) => rtrim($s, '/');
        $removeQueryArgs = fn ($s) => strtok($s, '?');

        return $removeLeftSlash($removeRightSlash($removeQueryArgs($path)));
    }

    public function attachHandler(string $route, Types\IRedirectHandler $handler, callable $callback): void
    {
        if ($this->matchRoute($route) && $handler->shouldRedirect($_GET)) {
            $callback($handler->redirectUrl($_GET));
        }
    }

    public function matchRoute(string $route)
    {
        return $route === '*' || $this->normalizePath($route) === $this->currentRoute;
    }
}
