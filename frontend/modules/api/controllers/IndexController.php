<?php
namespace frontend\modules\api\controllers;

use Yii;
use frontend\modules\api\controllers\base\BaseController;


class IndexController extends BaseController
{
	public function actionIndex()
	{
		return ['data'=>'api sample'];
		
	}
}
