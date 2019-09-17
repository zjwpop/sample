<?php

namespace api\controllers;

use api\controllers\base\BaseController;

class IndexController extends BaseController
{
	public function actionIndex()
	{
		return ['code' => 0, 'msg' => 'success'];
	}
}
