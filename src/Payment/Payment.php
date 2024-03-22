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
        $this->config = $container['config'];
    }

    public static function getName(): string
    {
        return 'payment';
    }

    public function sign(array $map): string
    {
        $rList = [];
        foreach ($map as $k => $v) {
            if ($k == 'other_settle_params' || $k == 'app_id' || $k == 'sign' || $k == 'thirdparty_id') {
                continue;
            }

            $value = trim(strval($v));
            if (is_array($v)) {
                $value = $this->arrayToStr($v);
            }
            $len = strlen($value);
            if ($len > 1 && str_starts_with($value, '"') && str_ends_with($value, '"')) {
                $value = substr($value, 1, $len - 1);
            }
            $value = trim($value);
            if ($value == '' || $value == 'null') {
                continue;
            }
            $rList[] = $value;
        }
        $rList[] = $this->config->get('payment.salt');
        sort($rList, SORT_STRING);
        return md5(implode('&', $rList));
    }

    public function arrayToStr($map): string
    {
        $isMap = ! array_is_list($map);

        $result = '';
        if ($isMap) {
            $result = 'map[';
        }

        ksort($map);

        $paramsArr = [];
        foreach ($map as $k => $v) {
            if ($isMap) {
                if (is_array($v)) {
                    $paramsArr[] = sprintf('%s:%s', $k, $this->arrayToStr($v));
                } else {
                    $paramsArr[] = sprintf('%s:%s', $k, trim(strval($v)));
                }
            } else {
                if (is_array($v)) {
                    $paramsArr[] = $this->arrayToStr($v);
                } else {
                    $paramsArr[] = trim(strval($v));
                }
            }
        }

        $result = sprintf('%s%s', $result, join(' ', $paramsArr));
        if (! $isMap) {
            $result = sprintf('[%s]', $result);
        } else {
            $result = sprintf('%s]', $result);
        }

        return $result;
    }
}
