<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap;
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php
$this->title="作業者リスト";

?>
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
                <h3>作業者リスト</h3>
            </div>
            <div class="row-fluid form-wrapper">
                <table class="table">
                    <tr>
                        <th>Id</th>
                        <th>ユーザーネーム</th>
                        <th>メール</th>
                        <th>本名</th>
                        <th>権限</th>
                        <th>アイコン</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach ($models as $model):?>
                    <tr>
                        <td><?=$model->id?></td>
                        <td><?=$model->username?></td>
                        <td><?=$model->mail?></td>
                        <td><?=$model->fullName?></td>
                        <td><?=\app\models\Admin::$adminOptions[$model->code]?></td>
                        <td><?=$model->img?bootstrap\Html::img($model->img,['width'=>25]):bootstrap\Html::img('/images/default.jpg',['width'=>25])?></td>
                        <td><?=bootstrap\Html::a('修正',['admin/edit','id'=>$model->id],['class'=>'btn btn-info'])?>
                            <a href="javascript:;" class="btn_del btn btn-danger"data-id="<?=$model->id?>">削除</a>
                            <?=Html::a('記録',['admin/record','id'=>$model->id],['class'=>'btn btn-primary'])?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
               <?php
               //ページング
              echo \yii\widgets\LinkPager::widget(['pagination'=>$pager]);

               ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php
/**
 * @var $this \yii\web\view
 */
//新規jsコード
$url=\yii\helpers\Url::to(['admin/del']);
  $this->registerJs(
          <<<JS

$(".btn_del").click(function() {
  if(confirm('作業員削除しますか?')){
      var url="{$url}";
      var id=$(this).attr('data-id');
      var that=this;
      $.post(url,{id:id},function(data) {
        if(data=='success'){
            
            $(that).closest('tr').fadeOut();
        }else {
            alert('data')
        }
      });
  }
    
});

JS

  );