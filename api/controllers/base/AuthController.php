<?php
namespace api\controllers\base;

use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\auth\QueryParamAuth;

class AuthController extends BaseController
{
	public function init()
	{
		parent::init();
		Yii::$app->user->enableSession = false;
	}
	public function behaviors()
	{

		$behaviors=parent::behaviors();

		$behaviors['contentNegotiator'] = [
			'class' => ContentNegotiator::className(),
			'formats' => [
				'application/json' => Response::FORMAT_JSON,
			]
		];

		$behaviors['authenticator'] = [
    		'class' => QueryParamAuth::className(),
    		'tokenParam' => 'token'
		];
		return $behaviors;
	}
}
