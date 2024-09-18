<?php

namespace tests\unit;

use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    public function testYiiLoaded(): void
    {
        $this->assertTrue(class_exists('Yii'), 'Yii class not found');
    }
}