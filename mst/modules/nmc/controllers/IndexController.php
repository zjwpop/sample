<?php

namespace mst\modules\nmc\controllers;

use common\models\form\UserLogin;
use mst\modules\abc\controllers\base\AuthController;
use yii\filters\VerbFilter;

class IndexController extends AuthController
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all Admin models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		exit('nmc index');
	}

	public function actionAuth()
	{
		$token = Yii::$app->request('abt_token');
		$model = new UserLogin();
		if ($model->loginByToken($token)) {
			return 'yes';
		}
		return 'no';
	}
}
