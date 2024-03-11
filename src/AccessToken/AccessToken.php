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
use Fan\DouYin\OpenApi\Config\Config;
use Fan\DouYin\OpenApi\Http\Client;
use Fan\DouYin\OpenApi\ProviderInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

abstract class AccessToken implements AccessTokenInterface, ProviderInterface
{
    public function __construct(protected Config $config, protected Client $client)
    {
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
}
