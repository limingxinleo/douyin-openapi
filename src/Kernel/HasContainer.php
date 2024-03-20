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

namespace Fan\DouYin\OpenApi\Kernel;

use Hyperf\Context\ApplicationContext;

trait HasContainer
{
    public function get(string $interface): mixed
    {
        if (! ApplicationContext::hasContainer()) {
            return null;
        }

        if (! ApplicationContext::getContainer()->has($interface)) {
            return null;
        }

        return ApplicationContext::getContainer()->get($interface);
    }
}
