<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Staff;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Chamber;
use App\Models\Medicine;
use App\Models\Department;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashobard(){
        $setting=Setting::first();
        $users=User::where('status', 1)->get();
        $doctors=Doctor::where('status', 1)->get();
        $todayAppointments=Appointment::whereDay('created_at', now()->day)->get();
        $appointments=Appointment::all();
        $monthlyAppointments=Appointment::whereMonth('created_at', now()->month)->get();
        $yearlyAppointments=Appointment::whereYear('created_at', now()->year)->get();
        $chambers=Chamber::all();
        $staffs=Staff::all();
        $medicines=Medicine::all();
        $departments=Department::all();
        return view('admin.dashboard', compact('setting', 'users', 'doctors','appointments','todayAppointments', 'monthlyAppointments','yearlyAppointments','chambers','staffs','medicines','departments'));
    }
}