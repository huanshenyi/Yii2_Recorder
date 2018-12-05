<?php

namespace app\models;

use Yii;
use yii\web\Request;

/**
 * This is the model class for table "data".
 *
 * @property int $id
 * @property string $data
 * @property int $recordId
 */
class Data extends \yii\db\ActiveRecord
{

    public $dataFiles;
    //Record表との多対一の関係を作る
    public function getRecord()
    {
        return $this->hasOne(Record::className(),['id'=>'recordId']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recordId'], 'integer'],
            [['data'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => '音声記録',
            'recordId' => 'Record ID',
            'dataFile'=>'記録ファイル'
        ];
    }
}
