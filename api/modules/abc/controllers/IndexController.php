<?php

namespace api\modules\abc\controllers;

use api\modules\abc\controllers\base\BaseController;

class IndexController extends BaseController
{
	public function actionIndex()
	{
		return ['code' => 0, 'message' => 'success', 'data' => []];
	}
}
