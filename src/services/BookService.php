<?php

namespace app\services;

use app\repositories\BookRepository;
use Throwable;
use yii\db\Exception;

class BookService
{
    public function __construct(
        protected array $requestData,
        private readonly BookRepository $bookRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function createBook(array $data): void
    {
        $this->bookRepository->createBook($data);
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function deleteBook(array $data): void
    {
        $this->bookRepository->deleteBook($data);
    }
}