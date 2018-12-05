<?php

namespace app\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    //ログイン状態記録
    public $rememberMe=true;

   public function rules()
   {
       return[
         [['username','password'],'required'],
       ];
   }

   public function attributeLabels()
   {
       return [
         'username'=>'ユーザーネーム',
         'password'=>'パスワード',
       ];
   }

   public function login()
   {
       $admin=Admin::findOne(['username'=>$this->username]);
       if($admin)
       {
           //存在
           //1.2パスワードを比べて
           //平文　　　　　　　　暗号
           if(\Yii::$app->security->validatePassword($this->password,$admin->password)){
               //パスワード正解ログイン                         ログイン状態を記録
               \Yii::$app->user->login($admin,$this->rememberMe ? 3600*24*30 : 0);
               return true;
           }else{
               //パスワード間違ってる
               $this->addError('password','パスワード間違ってる');
           }

       }else{

           //存在しない
           //エラーを出す
           $this->addError('username','ユーザー存在しない');
       }
       return false;
   }


}
