<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m240918_004833_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('client', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'cpf' => $this->string(14)->notNull()->unique(),
            'address_zip' => $this->integer(),
            'address_street' => $this->string(),
            'address_number' => $this->integer(),
            'address_city' => $this->string(),
            'address_state' => $this->string(),
            'address_complement' => $this->string(),
            'gender' => $this->string(1),
        ]);

        $this->createIndex('idx-client-name', 'client', 'name');
        $this->createIndex('idx-client-cpf', 'client', 'cpf');
        $this->createIndex('idx-client-address-city', 'client', 'address_city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%client}}');
    }
}
