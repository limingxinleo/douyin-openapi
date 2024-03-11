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

namespace Fan\DouYin\OpenApi;

use JetBrains\PhpStorm\ArrayShape;
use Pimple\Container;

/**
 * @property Config\Config $config
 */
class Application
{
    private Container $container;

    private array $providers = [
    ];

    public function __construct(
        #[ArrayShape([
            'client_key' => 'string',
            'client_secret' => 'string',
            'http' => [
                'base_uri' => 'string',
                'timeout' => 'int',
                'http_errors' => 'boolean',
            ],
        ])]
        array $config
    ) {
        $config = new Config\Config($config);
        $this->container = new Container([
            'config' => $config,
        ]);

        foreach ($this->providers as $provider) {
            $this->container->register(new $provider());
        }
    }

    public function __get(string $name)
    {
        return $this->container[$name] ?? null;
    }
}
