<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Http\Requests\Medicine\MedicineStoreRequest;
use App\Http\Requests\Medicine\MedicineUpdateRequest;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $setting=$this->setting();
        $medicines=Medicine::orderBy('id', 'DESC')->get();
        return view('admin.medicines.index', compact('setting', 'medicines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $setting=$this->setting();
        return view('admin.medicines.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicineStoreRequest $request) {
        $medicine=Medicine::create(['name' => request('name')]);
        if ($medicine) {
            return redirect()->route('medicines.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La medicina ha sido registrada exitosamente.']);
        } else {
            return redirect()->route('medicines.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medicine $medicine
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicine $medicine) {
        $setting=$this->setting();
        return view('admin.medicines.edit', compact('setting', 'medicine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medicine $medicine
     * @return \Illuminate\Http\Response
     */
    public function update(MedicineUpdateRequest $request, Medicine $medicine) {
        $medicine->fill(['name' => request('name')])->save();
        if ($medicine) {
            return redirect()->route('medicines.edit', ['medicine' => $medicine->slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La medicina ha sido editada exitosamente.']);
        } else {
            return redirect()->route('medicines.edit', ['medicine' => $medicine->slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medicine $medicine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicine $medicine) {
        $medicine->delete();
        if ($medicine) {
            return redirect()->route('medicines.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'La medicina ha sido eliminada exitosamente.']);
        } else {
            return redirect()->route('medicines.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, Medicine $medicine) {
        $medicine->fill(['state' => "0"])->save();
        if ($medicine) {
            return redirect()->route('medicines.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La medicina ha sido desactivada exitosamente.']);
        } else {
            return redirect()->route('medicines.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, Medicine $medicine) {
        $medicine->fill(['state' => "1"])->save();
        if ($medicine) {
            return redirect()->route('medicines.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La medicina ha sido activada exitosamente.']);
        } else {
            return redirect()->route('medicines.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
