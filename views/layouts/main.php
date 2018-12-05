<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="icon" href="/images/icon.jpg">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .container {width: auto;}
        nav#top a.navbar-brand {
            padding-top: 0px;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' =>Html::img('@web/images/logo.jpg', [Yii::$app->name]),
        'brandUrl' => ['/admin/index'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
        'id'=>'top',
    ]);

    if (!Yii::$app->user->isGuest) {
        $menuReport = [];
        $menuReport[] = addNavMenu('個人記録一覧', '/text/list-private');
        if(\Yii::$app->user->identity->code ==2){
            $menuReport[] = addNavMenu('記録一覧（管理者）', '/text/list');
        }
        $menuReport[] = '<li class="divider"></li>';
        $menuReport[] = addNavMenu('音声データの取り込み', '/text/upload');


        $menuSuper[] = [
            'label' => '記録管理',
            'items' => $menuReport
        ];

        $menuSuper[] = [
            'label' => '録音システム',
            'url' => ['/text/index']
        ];
        if(\Yii::$app->user->identity->code ==2){
            $menuSuper[] = [
                'label' => '管理メニュー',
                'url' => ['/admin/admin']
            ];
        }
        //}
        echo Nav::widget([
            'items' => $menuSuper,
            'options' => ['class' => 'navbar-nav navbar']
        ]);
    }



    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            !Yii::$app->user->isGuest ?
                [ 'label' => Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => 'パスワードの変更', 'url' => ['/admin/passwd']],
                        ['label' => 'ログアウト',
                            'url' => ['/admin/logout'],
                            'linkOptions' => ['data-method' => 'post']
                        ]]] :
                ['label' => 'ログインしていません。', 'url' => ['/admin/login']]
        ]
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Recorder <?= date('Y') ?>Humanware</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php

function addNavMenu($label, $url) {
    $menu = [
        'label' => $label,
        'url' => [$url]
    ];
    return $menu;
}

function addLine() {
    $line = '<li class="divider"></li>';
    return $line;
}
?>
