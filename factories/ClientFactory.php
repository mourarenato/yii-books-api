<?php

namespace factories;

use app\models\Customer;
use Faker\Factory as Faker;

class ClientFactory
{
    public static function create()
    {
        $faker = Faker::create();

        return new Customer([
            'name' => $faker->name,
            'cpf' => $faker->unique()->numerify('###.###.###-##'),
            'address_zip' => $faker->numerify('#####-###'),
            'address_street' => $faker->streetName,
            'address_number' => $faker->numberBetween(1, 1000),
            'address_city' => $faker->city,
            'address_state' => $faker->stateAbbr,
            'address_complement' => $faker->optional()->streetAddress,
            'gender' => $faker->randomElement(['M', 'F']),
        ]);
    }
}