<?php

namespace ModMyPages\Rest;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use ModMyPages\Plugin\ActionHookSubscriber;
use ModMyPages\Service\ACFService\ACFGetOption;
use ModMyPages\Service\CookieRepository\ICookieRepository;
use ModMyPages\Service\WPService\RegisterRestRoute;

class AccessToken implements ActionHookSubscriber
{
    private RegisterRestRoute $wp;
    private ACFGetOption $acf;
    private ICookieRepository $cookies;

    public function __construct(
        RegisterRestRoute $wp,
        ACFGetOption $acf,
        ICookieRepository $cookies
    ) {
        $this->acf = $acf;
        $this->wp = $wp;
        $this->cookies = $cookies;
    }

    public static function addActions(): array
    {
        return [
            ['rest_api_init', 'init']
        ];
    }

    public function init()
    {
        $this->wp->registerRestRoute('mod-my-pages/v1', '/access-token', array(
            'methods' => 'POST',
            'callback' => function () { {
                    $tryDecodeToken = function (string $jwt) {
                        $decoded = null;
                        try {
                            $decoded = JWT::decode(
                                $jwt,
                                new Key($this->acf->getOption('mod_my_pages_api_auth_secret') ?: 'apan_japan', 'HS256')
                            );
                        } catch (Exception $e) {
                            error_log('REST ---------' . PHP_EOL);
                            error_log('/access-token');
                            error_log(print_r($e->getMessage(), true));
                            error_log('END REST ---------' . PHP_EOL);
                            $this->cookies->set(\ModMyPages\Token\AccessToken::$cookieName, '');
                        }

                        return $decoded;
                    };

                    $token = $this->cookies->get(\ModMyPages\Token\AccessToken::$cookieName);

                    return [
                        'token' => $tryDecodeToken($token) ? $token : '',
                        'expires' => $tryDecodeToken($token)->exp ?? 0,
                        'decoded' => $tryDecodeToken($token)
                    ];
                }
            }
        ));
    }
}
