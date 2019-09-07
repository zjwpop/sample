<?php

namespace api\modules\nmc\controllers;

use api\modules\nmc\controllers\base\BaseController;
use yii\filters\VerbFilter;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        return ['code' => 0, 'msg' => 'success'];
    }
}
