<?php

namespace ModMyPages\Redirects\Handlers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use ModMyPages\Redirects\Types\IRedirectHandler;
use ModMyPages\Services\Types\ICookieRepository;
use ModMyPages\Services\Types\ITokenService;
use ModMyPages\Token\AccessToken;
use UnexpectedValueException;

class AuthenticateUser implements IRedirectHandler
{
    private string $successUrl;

    private string $errorUrl;

    private ICookieRepository $cookies;

    private ITokenService $tokenService;

    private string $cookieDomain;

    private string $jwtSecretKey;

    public function __construct(array $args)
    {
        $this->successUrl = $args['successUrl'];
        $this->errorUrl = $args['errorUrl'];
        $this->cookies = $args['cookies'];
        $this->tokenService = $args['tokenService'];
        $this->cookieDomain = $args['cookieDomain'] ?? '';
        $this->jwtSecretKey = $args['jwtSecretKey'];
    }

    public function redirectUrl(array $args): string
    {
        $logError = defined('WP_DEBUG') && WP_DEBUG
            ? function (string $msg) {
                error_log('Failed to decode JWT: ' . $msg);
                error_log(PHP_EOL);
            }
            : fn (string $msg) => $msg;

        try {
            $jwt = ($this->tokenService)($args['ts_session_id']);

            if (!empty($jwt)) {
                JWT::decode($jwt, new Key($this->jwtSecretKey, 'HS256'));
                $this->cookies->set(AccessToken::$cookieName, $jwt);
                return $args['callbackUrl'] ?? $this->successUrl;
            }
        } catch (LogicException $e) {
            // errors having to do with environmental setup or malformed JWT Keys
            $logError($e->getMessage());
        } catch (UnexpectedValueException $e) {
            // errors having to do with JWT signature and claims
            $logError($e->getMessage());
        }

        return $this->errorUrl;
    }

    public function shouldRedirect(array $args): bool
    {
        return !empty($args['ts_session_id']);
    }
}
