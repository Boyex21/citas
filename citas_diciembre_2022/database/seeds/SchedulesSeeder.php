<?php

use Illuminate\Database\Seeder;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedules = [
        	['id' => 1, 'day' => 1, 'start' => '08:00:00', 'end' => '18:00:00', 'appointment_limit' => 10, 'state' => '1'],
        	['id' => 2, 'day' => 2, 'start' => '08:00:00', 'end' => '18:00:00', 'appointment_limit' => 10, 'state' => '1'],
        	['id' => 3, 'day' => 3, 'start' => '08:00:00', 'end' => '18:00:00', 'appointment_limit' => 10, 'state' => '1'],
        	['id' => 4, 'day' => 4, 'start' => '08:00:00', 'end' => '18:00:00', 'appointment_limit' => 10, 'state' => '1'],
        	['id' => 5, 'day' => 5, 'start' => '08:00:00', 'end' => '18:00:00', 'appointment_limit' => 10, 'state' => '1'],
            ['id' => 6, 'day' => 6, 'start' => '08:00:00', 'end' => '18:00:00', 'appointment_limit' => 10, 'state' => '1'],
            ['id' => 7, 'day' => 7, 'start' => '08:00:00', 'end' => '18:00:00', 'appointment_limit' => 10, 'state' => '1']
    	];
    	DB::table('schedules')->insert($schedules);
    }
}
