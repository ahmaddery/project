<?php

use yii\db\Migration;

/**
 * Handles seeding default accounts
 */
class m240924_120002_seed_accounts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Password: admin (hashed)
        $this->insert('{{%account}}', [
            'username' => 'admin',
            'password' => '$2y$13$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'name' => 'Administrator',
            'role' => 'admin',
        ]);

        // Password: author (hashed)
        $this->insert('{{%account}}', [
            'username' => 'author',
            'password' => '$2y$13$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'name' => 'Content Author',
            'role' => 'author',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%account}}', ['username' => ['admin', 'author']]);
    }
}