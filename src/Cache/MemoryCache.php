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

use DateInterval;
use Fan\DouYin\OpenApi\Exception\RuntimeException;
use Psr\SimpleCache\CacheInterface;

class MemoryCache implements CacheInterface
{
    protected static $data = [];

    public function get(string $key, mixed $default = null): mixed
    {
        return self::$data[$key] ?? $default;
    }

    public function set(string $key, mixed $value, null|DateInterval|int $ttl = null): bool
    {
        self::$data[$key] = $value;
        return true;
    }

    public function delete(string $key): bool
    {
        unset(self::$data[$key]);
        return true;
    }

    public function clear(): bool
    {
        self::$data = [];
        return true;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        throw new RuntimeException('Not Support');
    }

    public function setMultiple(iterable $values, null|DateInterval|int $ttl = null): bool
    {
        throw new RuntimeException('Not Support');
    }

    public function deleteMultiple(iterable $keys): bool
    {
        throw new RuntimeException('Not Support');
    }

    public function has(string $key): bool
    {
        return isset(self::$data[$key]);
    }
}
