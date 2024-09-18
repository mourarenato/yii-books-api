<?php

namespace app\services;

use app\repositories\BookRepository;
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
}