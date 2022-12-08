<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Appointment;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
	$covid_state=$covid_date=$uci=NULL;
	$covid=$faker->randomElement(['0', '1']);
	if ($covid=='1') {
		$uci=$faker->randomElement(['0', '1']);
		$covid_date=$faker->date($format='Y-m-d', $max='now');
		$covid_state=$faker->randomElement(['1', '2']);
	}
	$doctors=User::role(['Doctor'])->get()->pluck('id');
	$patients=User::role(['Paciente'])->get()->pluck('id');
	$doctor=$faker->randomElement($doctors);
	$doctor=User::role(['Doctor'])->with(['schedules', 'specialties'])->where('id', $doctor)->first();
	$schedules=$doctor['schedules']->pluck('id');
	$specialties=$doctor['specialties']->pluck('id');
	$doctor=$doctor->id;
    return [
        'day' => $faker->randomElement(['1', '2', '3', '4', '5', '6', '7']),
        'date' => $faker->dateTimeBetween('-90 days', '-1 days')->format('Y-m-d'),
        'blood_pressure' => $faker->numberBetween($min=30, $max=70),
        'pulse_rate' => $faker->numberBetween($min=50, $max=100),
        'temperature' => $faker->numberBetween($min=15, $max=30),
        'problem_description' => $faker->sentence($nbWords=20),
        'covid' => $covid,
        'uci' => $uci,
        'covid_date' => $covid_date,
        'covid_state' => $covid_state,
        'advice' => $faker->sentence($nbWords=20),
        'test' => $faker->sentence($nbWords=20),
        'days' => $faker->numberBetween($min=1, $max=10),
        'time' => $faker->randomElement(['1', '2', '3']),
        'type' => $faker->randomElement(['1', '2']),
        'state' => $faker->randomElement(['0', '1', '2']),
        'specialty_id' => $faker->randomElement($specialties),
        'schedule_id' => $faker->randomElement($schedules),
        'user_id' => $faker->randomElement($patients),
        'doctor_id' => $doctor,
    ];
});
