<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\SettingUpdateRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit() {
        $setting=$this->setting();
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(SettingUpdateRequest $request) {
        $setting=$this->setting();
        $setting->fill(['name' => request('name'), 'enable_register' => request('enable_register')])->save();
        if ($setting) {
            // Mover imagen a carpeta settings y extraer nombre
            if ($request->hasFile('logo')) {
                $file=$request->file('logo');
                $logo=store_files($file, 'logo', '/admins/img/settings/');
                $setting->fill(['logo' => $logo])->save();
            }

            // Mover imagen a carpeta settings y extraer nombre
            if ($request->hasFile('favicon')) {
                $file=$request->file('favicon');
                $favicon=store_files($file, 'favicon', '/admins/img/settings/');
                $setting->fill(['favicon' => $favicon])->save();
            }

            return redirect()->route('settings.edit')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'Los ajustes han sido editados exitosamente.']);
        } else {
            return redirect()->route('settings.edit')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
