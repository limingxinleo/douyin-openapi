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

use Fan\DouYin\OpenApi\AccessToken\AccessTokenProvider;
use Fan\DouYin\OpenApi\Http\ClientProvider;
use JetBrains\PhpStorm\ArrayShape;
use Pimple\Container;

/**
 * @property Config\Config $config
 * @property AccessToken\ClientAccessToken $client_access_token
 * @property AccessToken\UserAccessToken $user_access_token
 * @property Http\Client $http
 */
class Application
{
    private Container $container;

    private array $providers = [
        AccessTokenProvider::class,
        ClientProvider::class,
    ];

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
        array $config
    ) {
        $config = new Config\Config($config);
        $this->container = new Container([
            Config\Config::getName() => $config,
        ]);

        foreach ($this->providers as $provider) {
            $this->container->register(new $provider());
        }
    }

    public function __get(string $name)
    {
        return $this->container[$name] ?? null;
    }

    public function __set(string $name, mixed $callback)
    {
        $this->container[$name] = $callback;
    }
}
