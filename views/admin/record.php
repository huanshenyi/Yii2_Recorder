<?php
$this->title='記録一覧';

?>
<div >
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>相手お名前</th>
            <th>メモ</th>
            <th>音声記録</th>
            <th>記録時間</th>
            <th>ダウンロード</th>
            <th>担当者</th>
        </tr>
        </thead>
        <?php foreach ($models as $model):?>
            <tbody>
            <tr>
                <td><?=$model->id?></td>
                <td><?=$model->name?></td>
                <td><?=$model->memo?></td>
                <td><a href="<?=isset($model->data) ? $model->data : $model->datas->data ;?>"><button type="button" class="btn btn-default btn-xs">

                            <span class="glyphicon glyphicon-music" aria-hidden="true"></span> 流す
                        </button></a></td>
                <td><?=date("Y-m-d H:i:s",$model->created)?></td>
                <td><button>
                        <a href = "<?=$model->data?>">
                            ファイルダウンロード
                    </button></td>
                <!--$modelはRecord,admin属性使用すると自動的getAdminを使用-->
                <td><?=$model->admin->fullName?></td>
            </tr>
            </tbody>
        <?php endforeach;?>
    </table>
</div>