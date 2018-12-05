<?php
$this->title="レコーダーテスト";


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Simple Recorder.js demo with record, stop and pause</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/site/style.css">
</head>
<body>
<!-- 提出用のアクションurlを設定-->
<?php $url=\yii\helpers\Url::to(['recorder/save']);?>
<script>
    var url="{$url}";
</script>
<h1><span class="label label-default center-block">テスト版レコーダー</span></h1>
<h2></h2>

<div id="controls" class="btn-group btn-group-justified" role="group">
    <div class=" btn-group" role="group" >
    <button id="recordButton" class="btn btn-info btn-lg">記録</button>
    </div>
    <div class=" btn-group" role="group">
    <button id="pauseButton" class="btn btn-warning btn-lg" disabled>休止</button>
    </div>
    <div class=" btn-group" role="group">
    <button id="stopButton" class="btn btn-danger btn-lg" disabled>停止</button>
    </div>
</div>
<h1></h1>
<div id="formats" class="alert alert-success" role="alert"><p>録音開始したらサンプルを表示します</p></div>
<div class="bg-warning center-block">
<h3>録音データたち</h3>
</div>
<ol id="recordingsList"></ol>

<!-- inserting these scripts at the end to be able to use all the elements in the DOM -->
<script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
<script src="/recorder/js/app.js"></script>


</body>
</html>