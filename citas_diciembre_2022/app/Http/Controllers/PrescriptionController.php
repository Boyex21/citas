<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\AppointmentSymptom;
use App\Http\Requests\Prescription\PrescriptionStoreRequest;
use App\Http\Requests\Prescription\PrescriptionUpdateRequest;
use App\Http\Requests\Prescription\PrescriptionMedicineAddRequest;
use App\Http\Requests\Prescription\PrescriptionMedicineUpdateRequest;
use App\Http\Requests\Prescription\PrescriptionMedicineDeleteRequest;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Appointment $appointment) {
        $setting=$this->setting();
        $medicines=Medicine::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.prescriptions.create', compact('setting', 'appointment', 'medicines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrescriptionStoreRequest $request, Appointment $appointment) {
        $data=array('blood_pressure' => request('blood_pressure'), 'pulse_rate' => request('pulse_rate'), 'temperature' => request('temperature'), 'problem_description' => request('problem_description'), 'covid' => request('covid'), 'covid_date' => request('covid_date'), 'symptoms' => request('symptoms'), 'uci' => request('uci'), 'covid_state' => request('covid_state'), 'test' => request('test'), 'advice' => request('advice'), 'days' => request('days'), 'time' => request('time'), 'state' => '1');
        $appointment->fill($data)->save();
        if ($appointment) {
            foreach (session('prescription') as $key => $value) {
                if (!is_null($value['medicine'])) {
                    $data=array('dosage' => $value['dosage'], 'days' => $value['days'], 'time' => $value['time'], 'comments' => $value['comments'], 'medicine_id' => $value['medicine']->id, 'appointment_id' => $appointment->id);
                    Prescription::create($data);
                }
            }

            if (request('covid')=='1') {
                foreach (request('symptoms') as $key => $value) {
                    $data=array('symptom' => $value, 'appointment_id' => $appointment->id);
                    AppointmentSymptom::create($data);
                }
            }

            if ($request->session()->has("prescription")) {
                $request->session()->forget("prescription");
            }

            return redirect()->route('appointments.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La prescripción ha sido registrada exitosamente.']);
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
        $medicines=Medicine::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.prescriptions.edit', compact('setting', 'appointment', 'medicines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(PrescriptionUpdateRequest $request, Appointment $appointment) {
        $data=array('blood_pressure' => request('blood_pressure'), 'pulse_rate' => request('pulse_rate'), 'temperature' => request('temperature'), 'problem_description' => request('problem_description'), 'covid' => request('covid'), 'covid_date' => request('covid_date'), 'symptoms' => request('symptoms'), 'uci' => request('uci'), 'covid_state' => request('covid_state'), 'test' => request('test'), 'advice' => request('advice'), 'days' => request('days'), 'time' => request('time'));
        $appointment->fill($data)->save();
        if ($appointment) {
            AppointmentSymptom::where('appointment_id', $appointment->id)->delete();
            if (request('covid')=='1') {
                foreach (request('symptoms') as $key => $value) {
                    $data=array('symptom' => $value, 'appointment_id' => $appointment->id);
                    AppointmentSymptom::create($data);
                }
            }

            return redirect()->route('prescriptions.edit', ['appointment' => $appointment->id])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La prescripción ha sido editada exitosamente.']);
        } else {
            return redirect()->route('prescriptions.edit', ['appointment' => $appointment->id])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function prescriptionAdd(PrescriptionMedicineAddRequest $request, Appointment $appointment) {
        $medicine=Medicine::where('slug', request('medicine'))->first();
        if (!is_null($medicine)) {
            $code=$medicine->slug.'-'.request('dosage').'-'.request('days').'-'.request('time');
            
            if ($request->session()->has("prescription")) {
                $prescription=session("prescription");

                if (array_search($code, array_column($prescription, 'code'))!==false) {
                    $count=count(session("prescription"));
                    return response()->json(['status' => true, 'exist' => true, 'count' => $count]);
                } else {
                    $data=array('medicine' => $medicine, 'dosage' => request('dosage'), 'days' => request('days'), 'time' => request('time'), 'comments' => request('comments'), 'code' => $code);
                    $request->session()->push("prescription", $data);
                    $count=count(session("prescription"));
                    return response()->json(['status' => true, 'exist' => false, 'count' => $count, 'data' => $data]);
                }
            } else {
                $data=array('medicine' => $medicine, 'dosage' => request('dosage'), 'days' => request('days'), 'time' => request('time'), 'comments' => request('comments'), 'code' => $code);
                $request->session()->push("prescription", $data);
                $count=count(session("prescription"));
                return response()->json(['status' => true, 'exist' => false, 'count' => $count, 'data' => $data]);
            }
        }

        return response()->json(['status' => false]);
    }

    public function prescriptionRemove(Request $request, Appointment $appointment) {
        if ($request->session()->has("prescription")) {
            $prescription=session("prescription");

            if (array_search(request('code'), array_column($prescription, 'code'))!==false) {
                $request->session()->forget("prescription");
                foreach ($prescription as $item) {
                    if (request('code')!=$item['code']) {
                        if (!$request->session()->has("prescription")) {
                            $request->session()->put("prescription", array(0 => $item));
                        } else {
                            $request->session()->push("prescription", $item);
                        }
                    }
                }
                $count=($request->session()->has("prescription")) ? count(session("prescription")) : 0;

                return response()->json(['status' => true, 'count' => $count]);
            }
        }

        return response()->json(['status' => false]);
    }

    public function prescriptionUpdate(PrescriptionMedicineUpdateRequest $request, Appointment $appointment) {
        $medicine=Medicine::where('slug', request('medicine'))->first();
        if (!is_null($appointment) && !is_null($medicine)) {
            if ($appointment->prescriptions()->where([['dosage', request('dosage')], ['days', request('days')], ['time', request('time')], ['medicine_id', $medicine->id]])->count()>0) {
                $count=$appointment['prescriptions']->count();
                return response()->json(['status' => true, 'exist' => true, 'count' => $count]);
            } else {
                $data=array('dosage' => request('dosage'), 'days' => request('days'), 'time' => request('time'), 'comments' => request('comments'), 'medicine_id' => $medicine->id, 'appointment_id' => $appointment->id);
                $item=Prescription::create($data);
                if ($item) {
                    $data=array('medicine' => $medicine, 'dosage' => request('dosage'), 'days' => request('days'), 'time' => request('time'), 'comments' => request('comments'), 'code' => $item->id);

                    $appointment=Appointment::with(['prescriptions'])->where('id', $appointment->id)->first();
                    $count=$appointment['prescriptions']->count();
                    
                    return response()->json(['status' => true, 'exist' => false, 'count' => $count, 'data' => $data]);
                }
            }
        }

        return response()->json(['status' => false]);
    }

    public function prescriptionDelete(PrescriptionMedicineDeleteRequest $request, Appointment $appointment) {
        if (!is_null($appointment)) {
            if ($appointment['prescriptions']->where('id', request('code'))->count()>0) {
                foreach ($appointment['prescriptions'] as $item) {
                    if (request('code')==$item->id) {
                        $item->delete();
                    }
                }
                $appointment=Appointment::with(['prescriptions'])->where('id', $appointment->id)->first();
                $count=$appointment['prescriptions']->count();

                return response()->json(['status' => true, 'count' => $count]);
            }
        }

        return response()->json(['status' => false]);
    }
}
