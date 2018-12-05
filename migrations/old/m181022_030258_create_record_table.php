<?php

use yii\db\Migration;

/**
 * Handles the creation of table `record`.
 */
class m181022_030258_create_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('record', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->defaultValue(''),
            'memo'=>$this->string()->notNull()->defaultValue(''),
            'data'=>$this->string()->notNull()->defaultValue(''),
            'created'=>$this->integer()->notNull()->defaultValue(0),
            'year'=>$this->integer()->notNull()->defaultValue(0),
            'month'=>$this->integer()->notNull()->defaultValue(0),
            'userId'=>$this->integer()->notNull()->defaultValue(0),//ユーザー表と関連する
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('record');
    }
}
