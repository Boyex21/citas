<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Specialty\Specialty;
use App\Models\Specialty\SpecialtyUser;
use Faker\Generator as Faker;

$factory->define(SpecialtyUser::class, function (Faker $faker) {
	$users=User::role(['Doctor'])->get()->pluck('id');
	$specialties=Specialty::get()->pluck('id');
    return [
        'user_id' => $faker->randomElement($users),
        'specialty_id' => $faker->randomElement($specialties)
    ];
});
