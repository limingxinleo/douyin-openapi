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

use Fan\DouYin\OpenApi\Kernel\HasContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\SimpleCache\CacheInterface;

class CacheProvider implements ServiceProviderInterface
{
    use HasContainer;

    public function register(Container $pimple)
    {
        $cache = $this->get(CacheInterface::class);

        $pimple['cache'] = $cache ?? new MemoryCache();
    }
}
