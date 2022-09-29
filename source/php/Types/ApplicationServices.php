<?php
namespace ModMyPages\Types;

use ModMyPages\Cookie\Types\ICookieRepository;
use ModMyPages\Services\Types\IGetQueriredObjectIdCallback;
use ModMyPages\Redirects\Types\IRedirectCallback;

class ApplicationServices
{
    public ICookieRepository $cookieRepository;

    public IRedirectCallback $redirectCallback;
    
    public IGetQueriredObjectIdCallback $getQueriedObjectId;
}
