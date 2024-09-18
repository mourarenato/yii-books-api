<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m240918_092114_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'isbn' => $this->string()->notNull()->unique(),
            'title' => $this->string(),
            'author' => $this->string(),
            'price' => $this->decimal(10, 2),
            'stock' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%books}}');
    }
}
