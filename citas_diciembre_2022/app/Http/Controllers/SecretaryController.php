<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Http\Requests\Secretary\SecretaryStoreRequest;
use App\Http\Requests\Secretary\SecretaryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailRegister;
use Auth;

class SecretaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $setting=$this->setting();
        $users=User::with(['roles'])->role(['Secretaria'])->orderBy('id', 'DESC')->get();
        return view('admin.secretaries.index', compact('setting', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $setting=$this->setting();
        $locations=Location::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.secretaries.create', compact('setting', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SecretaryStoreRequest $request) {
        $location=Location::where('slug', request('location_id'))->firstOrFail();
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'email' => request('email'), 'address' => request('address'), 'password' => Hash::make(request('password')), 'location_id' => $location->id);
        $user=User::create($data);

        if ($user) {
            $user->assignRole('Secretaria');

            // Mover imagen a carpeta users y extraer nombre
            if ($request->hasFile('photo')) {
                $file=$request->file('photo');
                $photo=store_files($file, $user->slug, '/admins/img/users/');
                $user->fill(['photo' => $photo])->save();
            }

            SendEmailRegister::dispatch($user->slug);
            return redirect()->route('secretaries.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La secretaria ha sido registrada exitosamente.']);
        } else {
            return redirect()->route('secretaries.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        $setting=$this->setting();
        return view('admin.secretaries.show', compact('setting', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        if (Auth::user()->id==$user->id) {
            return redirect()->route('profile.edit');
        }
        $setting=$this->setting();
        $locations=Location::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.secretaries.edit', compact('setting', 'user', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SecretaryUpdateRequest $request, User $user) {
        $location=Location::where('slug', request('location_id'))->firstOrFail();
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'address' => request('address'), 'state' => request('state'), 'location_id' => $location->id);
        $user->fill($data)->save();        

        if ($user) {
            $user->syncRoles(['Secretaria']);

            // Mover imagen a carpeta users y extraer nombre
            if ($request->hasFile('photo')) {
                $file=$request->file('photo');
                $photo=store_files($file, $user->slug, '/admins/img/users/');
                $user->fill(['photo' => $photo])->save();
            }

            return redirect()->route('secretaries.edit', ['user' => $user->slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La secretaria ha sido editada exitosamente.']);
        } else {
            return redirect()->route('secretaries.edit', ['user' => $user->slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        if ($user) {
            return redirect()->route('secretaries.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'La secretaria ha sido eliminada exitosamente.']);
        } else {
            return redirect()->route('secretaries.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, User $user) {
        $user->fill(['state' => "0"])->save();
        if ($user) {
            return redirect()->route('secretaries.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La secretaria ha sido desactivada exitosamente.']);
        } else {
            return redirect()->route('secretaries.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, User $user) {
        $user->fill(['state' => "1"])->save();
        if ($user) {
            return redirect()->route('secretaries.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La secretaria ha sido activada exitosamente.']);
        } else {
            return redirect()->route('secretaries.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
