<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '权限管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="padding:15px">
<?php $form = ActiveForm::begin([
        'action' => ['setted'],
        'method' => 'post',
		'options'=>['class'=>'form-inline'],
    ]); ?>
<input type='hidden' value="<?=$id ?>" name="user_id" />


<div >
<?php foreach($all_role as $role) :  ?>
	<input type='checkbox' name="roles[]" value="<?php echo $role['name'] ?>"  <?= in_array($role['name'], $my_role)?'checked' : '' ?> />
	<?php echo $role['description'] ?>
<?php endforeach ?>

</div>

<div><?= Html::submitButton('设置', ['class' => 'btn btn-primary btn-sm']) ?></div>
<?php ActiveForm::end() ?>
</div>
