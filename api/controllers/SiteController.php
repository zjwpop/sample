<?php

namespace api\controllers;

use api\controllers\base\BaseController;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends BaseController
{

	public function actions()
	{
		return [
			'error' => [
				'class' => ErrorAction::className(),
			],
		];
	}

}
