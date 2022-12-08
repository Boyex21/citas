<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentSymptom;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
    	$setting=$this->setting();

        $patientsAge=User::role(['Paciente'])->get();
        $ages[0]=$patientsAge->whereBetween('age', [0, 20])->count();
        $ages[1]=$patientsAge->whereBetween('age', [21, 40])->count();
        $ages[2]=$patientsAge->whereBetween('age', [41, 70])->count();

        $genders=User::role(['Paciente'])->select('gender', DB::raw('count(*) as total'))->groupBy('gender')->get();

        $localities=User::role(['Paciente'])->with(['location'])->select('location_id', DB::raw('count(*) as total'))->groupBy('location_id')->get();

        $appointmentsYears=Appointment::select(DB::raw('count(*) as total'), DB::raw('YEAR(date) year'))->where('state', '1')->groupBy('year')->get();
        $appointmentsMonths=Appointment::select(DB::raw('count(*) as total'), DB::raw("DATE_FORMAT(date, '%m-%Y') new_date"), DB::raw('YEAR(date) year, MONTH(date) month'))->where('state', '1')->groupBy('year', 'month')->get();
        $appointmentsWeekly=Appointment::select(DB::raw('count(*) as total'), DB::raw('WEEK(date) week'))->where([['date', '>=', date('Y-m-d', strtotime(date('Y-m-d').'- 3 months'))], ['state', '1']])->groupBy('week')->get();
        $appointmentsDiary=Appointment::select(DB::raw('count(*) as total'), DB::raw("DATE_FORMAT(date, '%d-%m-%Y') new_date"))->where([['date', '>=', date('Y-m-d', strtotime(date('Y-m-d').'- 30 days'))], ['state', '1']])->groupBy('date')->get();
        
        $specialties=Appointment::with(['specialty'])->select('specialty_id', DB::raw('count(*) as total'))->where('state', '1')->groupBy('specialty_id')->get();
        
        $covids=Appointment::with(['user', 'symptoms'])->where('covid', '1')->orderBy('id', 'DESC')->get();
        
        $symptoms=AppointmentSymptom::select('symptom', DB::raw('count(*) as total'))->groupBy('symptom')->get();

        return view('admin.statistics.index', compact('setting', 'ages', 'genders', 'localities', 'appointmentsYears', 'appointmentsMonths', 'appointmentsWeekly', 'appointmentsDiary', 'specialties', 'covids', 'symptoms'));
    }
}
