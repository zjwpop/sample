<?php
namespace pc\controllers;

use yii\web\Controller;

/**
 * Index controller
 */
class IndexController extends Controller
{
	public function actionIndex(){
		return $this->render('index');
	}
}
