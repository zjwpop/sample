<?php
namespace pc\controllers;

use pc\controllers\base\BaseController;
use common\helpers\Helper;

class IndexController extends BaseController
{
	public function actionIndex(){
        $str = Helper::randString(16);
		return $this->render('index',['str'=>$str]);
	}
}
