<?php

use app\models\User;
use yii\helpers\BaseHtml;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = '管理メニュー';
?>
<div class="container" ng-controller="joinCtrl">
    <div class="row">
        <div class="col-md-6">
            <h2><span class="label label-default">管理メニュー</span></h2>

            <ul class="list-group">
                <li class="list-group-item"><a href="<?=Url::to(['text/index'])?>">レコーダー使用</a></li>
            </ul>

            <ul class="list-group">
                <li class="list-group-item"><a href="<?=Url::to(['text/list'])?>">記録一覧</a></li>
            </ul>

            <ul class="list-group">
                <li class="list-group-item"><a href="<?=Url::to(['admin/adds'])?>">作業者挿入</a></li>
                <li class="list-group-item"><a href="<?=Url::to(['admin/list'])?>">作業者リスト</a></li>
                <li class="list-group-item"><a href="<?=Url::to(['admin/projects'])?>">アンケート集計</a></li>
                <li class="list-group-item"><a href="<?=Url::to(['admin/projects'])?>">アンケート送信</a></li>
            </ul>


        </div>
    </div>
</div>
