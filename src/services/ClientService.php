<?php

namespace app\services;

use app\repositories\ClientRepository;
use Throwable;
use yii\db\Exception;

class ClientService
{
    public function __construct(
        protected array $requestData,
        private readonly ClientRepository $clientRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function createClient(array $data): void
    {
        $this->clientRepository->createClient($data);
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function deleteClient(array $data): void
    {
        $this->clientRepository->deleteClient($data);
    }
}