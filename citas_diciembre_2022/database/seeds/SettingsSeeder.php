<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
    		['id' => 1, 'name' => 'Medyapp', 'logo' => 'logo.png', 'favicon' => 'favicon.png', 'enable_register' => '1']
    	];
    	DB::table('settings')->insert($settings);
    }
}
