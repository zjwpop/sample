<?php

$config = [
	// 'login' => '/user/login',
	// 'logout' => '/user/logout',

	'//<_m>.mst.sample.cc' => '<_m>/index',
	[
		'pattern' => '//<_m>.mst.sample.cc/car/<id:\d+>',
		'suffix' => '.html',
		'route' => '<_m>/car/detail',
	],

	'//<_m>.mst.sample.cc/<controller>' => '<_m>/<controller>/index',
	'//<_m>.mst.sample.cc/<controller>/<action>' => '<_m>/<controller>/<action>',

	// 'http://<_m:[^www]\w+>.kuitao8.com' => 'member',//绑定除 www 的所有域名到Member模块
];

return $config;
