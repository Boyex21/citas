<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission to Access the Administrative Panel
        $permission=Permission::where('name', 'dashboard')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'dashboard']);
        }

        // User Permissions
        $permission=Permission::where('name', 'users.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'users.index']);
            Permission::create(['name' => 'users.create']);
            Permission::create(['name' => 'users.show']);
            Permission::create(['name' => 'users.edit']);
            Permission::create(['name' => 'users.delete']);
            Permission::create(['name' => 'users.active']);
            Permission::create(['name' => 'users.deactive']);
        }

        // Doctor Permissions
        $permission=Permission::where('name', 'doctors.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'doctors.index']);
            Permission::create(['name' => 'doctors.create']);
            Permission::create(['name' => 'doctors.show']);
            Permission::create(['name' => 'doctors.edit']);
            Permission::create(['name' => 'doctors.delete']);
            Permission::create(['name' => 'doctors.active']);
            Permission::create(['name' => 'doctors.deactive']);
            Permission::create(['name' => 'doctors.schedules']);
        }

        // Secretary Permissions
        $permission=Permission::where('name', 'secretaries.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'secretaries.index']);
            Permission::create(['name' => 'secretaries.create']);
            Permission::create(['name' => 'secretaries.show']);
            Permission::create(['name' => 'secretaries.edit']);
            Permission::create(['name' => 'secretaries.delete']);
            Permission::create(['name' => 'secretaries.active']);
            Permission::create(['name' => 'secretaries.deactive']);
        }

        // Patient Permissions
        $permission=Permission::where('name', 'patients.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'patients.index']);
            Permission::create(['name' => 'patients.create']);
            Permission::create(['name' => 'patients.show']);
            Permission::create(['name' => 'patients.edit']);
            Permission::create(['name' => 'patients.delete']);
            Permission::create(['name' => 'patients.active']);
            Permission::create(['name' => 'patients.deactive']);
        }

        // Appointment Permissions
        $permission=Permission::where('name', 'appointments.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'appointments.index']);
            Permission::create(['name' => 'appointments.create']);
            Permission::create(['name' => 'appointments.show']);
            Permission::create(['name' => 'appointments.edit']);
            Permission::create(['name' => 'appointments.delete']);
            Permission::create(['name' => 'appointments.attend']);
            Permission::create(['name' => 'appointments.cancel']);
        }

        // Document Permissions
        $permission=Permission::where('name', 'documents.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'documents.index']);
            Permission::create(['name' => 'documents.create']);
            Permission::create(['name' => 'documents.show']);
            Permission::create(['name' => 'documents.edit']);
            Permission::create(['name' => 'documents.delete']);
        }

        // Specialty Permissions
        $permission=Permission::where('name', 'specialties.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'specialties.index']);
            Permission::create(['name' => 'specialties.create']);
            Permission::create(['name' => 'specialties.show']);
            Permission::create(['name' => 'specialties.edit']);
            Permission::create(['name' => 'specialties.delete']);
            Permission::create(['name' => 'specialties.active']);
            Permission::create(['name' => 'specialties.deactive']);
        }

        // Department Permissions
        $permission=Permission::where('name', 'departments.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'departments.index']);
            Permission::create(['name' => 'departments.create']);
            Permission::create(['name' => 'departments.show']);
            Permission::create(['name' => 'departments.edit']);
            Permission::create(['name' => 'departments.delete']);
            Permission::create(['name' => 'departments.active']);
            Permission::create(['name' => 'departments.deactive']);
        }

        // Medicine Permissions
        $permission=Permission::where('name', 'medicines.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'medicines.index']);
            Permission::create(['name' => 'medicines.create']);
            Permission::create(['name' => 'medicines.show']);
            Permission::create(['name' => 'medicines.edit']);
            Permission::create(['name' => 'medicines.delete']);
            Permission::create(['name' => 'medicines.active']);
            Permission::create(['name' => 'medicines.deactive']);
        }

        // Schedule Permissions
        $permission=Permission::where('name', 'schedules.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'schedules.index']);
            Permission::create(['name' => 'schedules.create']);
            Permission::create(['name' => 'schedules.show']);
            Permission::create(['name' => 'schedules.edit']);
            Permission::create(['name' => 'schedules.delete']);
            Permission::create(['name' => 'schedules.active']);
            Permission::create(['name' => 'schedules.deactive']);
        }

        // Location Permissions
        $permission=Permission::where('name', 'locations.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'locations.index']);
            Permission::create(['name' => 'locations.create']);
            Permission::create(['name' => 'locations.show']);
            Permission::create(['name' => 'locations.edit']);
            Permission::create(['name' => 'locations.delete']);
            Permission::create(['name' => 'locations.active']);
            Permission::create(['name' => 'locations.deactive']);
        }

        // Role Permissions
        $permission=Permission::where('name', 'roles.index')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'roles.index']);
            Permission::create(['name' => 'roles.create']);
            Permission::create(['name' => 'roles.show']);
            Permission::create(['name' => 'roles.edit']);
            Permission::create(['name' => 'roles.delete']);
        }

        // Setting Permissions
        $permission=Permission::where('name', 'settings.edit')->first();
        if (is_null($permission)) {
            Permission::create(['name' => 'settings.edit']);
        }
    }
}
