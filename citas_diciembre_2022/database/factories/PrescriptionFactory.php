<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\Prescription;
use Faker\Generator as Faker;

$factory->define(Prescription::class, function (Faker $faker) {
	$medicines=Medicine::get()->pluck('id');
	$appointments=Appointment::get()->pluck('id');
    return [
        'dosage' => $faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8']),
        'days' => $faker->numberBetween($min=1, $max=15),
        'time' => $faker->randomElement(['1', '2']),
        'comments' => $faker->sentence($nbWords=5),
        'medicine_id' => $faker->randomElement($medicines),
        'appointment_id' => $faker->randomElement($appointments),
    ];
});
