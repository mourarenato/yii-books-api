<?php

namespace app\services;

use app\dto\DefaultFilterDto;
use app\repositories\BookRepository;
use Throwable;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class BookService
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        protected array $requestData = [],
    ) {}

    /**
     * @throws Exception
     */
    public function createBooks(): void
    {
        $data = json_decode(json_encode($this->requestData), true);

        if (count($data) > 10) {
            throw new Exception('You can only add 10 books per request.');
        }

        foreach ($data as $bookData) {
            $this->bookRepository->createBook($bookData);
        }
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function deleteBook(): void
    {
        $data = json_decode(json_encode($this->requestData), true);

        if (count($data) > 1) {
            throw new Exception('You can only delete 1 book per request.');
        }

        $this->bookRepository->deleteBook($this->requestData);
    }

    public function listBooks(): ActiveDataProvider
    {
        $dto = new DefaultFilterDto();
        $dto->limit = $this->requestData['limit'];
        $dto->offset = $this->requestData['offset'];
        $dto->order = $this->requestData['order'];
        $dto->filter = $this->requestData['filter'];

        return $this->bookRepository->getBooks($dto);
    }
}