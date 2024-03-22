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
use Fan\DouYin\OpenApi\Cache\CacheProvider;
use Fan\DouYin\OpenApi\Http\ClientProvider;
use Fan\DouYin\OpenApi\Kernel\LoggerProvider;
use Fan\DouYin\OpenApi\Payment\Payment;
use Fan\DouYin\OpenApi\Payment\PaymentProvider;
use JetBrains\PhpStorm\ArrayShape;
use Pimple\Container;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @property Config\Config $config
 * @property AccessToken\ClientAccessToken $client_access_token
 * @property AccessToken\UserAccessToken $user_access_token
 * @property AccessToken\TouTiaoAccessToken $tou_tiao_access_token
 * @property Http\Client $http
 * @property CacheInterface $cache
 * @property ?LoggerInterface $logger
 * @property Payment $payment
 */
class Application
{
    private Container $container;

    private array $providers = [
        AccessTokenProvider::class,
        ClientProvider::class,
        CacheProvider::class,
        LoggerProvider::class,
        PaymentProvider::class,
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
