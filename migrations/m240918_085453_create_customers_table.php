<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customers}}`.
 */
class m240918_085453_create_customers_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('customers', [
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

        $this->createIndex('idx-customers-name', 'customers', 'name');
        $this->createIndex('idx-customers-cpf', 'customers', 'cpf');
        $this->createIndex('idx-customers-address-city', 'customers', 'address_city');
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%customers}}');
    }
}
