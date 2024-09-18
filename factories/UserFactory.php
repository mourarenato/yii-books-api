<?php

namespace factories;

use app\models\User;
use Faker\Factory as Faker;
use yii\base\Exception;

class UserFactory
{
    /**
     * @throws Exception
     */
    public static function create(): User
    {
        $faker = Faker::create();

        return new \app\models\User([
            'username' => $faker->userName,
            'password' => \Yii::$app->security->generatePasswordHash('password'),
            'authKey' => $faker->uuid,
        ]);
    }
}