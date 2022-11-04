<?php

namespace ModMyPages\Redirect\Handlers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use ModMyPages\Redirect\IRedirectHandler;
use ModMyPages\Redirect\IRedirectHandlerFactory;
use ModMyPages\Services\Types\ITokenService;
use UnexpectedValueException;

class AuthenticateUser implements IRedirectHandler, IRedirectHandlerFactory
{
    private string $successUrl;

    private string $errorUrl;

    private ITokenService $tokenService;

    private Key $secret;

    private \Closure $onSuccess;

    private \Closure $onError;

    public function __construct(array $args)
    {
        $logError = defined('WP_DEBUG') && WP_DEBUG
            ? function (string $msg) {
                error_log('Failed to decode JWT: ' . $msg);
                error_log(PHP_EOL);
            }
            : fn (string $msg) => $msg;

        $this->successUrl = $args['successUrl'];
        $this->errorUrl = $args['errorUrl'];
        $this->tokenService = $args['tokenService'];
        $this->secret = $args['jwtSecretKey'];
        $this->onSuccess = $args['onSuccess'] ?? fn (string $jwt) => null;
        $this->onError = $args['onError'] ?? $logError;
    }

    public function redirectUrl(array $args): string
    {
        try {
            $jwt = ($this->tokenService)($args['ts_session_id']);

            if (!empty($jwt)) {
                JWT::decode($jwt, $this->secret);
                ($this->onSuccess)($jwt);
                return $args['callbackUrl'] ?? $this->successUrl;
            }
        } catch (LogicException $e) {
            // errors having to do with environmental setup or malformed JWT Keys
            ($this->onError)($e->getMessage());
        } catch (UnexpectedValueException $e) {
            // errors having to do with JWT signature and claims
            ($this->onError)($e->getMessage());
        }

        return $args['callbackUrl'] ?? $this->errorUrl;
    }

    public function shouldRedirect(array $args): bool
    {
        return true;
    }

    public static function create(array $args = []): IRedirectHandler
    {
        return new AuthenticateUser($args);
    }
}
