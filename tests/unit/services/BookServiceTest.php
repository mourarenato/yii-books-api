<?php

namespace tests\unit\services;

use app\repositories\BookRepository;
use app\services\BookService;
use Exception;
use PHPUnit\Framework\MockObject\Exception as MockException;
use tests\unit\TestCase;
use yii\data\ActiveDataProvider;

class BookServiceTest extends TestCase
{
    private BookRepository $bookRepository;

    /**
     * @throws MockException
     */
    public function __construct()
    {
        parent::__construct(...func_get_args());
        $this->bookRepository = $this->createMock(BookRepository::class);
    }

    public function testCreateOneBook()
    {
        $requestData = [
            [
                "isbn" => "9783161484100",
                "title" => "The Great Adventure",
                "author" => "Alice Smith",
                "price" => 29.99,
                "stock" => 50
            ]
        ];

        $bookService = new BookService($this->bookRepository, $requestData);
        $this->bookRepository->expects($this->once())->method('createBook');
        $this->assertNull($bookService->createBooks());
    }

    public function testCreateMoreThanOneBook()
    {
        $requestData = [
            [
                "isbn" => "9783161484100",
                "title" => "The Great Adventure",
                "author" => "Alice Smith",
                "price" => 29.99,
                "stock" => 50
            ],
            [
                "isbn" => "9783161484101",
                "title" => "Mystery of the Lost Key",
                "author" => "Bob Johnson",
                "price" => 15.50,
                "stock" => 75
            ],
            [
                "isbn" => "9783161484102",
                "title" => "Cooking with Love",
                "author" => "Catherine Lee",
                "price" => 25.00,
                "stock" => 20
            ]
        ];

        $bookService = new BookService($this->bookRepository, $requestData);
        $this->bookRepository->expects($this->exactly(3))->method('createBook');
        $this->assertNull($bookService->createBooks());
    }

    public function testCreateBooksShouldThrowExceptionWhenTryToCreateMoreThanTenBooks()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('You can only add 10 books per request.');

        $requestData = [
            [
                "isbn" => "9783161484103",
                "title" => "Journey Through Time",
                "author" => "Emma White",
                "price" => 22.50,
                "stock" => 35
            ],
            [
                "isbn" => "9783161484104",
                "title" => "Secrets of the Ocean",
                "author" => "Liam Brown",
                "price" => 18.99,
                "stock" => 60
            ],
            [
                "isbn" => "9783161484105",
                "title" => "The Art of Photography",
                "author" => "Sophia Green",
                "price" => 27.75,
                "stock" => 25
            ],
            [
                "isbn" => "9783161484106",
                "title" => "Digital Marketing 101",
                "author" => "James Taylor",
                "price" => 35.00,
                "stock" => 40
            ],
            [
                "isbn" => "9783161484107",
                "title" => "Healthy Cooking for Beginners",
                "author" => "Olivia Clark",
                "price" => 20.00,
                "stock" => 50
            ],
            [
                "isbn" => "9783161484108",
                "title" => "The Science of Happiness",
                "author" => "Benjamin Harris",
                "price" => 15.30,
                "stock" => 70
            ],
            [
                "isbn" => "9783161484109",
                "title" => "Understanding the Universe",
                "author" => "Isabella Lewis",
                "price" => 29.99,
                "stock" => 30
            ],
            [
                "isbn" => "9783161484110",
                "title" => "A Guide to Mindfulness",
                "author" => "Mason Robinson",
                "price" => 24.50,
                "stock" => 45
            ],
            [
                "isbn" => "9783161484111",
                "title" => "Adventure in Coding",
                "author" => "Evelyn Martinez",
                "price" => 19.99,
                "stock" => 55
            ],
            [
                "isbn" => "9783161484112",
                "title" => "Exploring World Cultures",
                "author" => "Jacob Walker",
                "price" => 17.85,
                "stock" => 65
            ],
            [
                "isbn" => "9783161484113",
                "title" => "Fitness for Life",
                "author" => "Ava Young",
                "price" => 28.00,
                "stock" => 40
            ]
        ];

        $bookService = new BookService($this->bookRepository, $requestData);
        $this->bookRepository->expects($this->never())->method('createBook');
        $this->assertNull($bookService->createBooks());
    }

    public function testDeleteBook()
    {
        $requestData = [
            [
                "isbn" => "9783161484100",
                "title" => "The Great Adventure",
                "author" => "Alice Smith",
                "price" => 29.99,
                "stock" => 50
            ]
        ];

        $bookService = new BookService($this->bookRepository, $requestData);
        $this->bookRepository->expects($this->once())->method('deleteBook');
        $this->assertNull($bookService->deleteBook());
    }

    public function testDeleteBookShouldThrowExceptionWhenTryToDeleteMoreThanOneBook()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('You can only delete 1 book per request.');

        $requestData = [
            [
                "isbn" => "9783161484100",
                "title" => "The Great Adventure",
                "author" => "Alice Smith",
                "price" => 29.99,
                "stock" => 50
            ],
            [
                "isbn" => "9783161484100",
                "title" => "The Great Adventure",
                "author" => "Alice Smith",
                "price" => 29.99,
                "stock" => 50
            ]
        ];

        $bookService = new BookService($this->bookRepository, $requestData);
        $this->bookRepository->expects($this->never())->method('deleteBook');
        $this->assertNull($bookService->deleteBook());
    }

    public function testListBooksShouldReturnAnActiveDataProviderObject()
    {
        $requestData = [
            "limit" => 10,
            "offset" => 0,
            "order" => "name",
            "filter" => null,
        ];

        $bookService = new BookService($this->bookRepository, $requestData);
        $this->bookRepository->expects($this->once())->method('getBooks');
        $this->assertInstanceOf(ActiveDataProvider::class, $bookService->listBooks());
    }
}