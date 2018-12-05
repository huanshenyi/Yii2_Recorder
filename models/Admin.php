<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $code
 */
                                           //インターフェースを入れる
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    //レコーダー表と関係付け 一対多
    public function getRecord()
    {

    }


    public $imgFile;

    //権限のリスト
    static public $adminOptions=[1=>'作業者',2=>'管理者'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'string', 'max' => 255],
            [['code','fullName','mail'],'required'],
            ['mail','email','message'=>'有効なメールアドレス書式ではありません'],
                                                               //なければ、スキップ
            ['imgFile','file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>true,'checkExtensionByMimeType'=>false],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'ユーザーネーム',
            'password' => 'パスワード',
            'mail'=>'メールアドレス',
            'fullName'=>'本名',
            'code'=>'番号',
            'img'=>'アイコン',
            'imgFile'=>'アイコン',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    //保存する前に執行
    public function beforeSave($insert)
    {
        //$insertは新規の時にtrue

        if($insert){
            //パスワードを暗号化
            $this->password = \Yii::$app->security->generatePasswordHash($this->password);

        }else{
            //更新and修正

        }
        return parent::beforeSave($insert);
    }
}
