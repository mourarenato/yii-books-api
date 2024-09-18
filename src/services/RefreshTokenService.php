<?php

namespace app\services;

use app\repositories\RefreshTokenRepository;
use app\models\RefreshToken;
use Firebase\JWT\JWT;
use Yii;
use yii\base\Exception;

class RefreshTokenService
{
    public function __construct(
        private readonly refreshTokenRepository $refreshTokenRepository,
    ) {}

    /**
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function generateRefreshToken(int $userId): string
    {
        $key = Yii::$app->params['jwtSecretKey'];
        $expiresAt = time() + 60 * 60;

        $payload = [
            'iat' => time(), // issued at
            'exp' => $expiresAt, // expiration time
            'uid' => $userId,
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        $refreshToken = ['token' => $token, 'expires_at' => $expiresAt, 'user_id' => $userId];

        if ($this->refreshTokenRepository->updateOrCreate($refreshToken)) {
            return $token;
        }

        throw new Exception('Failed to create refresh token.');
    }
}