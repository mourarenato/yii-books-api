<?php

namespace app\repositories;

use app\dto\DefaultFilterDto;
use app\models\Customer;
use InvalidArgumentException;
use RuntimeException;
use Throwable;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class CustomerRepository
{
    /**
     * @throws Exception
     */
    public function createCustomer(array $data): Customer
    {
        $customer = new Customer();
        $customer->load($data, '');

        if (!$customer->validate()) {
            throw new InvalidArgumentException('Validation failed: ' . json_encode($customer->errors));
        }

        if (!$customer->save()) {
            throw new RuntimeException('Failed to save customer');
        }

        return $customer;
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function deleteCustomer(array $data): void
    {
        $customer = new Customer();
        $customer::findOne($data)->delete();
    }

    public function getCustomers(DefaultFilterDto $dto): ActiveDataProvider
    {
        $query = Customer::find();

        if ($dto->filter) {
            $query->andFilterWhere(['or',
                ['like', 'name', $dto->filter],
                ['like', 'cpf', $dto->filter],
            ]);
        }

        if (in_array($dto->order, ['name', 'cpf', 'address_city'])) {
            $query->orderBy($dto->order);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $dto->limit,
                'page' => $dto->offset / $dto->limit,
            ],
        ]);
    }
}