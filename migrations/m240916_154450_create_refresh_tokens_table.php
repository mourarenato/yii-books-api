<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%refresh_tokens}}`.
 */
class m240916_154450_create_refresh_tokens_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%refresh_tokens}}', [
            'id' => $this->primaryKey(),
            'token' => $this->string()->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()->defaultValue(time()),
            'updated_at' => $this->integer()->notNull()->defaultValue(time()),
            'expires_at' => $this->integer()->null()->defaultValue(null)
        ]);

        $this->createIndex(
            'idx-refresh-tokens-user-id',
            '{{%refresh_tokens}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-refresh-tokens-user-id',
            '{{%refresh_tokens}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey(
            'fk-refresh-tokens-user-id',
            '{{%refresh_tokens}}'
        );

        $this->dropIndex(
            'idx-refresh-tokens-user-id',
            '{{%refresh_tokens}}'
        );

        $this->dropTable('{{%refresh_tokens}}');
    }
}
