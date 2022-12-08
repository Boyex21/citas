<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Appointment;
use App\Models\AppointmentSymptom;
use Faker\Generator as Faker;

$factory->define(AppointmentSymptom::class, function (Faker $faker) {
	$appointments=Appointment::get()->pluck('id');
    return [
        'symptom' => $faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
        'appointment_id' => $faker->randomElement($appointments),
    ];
});
