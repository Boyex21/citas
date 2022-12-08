<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $faqs=Faq::all();
        return view('admin.faq', compact('faqs'));
    }


    public function create()
    {   $categories = FaqCategory::all();
        return view('admin.create_faq', compact('categories'));
    }


    public function store(Request $request)
    {
        $rules = [
            'question'=>'required',
            'answer'=>'required',
            'status'=>'required',
            'category'=>'required',
        ];
        $customMessages = [
            'question.required' => trans('admin_validation.Question is required'),
            'question.unique' => trans('admin_validation.Question already exist'),
            'answer.required' => trans('admin_validation.Answer is required'),
            'category.required' => trans('admin_validation.Category is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = $request->status;
        $faq->faq_category_id = $request->category;
        $faq->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.faq.index')->with($notification);
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        $categories = FaqCategory::all();
        return view('admin.edit_faq',compact('faq','categories'));
    }


    public function update(Request $request,$id)
    {
        $faq = Faq::find($id);
        $rules = [
            'question'=>'required',
            'answer'=>'required',
            'status'=>'required',
            'category'=>'required',
        ];
        $customMessages = [
            'question.required' => trans('admin_validation.Question is required'),
            'question.unique' => trans('admin_validation.Question already exist'),
            'answer.required' => trans('admin_validation.Answer is required'),
            'category.required' => trans('admin_validation.Category is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = $request->status;
        $faq->faq_category_id = $request->category;
        $faq->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.faq.index')->with($notification);
    }

    public function destroy($id)
    {
        $faq = Faq::find($id);
        $faq->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.faq.index')->with($notification);
    }

    public function changeStatus($id){
        $faq = Faq::find($id);
        if($faq->status==1){
            $faq->status=0;
            $faq->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $faq->status=1;
            $faq->save();
            $message= trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
