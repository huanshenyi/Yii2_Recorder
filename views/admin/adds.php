<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap;
?>
<?php
  if(!\Yii::$app->request->get('id')){
                    $this->title='作業者挿入';
                }else{
                    $this->title="作業者データ修正";
                }
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
                <?php if(!\Yii::$app->request->get('id')){
                    echo '<h3>作業者挿入</h3>';
                }else{
                    echo '<h3>作業者データ修正</h3>';
                }?>

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
                        <?php echo $form->field($model, 'username')->textInput(['class' => 'span9']); ?>
                        <?php echo $form->field($model, 'password')->passwordInput(['class' => 'span9']); ?>
                        <?php echo $form->field($model, 'mail')->textInput(['class' => 'span9']); ?>
                        <?php echo $form->field($model, 'fullName')->textInput(['class' => 'span9']); ?>
                        <?php echo $form->field($model,'imgFile')->fileInput()?>
                        <?php echo $form->field($model, 'code')->radioList(\app\models\Admin::$adminOptions,['class'=>'checkbox-inline']); ?>
                        <div class="span11 field-box actions">
                            <?php echo bootstrap\Html::submitButton('挿入',['class' => 'btn-glow primary']); ?>
                            <span>または</span>
                            <a href="JavaScript:history.back(-1)" class="btn btn-default">キャンセル</a>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>

                <!-- side right column -->
                <?php if(!\Yii::$app->request->get('id')){
                    echo '<div class="span3 form-sidebar pull-right">

                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>
                        左フォームで作業者データを挿入してください、権限を管理者にすると新規作業者と
                        全データを見る権限が追加されるのでお気を付けてください
                    </div>
                    <h6>注意</h6>
                    <p>メールアドレスはパスワードの再発行にも使用しますので</p>
                    <p>ご注意ください</p>';
                }else{
                    echo '<div class="span3 form-sidebar pull-right">

                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>
                        左フォームで作業者データを修正してください、権限を管理者にすると新規作業者と
                        全データを見る権限が追加されるのでお気を付けてください
                    </div>
                    <h6>注意</h6>
                    <p>メールアドレスはパスワードの再発行にも使用しますので</p>
                    <p>ご注意ください</p>';
                }?>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- end main container -->
