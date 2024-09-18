<?php

namespace app\repositories;

use app\models\RefreshToken;
use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;

class RefreshTokenRepository
{
    /**
     * @throws Exception
     */
    public function save(RefreshToken $refreshToken): bool
    {
        return $refreshToken->save();
    }

    /**
     */
    public static function updateOrCreate(array $attributes, array $conditions = []): RefreshToken|array|ActiveRecord|null
    {
        try {
            $record = RefreshToken::find()->where($conditions)->one();

            if (!$record) {
                $record = new RefreshToken();
            }
            $record->setAttributes($attributes);

            if ($record->save()) {
                return $record;
            }
            throw new Exception('Failed to save record: ' . json_encode($record->errors));
        } catch (Throwable $e) {
            Yii::error($e->getMessage());
            return null;
        }
    }

    public function findByToken(string $token): ?RefreshToken
    {
        return RefreshToken::findOne(['token' => $token]);
    }
}