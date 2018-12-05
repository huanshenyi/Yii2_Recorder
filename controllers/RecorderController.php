<?php

namespace app\controllers;



use yii\base\Controller;

class RecorderController extends Controllerer
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    //音声データのファイルを保存
    public function actionSave()
    {
        $request = \Yii::$app->request;

        if($request->isPost){
            $model=($request->post());
            var_dump($model);
        }

    }

}
