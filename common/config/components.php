<?php

$config = [
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
		// 'class' => 'yii\caching\FileCache',
		'class' => 'yii\redis\Cache',
		'redis' => 'redis',
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
