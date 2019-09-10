<?php
use pc\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

AppAsset::register($this);

// $this->title = '{{title}}';
// $this->registerMetaTag(['name' => 'keywords', 'content' => '{{keywords}}'], 'keywords');
// $this->registerMetaTag(['name' => 'description', 'content' => '{{description}}'], 'description');
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '主页', 'url' => ['/']],
            Yii::$app->user->isGuest ? (
                ['label' => 'B端登录', 'url' => ['patner/login']]
            ) : (
                '<li>'.Html::a(Yii::$app->user->identity->nick, ['partner/index/']).'</li>'
                .'<li>'.Html::a('B退出', ['partner/logout']).'</li>'
            ),

            Yii::$app->member->isGuest ? (
                ['label' => 'C端登录', 'url' => ['member/login']]
            ) : (
                '<li>'.Html::a(Yii::$app->member->identity->nick, ['member/index/']).'</li>'
                .'<li>'.Html::a('C退出', ['member/logout']).'</li>'
            ),
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
