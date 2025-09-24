<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m240924_120001_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'idpost' => $this->primaryKey()->comment('Post ID'),
            'title' => $this->text()->notNull()->comment('Post Title'),
            'content' => $this->text()->notNull()->comment('Post Content'),
            'date' => $this->dateTime()->notNull()->comment('Post Date'),
            'username' => $this->string(45)->notNull()->comment('Author Username'),
        ], 'ENGINE = InnoDB');

        $this->createIndex(
            'idx-post-username',
            '{{%post}}',
            'username'
        );

        $this->addForeignKey(
            'fk-post-username',
            '{{%post}}',
            'username',
            '{{%account}}',
            'username',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-post-username', '{{%post}}');
        $this->dropIndex('idx-post-username', '{{%post}}');
        $this->dropTable('{{%post}}');
    }
}