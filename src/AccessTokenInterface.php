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

namespace Fan\DouYin\OpenApi;

use JetBrains\PhpStorm\ArrayShape;

interface AccessTokenInterface
{
    public function getUri(): string;

    public function buildOAuthBody(): array;

    public function getHeaders(): array;

    #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int', 'expired_at' => 'int'])]
    public function store(array $token): array;
}
