<?php

namespace app\repositories;

use app\models\Client;
use InvalidArgumentException;
use RuntimeException;
use Throwable;
use yii\db\Exception;

class ClientRepository
{
    /**
     * @throws Exception
     */
    public function createClient(array $data): Client
    {
        $client = new Client();
        $client->load($data, '');

        if (!$client->validate()) {
            throw new InvalidArgumentException('Validation failed: ' . json_encode($client->errors));
        }

        if (!$client->save()) {
            throw new RuntimeException('Failed to save client');
        }

        return $client;
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function deleteClient(array $data): void
    {
        $client = new Client();
        $client::findOne($data)->delete();
    }
}