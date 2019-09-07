<?php
Yii::setAlias('@pc', dirname(dirname(__DIR__)) . '/pc');
Yii::setAlias('@m', dirname(dirname(__DIR__)) . '/m');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@mst', dirname(dirname(__DIR__)) . '/mst');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@common', dirname(dirname(__DIR__)) . '/common');

Yii::$container->set('yii\data\Pagination', [
	'pageParam' => 'page',
	'pageSizeParam' => 'pageSize',
	'defaultPageSize' => 20,
	'validatePage' => false,
]);

Yii::$container->set('yii\data\Sort', [
	'enableMultiSort' => true,
]);

Yii::$container->set('yii\widgets\ActiveField', [
	'inputOptions' => [
		'class' => ['form-control', 'input-sm'],
	],
]);
