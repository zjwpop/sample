<?php

$config = [
	'errorHandler' => [
		'errorAction' => 'site/error',
	],
	'request' => [
		'class' => 'yii\web\Request',
		'csrfParam' => '_csrf-frontend',
		'csrfCookie' => [
			'name' => '_csrf-frontend',
		],
	],
	'user' => [
		'identityClass' => 'common\models\table\User',
		'enableAutoLogin' => true,
		'identityCookie' => ['name' => '_identity-admin', 'httpOnly' =>false],
		'loginUrl' => '/user/login',
	],
	'session' => [
		'class' => 'yii\web\Session',
		// this is the name of the session cookie used for login on the backend
		'name' => 'advanced-frontend',
	],
	'urlManager' => [
		'enablePrettyUrl' => true,
		'showScriptName' => false,
		'rules' => require __DIR__ . '/route.php',
	],
	// 'authManager' => [
	// 	'class' => 'yii\rbac\DbManager',
	// ],
	'assetManager' => [
		'bundles' => [
			'yii\web\JqueryAsset' => [
				'sourcePath' => null,
				'basePath' => '@webroot',
				'baseUrl' => '@web',
				'js' => ['js/jquery/2.2.4/jquery.min.js'],
			],
			'yii\bootstrap\BootstrapAsset' => [
				'sourcePath' => null,
				'basePath' => '@webroot',
				'baseUrl' => '@web',
				'css' => ['css/bootstrap.min.css'],
			],
		]
	],
];

return $config;
