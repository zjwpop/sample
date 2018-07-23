<?php
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@common', dirname(dirname(__DIR__)) . '/common');

Yii::$container->set('yii\data\Pagination', [
    'defaultPageSize' => 20,
]);

Yii::$container->set('yii\data\Sort', [
    'enableMultiSort' => true,
]);

Yii::$container->set('yii\widgets\ActiveField', [
    'inputOptions' => [
        'class' => ['form-control', 'input-sm'],
    ],
]);

