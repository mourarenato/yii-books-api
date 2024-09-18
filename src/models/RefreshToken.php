<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "refresh_tokens".
 *
 * @property int $id
 * @property string $token
 * @property int $user_id
 * @property int $created_at
 * @property int $expires_at
 */
class RefreshToken extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%refresh_tokens}}';
    }

    public function rules(): array
    {
        return [
            [['token', 'user_id'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'expires_at'], 'integer'],
            ['token', 'string', 'max' => 255],
            ['token', 'unique'],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => function () {
                    return time(); // Or `date('Y-m-d H:i:s')` for datetime
                },
            ],
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
