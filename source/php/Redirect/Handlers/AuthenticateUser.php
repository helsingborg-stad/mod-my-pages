<?php

namespace ModMyPages\Redirect\Handlers;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use ModMyPages\Redirect\IRedirectHandler;
use ModMyPages\Redirect\IRedirectHandlerFactory;
use ModMyPages\Service\TokenService\ITokenService;
use UnexpectedValueException;

class AuthenticateUser implements IRedirectHandler, IRedirectHandlerFactory
{
    private string $successUrl;

    private string $errorUrl;

    private ITokenService $tokenService;

    private Key $secret;

    private Closure $onSuccess;

    private Closure $onError;

    public function __construct(array $args)
    {
        $this->successUrl = $args['successUrl'];
        $this->errorUrl = $args['errorUrl'];
        $this->tokenService = $args['tokenService'];
        $this->secret = $args['jwtSecretKey'];
        $this->onSuccess = $args['onSuccess'];
        $this->onError = $args['onError'];
    }

    public function redirectUrl(array $queryParams): string
    {
        try {
            $jwt = !empty($queryParams['ts_session_id'])
                ? ($this->tokenService)($queryParams['ts_session_id'])
                : null;

            if (!empty($jwt)) {
                JWT::decode($jwt, $this->secret);
                ($this->onSuccess)($jwt);
                return $queryParams['callbackUrl'] ?? $this->successUrl;
            }
        } catch (LogicException $e) {
            // errors having to do with environmental setup or malformed JWT Keys
            ($this->onError)($e->getMessage());
        } catch (UnexpectedValueException $e) {
            // errors having to do with JWT signature and claims
            ($this->onError)($e->getMessage());
        }

        return $queryParams['callbackUrl'] ?? $this->errorUrl;
    }

    public function shouldRedirect(array $queryParams): bool
    {
        return true;
    }

    public static function create(array $args = []): IRedirectHandler
    {
        $logError = function (string $msg): void {
            error_log('Failed to decode JWT: ' . $msg);
            error_log(PHP_EOL);
        };

        return new AuthenticateUser(array_merge(
            [
                'onSuccess' => fn (string $jwt) => null,
                'onError' => defined('WP_DEBUG') && WP_DEBUG
                    ? $logError
                    : fn (string $msg) => $msg,
            ],
            $args
        ));
    }
}
