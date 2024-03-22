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
class PaymentTest extends AbstractTestCase
{
    public function testSign()
    {
        $data = [
            'out_order_no' => 'xxxx',
            'total_amount' => 1,
            'subject' => '测试',
            'body' => '测试',
            'valid_time' => 3600,
            'nonce' => '65fd369b88bfd',
        ];

        $app = ApplicationStub::mockApplication();

        $result = $app->payment->sign($data);

        $this->assertSame('1efa107f9d85b4aad52f4e297e85b70e', $result);
    }

    public function testSignNotify()
    {
        $json = '{
    "msg": "{}",
    "msg_signature": "ca15658c3c5448a3226583ba0f51291ca3c11ede",
    "nonce": "3404",
    "timestamp": "1711098221",
    "type": "payment"
}';
        $json = Json::decode($json);

        $app = ApplicationStub::mockApplication();

        $result = $app->payment->signNotify($json);

        $this->assertSame('ca15658c3c5448a3226583ba0f51291ca3c11ede', $result);
    }
}
