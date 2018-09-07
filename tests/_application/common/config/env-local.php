<?php

use yii\helpers\ArrayHelper;
use yii2lab\test\helpers\TestHelper;

$config = [
    'jwt' => [
        'profiles' => [
            'default' => [
                'key' => 'qwerty123456',
                'life_time' => \yii2lab\misc\enums\TimeEnum::SECOND_PER_MINUTE * 20,
                'allowed_algs' => ['HS256', 'SHA512', 'HS384'],
                'default_alg' => 'HS256',
                'audience' => ["http://api.core.yii"],
            ],
        ],
    ],
];

$baseConfig = TestHelper::loadConfig('common/config/env-local.php');
return ArrayHelper::merge($baseConfig, $config);
