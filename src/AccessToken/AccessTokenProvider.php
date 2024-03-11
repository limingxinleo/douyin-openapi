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

namespace Fan\DouYin\OpenApi\AccessToken;

use Fan\DouYin\OpenApi\Config\Config;
use Fan\DouYin\OpenApi\Http\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AccessTokenProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple[UserAccessToken::getName()] = fn () => new UserAccessToken(
            $pimple[Config::getName()],
            $pimple[Client::getName()]
        );

        $pimple[ClientAccessToken::getName()] = fn () => new ClientAccessToken(
            $pimple[Config::getName()],
            $pimple[Client::getName()]
        );
    }
}
