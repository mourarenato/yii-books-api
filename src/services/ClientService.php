<?php

namespace app\services;

use app\repositories\ClientRepository;

class ClientService
{
    public function __construct(
        protected array $requestData,
        private readonly ClientRepository $clientRepository,
    ) {}

    /**
     */
    public function createClient(array $data): void
    {
        $this->clientRepository->createClient($data);
    }
}