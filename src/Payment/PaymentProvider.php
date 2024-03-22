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

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class PaymentProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple[Payment::getName()] = fn () => new Payment($pimple);
    }
}
