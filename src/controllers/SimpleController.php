<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SimpleController extends Controller
{
    public function behaviors(): array
    {
        return [
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

    public function actionIndex(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['data' => 'Hello World'];
    }
}