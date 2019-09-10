<?php

namespace pc\modules\member\controllers;

use common\helpers\Message;
use common\models\form\MemberLogin;
use pc\modules\member\controllers\base\BaseController;
use Yii;
use yii\filters\AccessControl;

class UserController extends BaseController
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'user' => 'member',
				'rules' => [
					[
						'allow' => true,
						'actions' => [
							'login',
						],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => [
							'index',
							'logout',
						],
						'roles' => ['@'],
					],
				],
				'denyCallback' => function ($rule, $action) {
					return $this->goBack();
				},
			],
		];
	}

	public function actionLogin()
	{
		$model = new MemberLogin();
		if ($model->load(Yii::$app->request->post())) {
			if ($model->login()) {
				Message::setSuccessMsg('登录成功');
				return $this->redirect(['index']);
			} else {
				Message::setErrorMsg('登录失败');
			}
		}

		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->member->logout();
		Message::setMessage('已登出');
		return $this->redirect(['user/login']);
	}
}
