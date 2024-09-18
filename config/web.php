<?php

use app\repositories\RefreshTokenRepository;
use app\services\RefreshTokenService;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '8NF_G9Mzj6Qxzf91aG7VM1TQYkzSyJ6J',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ],
            'enableCsrfValidation' => false,
        ],
        'authManager' => [
            'class' => 'app\components\JwtAuthFilter',
            'refreshTokenService' => [
                'class' => RefreshTokenService::class,
                'refreshTokenRepository' => [
                    'class' => RefreshTokenRepository::class,
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => \app\models\User::class,
            'enableAutoLogin' => true,
        ],
        'userService' => [
            'class' => \app\services\UserService::class,
            'userRepository' => ['class' => 'app\repositories\UserRepository'],
            'jwtSecretKey' => 'yiibookrestapi',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/app.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/info.log',
                ],
            ],
        ],
        'db' => array_merge(
            ['class' => 'yii\db\Connection'],
            $db
        ),
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'simple/index' => 'simple/index',
                'user/signup' => 'user/signup',
                'user/signin' => 'user/signin',
                'user/signout' => 'user/signout',
                'customer/create' => 'customer/create',
                'customer/list' => 'customer/list',
                'customer/delete' => 'customer/delete',
                'book/add' => 'book/create',
                'book/list' => 'book/list',
                'book/delete' => 'book/delete',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '10.10.0.22', '10.10.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '10.10.0.22', '10.10.0.1'],
    ];
}

return $config;
