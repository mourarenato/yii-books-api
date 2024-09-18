<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $isbn
 * @property string $title
 * @property string $author
 * @property float $price
 * @property int $stock
 */
class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'book';
    }

    public function rules(): array
    {
        return [
            [['isbn'], 'required'],
            [['isbn'], 'number', 'max' => 13],
            [['isbn'], 'unique'],

            [['title'], 'string', 'max' => 255],

            [['author'], 'string', 'max' => 255],

            [['price'], 'number'],

            [['stock'], 'integer'],
        ];
    }
}