<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=Role::where('name', 'Super Admin')->first();
    	if (is_null($role)) {
    		Role::create(['name' => 'Super Admin']);
    	}

    	$role=Role::where('name', 'Administrador')->first();
    	if (is_null($role)) {
    		Role::create(['name' => 'Administrador']);
    	}

        $role=Role::where('name', 'Doctor')->first();
        if (is_null($role)) {
            Role::create(['name' => 'Doctor']);
        }

        $role=Role::where('name', 'Secretaria')->first();
        if (is_null($role)) {
            Role::create(['name' => 'Secretaria']);
        }

        $role=Role::where('name', 'Paciente')->first();
        if (is_null($role)) {
            Role::create(['name' => 'Paciente']);
        }

    	$superadmin=Role::where('name', 'Super Admin')->first();
    	$superadmin->givePermissionTo(Permission::all());

    	$admin=Role::where('name', 'Administrador')->first();
    	$admin->givePermissionTo(Permission::all());

        $doctor=Role::where('name', 'Doctor')->first();
        $doctor->givePermissionTo(['dashboard',  'appointments.index', 'appointments.create', 'appointments.show', 'appointments.edit', 'appointments.delete', 'appointments.attend', 'appointments.cancel', 'documents.index', 'documents.create', 'documents.show', 'documents.edit', 'documents.delete', 'medicines.index', 'medicines.create', 'medicines.show', 'medicines.edit', 'medicines.delete', 'medicines.active', 'medicines.deactive', 'schedules.index', 'schedules.create', 'schedules.show', 'schedules.edit', 'schedules.delete', 'schedules.active', 'schedules.deactive', 'locations.index', 'locations.create', 'locations.show', 'locations.edit', 'locations.delete', 'locations.active', 'locations.deactive']);

        $secretary=Role::where('name', 'Secretaria')->first();
        $secretary->givePermissionTo(['dashboard', 'doctors.index', 'doctors.show', 'doctors.schedules', 'patients.index', 'patients.create', 'patients.show', 'patients.edit', 'patients.delete', 'patients.active', 'patients.deactive', 'appointments.index', 'appointments.create', 'appointments.show', 'appointments.edit', 'appointments.delete', 'appointments.cancel', 'medicines.index', 'medicines.create', 'medicines.show', 'medicines.edit', 'medicines.delete', 'medicines.active', 'medicines.deactive', 'schedules.index', 'schedules.show', 'locations.index', 'locations.show']);

        $patient=Role::where('name', 'Paciente')->first();
        $patient->givePermissionTo(['dashboard', 'appointments.index', 'appointments.create', 'appointments.show', 'documents.index', 'documents.create', 'documents.show', 'documents.edit', 'documents.delete']);
    }
}
