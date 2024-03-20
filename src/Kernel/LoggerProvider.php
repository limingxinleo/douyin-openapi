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

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Log\LoggerInterface;

class LoggerProvider implements ServiceProviderInterface
{
    use HasContainer;

    public function register(Container $pimple)
    {
        $pimple['logger'] = $this->get(LoggerInterface::class);
    }
}
