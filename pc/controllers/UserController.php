<?php

namespace pc\controllers;

use yii\web\Controller;
use pc\models\form\LoginForm;
use common\helpers\Message;
use Yii;
use yii\filters\AccessControl;

class UserController extends Controller {
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => [
							'login',
							'index',
						],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => [
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

	public function actionIndex(){
		echo 'yes';
	}

	public function actionLogin() {
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post())) {
			if ($model->login()) {
				Message::setSuccessMsg('登录成功');
				return $this->redirect(['/master/index']);
			} else {
				Message::setErrorMsg('登录失败');
			}
		}

		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionLogout() {
		Yii::$app->user->logout();
		Message::setMessage('已登出');
		return $this->redirect(['user/login']);
	}
}
