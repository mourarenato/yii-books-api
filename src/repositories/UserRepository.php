<?php

namespace app\repositories;

use app\models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use InvalidArgumentException;
use RuntimeException;
use Yii;
use yii\db\Exception;

class UserRepository
{
    public function findByUsername(string $username): ?User
    {
        return User::findOne(['username' => $username]);
    }

    public function findIdentity($id): ?User
    {
        return User::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(User $user): bool
    {
        return $user->save();
    }

    /**
     * @throws Exception
     */
    public function createUser(array $data): User
    {
        $user = new User();
        $user->load($data, '');

        if (!$user->validate()) {
            throw new InvalidArgumentException('Validation failed: ' . json_encode($user->errors));
        }

        if (!$user->save()) {
            throw new RuntimeException('Failed to save user');
        }

        return $user;
    }

    /**
     * @throws Exception
     */
    public function deleteRefreshToken(int $userId): void
    {
        $db = Yii::$app->db;
        $db->createCommand()->delete('refresh_tokens', ['user_id' => $userId])->execute();
    }

    public function getUserByToken(string $token): ?User
    {
        try {
            $secret = Yii::$app->params['jwtSecretKey'];
            $decodedToken = JWT::decode($token, new Key($secret, 'HS256'));
            $userId = $decodedToken->uid;
            return User::findOne($userId);
        } catch (\Exception $e) {
            return null;
        }
    }
}