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
		'identityClass' => 'common\models\table\abc\User',
		'enableAutoLogin' => true,
		'identityCookie' => ['name' => '_identity-pc', 'httpOnly' =>false],
		'loginUrl' => 'partner/login',
	],
	'member' => [
			'class' => 'yii\web\User',
			'identityClass' => 'common\models\table\abc\Member',
			'enableAutoLogin' => true,
			'identityCookie' => ['name' => '_identity-member', 'httpOnly' => true],
			'idParam' => '__member-id',
			'authTimeoutParam' => '__member-expire',
			'absoluteAuthTimeoutParam' => '__memberabsoluteExpire',
			'returnUrlParam' => '__member-returnUrl',
			'loginUrl' => ['/member/login'],
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
