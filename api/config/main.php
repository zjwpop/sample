<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$components = array_merge(
    require(__DIR__ . '/components.php'),
    require(__DIR__ . '/db.php')// 数据库
);

$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'api',
    'name' => '****公司',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'params' => $params,
    'components' => $components,
    'modules' => $modules,
    'defaultRoute' => 'index',
	'layout' => '@api/views/layouts/main',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*.*.*.*'],
    ];

}

return $config;
