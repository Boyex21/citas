<?php

use App\Models\User;
use App\Models\Schedule\Schedule;
use App\Models\Schedule\ScheduleUser;
use App\Models\Specialty\SpecialtyUser;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'Super',
            'lastname' => 'Admin',
            'slug' => 'super-admin',
        	'photo' => 'usuario.png',
            'phone' => '12345678',
        	'email' => 'admin@gmail.com',
            'address' => 'Dirección',
            'gender' => '1',
        	'password' => bcrypt('12345678'),
        	'state' => "1"
        ]);

        $user=User::find(1);
        $user->assignRole('Super Admin');

        factory(User::class, 1)->create(['email' => 'secretaria@gmail.com', 'dni' => NULL, 'birthday' => NULL, 'weight' => NULL, 'designation' => NULL, 'about' => NULL, 'education' => NULL,  'state' => '1']);
        factory(User::class, 4)->create(['dni' => NULL, 'birthday' => NULL, 'weight' => NULL, 'designation' => NULL, 'about' => NULL, 'education' => NULL,  'state' => '1']);
        $secretaries=User::where('id', '>', '1')->get();
        foreach ($secretaries as $secretary) {
            $secretary->assignRole('Secretaria');
        }

        factory(User::class, 1)->create(['email' => 'doctor@gmail.com', 'dni' => NULL, 'birthday' => NULL, 'weight' => NULL, 'state' => '1']);
        factory(User::class, 9)->create(['dni' => NULL, 'birthday' => NULL, 'weight' => NULL, 'state' => '1']);
        $doctors=User::where('id', '>', '6')->get();
        $schedules=Schedule::get();
        foreach ($doctors as $doctor) {
            $doctor->assignRole('Doctor');
            foreach ($schedules as $schedule) {
                factory(ScheduleUser::class, 1)->create(['schedule_id' => $schedule->id, 'user_id' => $doctor->id]);
            }
            factory(SpecialtyUser::class, 1)->create(['user_id' => $doctor->id]);
        }

        factory(User::class, 1)->create(['email' => 'paciente@gmail.com', 'designation' => NULL, 'about' => NULL, 'education' => NULL,  'state' => '1']);
        factory(User::class, 9)->create(['designation' => NULL, 'about' => NULL, 'education' => NULL,  'state' => '1']);
        $patients=User::where('id', '>', '16')->get();
        foreach ($patients as $patient) {
            $patient->assignRole('Paciente');
        }
    }
}
