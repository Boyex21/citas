<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Schedule\Schedule;
use App\Models\Schedule\ScheduleUser;
use App\Http\Requests\Schedule\ScheduleStoreRequest;
use App\Http\Requests\Schedule\ScheduleUpdateRequest;
use App\Http\Requests\Schedule\ScheduleDoctorRequest;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $setting=$this->setting();
        $schedules=Schedule::orderBy('id', 'DESC')->get();
        return view('admin.schedules.index', compact('setting', 'schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $setting=$this->setting();
        return view('admin.schedules.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleStoreRequest $request) {
    	$data=array('day' => request('day'), 'start' => request('start'), 'end' => request('end'), 'appointment_limit' => request('appointment_limit'));
        $schedule=Schedule::create($data);
        if ($schedule) {
            return redirect()->route('schedules.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El horario ha sido registrado exitosamente.']);
        } else {
            return redirect()->route('schedules.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule) {
        $setting=$this->setting();
        return view('admin.schedules.edit', compact('setting', 'schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleUpdateRequest $request, Schedule $schedule) {
    	$data=array('day' => request('day'), 'start' => request('start'), 'end' => request('end'), 'appointment_limit' => request('appointment_limit'));
        $schedule->fill($data)->save();
        if ($schedule) {
            return redirect()->route('schedules.edit', ['schedule' => $schedule->id])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El horario ha sido editado exitosamente.']);
        } else {
            return redirect()->route('schedules.edit', ['schedule' => $schedule->id])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule) {
        $schedule->delete();
        if ($schedule) {
            return redirect()->route('schedules.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El horario ha sido eliminado exitosamente.']);
        } else {
            return redirect()->route('schedules.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, Schedule $schedule) {
        $schedule->fill(['state' => "0"])->save();
        if ($schedule) {
            return redirect()->route('schedules.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El horario ha sido desactivado exitosamente.']);
        } else {
            return redirect()->route('schedules.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, Schedule $schedule) {
        $schedule->fill(['state' => "1"])->save();
        if ($schedule) {
            return redirect()->route('schedules.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El horario ha sido activado exitosamente.']);
        } else {
            return redirect()->route('schedules.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function getSchedules(ScheduleDoctorRequest $request){
        $doctor=User::role(['Doctor'])->where('slug', request('doctor_id'))->first();
        if (!is_null($doctor)) {
            $data=[];
            $schedules=$doctor->schedules()->where([['day', date('N', strtotime(request('date')))], ['state', '1']])->get();
            foreach ($schedules as $key => $schedule) {
                $countAppointment=Appointment::where([['date', date('Y-m-d', strtotime(request('date')))], ['schedule_id' , $schedule->id], ['doctor_id', $doctor->id]])->count();
                $limit=$schedule->appointment_limit-$countAppointment;
                $data[$key]=array('id' => $schedule->id, 'start' => $schedule->start->format('H:i A'), 'end' => $schedule->end->format('H:i A'), 'limit' => $limit);
            }
            return response()->json(['state' => true, 'data' => $data]);
        }
        return response()->json(['state' => false]);
    }
}
