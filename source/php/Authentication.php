<?php

namespace ModMyPages;

class Authentication implements \ModMyPages\Redirect\IRedirectHandler
{
    private string $successUrl;
    private string $errorUrl;

    public function __construct(array $args)
    {
        $this->successUrl = $args['successUrl'];
        $this->errorUrl = $args['errorUrl'];
    }

    public function validate(array $args): bool
    {
        return !empty($args['ts_session_id']);
    }

    public function redirect(array $args): string
    {
        $token = \ModMyPages\Service\AuthService::token([
            'ts_session_id' => $args['ts_session_id']
        ]);

        if ($token && \ModMyPages\Session\Token::isValid($token)) {
            \ModMyPages\Session\Cookie::set($token);
            return $args['callbackUrl'] ?? $this->successUrl;
        }

        return $this->errorUrl;
    }
}
