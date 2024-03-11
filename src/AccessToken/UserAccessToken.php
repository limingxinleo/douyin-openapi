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
}
