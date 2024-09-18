<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m240918_005350_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('book', [
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
        $this->dropTable('{{%book}}');
    }
}
