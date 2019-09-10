<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'iUbyeYZfG0PHMP4YPM5QJU7XhIwwVEVt',
        ],
    ],
];
$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
	'class' => 'yii\gii\Module',
	'generators' => [
		'model' => [
			'class' => 'yii\gii\generators\model\Generator',
			'ns' => 'common\models\base',
			'baseClass' => 'common\extensions\ActiveRecord',
			'generateLabelsFromComments' => true,
			'useTablePrefix' => false,
		],
		'crud' => [
			'class' => 'yii\gii\generators\crud\Generator',
			'modelClass' => 'common\models\table\(Model名)',
			'controllerClass' => 'mst\controllers\(控制器名)Controller',
			'viewPath' => '@mst/views/(路由)',
			'baseControllerClass' => 'mst\controllers\base\AuthController',
			'searchModelClass' => 'common\models\search\(Model名)Search',
		],
	],
];

return $config;
