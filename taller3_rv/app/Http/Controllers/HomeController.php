<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomePageOneVisibility;

use App\Models\Slider;
use App\Models\MaintainanceText;
use App\Models\Feature;
use App\Models\Location;
use App\Models\Department;
use App\Models\Service;
use App\Models\Achievement;
use App\Models\Testimonial;
use App\Models\Doctor;
use App\Models\BannerImage;
use App\Models\Blog;
use App\Models\AboutUs;
use App\Models\GoogleRecaptcha;
use App\Models\ContactPage;
use App\Models\Subscriber;
use App\Mail\SubscriptionVerification;
use App\Mail\ContactMessageInformation;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use App\Models\Setting;
use App\Models\ContactMessage;
use App\Models\PopularPost;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\FacebookComment;
use App\Models\FaqCategory;
use App\Models\Package;
use App\Models\ZoomCredential;
use App\Models\Order;
use App\Models\Leave;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Day;
use App\Models\Chamber;
use App\Models\BreadcrumbImage;
use App\Models\CustomPagination;
use App\Models\Faq;
use App\Models\CustomPage;
use App\Models\TermsAndCondition;
use App\Models\DoctorReview;
use App\Models\SeoSetting;
use App\Models\HomepageContent;
use App\Rules\Captcha;
use Mail;
use Str;
use Session;
use Carbon\Carbon;
use Route;
use Cache;
use File;
use Image;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $sections = HomePageOneVisibility::all();
        $sliderQty = $sections->where('id', 1)->first()->qty;
        $featureQty = $sections->where('id', 2)->first()->qty;
        $serviceQty = $sections->where('id', 3)->first()->qty;
        $achievementQty = $sections->where('id', 4)->first()->qty;
        $testimonialQty = $sections->where('id', 5)->first()->qty;
        $expertQty = $sections->where('id', 6)->first()->qty;
        $blogQty = $sections->where('id', 7)->first()->qty;

        $sliders = Slider::orderBy('serial','asc')->where(['status' => 1])->get()->take($sliderQty);
        $sliderContent = MaintainanceText::first();
        $features = Feature::where('status', 1)->get()->take($featureQty);
        $locations = Location::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        $services = Service::where('status',1)->get()->take($serviceQty);
        $achievements = Achievement::where('status', 1)->get()->take($achievementQty);
        $testimonials = Testimonial::where('status', 1)->get()->take($testimonialQty);
        $doctors = Doctor::where('status', 1)->where('profile_fillup', 1)->orderBy('name', 'asc')->get()->take($expertQty);
        $defaultProfile = BannerImage::whereId('15')->first();
        $blogs = Blog::with('admin','category','comments')->where(['show_homepage' => 1, 'status' => 1])->get()->take($blogQty);
        $seo = SeoSetting::find(1);
        $contents = HomepageContent::all();
        $menuDoctors = Doctor::where('status', 1)->where('profile_fillup', 1)->orderBy('name', 'asc')->get();


        return view('index', compact('sliders', 'sliderContent', 'features', 'locations', 'departments','services','achievements','testimonials','doctors','defaultProfile','blogs','seo','contents','sections','menuDoctors'));
    }

    public function aboutUs(){
        $aboutUs = AboutUs::first();
        $banner = BreadcrumbImage::where(['id' => 12])->first();
        $seo = SeoSetting::find(2);
        return view('about_us', compact('aboutUs','banner','seo'));
    }

    public function contactUs(){
        $contact = ContactPage::first();
        $recaptchaSetting = GoogleRecaptcha::first();
        $seo = SeoSetting::find(3);
        return view('contact_us', compact('contact','recaptchaSetting','seo'));
    }

    public function sendContactMessage(Request $request){
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'subject'=>'required',
            'massege'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'name.required' => trans('user_validation.name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'subject.required' => trans('user_validation.Subject is required'),
            'massege.required' => trans('user_validation.Message is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $setting = Setting::first();
        if($setting->enable_save_contact_message == 1){
            $contact = new ContactMessage();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->phone = $request->phone;
            $contact->message = $request->massege;
            $contact->save();
        }

        MailHelper::setMailConfig();
        $template = EmailTemplate::where('id',2)->first();
        $message = $template->description;
        $subject = $template->subject;
        $message = str_replace('{{name}}',$request->name,$message);
        $message = str_replace('{{email}}',$request->email,$message);
        $message = str_replace('{{phone}}',$request->phone,$message);
        $message = str_replace('{{subject}}',$request->subject,$message);
        $message = str_replace('{{message}}',$request->massege,$message);

        Mail::to($setting->contact_email)->send(new ContactMessageInformation($message,$subject));

        $notification = trans('user_validation.Message send successfully');
        return response()->json(['status' => 1, 'message' => $notification]);

    }

    public function blog(){
        $paginateQty = CustomPagination::whereId('1')->first()->qty;
        $blogs = Blog::with('category')->orderBy('id','desc')->where(['status' => 1])->paginate($paginateQty);
        $banner = BreadcrumbImage::where(['id' => 10])->first();
        $defaultProfile = BannerImage::whereId('15')->first();
        $setting = Setting::first();
        $seo = SeoSetting::find(6);
        return view('blog', compact('blogs','banner','defaultProfile','setting','seo'));
    }

    public function blogDetail($slug){
        $blog = Blog::with('comments','admin','category')->where(['status' => 1, 'slug'=>$slug])->first();
        $blog->views += 1;
        $blog->save();

        $popularPosts = PopularPost::where(['status' => 1])->get();
        $categories = BlogCategory::with('blogs')->where(['status' => 1])->get();
        $recaptchaSetting = GoogleRecaptcha::first();
        $banner = BreadcrumbImage::where(['id' => 10])->first();
        $facebookComment = FacebookComment::first();
        $setting = Setting::first();
        return view('blog_detail', compact('blog','popularPosts','categories','recaptchaSetting','banner','facebookComment'));
    }

    public function blogByCategory($slug){
        $paginateQty = CustomPagination::whereId('1')->first()->qty;
        $category = BlogCategory::where('slug',$slug)->first();
        $blogs = Blog::orderBy('id','desc')->where(['status' => 1, 'blog_category_id' => $category->id])->paginate($paginateQty);
        $banner = BreadcrumbImage::where(['id' => 10])->first();
        $seoSetting = SeoSetting::find(6);
        $defaultProfile = BannerImage::whereId('15')->first();
        $seo = SeoSetting::find(6);
        return view('blog', compact('blogs','banner','seoSetting','defaultProfile','seo'));
    }

    public function blogSearch(Request $request){
        $paginateQty = CustomPagination::whereId('1')->first()->qty;
        if($request->category){
            $category = BlogCategory::where('slug', $request->category)->first();
            $blogs = Blog::orderBy('id','desc')
                        ->where(['status' => 1])
                        ->where('blog_category_id', $category->id)
                        ->paginate($paginateQty);
        }else{
            $blogs = Blog::orderBy('id','desc')
                        ->where(['status' => 1])
                        ->where('title','LIKE','%'.$request->search.'%')
                        ->orWhere('description','LIKE','%'.$request->search.'%')
                        ->paginate($paginateQty);
        }

        $banner = BreadcrumbImage::where(['id' => 10])->first();
        $seoSetting = SeoSetting::find(6);
        $defaultProfile = BannerImage::whereId('15')->first();
        $setting = Setting::first();
        $seo = SeoSetting::find(6);
        $blogs = $blogs->appends($request->all());
        return view('blog', compact('blogs','banner','seoSetting','defaultProfile','setting','seo'));
    }

    public function blogComment(Request $request){
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'comment'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'name.required' => trans('user_validation.name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'comment.required' => trans('user_validation.Comment is required'),
        ];
        $this->validate($request, $rules,$customMessages);


        $comment = new BlogComment();
        $comment->blog_id = $request->blog_id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->save();

        $notification = trans('user_validation.Blog comment submited successfully');

        return response()->json(['status' => 1, 'message' => $notification]);
    }


    public function service(){
        $services = Service::where('status',1)->get();
        $banner = BreadcrumbImage::where(['id' => 13])->first();
        $seo = SeoSetting::find(4);
        return view('service', compact('services', 'banner','seo'));
    }


    public function serviceDetail($slug){
        $service = Service::with('faqs','galleries','galleries','videos')->where('slug', $slug)->first();
        $banner = BreadcrumbImage::where(['id' => 13])->first();
        $services = Service::where('status',1)->get();
        $contact = ContactPage::first();
        $recaptchaSetting = GoogleRecaptcha::first();
        return view('service_detail', compact('service', 'banner','services','contact','recaptchaSetting'));
    }

    public function faq(){
        $categories = FaqCategory::where('status', 1)->get();
        $banner = BreadcrumbImage::where(['id' => 4])->first();
        $seo = SeoSetting::find(9);
        return view('faq', compact('banner','categories','seo'));
    }

    public function customPage($slug){
        $page = CustomPage::where(['slug' => $slug, 'status' => 1])->first();
        return view('custom_page', compact('page'));
    }

    public function termsAndCondition(){
        $terms_conditions = TermsAndCondition::first();;
        return view('terms_and_conditions', compact('terms_conditions'));
    }

    public function privacyPolicy(){
        $privacyPolicy = TermsAndCondition::first();
        return view('privacy_policy', compact('privacyPolicy'));
    }

    public function subscribeRequest(Request $request){
        if($request->email != null){
            $isExist = Subscriber::where('email', $request->email)->count();
            if($isExist == 0){
                $subscriber = new Subscriber();
                $subscriber->email = $request->email;
                $subscriber->verified_token = Str::random(25);
                $subscriber->save();

                MailHelper::setMailConfig();

                $template = EmailTemplate::where('id',3)->first();
                $message = $template->description;
                $subject = $template->subject;
                Mail::to($subscriber->email)->send(new SubscriptionVerification($subscriber,$message,$subject));

                return response()->json(['status' => 1, 'message' => trans('user_validation.Subscription successfully, please verified your email')]);

            }else{
                return response()->json(['status' => 0, 'message' => trans('user_validation.Email already exist')]);
            }
        }else{
            return response()->json(['status' => 0, 'message' => trans('user_validation.Email Field is required')]);
        }
    }

    public function subscriberVerifcation($token){
        $subscriber = Subscriber::where('verified_token',$token)->first();
        if($subscriber){
            $subscriber->verified_token = null;
            $subscriber->is_verified = 1;
            $subscriber->save();
            $notification = trans('user_validation.Email verification successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('home')->with($notification);
        }else{
            $notification = trans('user_validation.Invalid token');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('home')->with($notification);
        }

    }

    public function testimonial(){
        $banner = BreadcrumbImage::where(['id' => 17])->first();
        $testimonials = Testimonial::where('status', 1)->get();
        $seo = SeoSetting::find(10);
        return view('testimonial', compact('banner', 'testimonials','seo'));
    }

    public function ourExpert(Request $request){
        $paginateQty = CustomPagination::whereId('1')->first()->qty;
        $banner = BreadcrumbImage::where(['id' => 16])->first();

        $experts = Doctor::orderBy('name', 'asc')->where('status', 1)->where('profile_fillup', 1);
        if($request->expert){
            $experts = $experts->where('slug', $request->expert);
        }

        if($request->location){
            $location = Location::where('slug', $request->location)->first();
            $experts = $experts->where('location_id', $location->id);
        }

        if($request->department){
            $department = Department::where('slug', $request->department)->first();
            $experts = $experts->where('department_id', $department->id);
        }

        $experts = $experts->paginate($paginateQty);
        $experts = $experts->appends($request->all());

        $defaultProfile = BannerImage::whereId('15')->first();
        $seo = SeoSetting::find(7);

        $locations = Location::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        $doctors = Doctor::where('status', 1)->where('profile_fillup', 1)->orderBy('name', 'asc')->get();

        return view('expert', compact('banner', 'experts','defaultProfile','seo','locations','departments','doctors'));
    }

    public function showExpert($slug){
        $banner = BreadcrumbImage::where(['id' => 16])->first();
        $expert = Doctor::where('status', 1)->with('videoGelleries','imageGelleries','socialLinks','schedules')->where('slug', $slug)->where('profile_fillup', 1)->first();
        $defaultProfile = BannerImage::whereId('15')->first();
        $setting = Setting::first();
        $credential = ZoomCredential::where('doctor_id',$expert->id)->first();
        $recaptchaSetting = GoogleRecaptcha::first();
        $comments = DoctorReview::where(['doctor_id' => $expert->id, 'status' => 1])->orderBy('id', 'desc')->paginate(10);
        $totalComments = DoctorReview::where(['doctor_id' => $expert->id, 'status' => 1])->orderBy('id', 'desc')->count();

        $activeOrder = Order::where('doctor_id', $expert->id)->where('status', 1)->first();

        $isShow = true;
        if ($activeOrder) {
            if($activeOrder->expired_date){
                if(date('Y-m-d') > $activeOrder->expired_date)  $isShow = false;
            }

        }else $isShow = false;

        if(!$isShow){
            $notification= trans('user_validation.Something Went Wrong');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('our-experts')->with($notification);
        }

        return view('expert_detail', compact('banner', 'expert','defaultProfile', 'setting', 'credential','recaptchaSetting','comments','totalComments','activeOrder'));
    }

    public function pricingPlan(){
        $banner = BreadcrumbImage::where(['id' => 16])->first();
        $packages = Package::where('status', 1)->get();
        $setting = Setting::first();
        $seo = SeoSetting::find(5);
        return view('pricing_plan', compact('banner','packages', 'setting','seo'));
    }

    public function getSchedule(Request $request){
        if($request->date){
            $doctor = Doctor::find($request->doctor_id);

            $activeOrder = Order::where('doctor_id', $doctor->id)->where('status', 1)->first();

            if(!$activeOrder){
                $notification = trans('user_validation.Something went wrong');
                return response()->json(['status' => 0, 'message' => $notification]);
            }

            $leave= Leave::where(['doctor_id' => $doctor->id,'date' => $request->date])->count();

            if($leave == 1){
                $response = "<option>".trans('user_validation.Select Schedule')."</option>";
                return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => 0]);
            }

            $todayAppointmentQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->count();

            if($activeOrder->daily_appointment_qty == -1){
                $day = date('l',strtotime($request->date));
                $day = Day::where('day',$day)->first();
                $schedules = Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id, 'status' => 1, 'chamber_id' => $request->chamber])->get();

                $response = "<option>".trans('user_validation.Select Schedule')."</option>";
                foreach($schedules as $index=> $schedule){
                    $checkQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
                    $exist = $schedule->appointment_limit - $checkQty;
                    $exist = $exist.' '.trans('user_validation.Seats');

                    $start_time = date('h:i A', strtotime($schedule->start_time));
                    $end_time = date('h:i A', strtotime($schedule->end_time));
                    $response.='<option value="'.$schedule->id.'">'.$start_time.'-'.$end_time. ' - ('. $exist .')' .'</option>';
                }
                $scheduleQty = $schedules->count();

                return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => $scheduleQty]);
            }else{
                if($todayAppointmentQty < $activeOrder->daily_appointment_qty){
                    $day = date('l',strtotime($request->date));
                    $day = Day::where('day',$day)->first();
                    $schedules = Schedule::where(['doctor_id' => $doctor->id, 'day_id' => $day->id, 'status' => 1, 'chamber_id' => $request->chamber])->get();

                    $response = "<option>".trans('user_validation.Select Schedule')."</option>";
                    foreach($schedules as $index=> $schedule){
                        $checkQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
                        $exist = $schedule->appointment_limit - $checkQty;
                        $exist = $exist.' '.trans('user_validation.Seats');

                        $start_time = date('h:i A', strtotime($schedule->start_time));
                        $end_time = date('h:i A', strtotime($schedule->end_time));
                        $response.='<option value="'.$schedule->id.'">'.$start_time.'-'.$end_time. ' - ('. $exist .')' .'</option>';
                    }
                    $scheduleQty = $schedules->count();

                    return response()->json(['status' => 1, 'schedules' => $response, 'scheduleQty' => $scheduleQty]);

                }else{
                    $notification = trans('user_validation.Today you can not make any appointment');
                    return response()->json(['status' => 0, 'message' => $notification]);
                }
            }
        }else{
            $notification = trans('user_validation.Date is required');
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }


    public function scheduleAvaibility(Request $request){
        if($request->schedule){
            $doctor = Doctor::find($request->doctor_id);
            $schedule = Schedule::find($request->schedule);
            $todayAppointmentQty = Appointment::where('doctor_id', $doctor->id)->where('date', $request->date)->where('schedule_id' , $schedule->id)->count();
            if($todayAppointmentQty < $schedule->appointment_limit){
                return response()->json(['status' => 1]);
            }else{
                $notification = trans('user_validation.Today you can not make any appointment under this schedule');
                return response()->json(['status' => 0, 'message' => $notification]);
            }
        }else{
            $notification = trans('user_validation.Schedule is required');
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }


    public function createAppointment(Request $request){
        $rules = [
            'consultation_type'=>'required',
            'chamber'=>'required',
            'doctor_id'=>'required',
            'date'=>'required',
            'schedule'=>'required',

        ];
        $customMessages = [
            'consultation_type.required' => trans('user_validation.Consultation type is required'),
            'chamber.required' => trans('user_validation.Chamber is required'),
            'doctor_id.required' => trans('user_validation.Doctor is required'),
            'date.required' => trans('user_validation.Date is required'),
            'schedule.required' => trans('user_validation.Schedule is required'),
        ];
        $this->validate($request, $rules,$customMessages);


        $schedule = Schedule::find($request->schedule);
        $doctor = Doctor::find($request->doctor_id);
        $department = Department::find($doctor->department_id);
        $chamber = Chamber::find($request->chamber);


        $data['id'] = rand(22,222);// it is mendetory
        $data['name'] = $doctor->name;
        $data['qty'] = 1;
        $data['price'] = $doctor->fee;
        $data['weight'] = 0; // it is mendetory
        $data['options']['doctor_id'] = $doctor->id;
        $data['options']['department'] = $department->name;
        $data['options']['location'] = $doctor->location->location;
        $data['options']['location_id'] = $doctor->location->id;
        $data['options']['chamber'] = $chamber->name;
        $data['options']['chamber_id'] = $chamber->id;
        $data['options']['date'] = $request->date;
        $start_time = date('h:i A', strtotime($schedule->start_time));
        $end_time = date('h:i A', strtotime($schedule->end_time));
        $data['options']['schedule'] = $start_time.'-'.$end_time;
        $data['options']['schedule_id'] = $schedule->id;
        $data['options']['day_id'] = $schedule->day_id;
        $data['options']['consultation_type'] = $request->consultation_type;

        Session::put('appointment', $data);
        $notification = trans('user_validation.Appointment created successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('payment')->with($notification);
    }


    public function storeReview(Request $request){
        $rules = [
            'rating'=>'required',
            'doctor_id'=>'required',
            'comment'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'rating.required' => trans('user_validation.Rating is required'),
            'doctor_id.required' => trans('user_validation.Doctor is required'),
            'comment.required' => trans('user_validation.Comment is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();

        $appointment = Appointment::where(['doctor_id' => $request->doctor_id, 'user_id' => $user->id])->count();
        if($appointment > 0){
            $isExist = DoctorReview::where(['doctor_id' => $request->doctor_id, 'user_id' => $user->id])->count();
            if($isExist == 0){
                $review = new DoctorReview();
                $review->user_id = $user->id;
                $review->doctor_id = $request->doctor_id;
                $review->rating = $request->rating;
                $review->comment = $request->comment;
                $review->save();

                $notification = trans('user_validation.Review submited successfully');
                $notification = array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->back()->with($notification);
            }else{
                $notification = trans('user_validation.Review already exist');
                $notification = array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }

        }else{
            $notification = trans('user_validation.Sorry. You can not make any review');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

    }


}
