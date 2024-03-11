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

namespace Fan\DouYin\OpenApi\Config;

use Fan\DouYin\OpenApi\ProviderInterface;
use JetBrains\PhpStorm\ArrayShape;

class Config implements ProviderInterface
{
    public function __construct(
        #[ArrayShape([
            'client_key' => 'string',
            'client_secret' => 'string',
            'http' => [
                'base_uri' => 'string',
                'timeout' => 'int',
                'http_errors' => 'boolean',
            ],
        ])]
        protected array $config
    ) {
    }

    public function getClientKey(): string
    {
        return $this->config['client_key'] ?? '';
    }

    public function getClientSecret(): string
    {
        return $this->config['client_secret'] ?? '';
    }

    #[ArrayShape(['base_uri' => 'string', 'timeout' => 'int'])]
    public function getHttp(): array
    {
        return $this->config['http'];
    }

    public function toArray(): array
    {
        return $this->config;
    }

    public static function getName(): string
    {
        return 'config';
    }
}
