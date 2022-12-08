<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Schedule\Schedule;
use App\Models\Schedule\ScheduleUser;
use Faker\Generator as Faker;

$factory->define(ScheduleUser::class, function (Faker $faker) {
	$users=User::role(['Doctor'])->get()->pluck('id');
	$schedules=Schedule::get()->pluck('id');
    return [
        'user_id' => $faker->randomElement($users),
        'schedule_id' => $faker->randomElement($schedules)
    ];
});
