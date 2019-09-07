<?php
namespace pc\modules\api\controllers;

use Yii;
use pc\modules\api\controllers\base\BaseController;


class IndexController extends BaseController
{
	public function actionIndex()
	{
		return ['data'=>'api sample'];
		
	}
}
