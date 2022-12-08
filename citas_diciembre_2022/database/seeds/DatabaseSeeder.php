<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SpecialtiesSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(MedicinesSeeder::class);
        $this->call(SchedulesSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(SettingsSeeder::class);
    }
}
