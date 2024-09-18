<?php

namespace tests\unit\models;

use app\models\User;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetModelName()
    {
        $mock = $this->createMock(User::class);
        $mock->method('getModelName')->willReturn('Usuario');

        $this->assertEquals('Usuario', $mock->getModelName());
    }

    public function testDbConfig()
    {
        $this->assertEquals('mysql:host=mysql;dbname=books_api_test', getenv('DB_DSN'));
        $this->assertEquals('root', getenv('DB_USER'));
        $this->assertEquals('password', getenv('DB_PASS'));
    }
}
