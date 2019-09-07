<?php

$config = [
	'errorHandler' => [
		'errorAction' => 'site/error',
	],
	'request' => [
		'class' => 'yii\web\Request',
		'csrfParam' => '_csrf-pc',
		'csrfCookie' => [
			'name' => '_csrf-pc',
		],
	],
	'user' => [
		'identityClass' => 'common\models\table\all\User',
		'enableAutoLogin' => true,
		'identityCookie' => ['name' => '_identity-pc', 'httpOnly' =>false],
		'loginUrl' => '/login',
	],
	'master' => [
			'class' => 'yii\web\User',
			'identityClass' => 'common\models\table\all\Master',
			'enableAutoLogin' => true,
			'identityCookie' => ['name' => '_identity-master', 'httpOnly' => true],
			'idParam' => '__manster-id',
			'authTimeoutParam' => '__manster-expire',
			'absoluteAuthTimeoutParam' => '__manster-absoluteExpire',
			'returnUrlParam' => '__manster-returnUrl',
			'loginUrl' => ['/user/login'],
		],
	'session' => [
		'class' => 'yii\web\Session',
		// this is the name of the session cookie used for login on the backend
		'name' => 'advanced-pc',
	],
	'urlManager' => [
		'enablePrettyUrl' => true,
		'showScriptName' => false,
		'rules' => require __DIR__ . '/route.php',
	],
];

return $config;
