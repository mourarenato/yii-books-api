<?php

namespace app\repositories;

use app\dto\DefaultFilterDto;
use app\models\Book;
use InvalidArgumentException;
use RuntimeException;
use Throwable;
use yii\data\ActiveDataProvider;
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

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function deleteBook(array $data): void
    {
        $client = new Book();
        $client::findOne($data)->delete();
    }

    public function getBooks(DefaultFilterDto $dto): ActiveDataProvider
    {
        $query = Book::find();

        if ($dto->filter) {
            $query->andFilterWhere(['or',
                ['like', 'isbn', $dto->filter],
                ['like', 'author', $dto->filter],
                ['like', 'title', $dto->filter],
            ]);
        }

        if (in_array($dto->order, ['title', 'price'])) {
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