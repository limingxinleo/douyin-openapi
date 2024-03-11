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
            'appid' => $this->config->getClientKey(),
            'secret' => $this->config->getClientSecret(),
            'grant_type' => 'client_credential',
        ];
    }

    #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int'])]
    public function getToken(): array
    {
        return $this->request();
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
}
