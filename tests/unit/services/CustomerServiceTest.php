<?php

namespace tests\unit\services;

use app\repositories\CustomerRepository;
use app\services\CustomerService;
use Exception;
use PHPUnit\Framework\MockObject\Exception as MockException;
use tests\unit\TestCase;
use yii\data\ActiveDataProvider;

class CustomerServiceTest extends TestCase
{
    private CustomerRepository $customerRepository;

    /**
     * @throws MockException
     */
    public function __construct()
    {
        parent::__construct(...func_get_args());
        $this->customerRepository = $this->createMock(CustomerRepository::class);
    }

    public function testCreateOneCustomer()
    {
        $requestData = [
            [
                "name" => "John Doe",
                "cpf" => "123.456.789-01",
                "address_zip" => 12345678,
                "address_street" => "Main St",
                "address_number" => 123,
                "address_city" => "Springfield",
                "address_state" => "IL",
                "address_complement" => "Apt 4B",
                "gender" => "M"
            ]
        ];

        $customerService = new CustomerService($this->customerRepository, $requestData);
        $this->customerRepository->expects($this->once())->method('createCustomer');
        $this->assertNull($customerService->createCustomers());
    }

    public function testCreateMoreThanOneCustomer()
    {
        $requestData = [
            [
                "name" => "Jane Smith",
                "cpf" => "987.654.321-00",
                "address_zip" => 87654321,
                "address_street" => "2nd Ave",
                "address_number" => 456,
                "address_city" => "Lincoln",
                "address_state" => "NE",
                "address_complement" => "",
                "gender" => "F"
            ],
            [
                "name" => "Alice Johnson",
                "cpf" => "321.654.987-02",
                "address_zip" => 23456789,
                "address_street" => "Elm St",
                "address_number" => 789,
                "address_city" => "Greenville",
                "address_state" => "SC",
                "address_complement" => "Unit 3",
                "gender" => "F"
            ],
            [
                "name" => "Bob Brown",
                "cpf" => "456.123.789-03",
                "address_zip" => 34567890,
                "address_street" => "Oak St",
                "address_number" => 101,
                "address_city" => "Madison",
                "address_state" => "WI",
                "address_complement" => "Suite 202",
                "gender" => "M"
            ],
        ];

        $customerService = new CustomerService($this->customerRepository, $requestData);
        $this->customerRepository->expects($this->exactly(3))->method('createCustomer');
        $this->assertNull($customerService->createCustomers());
    }

    public function testCreateBooksShouldThrowExceptionWhenTryToCreateMoreThanTenCustomers()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('You can only add 10 customers per request.');

