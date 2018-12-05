<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m181023_025606_create_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),//レコーダー表と関連する
            'username'=>$this->string(),
            'password'=>$this->string(),
            'mail'=>$this->string()->notNull()->defaultValue(''),
            'fullName'=>$this->string()->notNull()->defaultValue(''),
            'code'=>$this->integer()->notNull()->defaultValue(0),
            'img'=>$this->string()->notNull()->defaultValue(''),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('admin');
    }
}
