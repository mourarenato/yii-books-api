<?php

namespace app\repositories;

use app\models\Client;
use InvalidArgumentException;
use RuntimeException;

class ClientRepository
{
    public function createClient(array $data): Client
    {
        $user = new Client();
        $user->load($data, '');

        if (!$user->validate()) {
            throw new InvalidArgumentException('Validation failed: ' . json_encode($user->errors));
        }

        if (!$user->save()) {
            throw new RuntimeException('Failed to save user');
        }

        return $user;
    }
}