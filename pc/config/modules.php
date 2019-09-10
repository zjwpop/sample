<?php

$config = [
	'api' => [
		'class' => 'pc\modules\api\Module',
		'layout' => '@pc/views/layouts/api',
	],
	'member' => [
		'class' => 'pc\modules\member\Module',
		'layout' => '@pc/views/layouts/member',
	],
	'partner' => [
		'class' => 'pc\modules\partner\Module',
		'layout' => '@pc/views/layouts/partner',
	],
	'gridview' => [
		'class' => 'kartik\grid\Module',
	],
];

return $config;
