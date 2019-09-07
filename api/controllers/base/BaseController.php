<?php
namespace api\controllers\base;

use Yii;
use yii\web\Controller;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class BaseController extends Controller
{
	public function init() {
		parent::init();
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

		return $behaviors;
	}
}

