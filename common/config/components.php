<?php

$config = [
	'request' => [
		'class' => 'yii\web\Request',
		'csrfParam' => '_csrf-frontend',
		'csrfCookie' => [
			'name' => '_csrf-frontend',
		],
	],
	'user' => [
		'identityClass' => 'common\models\table\Member',
		'enableAutoLogin' => true,
		'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
		'loginUrl' => '/user/login',
	],
	'session' => [
		'class' => 'yii\web\Session',
		// this is the name of the session cookie used for login on the backend
		'name' => 'advanced-frontend',
	],
	'errorHandler' => [
		'errorAction' => 'site/error',
	],
	'urlManager' => [
		'enablePrettyUrl' => true,
		'showScriptName' => false,
	],
	'formatter' => [
		// 'nullDisplay' => '',
		'dateFormat' => 'php:Y-m-d',
		'datetimeFormat' => 'php:Y-m-d H:i:s',
	],
	'cache' => [
		'class' => 'yii\caching\FileCache',
	],
	'log' => [
		'traceLevel' => YII_DEBUG ? 3 : 0,
		'targets' => [
			[
				'class' => 'yii\log\FileTarget',
				'levels' => ['error', 'warning'],
			],
		],
	],
];

return $config;
