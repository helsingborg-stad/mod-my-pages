<?php

namespace ModMyPages\Redirect;

use Closure;
use ModMyPages\Redirect\IRedirectHandler;

class UseRedirect implements IUseRedirect
{
    /**
     * @var array<string, IRedirectHandler>
     */
    private array $routes = [];
    private string $currentRoute;

    private Closure $redirectCallback;

    public function __construct(Closure $serverPath, Closure $redirectCallback)
    {
        $this->currentRoute = $this->normalizePath($serverPath());
        $this->redirectCallback = $redirectCallback;
    }

    public function use(string $route, IRedirectHandler $handler): IUseRedirect
    {
        $this->routes[$route] = $handler;
        return $this;
    }

    /**
     * @return void
     */
    public function redirect()
    {
        $hasRedirected = false;
        foreach ($this->routes as $route => $handler) {
            if (!$hasRedirected && $this->matchRoute($route) && $handler->shouldRedirect($_GET)) {
                $hasRedirected = true;
                ($this->redirectCallback)($handler->redirectUrl($_GET));
            }
        }
    }

    private function normalizePath(string $path): string
    {
        $removeLeftSlash = fn(string $s): string => ltrim($s, '/');
        $removeRightSlash = fn(string $s): string => rtrim($s, '/');
        $removeQueryArgs = fn(string $s): string => strtok($s, '?');

        return $removeLeftSlash($removeRightSlash($removeQueryArgs($path)));
    }

    private function matchRoute(string $route): bool
    {
        return $route === '*' || $this->normalizePath($route) === $this->currentRoute;
    }
}
