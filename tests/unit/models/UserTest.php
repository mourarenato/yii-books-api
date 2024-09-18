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
}
