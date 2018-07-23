<?php

namespace frontend\modules\master\controllers;

use Yii;
use frontend\modules\master\controllers\base\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\Message;
use frontend\modules\master\models\Admin;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends BaseController
{
    /**
     * @inheritdoc
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
        $searchModel = new Admin();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();
        $request = Yii::$app->request;

        if ($request->isPost) {
            $post = $request->post($model->formName(), []);
            if (empty($post['password'])) {
                unset($post['password']);
            }
            $model->setAttributes($post);
            if (isset($post['password'])) {
                $model->setPassword($post['password']);
            }
            if ($model->save()){
                Message::setSuccessMsg('添加成功');
                return $this->redirect(['index']);
            } else {
                Message::setErrorMsg('添加失败');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
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
            if ($model->save()){
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
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetRoles($id){
        $all_role=AuthItem::find(['name','description'])->where(['type'=>1])->all();
        $my_role=AuthAssignment::find(['name'])->where(['user_id'=>$id])->column();

        return $this->render('set_roles', [
            'id' => $id,
            'all_role' => $all_role,
            'my_role' => $my_role,
        ]);
    }

    public function actionSetted(){
        $post=Yii::$app->request->post();
        //echo json_encode($post);

        $request=Yii::$app->request;
        $user_id=$request->post('user_id');
        $roles=$request->post('roles',[]);

        $auth_db = new DbManager();
        $auth_db->revokeAll($user_id);

        $auth = Yii::$app->authManager;
        foreach($roles as $name){
            $role = $auth->createRole($name);
            $auth_db->assign($role, $user_id);
        }
        return $this->redirect(['index']);
    }
}
