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

use Fan\DouYin\OpenApi\AccessTokenInterface;
use Fan\DouYin\OpenApi\Application;
use Fan\DouYin\OpenApi\Config\Config;
use Fan\DouYin\OpenApi\Exception\RuntimeException;
use Fan\DouYin\OpenApi\Http\Client;
use Fan\DouYin\OpenApi\ProviderInterface;
use GuzzleHttp\RequestOptions;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

abstract class AccessToken implements AccessTokenInterface, ProviderInterface
{
    protected Config $config;

    protected Client $client;

    /**
     * @param Application $container
     */
    public function __construct(protected Container $container)
    {
        $this->config = $container[Config::getName()];
        $this->client = $container[Client::getName()];
    }

    public function request(): array
    {
        $response = $this->client->client()->request('POST', $this->getUri(), [
            RequestOptions::JSON => $this->buildOAuthBody(),
        ]);

        return $this->handleResponse($response);
    }

    public function handleResponse(ResponseInterface $response): array
    {
        return $this->client->handleResponse($response);
    }

    public function storeKey(string $name): string
    {
        return sprintf('token:%s:%s', $name, $this->config->getClientKey());
    }

    public function cache(): CacheInterface
    {
        $cache = $this->container['cache'] ?? null;
        if (! $cache instanceof CacheInterface) {
            throw new RuntimeException('You must implements cache interface.');
        }

        return $cache;
    }
}
