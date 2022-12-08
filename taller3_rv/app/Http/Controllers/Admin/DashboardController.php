<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Order;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Chamber;
use App\Models\Staff;
use App\Models\Medicine;
use App\Models\Department;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashobard(){
        $todayOrders = Order::with('doctor')->orderBy('id','desc')->whereDay('created_at', now()->day)->get();
        $orders = Order::all();
        $users = User::where('status', 1)->get();
        $doctors = Doctor::where('status', 1)->get();
        $subscribers = Subscriber::where('is_verified',1)->get();
        $setting = Setting::first();
        $todayAppointments = Appointment::whereDay('created_at', now()->day)->get();
        $appointments = Appointment::all();
        $monthlyAppointments = Appointment::whereMonth('created_at', now()->month)->get();
        $yearlyAppointments = Appointment::whereYear('created_at', now()->year)->get();
        $chambers = Chamber::all();
        $staffs = Staff::all();
        $medicines = Medicine::all();
        $departments = Department::all();
        return view('admin.dashboard', compact('todayOrders', 'orders', 'users', 'subscribers', 'setting', 'doctors','appointments','todayAppointments', 'monthlyAppointments','yearlyAppointments','chambers','staffs','medicines','departments'));
    }


}
