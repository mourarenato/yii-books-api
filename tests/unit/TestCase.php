<?php

namespace tests\unit;

use \PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
//    public function __construct($name = '', array $data = [], $dataName = '')
//    {
//        parent::__construct($name, $data, $dataName);
//    }

    public function __construct() {
        parent::__construct(...func_get_args());
    }
}