<?php

namespace app\controllers;

use app\components\JwtAuthFilter;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

class SimpleController extends Controller
{
    public function behaviors(): array
    {
        return [
//            'authenticator' => [
//                'class' => JwtAuthFilter::class,
//                'only' => ['index'],
//            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'verbs' => ['GET'],
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
        $allowedRoutes = ['index'];
        if (in_array($action->id, $allowedRoutes)) {
            if (!Yii::$app->request->isPost) {
                throw new MethodNotAllowedHttpException('Only POST requests are allowed.');
            }
        }
        return parent::beforeAction($action);
    }

    public function actionIndex(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['data' => 'Hello World'];
    }
}