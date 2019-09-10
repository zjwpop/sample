<?php

namespace mst\modules\nmc\controllers;

use common\helpers\Message;
use common\models\form\UserLogin;
use mst\modules\abc\controllers\base\BaseController;
use Yii;

class AuthController extends BaseController
{
	public function actionLogin()
	{
		$token = Yii::$app->request->get('abt_token');
		$model = new UserLogin();
		if ($model->loginByToken($token)) {
			return $this->redirect(['index/index']);
		}
		return $this->redirect('//mst.sample.cc/user/logout');
	}

	public function actionLogout() {
		Yii::$app->user->logout();
		Message::setMessage('已登出');
		return $this->redirect("//mst.sample.cc/user/logout");
	}
}
