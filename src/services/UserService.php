<?php

namespace app\services;

use app\repositories\UserRepository;
use InvalidArgumentException;
use RuntimeException;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\UnprocessableEntityHttpException;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        protected JwtAuthService $jwtAuthService,
        protected array $requestData = [],
    ) {}

    /**
     * @throws Exception
     */
    public function signup(): array
    {
        try {
            $this->userRepository->createUser($this->requestData);
            return [
                'status' => 'success',
                'message' => 'User registered successfully'
            ];
        } catch (InvalidArgumentException $e) {
            Yii::error($e->getMessage());
            throw new UnprocessableEntityHttpException($e->getMessage());
        } catch (RuntimeException $e) {
            Yii::error($e->getMessage());
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function signin(): array
    {
        try {
            if (empty($this->requestData['username']) || empty($this->requestData['password'])) {
                throw new BadRequestHttpException('Username and password are required');
            }

            $user = $this->userRepository->findByUsername($this->requestData['username']);

            if (!$user || !$user->validatePassword($this->requestData['password'])) {
                throw new BadRequestHttpException('Invalid username or password.');
            }

            $token = $this->jwtAuthService->generateToken($user->id);

            return [
                'token' => $token,
            ];
        } catch (BadRequestHttpException $e) {
            Yii::error($e->getMessage());
            throw new BadRequestHttpException($e->getMessage());
        } catch (Throwable $e) {
            Yii::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws \yii\db\Exception
     */
    public function signout(): void
    {
        $userId = Yii::$app->user->id;
        $this->userRepository->deleteRefreshToken($userId);
    }
}
