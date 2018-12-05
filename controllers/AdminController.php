<?php

namespace app\controllers;

use app\models\Admin;
use app\models\LoginForm;
use app\models\PasswdForm;
use app\models\Record;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{
    //フィルター
    public function behaviors()
    {
        return [
            'ACF'=>[
                'class' =>AccessControl::className(),
                'only'=>['login','index','add','Passwd','add','list','adds'],
                'rules'=>[
                    [
                        'allow'=>true,
                        'actions'=>['login'],
                        'roles'=>['?'],
                    ],
                    [
                        'allow'=>true,
                        'actions'=>['logout','index','Passwd','add','list','adds','login'],
                        'roles'=>['@'],
                    ],
                ]
            ],
        ];
    }

    //ログイン機能
    public function actionLogin()
    {
        //1パスワードとユーザーネーム確認
         $model= new LoginForm();
         $request = new Request();
         if($request->isPost){
             $model->load($request->post());
           if($model->login())
           {
              //成功
               \Yii::$app->session->setFlash('success','ログイン成功しました');
               return $this->redirect(['admin/index']);
           }
         }
         return $this->render('login',['model'=>$model]);
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    //ユーザー一覧
    public function actionList()
    {
        //ページング
        $query=Admin::find();
        //全データ数
        $total=$query->count();
        //表示データ数
        $perPage=8;
        //ページング用クラス
        $pager= new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>$perPage,
        ]);

        $models=$query->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('list',['models'=>$models,'pager'=>$pager]);
    }


    //ユーザー挿入
    public function actionAdd()
    {
        $admin= new Admin();
        $admin->username="admin";
        $admin->password=\Yii::$app->security->generatePasswordHash('admin');
        $admin->mail="test@test.com";
        $admin->fullName='アドミン';
        $admin->code='123';
        $admin->save();

    }

    //ログアウト
    public function actionLogout()
    {
       \Yii::$app->user->logout();
       return $this->redirect(['admin/login']);
    }

    //パスワード修正
    public function actionPasswd()
    {
         $model=new PasswdForm();

         $request=new Request();
         if($request->isPost){
             $model->load($request->post());
             if($model->validate())
             {
                 //成功
                // $admin= Admin::findOne(['id'=>\Yii::$app->user->id]);
                 //上の方法と一致
                 //現在のユーザーデータをオブジェクトとして取得
                 $admin=\Yii::$app->user->identity;
                 //
                 $admin->password=\Yii::$app->security->generatePasswordHash($model->newPassword);
                 if($admin->save(false))
                 {
                     \Yii::$app->session->setFlash('success','パスワード修正しました');
                     return $this->redirect(['admin/index']);
                 }else{
                     var_dump($admin->getErrors());exit();
                 }
             }
         }
         return $this->render('passwd',['model'=>$model]);
    }

    //使用者挿入
    public function actionAdds()
    {
        $model = new Admin();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());

            //画像をオブジェクト化
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');

            //検証
            if($model->validate())
            {
                //もし画像がない場合
                if($model->imgFile){

                    //検証通過、画像を保存
                    $fileName='/images/'.date('Ymd').uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->img=$fileName;
                }

                $model->save();
                \Yii::$app->session->setFlash('success','追加成功しました');
                                           //別のページでもよい
                return $this->redirect(['admin/list']);
            }else{
                var_dump($model->getErrors());exit();
            }

        }
         return $this->render('adds',['model'=>$model]);
    }

    //管理者メニューを挿入
    public function actionAdmin()
    {


        return $this->render('admin');
    }

    //作業員のデータ修正
    public function actionEdit($id)
    {
        $request=new Request();
        $model= Admin::findOne(['id'=>$id]);

        if($request->isPost){
            //$id=$request->get('id');
            $model->load($request->post());
            //画像をオブジェクト化
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');

            //検証
            if($model->validate())
            {
                //もし画像がない場合
                if($model->imgFile){

                    //検証通過、画像を保存
                    $fileName='/images/'.date('Ymd').uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->img=$fileName;
                }

                $model->save();
                \Yii::$app->session->setFlash('success','修正しました');
                //別のページでもよい
                return $this->redirect(['admin/list']);
            }else{
                var_dump($model->getErrors());exit();
            }

        }
        return $this->render('adds',['model'=>$model]);

    }

    //ajaxユーザー削除
    public function actionDel()
    {
        $id=\Yii::$app->request->post('id');

        $model=Admin::findOne(['id'=>$id]);

       if($model){
           $model->delete();
           return 'success';
       }else{
          return 'データ存在しませんか削除されました';
       }

    }

    //各作業員のデータを確認
    public function actionRecord($id){


        $models=Record::findAll(['userId'=>$id]);

        return $this->render('record',['models'=>$models]);

    }

}
