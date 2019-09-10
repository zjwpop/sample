<?php
namespace api\modules\abc\controllers\base;

use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use common\models\table\abc\User;

class AuthController extends BaseController
{
	public function init() {
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
			'user' => new User(),
			'tokenParam' => 'token',
			'optional' => [
				'login',
				'signup-test',
			],
		];
		return $behaviors;
	}
}
