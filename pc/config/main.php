<?php

$public_params =	file_exists(__DIR__.'/../../common/config/params.php') ? require(__DIR__.'/../../common/config/params.php') : [];
$public_local_params =	file_exists(__DIR__.'/../../common/config/params-local.php') ? require(__DIR__.'/../../common/config/params-local.php') : [];
$app_params = file_exists(__DIR__.'/params.php') ? require(__DIR__.'/params.php') : [];
$app_local_params = file_exists(__DIR__.'/params-local.php') ? require(__DIR__.'/params-local.php') : [];

$params = array_merge($public_params,$public_local_params,$app_params,$app_local_params);

$components = array_merge(
	require(__DIR__.'/components.php'),
	require(__DIR__.'/db.php')// 数据库
);

$modules = require __DIR__.'/modules.php';

$config = [
	'id' => 'pc',
	'name' => 'company',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'controllerNamespace' => 'pc\controllers',
	'params' => $params,
	'components' => $components,
	'modules' => $modules,
	'defaultRoute' => 'index',
	'layout' => '@pc/views/layouts/main',
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
