<?php
namespace app\models;

use yii\base\Model;

class PasswdForm extends Model
{
    //フォームの定義

    public $oldPassword;//現在のパスワード
    public $newPassword;//新しいパスワード
    public $rePassword;//新しいパスワード確認

    public function rules()
    {
        return [
          [['oldPassword','newPassword','rePassword'],'required'],
            //現在パスワードの確認
            ['oldPassword','validatePassword'],
            //新しいパスワード二回入力あってるか
            ['rePassword','compare','compareAttribute'=>'newPassword','message'=>"二回の入力値があってません"],

        ];
    }

    public function attributeLabels()
    {
        return [
          'oldPassword'=>'現在パスワード',
          'newPassword'=>'新しいパスワード',
          'rePassword'=>'パスワード確認',
        ];
    }

    public function validatePassword()
    {
        //ログインしてるユーザーのデータを取得
        //暗号化しているパスワードを取得
       $passwordHash = \Yii::$app->user->identity->password;

       //フォームからの平文のパスワード取得
       $password=$this->oldPassword;

       if(!\Yii::$app->security->validatePassword($password,$passwordHash))
       {
           //もし検証失敗
           $this->addError('oldPassword','現在のパスワード間違ってます');

       }


    }

}