<?php

use yii\helpers\Html;
use yii\grid\SerialColumn;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\base\AuthAssignment;

$this->title = '后台管理员';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    'id',
    'username',
    'nick',
    'mobile',
    'email:email',
    [
        'attribute'=>'status',
        'header'=>'启用',
    ],
    'create_time:datetime',
    // 'update_time',

    ['class' => 'yii\grid\ActionColumn'],
]

?>
<div class="admin-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php //= Render::gridView($dataProvider, $gridColumns) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]); ?>
</div>
<?= Html::a('创建管理员', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
