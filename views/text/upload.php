<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap;
use yii\web\JsExpression;
?>
<?php
$this->title='アップロード';
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- bootstrap -->
<link href="/assets/admin/css/bootstrap/bootstrap.css" rel="stylesheet" />
<link href="/assets/admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
<link href="/assets/admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

<!-- libraries -->
<link href="/assets/admin/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
<link href="/assets/admin/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

<!-- global styles -->
<link rel="stylesheet" type="text/css" href="/assets/admin/css/layout.css" />
<link rel="stylesheet" type="text/css" href="/assets/admin/css/elements.css" />
<link rel="stylesheet" type="text/css" href="/assets/admin/css/icons.css" />

<!-- this page specific styles -->
<link rel="stylesheet" href="/assets/admin/css/compiled/index.css" type="text/css" media="screen" />

<link rel="stylesheet" href="/assets/admin/css/compiled/new-user.css" type="text/css" media="screen" />
<!-- main container -->
<div class="content">

    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>記録アップロード</h3>
            </div>

            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php
                        if (Yii::$app->session->hasFlash('info')) {
                            echo Yii::$app->session->getFlash('info');
                        }
                        $form = ActiveForm::begin([
                            'options' => ['class' => 'new_user_form inline-input'],
                            'fieldConfig' => [
                                'template' => '<div class="span12 field-box">{label}{input}</div>{error}'
                            ],
                        ]);
                        ?>
                        <?php echo $form->field($model, 'name')->textInput(['class' => 'span9']); ?>
                        <?php echo $form->field($model, 'memo')->textarea(['class' => 'span9']); ?>
                        <?php echo $form->field($model,'dataFile')->fileInput()?>
                        <div class="span11 field-box actions">
                            <?php echo bootstrap\Html::submitButton('挿入',['class' => 'btn-glow primary']); ?>
                            <span>または</span>
                            <a href="JavaScript:history.back(-1)" class="btn btn-default">キャンセル</a>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>