<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [
        'sender_email' => $faker->email,
        'sender_phone' => $faker->phoneNumber,
        'receiver_email' => $faker->email,
        'receiver_phone' => $faker->phoneNumber
    ];
});

$factory->define(App\TransactionDetail::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph(mt_rand(10, 20)),
        'price' => mt_rand(1, 100000)
    ];
});
