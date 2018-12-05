<?php
use yii\web\JsExpression;

$this->title="レコーダーテスト";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Simple Recorder.js demo with record, stop and pause</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/site.css">
</head>
<body>
<!-- 提出用のアクションurlを設定-->
<?php $url=\yii\helpers\Url::to(['recorder/save']);?>
<script>
    var url="{$url}";
</script>
<h1><span class="label label-default center-block">テスト版レコーダー</span></h1>
<h2></h2>
<?php $form=\yii\bootstrap\ActiveForm::begin()?>
<?= $form->field($model,'name')->textInput()?>
<?= $form->field($model,'memo')->textarea()?>

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
<div class="alert alert-warning" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">使用注意:</span>
    提出する前先ず音声記録をアップロードするか，既に保存された音声記録をアップロードして提出してください
</div>
<?=$form->field($model,'dataFile')->fileInput();?>
<!-- モジュール使用begin-->
<!--モジュール使用終わり-->
<?=\yii\bootstrap\Html::submitButton('提出',['class'=>'btn btn-info'])?>
<h1></h1>
<br>
<a href="JavaScript:history.back(-1)" class="btn btn-default">キャンセル</a>
<?php \yii\bootstrap\ActiveForm::end()?>
<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
<!-- inserting these scripts at the end to be able to use all the elements in the DOM -->
<script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>



</body>
</html>
<?php
$url=\yii\helpers\Url::to(['text/save']);
$this->registerJs(
        <<<JS
        //webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb. 
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var pauseButton = document.getElementById("pauseButton");

//add events to those 2 buttons
recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
pauseButton.addEventListener("click", pauseRecording);

function startRecording() {
	console.log("recordButton clicked");

	/*
		Simple constraints object, for more advanced audio features see
		https://addpipe.com/blog/audio-constraints-getusermedia/
	*/
    
    var constraints = { audio: true, video:false }

 	/*
    	Disable the record button until we get a success or fail from getUserMedia() 
	*/

	recordButton.disabled = true;
	stopButton.disabled = false;
	pauseButton.disabled = false

	/*
    	We're using the standard promise based getUserMedia() 
    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
	*/

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		console.log("getUserMedia() success, stream created, initializing Recorder.js ...");

		/*
			create an audio context after getUserMedia is called
			sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
			the sampleRate defaults to the one set in your OS for your playback device

		*/
		audioContext = new AudioContext();

		//update the format 
		document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

		/*  assign to gumStream for later use  */
		gumStream = stream;
		
		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);

		/* 
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
		*/
		rec = new Recorder(input,{numChannels:1})

		//start the recording process
		rec.record()

		console.log("Recording started");

	}).catch(function(err) {
	  	//enable the record button if getUserMedia() fails
    	recordButton.disabled = false;
    	stopButton.disabled = true;
    	pauseButton.disabled = true
	});
}

function pauseRecording(){
	console.log("pauseButton clicked rec.recording=",rec.recording );
	if (rec.recording){
		//pause
		rec.stop();
		pauseButton.innerHTML="再開";
	}else{
		//resume
		rec.record()
		pauseButton.innerHTML="休止";

	}
}

function stopRecording() {
	console.log("stopButton clicked");

	//disable the stop button, enable the record too allow for new recordings
	stopButton.disabled = true;
	recordButton.disabled = false;
	pauseButton.disabled = true;

	//reset button just in case the recording is stopped while paused
	pauseButton.innerHTML="休止";
	
	//tell the recorder to stop the recording
	rec.stop();

	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	//create the wav blob and pass it on to createDownloadLink
	rec.exportWAV(createDownloadLink);
}
        
function createDownloadLink(blob) {
	
	var url="{$url}";
	var au = document.createElement('audio');
	var li = document.createElement('li');
	var link = document.createElement('a');

	//name of .wav file to use during upload and download (without extendion)
	var filename = new Date().toISOString();

	//add controls to the <audio> element
	au.controls = true;
	au.src = url;

	//save to disk link
	link.href = url;
	link.download = filename+".wav"; //download forces the browser to donwload the file using the  filename
	link.innerHTML = "本体へ保存";

	//add the new audio element to li
	li.appendChild(au);
	
	//add the filename to the li
	li.appendChild(document.createTextNode(filename+".wav "))

	//add the save to disk link to li
	li.appendChild(link);
	
	//upload link
	var upload = document.createElement('a');
	upload.href="#";
	upload.innerHTML = "データベースへ保存";
	upload.addEventListener("click", function(event){
		  var xhr=new XMLHttpRequest();
		  xhr.onload=function(e) {
		      if(this.readyState === 4) {
		          console.log("Server returned: ",e.target.responseText);
		      }
		  };
		  var fd=new FormData();
		  fd.append("audio_data",blob, filename);
		  xhr.open("POST",'/text/save',true);
		  xhr.send(fd);
	})
	li.appendChild(document.createTextNode (" "))//add a space in between
	li.appendChild(upload)//add the upload link to li

	//add the li element to the ol
	recordingsList.appendChild(li);
}




JS

);
