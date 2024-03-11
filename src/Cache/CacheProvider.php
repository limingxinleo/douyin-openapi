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

namespace Fan\DouYin\OpenApi\Cache;

use Hyperf\Context\ApplicationContext;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\SimpleCache\CacheInterface;

class CacheProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        if (ApplicationContext::hasContainer() && ApplicationContext::getContainer()->has(CacheInterface::class) && $cache = ApplicationContext::getContainer()->get(CacheInterface::class)) {
            $pimple['cache'] = $cache;
        }
    }
}
