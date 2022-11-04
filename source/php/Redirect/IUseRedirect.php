<?php

namespace ModMyPages\Redirect;

interface IUseRedirect
{
    public function use(string $route, IRedirectHandler $handler): IUseRedirect;
    public function redirect();
}
