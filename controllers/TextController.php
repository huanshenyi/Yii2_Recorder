<?php
namespace app\controllers;

use app\models\Data;
use app\models\Record;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;

class TextController extends Controller
{

    public $enableCsrfValidation = false;

    //談話記録、＆音声データを
    public function actionIndex()
    {
        //csrfを無効化
        $this->enableCsrfValidation = false;
        $model = new Record();
        $request= new Request();

        if($request->isPost)
        {
            $model->load($request->post());

            //アップロードされたファイルを実体化
            $model->dataFile=UploadedFile::getInstance($model,'dataFile');

            //データ検証
            if($model->validate())
            {
                //もしアップロードしてなければ、処理
                if($model->dataFile)
                {
                    //音声データを処理
                    //データ名をランダム生成
                    $fileName = ('/upload/'.date('Ymd').uniqid().'.'.$model->dataFile->extension);
                    //move_uploaded_file()
                    $model->dataFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    //データベースにルートを保存する
                    $model->data=$fileName;
                }
                //時間を入れる
                $model->created=time();
                $model->year=date("Y");
                $model->month=date("m");
                $model->userId=\Yii::$app->user->identity->id;
                //保存してページを飛ぶ
                $model->save();
                return $this->redirect(['text/list-private']);

            }else{
                //検証失敗エラーを出す
                var_dump($model->getErrors());exit();
            }
        }
        return $this->render('index',['model'=>$model]);
    }

    //記録総合リストページ
    public function actionList()
    {

        //ページング
        $query = Record::find();
        //总条数
        $total = $query->count();
        //var_dump($total);exit;
        //每页显示条数 3
        $perPage = 10;

        //分页工具类
        $pager = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage
        ]);

        //LIMIT 0,3   ==> limit(3)->offset(0)
        $models = $query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('list',['models'=>$models,'pager'=>$pager]);


    }
    //個人記録リスト
    public function actionListPrivate()
    {
        $models=Record::findAll(['userId'=>\Yii::$app->user->identity->id]);


        return $this->render('listprivate',['models'=>$models]);
    }



    //音声ファイルをダウンロード
    public function actionDownload($id)
    {



    }

    //音声データのファイルを保存
    public function actionSave()
    {
        $this->enableCsrfValidation = false;

        //print_r($_FILES);

//        $size = $_FILES['audio_data']['size']; //the size in bytes
//        $input = $_FILES['audio_data']['tmp_name']; //temporary name that PHP gave to the uploaded file
//        $output = $_FILES['audio_data']['name'].".wav"; //letting the client control the filename is a rather bad idea

        $model= new Data();
        //$model->dataFiles=$_FILES;//UploadedFile::getInstance($model,'audio_data');
        $model->dataFiles= UploadedFile::getInstanceByName('audio_data');
        $request=new Request();

        if($request->isPost){

            //もしアップロードしてなければ、処理

                //音声データを処理
                //データ名をランダム生成
                //$fileName = ('/upload/'.date('Ymd').uniqid().'.'.$model->dataFile->extension);
                $fileName='/upload/'.date('Ymd').uniqid().".wav";

                //move_uploaded_file()
                $model->dataFiles->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                //データベースにルートを保存する
                $model->data=$fileName;

            //時間を入れる
           // $model->create_time=time();
            //$model->year=date("Y");
            //$model->month=date("m");

            //保存してページを飛ぶ
            //adminと関連付け

            $model->recordId=\Yii::$app->user->identity->id;
            $model->save();
            return $this->redirect(['text/list']);

            }
    }

    //音声データ取り込み
    public function actionUpload()
    {
        $model=new Record();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->dataFile=UploadedFile::getInstance($model,'dataFile');

            //データ検証
            if($model->validate())
            {
                //もしアップロードしてなければ、処理
                if($model->dataFile)
                {
                    //音声データを処理
                    //データ名をランダム生成
                    $fileName = ('/upload/'.date('Ymd').uniqid().'.'.$model->dataFile->extension);
                    //move_uploaded_file()
                    $model->dataFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    //データベースにルートを保存する
                    $model->data=$fileName;
                }
                //時間を入れる
                $model->created=time();
                $model->year=date("Y");
                $model->month=date("m");
                $model->userId=\Yii::$app->user->identity->id;
                //保存してページを飛ぶ
                $model->save();
                \Yii::$app->session->setFlash('info','データアップロードしました');
                return $this->redirect(['text/list-private']);

            }else{
                //検証失敗エラーを出す
                var_dump($model->getErrors());exit();
            }
        }
        return $this->render('upload',['model'=>$model]);

    }

}