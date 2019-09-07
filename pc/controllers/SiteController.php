<?php

namespace pc\controllers;

use yii\captcha\CaptchaAction;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => ErrorAction::className(),
			],
			'captcha' => [
				'class' => CaptchaAction::className(),
				'height' => 30,
				'width' => 120,
				'padding' => 1,
				'offset' => 6,
				'minLength' => 4,
				'maxLength' => 4,
			],
		];
	}

}
