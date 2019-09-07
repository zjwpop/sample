<?php

namespace backend\common\extensions;

use yii\web\Controller;
use Yii;

class MasterController extends Controller
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // ...
    }

    public function renderPjax($view, $params = [])
    {
        if (Yii::$app->request->isPjax) {
            return $this->renderAjax($view, $params);
        } else {
            return $this->render($view, $params);
        }
    }
}
