<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannerImage;
use App\Models\PopularCategory;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\ThreeColumnCategory;
use Image;
use File;
class HomePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){

        $popularCategory = PopularCategory::first();
        $categories = Category::whereStatus('1')->orderBy('name','asc')->get();
        $subCategories = SubCategory::whereStatus('1')->orderBy('name','asc')->get();
        $childCategories = ChildCategory::whereStatus('1')->orderBy('name','asc')->get();

        $threeColumnCategory = ThreeColumnCategory::first();

        return view('admin.home_page_banner', compact('popularCategory','categories','subCategories','childCategories','threeColumnCategory'));
    }

}
