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

use Fan\DouYin\OpenApi\Application;

/**
 * @internal
 * @coversNothing
 */
class ConfigTest extends AbstractTestCase
{
    public function testConfig()
    {
        $config = [
            'client_key' => 'xxx',
            'client_secret' => 'xxxxxx',
        ];

        $application = new Application($config);

        $this->assertSame('xxx', $application->config->getClientKey());
        $this->assertSame('xxxxxx', $application->config->getClientSecret());
    }
}
