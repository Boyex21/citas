<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Schedule\Schedule;
use App\Http\Requests\Appointment\AppointmentStoreRequest;
use App\Http\Requests\Appointment\AppointmentUpdateRequest;
use Illuminate\Http\Request;
use Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $setting=$this->setting();
        if (Auth::user()->hasRole('Paciente')) {
            $appointments=Appointment::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
        } elseif (Auth::user()->hasRole('Doctor')) {
            $appointments=Appointment::where('doctor_id', Auth::id())->orderBy('id', 'DESC')->get();
        } else {
            $appointments=Appointment::orderBy('id', 'DESC')->get();
        }
        return view('admin.appointments.index', compact('setting', 'appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $setting=$this->setting();
    	$schedules=Schedule::where('state', '1')->orderBy('id', 'DESC')->get();
    	$doctors=User::role(['Doctor'])->where('state', '1')->orderBy('name', 'DESC')->get();
    	$patients=User::role(['Paciente'])->where('state', '1')->orderBy('name', 'DESC')->get();
        return view('admin.appointments.create', compact('setting', 'doctors', 'patients', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentStoreRequest $request) {
    	$schedule=Schedule::where('id', request('schedule_id'))->firstOrFail();
    	$doctor=User::role(['Doctor'])->where('slug', request('doctor_id'))->firstOrFail();
    	$patient=User::role(['Paciente'])->where('slug', request('patient_id'))->firstOrFail();
    	$data=array('day' => request('day'), 'date' => request('date'), 'type' => request('type'), 'schedule_id' => $schedule->id, 'user_id' => $patient->id, 'doctor_id' => $doctor->id);
        $appointment=Appointment::create($data);
        if ($appointment) {
            return redirect()->route('appointments.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La cita ha sido registrada exitosamente.']);
        } else {
            return redirect()->route('appointments.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment) {
        $setting=$this->setting();
    	$schedules=Schedule::where('state', '1')->orderBy('id', 'DESC')->get();
        return view('admin.appointments.edit', compact('setting', 'appointment', 'schedules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentUpdateRequest $request, Appointment $appointment) {
    	$schedule=Schedule::where('id', request('schedule_id'))->firstOrFail();
    	$data=array('day' => request('day'), 'date' => request('date'), 'type' => request('type'), 'schedule_id' => $schedule->id);
        $appointment->fill($data)->save();
        if ($appointment) {
            return redirect()->route('appointments.edit', ['appointment' => $appointment->id])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La cita ha sido editada exitosamente.']);
        } else {
            return redirect()->route('appointments.edit', ['appointment' => $appointment->id])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment) {
        $appointment->delete();
        if ($appointment) {
            return redirect()->route('appointments.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'La cita ha sido eliminada exitosamente.']);
        } else {
            return redirect()->route('appointments.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function cancel(Request $request, Appointment $appointment) {
        $appointment->fill(['state' => "0"])->save();
        if ($appointment) {
            return redirect()->route('appointments.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La cita ha sido cancelada exitosamente.']);
        } else {
            return redirect()->route('appointments.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function attend(Request $request, Appointment $appointment) {
        $appointment->fill(['state' => "1"])->save();
        if ($appointment) {
            return redirect()->route('appointments.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La cita ha sido tratada exitosamente.']);
        } else {
            return redirect()->route('appointments.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
