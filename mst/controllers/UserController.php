<?php

namespace mst\controllers;

use yii\web\Controller;
use common\models\form\UserLogin;
use common\models\table\abc\Partner;
use common\helpers\Message;
use Yii;
use yii\filters\AccessControl;

class UserController extends Controller {
	/**
	 * @inheritdoc
	 */
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

	public function actionLogin() {
		$model = new UserLogin();
		if ($model->load(Yii::$app->request->post())) {
			if ($model->login()) {
				Message::setSuccessMsg('登录成功');
				$token = Yii::$app->user->identity->token;
				$pid = Yii::$app->user->identity->partner_id;
				$prefix = Partner::find()->select(['prefix'])->where(['id'=>$pid])->scalar();
				//exit("//{$prefix}.mst.sample.cc/user/auth?abt_token={$token}");
				return $this->redirect("//{$prefix}.mst.sample.cc/user/auth?abt_token={$token}");
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
