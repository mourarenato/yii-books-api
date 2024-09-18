<?php

namespace app\services;

use Firebase\JWT\JWT;
use Yii;
use yii\db\Exception;
use Firebase\JWT\Key;

class JwtAuthService
{
    public function __construct(
        private readonly RefreshTokenService $refreshTokenService,
    ) {}

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function generateToken(int $userId): string
    {
        return $this->refreshTokenService->generateRefreshToken($userId);
    }

    public function validateToken(string $token): array|null
    {
        try {
            $secret = Yii::$app->params['jwtSecretKey'];
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            return null;
        }
    }
}