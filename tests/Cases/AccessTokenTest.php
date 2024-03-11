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

namespace HyperfTest\Cases;

use Hyperf\Codec\Json;
use HyperfTest\ApplicationStub;

/**
 * @internal
 * @coversNothing
 */
class AccessTokenTest extends AbstractTestCase
{
    public function testGetClientAccessToken()
    {
        $application = ApplicationStub::mockApplication();

        $token = $application->client_access_token->getToken();

        $this->assertSame('clt.0cafbd032b7211ab4023043e0a75c5aa3hBvmjK7dfwZiFz1C255GPrk7i', $token);
    }

    public function testWebCastMateInfo()
    {
        $application = ApplicationStub::mockApplication();

        $res = $application->http->client($application->tou_tiao_access_token)->request(
            'POST',
            'https://webcast.bytedance.com/api/webcastmate/info',
            [
                'json' => [
                    'token' => 'xxx',
                ],
            ]
        );

        $data = Json::decode((string) $res->getBody());

        $this->assertSame(40002, $data['errcode']);
    }
}
