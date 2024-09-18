<?php

namespace app\repositories;

use app\models\Book;
use InvalidArgumentException;
use RuntimeException;
use yii\db\Exception;

class BookRepository
{
    /**
     * @throws Exception
     */
    public function createBook(array $data): Book
    {
        $book = new Book();
        $book->load($data, '');

        if (!$book->validate()) {
            throw new InvalidArgumentException('Validation failed: ' . json_encode($book->errors));
        }

        if (!$book->save()) {
            throw new RuntimeException('Failed to save book');
        }

        return $book;
    }
}