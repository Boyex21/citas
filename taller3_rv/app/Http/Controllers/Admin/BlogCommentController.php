<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Auth;
class BlogCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $blogComments = BlogComment::orderBy('id', 'desc')->get();
        return view('admin.blog_comment',compact('blogComments'));
    }

    public function destroy($id)
    {
        $blogComment = BlogComment::find($id);
        $blogComment->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.blog-comment.index')->with($notification);
    }

    public function changeStatus($id){
        $blogComment = BlogComment::find($id);
        if($blogComment->status == 1){
            $blogComment->status = 0;
            $blogComment->save();
            $message = trans('admin_validation.Inactive Successfully');
        }else{
            $blogComment->status = 1;
            $blogComment->save();
            $message = trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }
}
