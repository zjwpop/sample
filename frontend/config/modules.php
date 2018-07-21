<?php

$config = [
    'master' => [
        'class' => 'frontend\modules\master\Module',
        'layout' => '@frontend/views/layouts/master',
    ],
    'api' => [
        'class' => 'frontend\modules\api\Module',
        'layout' => '@frontend/views/layouts/api',
    ],
    'user' => [
        'class' => 'frontend\modules\user\Module',
        'layout' => '@frontend/views/layouts/user',
    ],
    'gridview' => [
		'class' => 'kartik\grid\Module',
	],
];

return $config;
