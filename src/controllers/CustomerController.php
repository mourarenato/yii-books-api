<?php

namespace app\controllers;

use app\components\JwtAuthFilter;
use app\repositories\CustomerRepository;
use app\services\CustomerService;
use Exception;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class CustomerController extends Controller
{
    public function behaviors(): array
    {
        return [
            'authenticator' => [
                'class' => JwtAuthFilter::class,
                'only' => ['signout', 'create', 'delete', 'list'],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['signin', 'signout', 'signup', 'create'],
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

            $customers = new CustomerService(new CustomerRepository(), $data);

            $customers->createCustomers();

            return [
                'message' => 'Customer(s) created with success'
            ];
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::error($e->getMessage());
            return [
                'error' => 'Failed to create customer(s)',
                'message' => $e->getMessage()
            ];
        }
    }

    public function actionDelete(): array
    {
        try {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $data = Yii::$app->request->getBodyParams();

            if (!isset($data['cpf'])) {
                throw new Exception('Cpf must be sent.');
            }

            $customers = new CustomerService(new CustomerRepository(), $data);

            $customers->deleteCustomer();

            return [
                'message' => 'Customers deleted with success'
            ];
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::error($e->getMessage());
            return [
                'error' => 'Failed to delete customer(s)',
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

            $customers = new CustomerService(new CustomerRepository(), $data);

            $dataProvider = $customers->listCustomers();

            return $this->asJson([
                'customers' => $dataProvider->models,
                'total' => $dataProvider->getTotalCount(),
                'pageSize' => $dataProvider->pagination->pageSize,
                'currentPage' => $dataProvider->pagination->page + 1,
                'totalPages' => ceil($dataProvider->getTotalCount() / $dataProvider->pagination->pageSize),
            ]);
        } catch (Throwable $e) {
            Yii::$app->response->statusCode = 500;
            Yii::error($e->getMessage());
            return [
                'error' => 'Failed to get customer(s) list',
                'message' => $e->getMessage()
            ];
        }
    }
}