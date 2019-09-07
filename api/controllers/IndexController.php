<?php

namespace api\controllers;

use api\controllers\base\BaseController;
use yii\filters\VerbFilter;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        return ['code' => 0, 'msg' => 'success'];
    }
}
