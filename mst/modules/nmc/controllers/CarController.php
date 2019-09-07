<?php

namespace mst\modules\nmc\controllers;

use mst\modules\nmc\controllers\base\BaseController;
use yii\filters\VerbFilter;
use Yii;

class CarController extends BaseController
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all Admin models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		exit('nmc car');
	}

	public function actionDetail()
	{
		$id= Yii::$app->request->get('id');
		if($id){
			echo $id;
		}
		exit('car detail');
	}
}
