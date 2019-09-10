<?php

namespace api\modules\nmc\controllers;

use api\modules\nmc\controllers\base\AuthController;

class CarController extends AuthController
{
	public function actionIndex()
	{
		return  ['code' => 0, 'msg' => 'success'];
	}
}
