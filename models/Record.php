<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "record".
 *
 * @property int $id
 * @property string $name
 * @property string $memo
 * @property int $create_time
 * @property int $year
 * @property int $month
 */
class Record extends \yii\db\ActiveRecord
{
    //admin表との多対一の関係を作る
    public function getAdmin()
    {
                    //hasoneは一対一
                   //[k=>v ]kはadminのキー,vはrecordの関連キー
       return $this->hasOne(Admin::className(),['id'=>'userId']);

    }

    //data表との一対複数の関係
    public function getDatas()
    {
        return $this->hasMany(Data::className(),['recordId'=>'id']);
    }

    //テーブルのdata代わりに使う
    public $dataFile;



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','memo'],'required'],
            [['created', 'year', 'month'], 'integer'],
            [['name', 'memo'], 'string', 'max' => 255],
            ['dataFile','file','skipOnEmpty'=>true,'extensions'=>'wav,mp3','checkExtensionByMimeType'=>false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '相手のお名前',
            'memo' => '詳細記入',
            'create_time' => '挿入時間',
            'year' => '年',
            'month' => '月',
            'dataFile'=>'音声記録アップロード',
        ];
    }


}
