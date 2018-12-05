<?php

use yii\db\Migration;

/**
 * Handles the creation of table `data`.
 */
class m181022_030241_create_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('data', [
            'id' => $this->primaryKey(),
            'data'=>$this->string()->notNull()->defaultValue(''),
            'recordId'=>$this->integer()->notNull()->defaultValue(0),//レコーダー表と関連する
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('data');
    }
}
