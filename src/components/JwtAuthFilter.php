<?php

namespace app\components;

use app\repositories\RefreshTokenRepository;
use app\services\JwtAuthService;
use app\services\RefreshTokenService;
use yii\filters\auth\AuthMethod;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

class JwtAuthFilter extends AuthMethod
{
    public function __construct(
        private readonly RefreshTokenService $refreshTokenService,
        private readonly RefreshTokenRepository $refreshTokenRepository,
        $config = []
    ) {
        parent::__construct($config);
    }

    public function authenticate($user, $request, $response): ?IdentityInterface
    {
        $authHeader = $request->getHeaders()->get('Authorization');

        if ($authHeader) {
            $token = str_replace('Bearer ', '', $authHeader);
            $jwtAuth = new JwtAuthService($this->refreshTokenService);
            $canProceed = $this->refreshTokenRepository->findByToken($token);
            $decoded = $jwtAuth->validateToken($token);

            if ($decoded && isset($decoded['uid']) && $canProceed) {
                return $user->loginByAccessToken($token, 'yii\filters\auth\HttpBearerAuth');
            }

            throw new UnauthorizedHttpException('Invalid token');
        }

        throw new UnauthorizedHttpException('Token not provided');
    }
}