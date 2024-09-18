<?php
//$db = require __DIR__ . '/db.php';
//// test database! Important not to run tests on production or development databases
//$db['dsn'] = 'mysql:host=mysql;dbname=yii_books_api_db_test';
//
//return $db;

return [
    'dsn' => getenv('DB_DSN'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => 'utf8',
];

