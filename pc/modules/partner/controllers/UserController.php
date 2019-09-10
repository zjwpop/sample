<?php
namespace pc\modules\partner\controllers;

use pc\modules\partner\controllers\base\BaseController;
use common\models\form\UserLogin;
use common\helpers\Message;
use Yii;
use yii\filters\AccessControl;

class UserController extends BaseController
{
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
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

	public function actionIndex() {
		exit('user index');
	}

	public function actionLogin() {
		$model = new UserLogin();
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

	public function actionLogout() {
		Yii::$app->user->logout();
		Message::setMessage('已登出');
		return $this->redirect(['user/login']);
	}
}
