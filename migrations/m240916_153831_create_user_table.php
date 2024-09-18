<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240916_153831_create_user_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'authKey' => $this->string(),
            'created_at' => $this->integer()->notNull()->defaultValue(time()),
            'updated_at' => $this->integer()->notNull()->defaultValue(time())
        ]);

        // Adicione mais índices, se necessário
        // $this->createIndex('idx-user-username', '{{%user}}', 'username');
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%user}}');
    }
}
