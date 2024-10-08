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
                        'actions' => ['list'],
                        'verbs' => ['GET'],
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

            $book = new BookService(new BookRepository(), $data);

            $book->createBooks();

            return [
                'message' => 'Book(s) added with success'
            ];
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::error($e->getMessage());
            return [
                'error' => 'Failed to add book(s)',
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

            $book = new BookService(new BookRepository(), $data);

            $book->deleteBook();

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

    public function actionList()
    {
        try {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $request = Yii::$app->request;

            $limit = $request->get('limit', 10);
            $offset = $request->get('offset', 0);
            $order = $request->get('order', 'name');
            $filter = $request->get('filter', null);

            $data = ['limit' => $limit, 'offset' => $offset, 'order' => $order, 'filter' => $filter];

            $bookService = new BookService(new BookRepository(), $data);

            $dataProvider = $bookService->listBooks();

            return $this->asJson([
                'books' => $dataProvider->models,
                'total' => $dataProvider->getTotalCount(),
                'pageSize' => $dataProvider->pagination->pageSize,
                'currentPage' => $dataProvider->pagination->page + 1,
                'totalPages' => ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize),
            ]);
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::error($e->getMessage());
            return [
                'error' => 'Failed to get books list',
                'message' => $e->getMessage()
            ];
        }
    }
}