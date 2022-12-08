<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Models\Schedule\Schedule;
use App\Models\Specialty\Specialty;
use App\Models\Schedule\ScheduleUser;
use App\Models\Specialty\SpecialtyUser;
use App\Http\Requests\Doctor\DoctorStoreRequest;
use App\Http\Requests\Doctor\DoctorUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailRegister;
use Auth;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $setting=$this->setting();
        $schedules=Schedule::where('state', '1')->orderBy('day', 'ASC')->get();
        $users=User::with(['roles'])->role(['Doctor'])->orderBy('id', 'DESC')->get();
        return view('admin.doctors.index', compact('setting', 'users', 'schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $setting=$this->setting();
        $locations=Location::where('state', '1')->orderBy('name', 'ASC')->get();
        $specialties=Specialty::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.doctors.create', compact('setting', 'locations', 'specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorStoreRequest $request) {
        $location=Location::where('slug', request('location_id'))->firstOrFail();
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'email' => request('email'), 'address' => request('address'), 'gender' => request('gender'), 'designation' => request('designation'), 'about' => request('about'), 'education' => request('education'), 'password' => Hash::make(request('password')), 'location_id' => $location->id);
        $user=User::create($data);

        if ($user) {
            $user->assignRole('Doctor');

            foreach (request('specialty_id') as $key => $value) {
                $specialty=Specialty::where('slug', $value)->first();
                if (!is_null($specialty)) {
                    $data=array('user_id' => $user->id, 'specialty_id' => $specialty->id);
                    SpecialtyUser::create($data);
                }
            }

            // Mover imagen a carpeta users y extraer nombre
            if ($request->hasFile('photo')) {
                $file=$request->file('photo');
                $photo=store_files($file, $user->slug, '/admins/img/users/');
                $user->fill(['photo' => $photo])->save();
            }

            SendEmailRegister::dispatch($user->slug);
            return redirect()->route('doctors.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El doctor ha sido registrado exitosamente.']);
        } else {
            return redirect()->route('doctors.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
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
        return view('admin.doctors.show', compact('setting', 'user'));
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
        $specialties=Specialty::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.doctors.edit', compact('setting', 'user', 'locations', 'specialties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorUpdateRequest $request, User $user) {
        $location=Location::where('slug', request('location_id'))->firstOrFail();
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'address' => request('address'), 'gender' => request('gender'), 'designation' => request('designation'), 'about' => request('about'), 'education' => request('education'), 'state' => request('state'), 'location_id' => $location->id);
        $user->fill($data)->save();        

        if ($user) {
            $user->syncRoles(['Doctor']);

            SpecialtyUser::where('user_id', $user->id)->delete();
            foreach (request('specialty_id') as $key => $value) {
                $specialty=Specialty::where('slug', $value)->first();
                if (!is_null($specialty)) {
                    $data=array('user_id' => $user->id, 'specialty_id' => $specialty->id);
                    SpecialtyUser::create($data);
                }
            }

            // Mover imagen a carpeta users y extraer nombre
            if ($request->hasFile('photo')) {
                $file=$request->file('photo');
                $photo=store_files($file, $user->slug, '/admins/img/users/');
                $user->fill(['photo' => $photo])->save();
            }

            return redirect()->route('doctors.edit', ['user' => $user->slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El doctor ha sido editado exitosamente.']);
        } else {
            return redirect()->route('doctors.edit', ['user' => $user->slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
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
            return redirect()->route('doctors.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El doctor ha sido eliminado exitosamente.']);
        } else {
            return redirect()->route('doctors.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, User $user) {
        $user->fill(['state' => "0"])->save();
        if ($user) {
            return redirect()->route('doctors.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El doctor ha sido desactivado exitosamente.']);
        } else {
            return redirect()->route('doctors.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, User $user) {
        $user->fill(['state' => "1"])->save();
        if ($user) {
            return redirect()->route('doctors.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El doctor ha sido activado exitosamente.']);
        } else {
            return redirect()->route('doctors.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function schedules(Request $request, User $user) {
        $schedules=false;
        ScheduleUser::where('user_id', $user->id)->delete();
        foreach (request('schedule_id') as $key => $value) {
            $schedule=Schedule::where('id', $value)->first();
            if (!is_null($schedule)) {
                $schedule_user=ScheduleUser::create(['user_id' => $user->id, 'schedule_id' => $schedule->id]);
                if ($schedule_user) {
                    $schedules=true;
                } else {
                    $schedules=true;
                }
            }
        }

        if ($schedules) {
            return redirect()->route('doctors.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'Los horarios del doctor han sido agregados exitosamente.']);
        } else {
            return redirect()->route('doctors.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
