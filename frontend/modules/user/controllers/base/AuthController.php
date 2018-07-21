<?php
namespace frontend\modules\master\controllers\base;

use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
	public function init() {
		parent::init();
	}

	/**
	 * 检查权限
	 * @author luotaipeng
	 */
	public function beforeAction($action) {
		if (!parent::beforeAction($action)) {
			return false;
		}

		//return true;

		if(Yii::$app->user->isGuest){
			return $this->redirect(['/user/login']);
		}

		if (Yii::$app->user->id >0) {
			return true;
		}

		$request_uri = '/'.Yii::$app->controller->route;
		if (!Yii::$app->user->can($request_uri) && Yii::$app->getErrorHandler()->exception === null) {
			throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
		}

		return true;
	}
}
