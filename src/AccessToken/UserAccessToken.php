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

class UserAccessToken extends AccessToken
{
    public static function getName(): string
    {
        return 'user_access_token';
    }

    public function getUri(): string
    {
        return '/oauth/access_token/';
    }

    public function buildOAuthBody(): array
    {
        return [];
    }

    public function getHeaders(): array
    {
        return [];
    }

    #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int', 'expired_at' => 'int'])]
    public function store(array $token): array
    {
        return [];
    }
}
