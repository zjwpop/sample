<?php

namespace pc\modules\partner\controllers;

use pc\modules\partner\controllers\base\AuthController;
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
		return $this->render('index');
	}
}
