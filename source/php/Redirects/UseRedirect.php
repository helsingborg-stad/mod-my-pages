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
        $this->currentRoute = rtrim($serverPath, '/');
        var_dump($this->currentRoute);
        $this->enable($redirectCallback);
    }

    public function enable(callable $callback): void
    {
        $this->log("Current route: {$this->currentRoute}");
        $this->log(PHP_EOL);
        foreach ($this->routes as $route => $handler) {
            $this->attachHandler($route, $handler, $callback);
        }
    }

    public function log(string $message)
    {
        error_log(print_r($message, true));
    }

    public function attachHandler(string $route, Types\IRedirectHandler $handler, callable $callback): void
    {
        $this->log("Match route: {$route} ? {$this->matchRoute($route)}");
        $this->log("Should redirect: {$route} ? {$handler->shouldRedirect($_GET)}");
        if ($this->matchRoute($route) && $handler->shouldRedirect($_GET)) {
            $this->log("Execute redirect: {$route}");
            $this->log(PHP_EOL);
            $callback($handler->redirectUrl($_GET));
            return;
        }

        $this->log("Skip redirect: {$route}");
        $this->log(PHP_EOL);
    }

    public function matchRoute(string $route)
    {
        return $route === '*' || $route === $this->currentRoute;
    }
}
