<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Document\File;
use App\Models\Document\Document;
use App\Http\Requests\Document\DocumentStoreRequest;
use App\Http\Requests\Document\DocumentUpdateRequest;
use Illuminate\Http\Request;
use Auth;
use Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
    	$setting=$this->setting();
        if (Auth::user()->hasRole('Paciente')) {
            $documents=Document::with(['files'])->where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
        } elseif (Auth::user()->hasRole('Doctor')) {
            $documents=Document::with(['files'])->where('doctor_id', Auth::id())->orderBy('id', 'DESC')->get();
        } else {
            $documents=Document::with(['files'])->orderBy('id', 'DESC')->get();
        }
    	return view('admin.documents.index', compact('setting', 'documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
    	$setting=$this->setting();
        $doctors=Appointment::with(['doctor'])->where('user_id', Auth::id())->groupBy('doctor_id')->get()->pluck('doctor')->where('state', 'Activo');
    	return view('admin.documents.create', compact('setting', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentStoreRequest $request) {
        $doctor=User::role(['Doctor'])->where('slug', request('doctor_id'))->firstOrFail();
    	$data=array('description' => request('description'), 'user_id' => Auth::id(), 'doctor_id' => $doctor->id);
    	$document=Document::create($data);
    	if ($document) {
    		if ($request->has('files')) {
    			foreach (request('files') as $key => $value) {
    				File::create(['file' => $value, 'document_id' => $document->id])->save();
    			}
    		}

    		return redirect()->route('documents.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El documento ha sido registrado exitosamente.']);
    	} else {
    		return redirect()->route('documents.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document) {
        $setting=$this->setting();
        return view('admin.documents.show', compact('setting', 'document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document\Document $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document) {
    	$setting=$this->setting();
    	$doctors=Appointment::with(['doctor'])->where('user_id', Auth::id())->groupBy('doctor_id')->get()->pluck('doctor')->where('state', 'Activo');
    	return view('admin.documents.edit', compact('setting', 'document', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document\Document $document
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentUpdateRequest $request, Document $document) {
    	$doctor=User::role(['Doctor'])->where('slug', request('doctor_id'))->firstOrFail();
        $data=array('description' => request('description'), 'doctor_id' => $doctor->id);
    	$document->fill($data)->save();
    	if ($document) {
    		return redirect()->route('documents.edit', ['document' => $document->id])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El documento ha sido editado exitosamente.']);
    	} else {
    		return redirect()->route('documents.edit', ['document' => $document->id])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document\Document $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document) {
    	$document->delete();
    	if ($document) {
    		File::where('document_id', $document->id)->delete();
    		return redirect()->route('documents.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El documento ha sido eliminado exitosamente.']);
    	} else {
    		return redirect()->route('documents.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
    	}
    }

    public function storeFile(Request $request) {
    	if ($request->hasFile('file')) {
    		$file=$request->file('file');
    		$name=store_files($file, time().'_'.Str::slug($file->getClientOriginalName(), "-"), '/admins/img/documents/');
    		return response()->json(['status' => true, 'name' => $name]);
    	}

    	return response()->json(['status' => false]);
    }

    public function updateFile(Request $request) {
    	$document=Document::where('id', request('id'))->first();
    	if (!is_null($document)) {
    		if ($request->hasFile('file')) {
    			$file=$request->file('file');
    			$name=store_files($file, time().'_'.$document->id, '/admins/img/documents/');
    			$file=File::create(['document_id' => $document->id, 'file' => $name]);
    			if ($file) {
    				return response()->json(['status' => true, 'name' => $name, 'id' => $document->id]);
    			}
    		}
    	}

    	return response()->json(['status' => false]);
    }

    public function destroyFile(Request $request) {
    	$document=Document::where('id', request('id'))->first();
    	if (!is_null($document)) {
    		$file=File::where('document_id', $document->id)->where('file', request('url'))->first();
    		if (!is_null($file)) {
    			$file->delete();
    			if ($file) {
    				if (file_exists(public_path().'/admins/img/documents/'.request('url'))) {
    					unlink(public_path().'/admins/img/documents/'.request('url'));
    				}
    				return response()->json(['status' => true]);
    			}
    		}
    	}
    	return response()->json(['status' => false]);
    }
}
