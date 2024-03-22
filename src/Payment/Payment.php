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

namespace Fan\DouYin\OpenApi\Payment;

use Fan\DouYin\OpenApi\Application;
use Fan\DouYin\OpenApi\Config\Config;
use Fan\DouYin\OpenApi\ProviderInterface;
use Pimple\Container;

class Payment implements ProviderInterface
{
    protected Config $config;

    /**
     * @param Application $container
     */
    public function __construct(protected Container $container)
    {
        $this->config = $container->config;
    }

    public static function getName(): string
    {
        return 'payment';
    }
}
