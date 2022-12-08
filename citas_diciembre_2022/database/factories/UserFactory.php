<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Location;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $locations=Location::get()->pluck('id');
    return [
        'name' => $faker->name,
        'lastname' => $faker->lastname,
        'dni' => $faker->numberBetween($min=10000000, $max=99999999),
        'phone' => $faker->numberBetween($min=10000000, $max=99999999),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'address' => $faker->address,
        'gender' => $faker->randomElement(['1', '2', '3']),
        'birthday' => $faker->date($format='Y-m-d', $max='now'),
        'weight' => $faker->numberBetween($min=50, $max=100),
        'designation' => $faker->word,
        'about' => $faker->sentence($nbWords=20),
        'education' => $faker->sentence($nbWords=20),
        'password' => Hash::make('12345678'),
        'remember_token' => Str::random(10),
        'state' => $faker->randomElement(['1', '0']),
        'location_id' => $faker->randomElement($locations)
    ];
});
