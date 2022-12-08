<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medicine;
use App\Models\Location;
use App\Models\Appointment;
use App\Models\Document\Document;
use App\Models\Schedule\Schedule;
use Spatie\Permission\Models\Role;
use App\Models\Specialty\Specialty;
use App\Models\Specialty\SpecialtyUser;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $setting=$this->setting();
        $roles=Role::where([['name', '!=', 'Doctor'], ['name', '!=', 'Secretaria'], ['name', '!=', 'Paciente']])->get()->pluck('name');
        $users=User::role($roles)->count();
        $doctors=User::role(['Doctor'])->count();
        $secretaries=User::role(['Secretaria'])->count();
        $patients=User::role(['Paciente'])->count();
        if (Auth::user()->hasRole('Paciente')) {
            $appointments=Appointment::where('user_id', Auth::id())->count();
        } elseif (Auth::user()->hasRole('Doctor')) {
            $appointments=Appointment::where('doctor_id', Auth::id())->count();
        } else {
            $appointments=Appointment::count();
        }
        if (Auth::user()->hasRole('Doctor')) {
            $appointmentsYear=Appointment::whereYear('date', date('Y'))->where('doctor_id', Auth::id())->count();
            $appointmentsMonth=Appointment::whereMonth('date', date('m'))->where('doctor_id', Auth::id())->count();
            $appointmentsDay=Appointment::where([['date', date('Y-m-d')], ['doctor_id', Auth::id()]])->count();
        } else {
            $appointmentsYear=Appointment::whereYear('date', date('Y'))->count();
            $appointmentsMonth=Appointment::whereMonth('date', date('m'))->count();
            $appointmentsDay=Appointment::where('date', date('Y-m-d'))->count();
        }

        if (Auth::user()->hasRole('Paciente')) {
            $appointmentsAttend=Appointment::where([['state', '1'], ['user_id', Auth::id()]])->count();
        } else {
            $appointmentsAttend=Appointment::where('state', '1')->count();
        }
        if (Auth::user()->hasRole('Paciente')) {
            $appointmentsPending=Appointment::where([['state', '2'], ['user_id', Auth::id()]])->count();
        } else {
            $appointmentsPending=Appointment::where('state', '2')->count();
        }
        if (Auth::user()->hasRole('Paciente')) {
            $documents=Document::where('user_id', Auth::id())->count();
        } elseif (Auth::user()->hasRole('Doctor')) {
            $documents=Document::where('doctor_id', Auth::id())->count();
        } else {
            $documents=Document::count();
        }
        $specialties=Specialty::count();
        $medicines=Medicine::count();
        $schedules=Schedule::count();
        $locations=Location::count();
        return view('admin.home', compact('setting', 'users', 'doctors', 'secretaries', 'patients', 'appointments', 'appointmentsYear', 'appointmentsMonth', 'appointmentsDay', 'appointmentsAttend', 'appointmentsPending', 'documents', 'specialties', 'medicines', 'schedules', 'locations'));
    }

    public function profile() {
        $setting=$this->setting();
        return view('admin.profile', compact('setting'));
    }

    public function profileEdit() {
        $setting=$this->setting();
        $locations=Location::where('state', '1')->orderBy('name', 'ASC')->get();
        $specialties=Specialty::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.edit', compact('setting', 'locations', 'specialties'));
    }

    public function profileUpdate(ProfileUpdateRequest $request) {
        $user=User::where('slug', Auth::user()->slug)->firstOrFail();
        $location=Location::where('slug', request('location_id'))->firstOrFail();
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'address' => request('address'), 'gender' => request('gender'), 'location_id' => $location->id);

        if ($user->hasRole(['Paciente'])) {
            $data['dni']=request('dni');
            $data['birthday']=request('birthday');
            $data['weight']=request('weight');
        }

        if ($user->hasRole(['Doctor'])) {
            $data['designation']=request('designation');
            $data['about']=request('about');
            $data['education']=request('education');
        }

        if (!is_null(request('password'))) {
            $data['password']=Hash::make(request('password'));
        }

        $user->fill($data)->save();

        if ($user) {
            // Mover imagen a carpeta users y extraer nombre
            if ($request->hasFile('photo')) {
                $file=$request->file('photo');
                $photo=store_files($file, $user->slug, '/admins/img/users/');
                $user->fill(['photo' => $photo])->save();
                Auth::user()->photo=$photo;
            }

            if ($user->hasRole(['Doctor'])) {
                SpecialtyUser::where('user_id', $user->id)->delete();
                foreach (request('specialty_id') as $key => $value) {
                    $specialty=Specialty::where('slug', $value)->first();
                    if (!is_null($specialty)) {
                        $data=array('user_id' => $user->id, 'specialty_id' => $specialty->id);
                        SpecialtyUser::create($data);
                    }
                }
            }

            Auth::user()->slug=$user->slug;
            Auth::user()->name=request('name');
            Auth::user()->lastname=request('lastname');
            Auth::user()->phone=request('phone');
            Auth::user()->address=request('address');
            Auth::user()->gender=request('gender');
            Auth::user()->location_id=$location->id;
            if ($user->hasRole(['Paciente'])) {
                Auth::user()->dni=request('dni');
                Auth::user()->birthday=request('birthday');
                Auth::user()->weight=request('weight');
            }
            if ($user->hasRole(['Doctor'])) {
                Auth::user()->designation=request('designation');
                Auth::user()->about=request('about');
                Auth::user()->education=request('education');
                Auth::user()['specialties']=$user->specialties;
            }
            if (!is_null(request('password'))) {
                Auth::user()->password=Hash::make(request('password'));
            }
            return redirect()->route('profile.edit')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El perfil ha sido editado exitosamente.']);
        } else {
            return redirect()->route('profile.edit')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function emailVerifyAdmin(Request $request)
    {
        $count=User::where('email', request('email'))->count();
        if ($count>0) {
            return "false";
        } else {
            return "true";
        }
    }
}
