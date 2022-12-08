<?php

use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
        	['id' => 1, 'name' => 'New York', 'slug' => 'new-york', 'state' => '1'],
        	['id' => 2, 'name' => 'Los Angeles', 'slug' => 'los-angeles', 'state' => '1'],
        	['id' => 3, 'name' => 'Chicago', 'slug' => 'chicago', 'state' => '1'],
        	['id' => 4, 'name' => 'Houston', 'slug' => 'houston', 'state' => '1'],
        	['id' => 5, 'name' => 'San Antonio', 'slug' => 'san-antonio', 'state' => '1'],
            ['id' => 6, 'name' => 'San Diego', 'slug' => 'san-diego', 'state' => '1']
    	];
    	DB::table('locations')->insert($locations);
    }
}
