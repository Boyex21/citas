<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Specialty\Specialty;
use App\Http\Requests\Specialty\SpecialtyStoreRequest;
use App\Http\Requests\Specialty\SpecialtyUpdateRequest;
use App\Http\Requests\Specialty\SpecialtyDoctorRequest;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $setting=$this->setting();
        $specialties=Specialty::orderBy('id', 'DESC')->get();
        return view('admin.specialties.index', compact('setting', 'specialties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $setting=$this->setting();
        return view('admin.specialties.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialtyStoreRequest $request) {
        $specialty=Specialty::create(['name' => request('name')]);
        if ($specialty) {
            return redirect()->route('specialties.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La especialidad ha sido registrada exitosamente.']);
        } else {
            return redirect()->route('specialties.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specialty\Specialty $specialty
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialty $specialty) {
        $setting=$this->setting();
        return view('admin.specialties.edit', compact('setting', 'specialty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialty\Specialty $specialty
     * @return \Illuminate\Http\Response
     */
    public function update(SpecialtyUpdateRequest $request, Specialty $specialty) {
        $specialty->fill(['name' => request('name')])->save();
        if ($specialty) {
            return redirect()->route('specialties.edit', ['specialty' => $specialty->slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La especialidad ha sido editada exitosamente.']);
        } else {
            return redirect()->route('specialties.edit', ['specialty' => $specialty->slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialty\Specialty $specialty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialty $specialty) {
        $specialty->delete();
        if ($specialty) {
            return redirect()->route('specialties.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'La especialidad ha sido eliminada exitosamente.']);
        } else {
            return redirect()->route('specialties.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, Specialty $specialty) {
        $specialty->fill(['state' => "0"])->save();
        if ($specialty) {
            return redirect()->route('specialties.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La especialidad ha sido desactivada exitosamente.']);
        } else {
            return redirect()->route('specialties.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, Specialty $specialty) {
        $specialty->fill(['state' => "1"])->save();
        if ($specialty) {
            return redirect()->route('specialties.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La especialidad ha sido activada exitosamente.']);
        } else {
            return redirect()->route('specialties.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function getSpecialties(SpecialtyDoctorRequest $request){
        $doctor=User::role(['Doctor'])->where('slug', request('doctor_id'))->first();
        if (!is_null($doctor)) {
            $specialties=$doctor->specialties()->where('state', '1')->get();
            return response()->json(['state' => true, 'data' => $specialties]);
        }
        return response()->json(['state' => false]);
    }
}
