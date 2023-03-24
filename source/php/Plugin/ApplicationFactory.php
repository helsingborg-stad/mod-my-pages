<?php

namespace ModMyPages\Plugin;

use ModMyPages\Application;
use ModMyPages\Plugin\DI\DIContainer;
use ModMyPages\Plugin\DI\DIContainerFactory;
use ModMyPages\Redirect\IUseRedirect;
use ModMyPages\Redirect\UseRedirectFactory;
use ModMyPages\Service\ACFService\ACFService;
use ModMyPages\Service\ACFService\ACFServiceFactory;
use ModMyPages\Service\CookieRepository\CookieRepositoryFactory;
use ModMyPages\Service\CookieRepository\ICookieRepository;
use ModMyPages\Service\LoginUrlService\ILoginUrlService;
use ModMyPages\Service\LoginUrlService\LoginUrlServiceFactory;
use ModMyPages\Service\SignOutService\SignOutServiceFactory;
use ModMyPages\Service\TokenService\ITokenService;
use ModMyPages\Service\TokenService\TokenServiceFactory;
use ModMyPages\Service\WPService\WPService;
use ModMyPages\Service\WPService\WPServiceFactory;

trait ApplicationFactory
{
    public static function create(): Application
    {
        return new class (DIContainerFactory::create()) extends Application {
            public function bootstrap(DIContainer $DI)
            {
                /**
                 * @@var $withExtemsom
                 */
                $withExtensions = fn(string $className) => [
                    $className,
                    ...(new \ReflectionClass($className))->getInterfaceNames(),
                ];

                $DI->bind($withExtensions(WPService::class), WPServiceFactory::create());
                $DI->bind($withExtensions(ACFService::class), ACFServiceFactory::create());
                $DI->bind(ICookieRepository::class, CookieRepositoryFactory::createFromEnv());
                $DI->bind(IUseRedirect::class, UseRedirectFactory::createFromEnv());
                $DI->bind(ILoginUrlService::class, LoginUrlServiceFactory::createFromEnv());
                $DI->bind(ITokenService::class, TokenServiceFactory::createFromEnv());
                $DI->bind('\Closure\signOutService', SignOutServiceFactory::createFromEnv());
            }
        };
    }
}
