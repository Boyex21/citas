<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Setting;
use App\Models\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use Hash;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function documents(){
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        $documents=Document::with(['files'])->orderBy('id', 'DESC')->where('doctor_id', $doctor->id)->paginate(10);
        return view('doctor.documents', compact('setting', 'doctor', 'documents'));
    }

    public function showDocument($id){
        $setting=Setting::first();
        $doctor=Auth::guard('doctor')->user();
        $document=Document::with(['files'])->where('id', $id)->where('doctor_id', $doctor->id)->firstOrFail();
        return view('doctor.show_document', compact('setting', 'doctor', 'document'));
    }
}