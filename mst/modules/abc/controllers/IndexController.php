<?php

namespace mst\modules\abc\controllers;

use mst\modules\abc\controllers\base\AuthController;
use yii\filters\VerbFilter;

class IndexController extends AuthController
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
        exit('abc index');
    }
}
