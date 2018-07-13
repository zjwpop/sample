<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class IndexController extends Controller
{
	public function actionIndex(){
		return $this->render('index');
	}
}
