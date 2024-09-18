<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Connection;
use yii\db\Exception;

class DbSetupCommand extends Controller
{
    public function actionCreateTestDb(string $dbName = 'books_api_test'): int
    {
        $dbConfig = require Yii::getAlias('@config/db.php');

        try {
            $db = new Connection($dbConfig);
            $db->createCommand("CREATE DATABASE IF NOT EXISTS $dbName")->execute();
            echo "Database $dbName created.\n";
        } catch (Exception $e) {
            echo "Error creating database: " . $e->getMessage() . "\n";
        }

        return ExitCode::OK;
    }
}