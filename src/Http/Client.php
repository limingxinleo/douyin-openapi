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

namespace Fan\DouYin\OpenApi\Http;

use Fan\DouYin\OpenApi\AccessTokenInterface;
use Fan\DouYin\OpenApi\Exception\RuntimeException;
use Fan\DouYin\OpenApi\ProviderInterface;
use GuzzleHttp;
use GuzzleHttp\RequestOptions;
use Hyperf\Codec\Json;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;

use function Hyperf\Support\make;

class Client implements ProviderInterface
{
    public function __construct(protected Container $pimple, protected array $config)
    {
    }

    public function client(?AccessTokenInterface $token = null): GuzzleHttp\Client
    {
        $config = $this->config;
        if ($token) {
            $config[RequestOptions::HEADERS]['Authorization'] = 'Bearer ' . $token->getToken();
        }

        return make(GuzzleHttp\Client::class, [$config]);
    }

    public function handleResponse(ResponseInterface $response): array
    {
        $ret = Json::decode((string) $response->getBody());
        $code = $ret['data']['error_code'];
        if ($code !== 0) {
            throw new RuntimeException($ret['data']['description'] ?? 'http request failed.', $code, $ret);
        }

        return $ret['data'];
    }

    public static function getName(): string
    {
        return 'http';
    }
}
