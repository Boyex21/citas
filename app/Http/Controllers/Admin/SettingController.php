<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use File;
use Str;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $setting=Setting::first();
        return view('admin.setting',compact('setting'));
    }

    public function updateGeneralSetting(Request $request){
        $rules=[
            'user_register' => 'required',
            'lg_header' => 'required',
            'sm_header' => 'required',
            'contact_email' => 'required'
        ];
        $this->validate($request, $rules);

        $setting=Setting::first();
        $setting->enable_user_register=$request->user_register;
        $setting->sidebar_lg_header=$request->lg_header;
        $setting->sidebar_sm_header=$request->sm_header;
        $setting->contact_email=$request->contact_email;
        $setting->save();

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function updateLogoFavicon(Request $request){
        $setting=Setting::first();
        if($request->logo){
            $old_logo=$setting->logo;
            $image=$request->logo;
            $ext=$image->getClientOriginalExtension();
            $logo_name= Str::slug($request->logo_name).'.'.$ext;
            $logo_name='uploads/website-images/'.$logo_name;

            if(File::exists(public_path().'/'.$logo_name)){
                if($old_logo==$logo_name){
                    $logo=Image::make($image)->save(public_path().'/'.$logo_name);
                    $setting->logo=$logo_name;
                    $setting->logo_alt=$request->logo_name;
                    $setting->save();
                }else{
                    $notification='El nombre del logotipo ya existe';
                    $notification=array('messege' => $notification, 'alert-type' => 'error');
                    return redirect()->back()->with($notification);
                }
            }else{
                $logo=Image::make($image)->save(public_path().'/'.$logo_name);
                $setting->logo=$logo_name;
                $setting->logo_alt=$request->logo_name;
                $setting->save();
                if($old_logo){
                    if(File::exists(public_path().'/'.$old_logo)) {
                        unlink(public_path().'/'.$old_logo);
                    }
                }
            }
        }

        if($request->favicon){
            $old_logo=$setting->favicon;
            $image=$request->favicon;
            $ext=$image->getClientOriginalExtension();
            $logo_name=Str::slug($request->favicon_name).'.'.$ext;
            $logo_name='uploads/website-images/'.$logo_name;

            if(File::exists(public_path().'/'.$logo_name)){
                if($old_logo==$logo_name){
                    $logo=Image::make($image)->save(public_path().'/'.$logo_name);
                    $setting->favicon=$logo_name;
                    $setting->favicon_alt=$request->favicon_name;
                    $setting->save();
                }else{
                    $notification='El nombre de Favicon ya existe';
                    $notification=array('messege' => $notification, 'alert-type' => 'error');
                    return redirect()->back()->with($notification);
                }
            }else{
                $logo=Image::make($image)->save(public_path().'/'.$logo_name);
                $setting->favicon=$logo_name;
                $setting->favicon_alt=$request->favicon_name;
                $setting->save();
                if($old_logo){
                    if(File::exists(public_path().'/'.$old_logo)){
                        unlink(public_path().'/'.$old_logo);
                    }
                }
            }
        }

        $setting->logo_alt=$request->logo_name;
        $setting->favicon_alt=$request->favicon_name;

        $notification='Edición Exitosa';
        $notification=array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
