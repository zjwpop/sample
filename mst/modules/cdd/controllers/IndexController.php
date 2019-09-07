<?php

namespace mst\modules\cdd\controllers;

use mst\modules\cdd\controllers\base\BaseController;
use yii\filters\VerbFilter;

class IndexController extends BaseController
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
        exit('cdd index');
    }
}
