<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqCategory;
class FaqCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $categories = FaqCategory::all();
        return view('admin.faq_category', compact('categories'));
    }


    public function create()
    {
        return view('admin.create_faq');
    }


    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:faq_categories',
            'status'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $category = new FaqCategory();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update(Request $request,$id)
    {
        $category = FaqCategory::find($id);
        $rules = [
            'name'=>'required|unique:faq_categories,name,'.$category->id,
            'status'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function destroy($id)
    {
        $category = FaqCategory::find($id);
        $category->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function changeStatus($id){
        $category = FaqCategory::find($id);
        if($category->status==1){
            $category->status=0;
            $category->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $category->status=1;
            $category->save();
            $message= trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
