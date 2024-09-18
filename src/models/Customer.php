<?php

namespace app\models;

namespace app\models;

use yii\db\ActiveRecord;

class Customer extends ActiveRecord
{
    /**
     * This is the model class for table "customers".
     *
     * @property int $id
     * @property string $name
     * @property string $cpf
     * @property int $address_zip
     * @property string address_street
     * @property int address_number
     * @property string address_city
     * @property string address_state
     * @property string address_complement
     * @property string gender
     */
    public static function tableName(): string
    {
        return 'customers';
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