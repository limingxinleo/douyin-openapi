# 抖音 OpenAPI

```
composer require limingxinleo/douyin-openapi
```

## 如何使用

```php
<?php

use Fan\DouYin\OpenApi\Application;
use Psr\Container\ContainerInterface;

$config = [
    'app_id' => $app->app_id,
    'app_secret' => $app->secret,
    'payment' => [
        'salt' => $app->salt,
        'token' => $app->token,
    ],
];

// 协程安全，可以常驻到容器中
$dy = new Application($config);

// 创建预定单
$client = $dy->http->client(options: [
    'base_uri' => 'https://developer.toutiao.com',
    'timeout' => 5,
]);

$json = [
    'out_order_no' => 'xxx',
    'total_amount' => 'xxx',
    'subject' => 'xxx',
    'body' => 'xxx',
    'valid_time' => 'xxx',
    'cp_extra' => 'xxx',
    'thirdparty_id' => 'xxx',
    'notify_url' => 'xxx',
    'limit_pay_way' => 'xxx',
    'nonce' => 'xxx', // 无任何业务影响, 仅影响加签内容, 使同一请求的多次签名不同
];
$json['sign'] = $dy->payment->sign($json);
$json['app_id'] = $app->app_id;

$res = $client->post('/api/apps/ecpay/v1/create_order', [
    'json' => $json,
]);

$res = Json::decode($content)['data'] ?? [];

var_dump($res);
```
