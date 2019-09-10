<?php

namespace pc\modules\member\controllers;

use pc\modules\member\controllers\base\AuthController;
use yii\filters\AccessControl;

class IndexController extends AuthController
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
				'denyCallback' => function ($rule, $action) {
					return $this->goBack();
				},
			],
		];
	}

	public function actionIndex()
	{
		echo 'member index';
		exit();
	}
}
