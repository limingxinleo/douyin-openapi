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

namespace HyperfTest;

use Fan\DouYin\OpenApi\Application;
use Fan\DouYin\OpenApi\Http\Client;
use GuzzleHttp\Psr7\Response;
use Hyperf\Codec\Json;
use Mockery;
use ReflectionClass;

class ApplicationStub
{
    public static function mockApplication(): Application
    {
        $application = new Application([
            'client_key' => 'ttcf9eb92350af05b110',
            'client_secret' => '4ea43a0b800d87c36ea5cd10ae2ca8a6ede1ce3b',
        ]);

        $rel = new ReflectionClass($application);
        $container = $rel->getProperty('container')->getValue($application);

        $application->http = $http = Mockery::mock(Client::class . '[client]', [$container, $application->config->getHttp()]);
        $http->shouldReceive('client')->withAnyArgs()->andReturn($client = Mockery::mock(\GuzzleHttp\Client::class));
        $client->shouldReceive('request')->withAnyArgs()->andReturnUsing(function ($method, $uri, $options) {
            $result = match ($uri) {
                '/oauth/client_token/' => [
                    'data' => [
                        'error_code' => 0,
                        'access_token' => 'clt.0cafbd032b7211ab4023043e0a75c5aa3hBvmjK7dfwZiFz1C255GPrk7i',
                        'expires_in' => 7200,
                    ],
                ],
                'https://webcast.bytedance.com/api/webcastmate/info' => [
                    'errcode' => 40002,
                    'errmsg' => "you don't have permission",
                ],
            };

            return new Response(body: Json::encode($result));
        });

        return $application;
    }
}
