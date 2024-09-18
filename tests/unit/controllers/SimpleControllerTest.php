<?php

namespace tests\unit\controllers;

use app\components\JwtAuthFilter;
use app\models\User;
use PHPUnit\Framework\TestCase;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Application;
use app\controllers\SimpleController;
use yii\web\UnauthorizedHttpException;

class SimpleControllerTest extends TestCase
{
    public function testActionIndexWithoutToken(): void
    {
    }

//    public function testIndexActionWithInvalidToken(): void
//    {
//        $request = Yii::$app->getRequest();
//        $request->headers->add('Authorization', 'invalid-token');
//
//        $controller = new SimpleController('test', Yii::$app);
//        $response = $controller->actionIndex();
//
//        $this->assertIsArray($response);
//        $this->assertEquals('error', $response['status']);
//        $this->assertEquals('Invalid token', $response['message']);
//    }
//
//    public function testIndexActionWithValidToken(): void
//    {
//        $token = $this->generateValidTokenForUser(1);
//
//        $request = Yii::$app->getRequest();
//        $request->setMethod('GET');
//        $request->headers->add('Authorization', $token);
//
//        $controller = new SimpleController('test', Yii::$app);
//        $response = $controller->actionIndex();
//
//        $this->assertIsArray($response);
//        $this->assertEquals('success', $response['status']);
//        $this->assertArrayHasKey('user', $response);
//        $this->assertEquals(1, $response['user']['id']);
//    }
//
//    private function generateValidTokenForUser($userId): string
//    {
//        return 'valid-token-for-user-' . $userId;
//    }
}