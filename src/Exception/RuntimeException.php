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

namespace Fan\DouYin\OpenApi\Exception;

class RuntimeException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, protected array $raw = [])
    {
        parent::__construct($message, $code);
    }

    public function getRaw(): array
    {
        return $this->raw;
    }
}
