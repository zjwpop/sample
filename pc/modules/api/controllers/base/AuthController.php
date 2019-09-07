<?php
namespace pc\modules\api\controllers\base;

use Yii;
use yii\web\Controller;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\auth\QueryParamAuth;

class AuthController extends Controller
{
	public $enableCsrfValidation = false;
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
    		'tokenParam' => 'b_token'
		];
		return $behaviors;
	}
}
