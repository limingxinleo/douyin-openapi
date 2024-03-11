<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Fan\DouYin\OpenApi\AccessToken;

class ClientAccessToken extends AccessToken
{
    public static function getName(): string
    {
        return 'client_access_token';
    }

    public function getUri(): string
    {
        return '/oauth/client_token/';
    }

    public function buildOAuthBody(): array
    {
        return [
            'client_key' => $this->config->getClientKey(),
            'client_secret' => $this->config->getClientSecret(),
            'grant_type' => 'client_credential',
        ];
    }

    public function getToken(): string
    {
        // {
        //     "access_token": "clt.75c380db41e815978a733994d96f5d23RqilUxH48iobyWhbIOQFo******",
        //     "description": "",
        //     "error_code": 0,
        //     "expires_in": 7200
        // }
        $result = $this->request();

        return $result['access_token'];
    }
}