        $requestData = [
            [
                "name" => "John Doe",
                "cpf" => "123.456.789-01",
                "address_zip" => 12345678,
                "address_street" => "Main St",
                "address_number" => 123,
                "address_city" => "Springfield",
                "address_state" => "IL",
                "address_complement" => "Apt 4B",
                "gender" => "M"
            ],
            [
                "name" => "Jane Smith",
                "cpf" => "987.654.321-00",
                "address_zip" => 87654321,
                "address_street" => "2nd Ave",
                "address_number" => 456,
                "address_city" => "Lincoln",
                "address_state" => "NE",
                "address_complement" => "",
                "gender" => "F"
            ],
            [
                "name" => "Alice Johnson",
                "cpf" => "321.654.987-02",
                "address_zip" => 23456789,
                "address_street" => "Elm St",
                "address_number" => 789,
                "address_city" => "Greenville",
                "address_state" => "SC",
                "address_complement" => "Unit 3",
                "gender" => "F"
            ],
            [
                "name" => "Bob Brown",
                "cpf" => "456.123.789-03",
                "address_zip" => 34567890,
                "address_street" => "Oak St",
                "address_number" => 101,
                "address_city" => "Madison",
                "address_state" => "WI",
                "address_complement" => "Suite 202",
                "gender" => "M"
            ],
            [
                "name" => "Charlie Davis",
                "cpf" => "654.321.987-04",
                "address_zip" => 45678901,
                "address_street" => "Pine St",
                "address_number" => 202,
                "address_city" => "Columbus",
                "address_state" => "OH",
                "address_complement" => "",
                "gender" => "M"
            ],
            [
                "name" => "Diana Wilson",
                "cpf" => "789.012.345-05",
                "address_zip" => 56789012,
                "address_street" => "Maple Ave",
                "address_number" => 303,
                "address_city" => "Phoenix",
                "address_state" => "AZ",
                "address_complement" => "Floor 1",
                "gender" => "F"
            ],
            [
                "name" => "Ethan White",
                "cpf" => "210.987.654-06",
                "address_zip" => 67890123,
                "address_street" => "Cedar St",
                "address_number" => 404,
                "address_city" => "Atlanta",
                "address_state" => "GA",
                "address_complement" => "",
                "gender" => "M"
            ],
            [
                "name" => "Fiona Green",
                "cpf" => "345.678.901-07",
                "address_zip" => 78901234,
                "address_street" => "Birch St",
                "address_number" => 505,
                "address_city" => "Miami",
                "address_state" => "FL",
                "address_complement" => "Penthouse",
                "gender" => "F"
            ],
            [
                "name" => "George Harris",
                "cpf" => "567.890.123-08",
                "address_zip" => 89012345,
                "address_street" => "Spruce St",
                "address_number" => 606,
                "address_city" => "Seattle",
                "address_state" => "WA",
                "address_complement" => "",
                "gender" => "M"
            ],
            [
                "name" => "Hannah Martin",
                "cpf" => "678.901.234-09",
                "address_zip" => 90123456,
                "address_street" => "Walnut St",
                "address_number" => 707,
                "address_city" => "Denver",
                "address_state" => "CO",
                "address_complement" => "Apt 2A",
                "gender" => "F"
            ],
            [
                "name" => "Ian Thompson",
                "cpf" => "789.012.345-10",
                "address_zip" => 12345678,
                "address_street" => "Ash St",
                "address_number" => 808,
                "address_city" => "Dallas",
                "address_state" => "TX",
                "address_complement" => "Room 101",
                "gender" => "M"
            ]
        ];

        $customerService = new CustomerService($this->customerRepository, $requestData);
        $this->customerRepository->expects($this->never())->method('createCustomer');
        $this->assertNull($customerService->createCustomers());
    }

    public function testDeleteCustomer()
    {
        $requestData = [
            [
                "name" => "Hannah Martin",
                "cpf" => "678.901.234-09",
                "address_zip" => 90123456,
                "address_street" => "Walnut St",
                "address_number" => 707,
                "address_city" => "Denver",
                "address_state" => "CO",
                "address_complement" => "Apt 2A",
                "gender" => "F"
            ],
        ];

        $customerService = new CustomerService($this->customerRepository, $requestData);
        $this->customerRepository->expects($this->once())->method('deleteCustomer');
        $this->assertNull($customerService->deleteCustomer());
    }

    public function testDeleteCustomerShouldThrowExceptionWhenTryToDeleteMoreThanOneCustomer()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('You can only delete 1 customer per request.');

        $requestData = [
            [
                "name" => "Fiona Green",
                "cpf" => "345.678.901-07",
                "address_zip" => 78901234,
                "address_street" => "Birch St",
                "address_number" => 505,
                "address_city" => "Miami",
                "address_state" => "FL",
                "address_complement" => "Penthouse",
                "gender" => "F"
            ],
            [
                "name" => "George Harris",
                "cpf" => "567.890.123-08",
                "address_zip" => 89012345,
                "address_street" => "Spruce St",
                "address_number" => 606,
                "address_city" => "Seattle",
                "address_state" => "WA",
                "address_complement" => "",
                "gender" => "M"
            ],
        ];

        $customerService = new CustomerService($this->customerRepository, $requestData);
        $this->customerRepository->expects($this->never())->method('deleteCustomer');
        $this->assertNull($customerService->deleteCustomer());
    }

    public function testListCustomersShouldReturnAnActiveDataProviderObject()
    {
        $requestData = [
            "limit" => 10,
            "offset" => 0,
            "order" => "name",
            "filter" => null,
        ];

        $customerService = new CustomerService($this->customerRepository, $requestData);
        $this->customerRepository->expects($this->once())->method('getCustomers');
        $this->assertInstanceOf(ActiveDataProvider::class, $customerService->listCustomers());
    }
}