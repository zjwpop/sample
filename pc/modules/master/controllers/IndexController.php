<?php

namespace pc\modules\master\controllers;

use common\helpers\FileHelper;
use common\helpers\Message;
use pc\modules\master\controllers\base\BaseController;
use pc\modules\master\models\Admin;
use pc\modules\master\models\form\PasswordForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class IndexController extends BaseController {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
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
	public function actionIndex() {
		$user = Yii::$app->get('master');
		// $user = Yii::$app->master;
		var_dump($user);

		echo Yii::$app->user->id;

		exit('master index');

		$searchModel = new Admin();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Admin model.
	 * @param  int                   $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Admin model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = Admin::find()->where(['mst' => 1])
			->andWhere(['=', 'username', ''])
			->orderBy(['id' => SORT_ASC])
			->one();
		$request = Yii::$app->request;
		$post = $request->post($model->formName(), []);
		if ($request->isPost) {
			//return json_encode($post);
			if(empty($post['username']) || empty($post['password'])){
				Message::setErrorMsg('用户名，密码不能为空');
				return $this->render('create', [
					'model' => $model,
				]);
			}
			$check=Admin::findOne(['username'=>$post['username']]);
			if($check){
				Message::setErrorMsg('用户名不能重复');
				return $this->render('create', [
					'model' => $model,
						]);
			 }
			if (empty($post['password'])) {
				unset($post['password']);
			}
			$model->setAttributes($post);
			if (isset($post['password'])) {
				$model->setPassword($post['password']);
			}
			if ($model->save()) {
				Message::setSuccessMsg('添加成功');
				return $this->redirect(['index']);
			} else {
				Message::setErrorMsg('添加失败');
				return json_encode($model->getErrors());
			}
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Admin model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param  int                   $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id) {
		$request = Yii::$app->request;
		$model = $this->findModel($id);

		if ($request->isPost) {
			$post = $request->post($model->formName(), []);
			if (empty($post['password'])) {
				unset($post['password']);
			}
			$model->setAttributes($post);
			if (isset($post['password'])) {
				$model->setPassword($post['password']);
			}
			if ($model->save()) {
				Message::setSuccessMsg('修改成功');
				return $this->redirect(['index']);
			} else {
				Message::setErrorMsg('修改失败');
			}
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Admin model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param  int                   $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Admin model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param  int                   $id
	 * @return Admin                 the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Admin::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionSetRoles($id) {
		$all_role = AuthItem::find(['name', 'description'])->where(['type' => 1])->all();
		$my_role = AuthAssignment::find(['name'])->where(['user_id' => $id])->column();

		return $this->render('set_roles', [
			'id' => $id,
			'all_role' => $all_role,
			'my_role' => $my_role,
		]);
	}

	public function actionSetted() {
		$post = Yii::$app->request->post();
		//echo json_encode($post);

		$request = Yii::$app->request;
		$user_id = $request->post('user_id');
		$roles = $request->post('roles', []);

		$auth_db = new DbManager();
		$auth_db->revokeAll($user_id);

		$auth = Yii::$app->authManager;
		foreach ($roles as $name) {
			$role = $auth->createRole($name);
			$auth_db->assign($role, $user_id);
		}
		return $this->redirect(['index']);
	}

	public function actionMine() {
		$model = Admin::findOne(YIi::$app->user->id);
		if ($model->load(Yii::$app->request->post())) {
			if ($_FILES['avatar']['name']) {
				// $up = FileHelper::qnUpload($_FILES['avatar'], 'admin');
				$up = FileHelper::picUpload($_FILES['avatar']);
				if ($up['errno'] == 0) {
					$model->avatar = $up['key'];
				}
			}
			if ($model->save()) {
				Message::setSuccessMsg('修改成功');
				return $this->redirect(['mine']);
			} else {
				Message::setErrorMsg('修改失败');
			}
		}

		return $this->render('mine', [
			'model' => $model,
		]);
	}

	public function actionPassword() {
		$model = new PasswordForm();

		if ($model->load(Yii::$app->request->post())) {
			if ($model->modifyPassword()) {
				Message::setSuccessMsg('修改成功');
				return $this->redirect(['password']);
			} else {
				Message::setErrorMsg('修改失败');
			}
		}

		return $this->render('password', [
			'model' => $model,
		]);
	}
}
