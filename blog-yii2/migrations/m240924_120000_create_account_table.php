<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%account}}`.
 */
class m240924_120000_create_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%account}}', [
            'username' => $this->string(45)->notNull()->comment('Username'),
            'password' => $this->string(250)->notNull()->comment('Password'),
            'name' => $this->string(45)->notNull()->comment('Full Name'),
            'role' => $this->string(45)->notNull()->comment('User Role'),
        ], 'ENGINE = InnoDB');

        $this->addPrimaryKey('pk-account-username', '{{%account}}', 'username');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%account}}');
    }
}