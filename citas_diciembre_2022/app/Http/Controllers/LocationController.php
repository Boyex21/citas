<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\Location\LocationStoreRequest;
use App\Http\Requests\Location\LocationUpdateRequest;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $setting=$this->setting();
        $locations=Location::orderBy('id', 'DESC')->get();
        return view('admin.locations.index', compact('setting', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $setting=$this->setting();
        return view('admin.locations.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request) {
        $location=Location::create(['name' => request('name')]);
        if ($location) {
            return redirect()->route('locations.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La locación ha sido registrada exitosamente.']);
        } else {
            return redirect()->route('locations.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location) {
        $setting=$this->setting();
        return view('admin.locations.edit', compact('setting', 'location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function update(LocationUpdateRequest $request, Location $location) {
        $location->fill(['name' => request('name')])->save();
        if ($location) {
            return redirect()->route('locations.edit', ['location' => $location->slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La locación ha sido editada exitosamente.']);
        } else {
            return redirect()->route('locations.edit', ['location' => $location->slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location) {
        $location->delete();
        if ($location) {
            return redirect()->route('locations.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'La locación ha sido eliminada exitosamente.']);
        } else {
            return redirect()->route('locations.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, Location $location) {
        $location->fill(['state' => "0"])->save();
        if ($location) {
            return redirect()->route('locations.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La locación ha sido desactivada exitosamente.']);
        } else {
            return redirect()->route('locations.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, Location $location) {
        $location->fill(['state' => "1"])->save();
        if ($location) {
            return redirect()->route('locations.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La locación ha sido activada exitosamente.']);
        } else {
            return redirect()->route('locations.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
