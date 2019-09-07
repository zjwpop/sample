<?php

$config = [
	'nmc' => [
		'class' => 'mst\modules\nmc\Module',
		'layout' => '@mst/views/layout/nmc',
	],
	'cdd' => [
		'class' => 'mst\modules\cdd\Module',
		'layout' => '@mst/views/layouts/cdd',
	],
	'gridview' => [
		'class' => 'kartik\grid\Module',
	],
];

return $config;
