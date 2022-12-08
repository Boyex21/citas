<?php

use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\AppointmentSymptom;
use Illuminate\Database\Seeder;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(Appointment::class, 50)->create(['state' => '1']);
    	$appointments=Appointment::where('state', '1')->get();
    	foreach ($appointments as $appointment) {
    		$medicines=Medicine::inRandomOrder()->limit(5)->get();
    		foreach ($medicines as $medicine) {
    			factory(Prescription::class, 1)->create(['medicine_id' => $medicine->id, 'appointment_id' => $appointment->id]);
    		}

    		if ($appointment->covid=='Si') {
    			factory(AppointmentSymptom::class, 3)->create(['appointment_id' => $appointment->id]);
    		}
    	}
    }
}
