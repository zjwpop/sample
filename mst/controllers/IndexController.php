<?php
namespace mst\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Index controller
 */
class IndexController extends Controller
{
	public function actionIndex(){
		return $this->render('index');
	}
}
