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
    protected array $config = [
        'http' => [
            'base_uri' => 'https://open.douyin.com',
            'timeout' => 5,
        ],
    ];

    public function __construct(
        #[ArrayShape([
            'app_id' => 'string',
            'app_secret' => 'string',
            'http' => [
                'base_uri' => 'string',
                'timeout' => 'int',
                'http_errors' => 'boolean',
            ],
        ])]
        array $config
    ) {
        $this->config = array_replace_recursive($this->config, $config);
    }

    public function getAppId(): string
    {
        return $this->config['app_id'] ?? '';
    }

    public function getAppSecret(): string
    {
        return $this->config['app_secret'] ?? '';
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
