<?php

namespace ModMyPages\Types;

use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Services\Types\IRedirectCallback;
use ModMyPages\Services\Types\IGetQueriredObjectIdCallback;

class ApplicationServices
{
    public ICookieRepository $cookieRepository;

    public IRedirectCallback $redirectCallback;

    public IGetQueriredObjectIdCallback $getQueriedObjectId;
}
