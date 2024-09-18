<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    public function testYiiLoaded(): void
    {
        $this->assertTrue(class_exists('Yii'), 'Yii class not found');
    }

    public function testDbConfig()
    {
        $this->assertEquals('mysql:host=mysql;dbname=books_api_test', getenv('DB_DSN'));
        $this->assertEquals('root', getenv('DB_USER'));
        $this->assertEquals('password', getenv('DB_PASS'));
    }
}