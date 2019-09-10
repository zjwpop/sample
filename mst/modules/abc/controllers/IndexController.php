<?php

namespace mst\modules\abc\controllers;

use mst\modules\abc\controllers\base\AuthController;
use Yii;

class IndexController extends AuthController
{
    public function actionIndex()
    {
        exit('abc index');
    }
}
