<?php
namespace pc\controllers;

use pc\controllers\base\BaseController;

class IndexController extends BaseController
{
	public function actionIndex(){
		return $this->render('index');
	}
}
