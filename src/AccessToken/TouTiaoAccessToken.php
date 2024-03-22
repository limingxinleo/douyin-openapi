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

use Fan\DouYin\OpenApi\Exception\RuntimeException;
use Hyperf\Codec\Json;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Http\Message\ResponseInterface;

class TouTiaoAccessToken extends AccessToken
{
    public static function getName(): string
    {
        return 'tou_tiao_access_token';
    }

    public function getUri(): string
    {
        return 'https://developer.toutiao.com/api/apps/v2/token';
    }

    public function buildOAuthBody(): array
    {
        return [
            'appid' => $this->config->getAppId(),
            'secret' => $this->config->getAppSecret(),
            'grant_type' => 'client_credential',
        ];
    }

    #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int', 'expired_at' => 'int'])]
    public function getToken(bool $fresh = false): array
    {
        $result = null;
        if (! $fresh) {
            $result = $this->cache()->get($this->storeKey(self::getName()));
            if ($result && $result['expired_at'] < time()) {
                $result = null;
            }
        }

        if (! $result) {
            $result = $this->store($this->request());
        }

        return $result;
    }

    public function handleResponse(ResponseInterface $response): array
    {
        $ret = Json::decode((string) $response->getBody());
        $code = $ret['err_no'];
        if ($code !== 0) {
            throw new RuntimeException($ret['err_tips'] ?? 'http request failed.', $code, $ret);
        }

        return $ret['data'];
    }

    public function getHeaders(): array
    {
        return [
            'x-token' => $this->getToken()['access_token'],
        ];
    }

    #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int', 'expired_at' => 'int'])]
    public function store(
        #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int'])]
        array $token
    ): array {
        $expiresIn = $token['expires_in'] - 600;

        $token = array_merge($token, ['expired_at' => time() + $expiresIn]);

        $this->cache()->set($this->storeKey(self::getName()), $token, $expiresIn);

        return $token;
    }
}
