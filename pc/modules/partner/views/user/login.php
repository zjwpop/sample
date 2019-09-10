<?php

use yii\bootstrap\BootstrapAsset;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model admin\models\form\LoginForm
 */

$this->title = '用户登录';

BootstrapAsset::register($this);
?>
<div class="container">
<div class="site-login row" style="padding-top: 120px;">
    <div class='col-md-4 col-md-offset-4'>
	<?php $form = ActiveForm::begin([
		'fieldConfig' => [
			'options' => [
				'tag' => 'div',
				'class' => ['form-group'],
			],
			'template' => "{label}\n{input}\n{hint}\n{error}",
			'inputOptions' => ['class' => ['form-control']],
			'errorOptions' => [
				'tag' => 'div',
				// 这里class要用空格
				'class' => 'help-block',
			],
			'labelOptions' => ['class' => ['control-label']],
			'hintOptions' => [
				'tag' => 'div',
				'class' => ['hint-block'],
			],
		],
	]); ?>

	<?= $form->field($model, 'username')->textInput([
		'autofocus' => true,
		'maxlength' => true,
	]) ?>

	<?= $form->field($model, 'password')->passwordInput() ?>

	<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
		'captchaAction' => '/site/captcha',
		'template' => '<div class="row"><div class="col-xs-4">{input}</div><div class="col-xs-8">{image}</div></div>'
	]) ?>

	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block">登录</button>
	</div>

	<?php ActiveForm::end(); ?>
	</div>
	<div class='col-md-4'>&nbsp;</div>
</div>
</div>
