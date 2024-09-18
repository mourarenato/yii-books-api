<?php

namespace app\services;

use app\dto\DefaultFilterDto;
use app\repositories\CustomerRepository;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class CustomerService
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        protected array $requestData = [],
    ) {}

    /**
     * @throws Exception
     */
    public function createCustomers(): void
    {
        $data = json_decode(json_encode($this->requestData), true);

        if (count($data) > 10) {
            throw new Exception('You can only add 10 customers per request.');
        }

        foreach ($data as $customerData) {
            $this->customerRepository->createCustomer($customerData);
        }
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function deleteCustomer(): void
    {
        $data = json_decode(json_encode($this->requestData), true);

        if (count($data) > 1) {
            throw new Exception('You can only delete 1 customer per request.');
        }

        $this->customerRepository->deleteCustomer($this->requestData);
    }

    public function listCustomers(): ActiveDataProvider
    {
        $dto = new DefaultFilterDto();
        $dto->limit = $this->requestData['limit'];
        $dto->offset = $this->requestData['offset'];
        $dto->order = $this->requestData['order'];
        $dto->filter = $this->requestData['filter'];

        return  $this->customerRepository->getCustomers($dto);
    }
}