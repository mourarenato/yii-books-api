<?php

namespace app\models;

namespace app\models;

use yii\db\ActiveRecord;

class Client extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'client';
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],

            [['cpf'], 'required'],
            [['cpf'], 'string', 'max' => 14],
            [['cpf'], 'match', 'pattern' => '/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', 'message' => 'Invalid CPF format'],

            [['address_zip', 'address_street', 'address_number', 'address_city', 'address_state'], 'safe'],
            [['address_zip', 'address_number'], 'integer'],
            [['address_street', 'address_city', 'address_state', 'address_complement'], 'string', 'max' => 255],

            [['gender'], 'string'],
            [['gender'], 'in', 'range' => ['M', 'F'], 'message' => 'Gender must be either M or F'],
        ];
    }
}