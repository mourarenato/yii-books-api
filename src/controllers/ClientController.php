<?php

namespace app\controllers;

use app\components\JwtAuthFilter;
use app\repositories\ClientRepository;
use app\services\ClientService;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class ClientController extends Controller
{
    public function behaviors(): array
    {
        return [
            'authenticator' => [
                'class' => JwtAuthFilter::class,
                'only' => ['signout', 'create'],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['signin', 'signout', 'signup', 'create'],
                        'verbs' => ['POST'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate(): array
    {
        try {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $data = Yii::$app->request->getBodyParams();

            $client = new ClientService($data, new ClientRepository());

            $client->createClient($data);

            return [
                'message' => 'Client created with success'
            ];
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::info($e->getMessage());
            return [
                'error' => 'Failed to create client',
                'message' => $e->getMessage()
            ];
        }
    }
}