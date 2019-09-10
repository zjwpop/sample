<?php

$config = [
	'abc' => [
		'class' => 'mst\modules\abc\Module',
		'layout' => '@mst/views/layout/abc',
	],
	'nmc' => [
		'class' => 'mst\modules\nmc\Module',
		'layout' => '@mst/views/layouts/abc',
	],
	'gridview' => [
		'class' => 'kartik\grid\Module',
	],
];

return $config;
