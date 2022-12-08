<?php

use Illuminate\Database\Seeder;

class SpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
        	['id' => 1, 'name' => 'Neurología', 'slug' => 'neurologia', 'state' => '1'],
        	['id' => 2, 'name' => 'Cardiología', 'slug' => 'cardiologia', 'state' => '1'],
        	['id' => 3, 'name' => 'Oftalmología', 'slug' => 'oftalmologia', 'state' => '1'],
        	['id' => 4, 'name' => 'Pediatría', 'slug' => 'pediatria', 'state' => '1'],
        	['id' => 5, 'name' => 'Radiología', 'slug' => 'radiologia', 'state' => '1'],
            ['id' => 6, 'name' => 'Urología', 'slug' => 'urologia', 'state' => '1']
    	];
    	DB::table('specialties')->insert($specialties);
    }
}
