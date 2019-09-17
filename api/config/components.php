<?php

$config = [
	'errorHandler' => [
		'errorAction' => 'site/error',
	],
	'request' => [
		'class' => 'yii\web\Request',
		'csrfParam' => '_csrf-api',
		'csrfCookie' => [
			'name' => '_csrf-api',
		],
	],
	'user' => [
		'identityClass' => 'common\models\table\abc\User',
		'enableAutoLogin' => true,
		'identityCookie' => ['name' => '_identity-api', 'httpOnly' =>false],
		// 'loginUrl' => '/user/login',
	],
	// 'session' => [
	// 	'class' => 'yii\web\Session',
	// 	// this is the name of the session cookie used for login on the backend
	// 	'name' => 'advanced-api',
	// ],
	'urlManager' => [
		'enablePrettyUrl' => true,
		'showScriptName' => false,
		'rules' => require __DIR__ . '/route.php',
	],
];

return $config;
