<?php

use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
        	['id' => 1, 'name' => 'Emergencia', 'slug' => 'emergencia', 'state' => '1'],
        	['id' => 2, 'name' => 'Pediatría', 'slug' => 'pediatria', 'state' => '1'],
        	['id' => 3, 'name' => 'Rayos X', 'slug' => 'rayos-x', 'state' => '1'],
        	['id' => 4, 'name' => 'Cirugía', 'slug' => 'cirugia', 'state' => '1']
    	];
    	DB::table('departments')->insert($departments);
    }
}
