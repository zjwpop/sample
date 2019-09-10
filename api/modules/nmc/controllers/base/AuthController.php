<?php

namespace api\modules\nmc\controllers\base;

use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;
use common\models\table\abc\Member;

class AuthController extends Controller
{
	public function init()
	{
		parent::init();
	}

	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['contentNegotiator'] = [
			'class' => ContentNegotiator::className(),
			'formats' => [
				'application/json' => Response::FORMAT_JSON,
			],
		];

		$behaviors['authenticator'] = [
			'class' => QueryParamAuth::className(),
			'user' => new Member(),
			'tokenParam' => 'access-token',
			'optional' => [
				'login',
				'signup-test',
			],
		];
		return $behaviors;
	}
}
