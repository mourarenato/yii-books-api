<?php

namespace factories;

use app\models\Book;
use Faker\Factory as Faker;

class BookFactory
{
    public static function create(): Book
    {
        $faker = Faker::create();

        return new Book([
            'isbn' => $faker->unique()->isbn13,
            'title' => $faker->sentence(3),
            'author' => $faker->name,
            'price' => $faker->randomFloat(2, 5, 100),
            'stock' => $faker->numberBetween(0, 100),
        ]);
    }
}