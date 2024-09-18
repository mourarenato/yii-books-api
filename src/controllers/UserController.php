<?php

namespace app\controllers;

use app\components\JwtAuthFilter;
use app\models\User;
use app\repositories\RefreshTokenRepository;
use app\repositories\UserRepository;
use app\services\JwtAuthService;
use app\services\RefreshTokenService;
use app\services\UserService;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

class UserController extends Controller
{
    public function behaviors(): array
    {
        return [
            'authenticator' => [
                'class' => JwtAuthFilter::class,
                'only' => ['signout'],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['signin', 'signout', 'signup'],
                        'verbs' => ['POST'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws BadRequestHttpException
     * @throws MethodNotAllowedHttpException
     */
    public function beforeAction($action): bool
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $allowedRoutes = ['signin', 'signup', 'signout'];
        if (in_array($action->id, $allowedRoutes)) {
            if (!Yii::$app->request->isPost) {
                throw new MethodNotAllowedHttpException('Only POST requests are allowed in this route');
            }
        }
        return parent::beforeAction($action);
    }

    public function actionSignin(): array
    {
        try {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $request = Yii::$app->request;
            $params = $request->post();

            $userRepository = new UserRepository();

            if (empty($params['username']) || empty($params['password'])) {
                throw new BadRequestHttpException('Username and password are required');
            }

            $user = $userRepository->findByUsername($params['username']);

            if (!$user || !$user->validatePassword($params['password'])) {
                throw new BadRequestHttpException('Invalid username or password.');
            }

            $userService = new UserService(
                $params,
                new UserRepository(),
                new JwtAuthService(new RefreshTokenService(new RefreshTokenRepository())),
            );

            $token = $userService->signin();

            return $token;
        } catch (BadRequestHttpException $e) {
            Yii::$app->response->statusCode = 400;
            Yii::info($e->getMessage() );
            return [
                'error' => 'Bad Request',
                'message' => $e->getMessage()
            ];
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::info($e->getMessage());
            return [
                'error' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function actionSignup(): array
    {
        try {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $request = Yii::$app->request;
            $params = $request->post();

            $user = new User();

            $user->attributes = $params;

            if (!$user->validate()) {
                Yii::$app->response->statusCode = 400;
                return [
                    'error' => 'Bad Request',
                    'message' => $user->errors,
                ];
            }

            $userRepository = new UserRepository();
            $userService = new UserService(
                $params,
                $userRepository,
                new JwtAuthService(new RefreshTokenService(new RefreshTokenRepository()))
            );

            $user = $userService->signup();

            if (!$user) {
                throw new Exception('Failed to create user.');
            }

            return [
                'message' => 'User created successfully.'
            ];

        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::info($e->getMessage());
            return [
                'error' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function actionSignout(): array
    {
        try {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $userService = new UserService(
                [],
                new UserRepository(),
                new JwtAuthService(new RefreshTokenService(new RefreshTokenRepository()))
            );

            $userService->signout();

            return [
                'message' => 'Signout successful'
            ];

        } catch (BadRequestHttpException $e) {
            Yii::$app->response->statusCode = 400;
            Yii::info($e->getMessage());
            return [
                'error' => 'Bad Request',
                'message' => $e->getMessage()
            ];
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::info($e->getMessage());
            return [
                'error' => 'Internal Server Error',
                'message' => $e->getMessage()
            ];
        }
    }
}