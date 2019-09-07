<?php
namespace pc\modules\api\controllers\base;

use Yii;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use common\helpers\Helper;

class BaseController extends Controller
{
	public $enableCsrfValidation = false;
	public function init()
	{
		parent::init();
	}
	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			'contentNegotiator' => [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,
				]
			]
		]);
	}
}
