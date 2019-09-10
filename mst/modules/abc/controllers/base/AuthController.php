<?php

namespace mst\modules\abc\controllers\base;

use common\models\table\abc\Partner;
use Yii;

class AuthController extends BaseController
{
	public function init()
	{
		parent::init();
	}

	/**
	 * 检查权限
	 * @author luotaipeng
	 */
	public function beforeAction($action)
	{

		if (!parent::beforeAction($action)) {
			return false;
		}

		//return true;

		if (Yii::$app->user->isGuest) {
			throw new \yii\web\UnauthorizedHttpException("对不起，您现在还没登录");
		}


		$module_name = Yii::$app->controller->module->id;
		$pid = Yii::$app->user->identity->partner_id;
		$prefix = Partner::find()->select('prefix')->where(['id' => $pid])->scalar();

		if ($module_name != $prefix) {
			throw new \yii\web\UnauthorizedHttpException("{$module_name} {$prefix} 对不起，非法访问被禁止");
			return false;
		}

		// $request_uri = '/'.Yii::$app->controller->route;
		// if (!Yii::$app->user->can($request_uri) && Yii::$app->getErrorHandler()->exception === null) {
		// 	throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
		// }

		return true;
	}
}
