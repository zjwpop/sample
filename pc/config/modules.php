<?php

$config = [
	'master' => [
		'class' => 'pc\modules\master\Module',
		'layout' => '@pc/views/layouts/master',
	],
	'api' => [
		'class' => 'pc\modules\api\Module',
		'layout' => '@pc/views/layouts/api',
	],
	'my' => [
		'class' => 'pc\modules\my\Module',
		'layout' => '@pc/views/layouts/my',
	],
	'gridview' => [
		'class' => 'kartik\grid\Module',
	],
];

return $config;
