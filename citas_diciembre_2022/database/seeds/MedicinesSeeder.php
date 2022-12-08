<?php

use Illuminate\Database\Seeder;

class MedicinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicines = [
        	['id' => 1, 'name' => 'Sirap', 'slug' => 'sirap', 'state' => '1'],
        	['id' => 2, 'name' => 'Simulect', 'slug' => 'simulect', 'state' => '1'],
        	['id' => 3, 'name' => 'Synthroid', 'slug' => 'synthroid', 'state' => '1'],
        	['id' => 4, 'name' => 'Crestor', 'slug' => 'crestor', 'state' => '1'],
        	['id' => 5, 'name' => 'Nexium', 'slug' => 'nexium', 'state' => '1'],
            ['id' => 6, 'name' => 'Advair Diskus', 'slug' => 'advair-diskus', 'state' => '1'],
            ['id' => 7, 'name' => 'Humira', 'slug' => 'humira', 'state' => '1'],
            ['id' => 8, 'name' => 'Lantus Solostar', 'slug' => 'lantus-solostar', 'state' => '1'],
            ['id' => 9, 'name' => 'Baclofen Inyección', 'slug' => 'baclofen-inyeccion', 'state' => '1']
    	];
    	DB::table('medicines')->insert($medicines);
    }
}
