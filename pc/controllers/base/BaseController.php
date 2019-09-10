<?php

namespace pc\controllers\base;

use yii\web\Controller;
use Yii;

class BaseController extends Controller
{
	public function init()
	{
		parent::init();

		// Yii::$app->view->title = "{{title}}";
		// Yii::$app->view->registerMetaTag(["name" => "keywords", "content" => "{{keywords}}"], 'keywords');
		// Yii::$app->view->registerMetaTag(["name" => "description", "content" => "{{description}}"], 'description');

	}
}
