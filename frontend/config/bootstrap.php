<?php

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
