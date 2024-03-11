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

use JetBrains\PhpStorm\ArrayShape;

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

    #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int'])]
    public function getToken(): array
    {
        return $this->request();
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function store(array $token): array
    {
        // TODO: Implement store() method.
    }
}
