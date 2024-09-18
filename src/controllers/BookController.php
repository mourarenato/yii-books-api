<?php

namespace app\controllers;

use app\components\JwtAuthFilter;
use app\repositories\BookRepository;
use app\services\BookService;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class BookController extends Controller
{
    public function behaviors(): array
    {
        return [
            'authenticator' => [
                'class' => JwtAuthFilter::class,
                'only' => ['create'],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'verbs' => ['POST'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'verbs' => ['DELETE'],
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

            $book = new BookService($data, new BookRepository());

            $book->createBook($data);

            return [
                'message' => 'Book created with success'
            ];
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::error($e->getMessage());
            return [
                'error' => 'Failed to create book',
                'message' => $e->getMessage()
            ];
        }
    }

    public function actionDelete(): array
    {
        try {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $data = Yii::$app->request->getBodyParams();

            if (!isset($data['isbn'])) {
                throw new Exception('Isbn must be sent.');
            }

            $client = new BookService($data, new BookRepository());

            $client->deleteBook($data);

            return [
                'message' => 'Book deleted with success'
            ];
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::error($e->getMessage());
            return [
                'error' => 'Failed to delete book',
                'message' => $e->getMessage()
            ];
        }
    }
}