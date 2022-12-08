<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Category;
use App\Models\CustomPage;
use App\Models\EmailConfiguration;
use App\Models\EmailTemplate;
use App\Models\PopularPost;
use App\Models\Service;
use App\Models\TermsAndCondition;
use App\Models\User;
use App\Models\Setting;
use App\Models\CookieConsent;
use App\Models\GoogleRecaptcha;
use App\Models\FacebookComment;
use App\Models\TawkChat;
use App\Models\GoogleAnalytic;
use App\Models\CustomPagination;
use App\Models\FacebookPixel;
use App\Models\About;
use App\Models\Currency;
use App\Models\AboutUs;
use App\Models\City;
use App\Models\ContactPage;
use App\Models\Country;
use App\Models\CountryState;
use App\Models\Faq;
use App\Models\FooterSocialLink;
use App\Models\Order;
use App\Models\ContactMessage;
use App\Models\Slider;
use App\Models\Subscriber;
use App\Models\Admin;
use App\Models\PusherCredentail;;
use App\Models\Achievement;
use App\Models\Process;
use App\Models\Servicevideo;
use App\Models\ServiceFaq;
use App\Models\ServiceImageGallery;
use App\Models\Team;
use App\Models\Testimonial;





use Image;
use File;
use Artisan;
use Validator;
use Str;
use Cache;

use App\Models\Appointment;
use App\Models\AppointmentOrder;
use App\Models\Chamber;
use App\Models\Department;
use App\Models\Doctor;

use App\Models\DoctorReview;
// use App\Models\DoctorPaypal;
// use App\Models\DoctorStripe;
// use App\Models\DoctorRazorpay;
// use App\Models\DoctorFlutterwave;
// use App\Models\DoctorBankPayment;
// use App\Models\DoctorMollie;
// use App\Models\DoctorPaystack;
// use App\Models\DoctorInstamojo;
use App\Models\DoctorSocialLink;
// use App\Models\FaqCategory;
use App\Models\ImageGallery;
use App\Models\Leave;
use App\Models\Location;
use App\Models\Medicine;
// use App\Models\MeetingHistory;
// use App\Models\Package;
use App\Models\PrescriptionMedicine;
use App\Models\Schedule;
use App\Models\Staff;
use App\Models\VideoGallery;
// use App\Models\ZoomCredential;
// use App\Models\ZoomMeeting;
// use App\Models\Feature;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $setting = Setting::first();
        $customPaginations = CustomPagination::all();
        $pusher = PusherCredentail::first();
        $currencies = Currency::orderBy('name','asc')->get();
        return view('admin.setting',compact('setting', 'customPaginations', 'currencies', 'pusher'));
    }

    public function updateThemeColor(Request $request){
        $setting = Setting::first();
        $setting->theme_one = $request->theme_one;
        $setting->theme_two = $request->theme_two;
        $setting->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateCustomPagination(Request $request){

        foreach($request->quantities as $index => $quantity){
            if($request->quantities[$index]==''){
                $notification=array(
                    'messege'=> trans('admin_validation.Every field is required'),
                    'alert-type'=>'error'
                );

                return redirect()->back()->with($notification);
            }

            $customPagination=CustomPagination::find($request->ids[$index]);
            $customPagination->qty=$request->quantities[$index];
            $customPagination->save();
        }

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function updateGeneralSetting(Request $request){
        $rules = [
            'user_register' => 'required',
            'blog_comment' => 'required',
            'layout' => 'required',
            'lg_header' => 'required',
            'sm_header' => 'required',
            'contact_email' => 'required',
            'currency_name' => 'required',
            'currency_icon' => 'required',
            'timezone' => 'required',
        ];
        $customMessages = [
            'user_register.required' => trans('admin_validation.User register is required'),
            'blog_comment.required' => trans('admin_validation.Blog comment is required'),
            'layout.required' => trans('admin_validation.Layout is required'),
            'lg_header.required' => trans('admin_validation.Sidebar large header is required'),
            'sm_header.required' => trans('admin_validation.Sidebar small header is required'),
            'contact_email.required' => trans('admin_validation.Contact email is required'),
            'currency_name.required' => trans('admin_validation.Currency name is required'),
            'currency_icon.required' => trans('admin_validation.Currency icon is required'),
            'timezone.required' => trans('admin_validation.Timezone is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $setting = Setting::first();
        $setting->enable_user_register = $request->user_register;
        $setting->blog_comment = $request->blog_comment;
        $setting->text_direction = $request->layout;
        $setting->sidebar_lg_header = $request->lg_header;
        $setting->sidebar_sm_header = $request->sm_header;
        $setting->contact_email = $request->contact_email;
        $setting->currency_name = $request->currency_name;
        $setting->currency_icon = $request->currency_icon;
        $setting->timezone = $request->timezone;
        $setting->save();

        $currencySetting = Setting::first();
        Cache::put('currencySetting', $currencySetting);
        Cache::put('setting', $currencySetting);

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateCookieConset(Request $request){
        $rules = [
            'allow' => 'required',
            'border' => 'required',
            'corners' => 'required',
            'background_color' => 'required',
            'text_color' => 'required',
            'border_color' => 'required',
            'button_color' => 'required',
            'btn_text_color' => 'required',
            'link_text' => 'required',
            'btn_text' => 'required',
            'message' => 'required',
        ];
        $customMessages = [
            'allow.required' => trans('admin_validation.Allow is required'),
            'border.required' => trans('admin_validation.Border is required'),
            'corners.required' => trans('admin_validation.Corner is required'),
            'background_color.required' => trans('admin_validation.Background color is required'),
            'text_color.required' => trans('admin_validation.Text color is required'),
            'border_color.required' => trans('admin_validation.Border Color is required'),
            'button_color.required' => trans('admin_validation.Button color is required'),
            'btn_text_color.required' => trans('admin_validation.Button text color is required'),
            'link_text.required' => trans('admin_validation.Link text is required'),
            'btn_text.required' => trans('admin_validation.Button text is required'),
            'message.required' => trans('admin_validation.Message is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $cookieConsent = CookieConsent::first();
        $cookieConsent->status = $request->allow;
        $cookieConsent->border = $request->border;
        $cookieConsent->corners = $request->corners;
        $cookieConsent->background_color = $request->background_color;
        $cookieConsent->text_color = $request->text_color;
        $cookieConsent->border_color = $request->border_color;
        $cookieConsent->btn_bg_color = $request->button_color;
        $cookieConsent->btn_text_color = $request->btn_text_color;
        $cookieConsent->link_text = $request->link_text;
        $cookieConsent->btn_text = $request->btn_text;
        $cookieConsent->message = $request->message;
        $cookieConsent->save();

        $cookie_consent = CookieConsent::first();
        Cache::put('cookie_consent', $cookie_consent);

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateFacebookComment(Request $request){
        $rules = [
            'comment_type' => 'required',
            'app_id' => $request->comment_type == 0 ?  'required' : ''
        ];
        $customMessages = [
            'app_id.required' => trans('admin_validation.App id is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $facebookComment = FacebookComment::first();
        $facebookComment->comment_type = $request->comment_type;
        $facebookComment->app_id = $request->app_id;
        $facebookComment->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateTawkChat(Request $request){
        $rules = [
            'allow' => 'required',
            'chat_link' => $request->allow == 1 ?  'required' : ''
        ];
        $customMessages = [
            'allow.required' => trans('admin_validation.Allow is required'),
            'chat_link.required' => trans('admin_validation.Chat link is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $tawkChat = TawkChat::first();
        $tawkChat->status = $request->allow;
        $tawkChat->chat_link = $request->chat_link;
        $tawkChat->save();

        $tawk_setting = TawkChat::first();
        Cache::put('tawk_setting', $tawk_setting);

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updateGoogleAnalytic(Request $request){
        $rules = [
            'allow' => 'required',
            'analytic_id' => $request->allow == 1 ?  'required' : ''
        ];
        $customMessages = [
            'allow.required' => trans('admin_validation.Allow is required'),
            'analytic_id.required' => trans('admin_validation.Analytic id is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $googleAnalytic = GoogleAnalytic::first();
        $googleAnalytic->status = $request->allow;
        $googleAnalytic->analytic_id = $request->analytic_id;
        $googleAnalytic->save();

        $googleAnalytic = GoogleAnalytic::first();
        Cache::put('googleAnalytic', $googleAnalytic);


        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function updateGoogleRecaptcha(Request $request){

        $rules = [
            'site_key' => $request->allow == 1 ?  'required' : '',
            'secret_key' => $request->allow == 1 ?  'required' : '',
            'allow' => 'required',
        ];
        $customMessages = [
            'site_key.required' => trans('admin_validation.Site key is required'),
            'secret_key.required' => trans('admin_validation.Secret key is required'),
            'allow.required' => trans('admin_validation.Allow is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $googleRecaptcha = GoogleRecaptcha::first();
        $googleRecaptcha->status = $request->allow;
        $googleRecaptcha->site_key = $request->site_key;
        $googleRecaptcha->secret_key = $request->secret_key;
        $googleRecaptcha->save();

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function updateLogoFavicon(Request $request){

        $setting = Setting::first();
        if($request->logo){
            $old_logo=$setting->logo;
            $image=$request->logo;
            $ext=$image->getClientOriginalExtension();
            $logo_name= Str::slug($request->logo_name).'.'.$ext;
            $logo_name='uploads/website-images/'.$logo_name;

            if(File::exists(public_path().'/'.$logo_name)){
                if($old_logo == $logo_name){
                    $logo=Image::make($image)
                            ->save(public_path().'/'.$logo_name);
                    $setting->logo=$logo_name;
                    $setting->logo_alt = $request->logo_name;
                    $setting->save();
                }else{
                    $notification = trans('admin_validation.Logo Name already exist');
                    $notification = array('messege'=>$notification,'alert-type'=>'error');
                    return redirect()->back()->with($notification);
                }
            }else{
                $logo=Image::make($image)
                        ->save(public_path().'/'.$logo_name);
                $setting->logo=$logo_name;
                $setting->logo_alt = $request->logo_name;
                $setting->save();
                if($old_logo){
                    if(File::exists(public_path().'/'.$old_logo))unlink(public_path().'/'.$old_logo);
                }
            }
        }

        if($request->footer_logo){
            $old_logo=$setting->footer_logo;
            $image=$request->footer_logo;
            $ext=$image->getClientOriginalExtension();
            $logo_name= Str::slug($request->footer_logo_name).'.'.$ext;
            $logo_name='uploads/website-images/'.$logo_name;

            if(File::exists(public_path().'/'.$logo_name)){
                if($old_logo == $logo_name){
                    $logo=Image::make($image)
                            ->save(public_path().'/'.$logo_name);
                    $setting->footer_logo=$logo_name;
                    $setting->footer_logo_alt = $request->footer_logo_name;
                    $setting->save();
                }else{
                    $notification = trans('admin_validation.Logo Name already exist');
                    $notification = array('messege'=>$notification,'alert-type'=>'error');
                    return redirect()->back()->with($notification);
                }
            }else{
                $logo=Image::make($image)
                            ->save(public_path().'/'.$logo_name);
                $setting->footer_logo=$logo_name;
                $setting->footer_logo_alt = $request->footer_logo_name;
                $setting->save();
                if($old_logo){
                    if(File::exists(public_path().'/'.$old_logo))unlink(public_path().'/'.$old_logo);
                }
            }
        }


        if($request->favicon){
            $old_logo=$setting->favicon;
            $image=$request->favicon;
            $ext=$image->getClientOriginalExtension();
            $logo_name= Str::slug($request->favicon_name).'.'.$ext;
            $logo_name='uploads/website-images/'.$logo_name;

            if(File::exists(public_path().'/'.$logo_name)){
                if($old_logo == $logo_name){
                    $logo=Image::make($image)
                            ->save(public_path().'/'.$logo_name);
                    $setting->favicon=$logo_name;
                    $setting->favicon_alt = $request->favicon_name;
                    $setting->save();
                }else{
                    $notification = trans('admin_validation.Favicon name already exist');
                    $notification = array('messege'=>$notification,'alert-type'=>'error');
                    return redirect()->back()->with($notification);
                }
            }else{
                $logo=Image::make($image)
                            ->save(public_path().'/'.$logo_name);
                $setting->favicon=$logo_name;
                $setting->favicon_alt = $request->favicon_name;
                $setting->save();
                if($old_logo){
                    if(File::exists(public_path().'/'.$old_logo))unlink(public_path().'/'.$old_logo);
                }
            }
        }

        $setting->logo_alt = $request->logo_name;
        $setting->footer_logo_alt = $request->footer_logo_name;
        $setting->favicon_alt = $request->favicon_name;

        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function showClearDatabasePage(){
        return view('admin.clear_database');
    }


    public function updateFacebookPixel(Request $request){

        $rules = [
            'app_id' => $request->allow_facebook_pixel ?  'required' : '',
        ];
        $customMessages = [
            'app_id.required' => trans('admin_validation.App id is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $facebookPixel = FacebookPixel::first();
        $facebookPixel->app_id = $request->app_id;
        $facebookPixel->status = $request->allow_facebook_pixel ? 1 : 0;
        $facebookPixel->save();

        $facebookPixel = FacebookPixel::first();
        Cache::put('facebookPixel', $facebookPixel);


        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function updatePusher(Request $request){
        $rules = [
            'app_id' => 'required',
            'app_key' => 'required',
            'app_secret' => 'required',
            'app_cluster' => 'required',
        ];
        $customMessages = [
            'app_id.required' => trans('admin_validation.App id is required'),
            'app_key.required' => trans('admin_validation.App key is required'),
            'app_secret.required' => trans('admin_validation.App secret is required'),
            'app_cluster.required' => trans('admin_validation.App cluster is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $pusher = PusherCredentail::first();
        $pusher->app_id = $request->app_id;
        $pusher->app_key = $request->app_key;
        $pusher->app_secret = $request->app_secret;
        $pusher->app_cluster = $request->app_cluster;
        $pusher->save();

        Artisan::call("env:set PUSHER_APP_ID='". $request->app_id ."'");
        Artisan::call("env:set PUSHER_APP_KEY='". $request->app_key ."'");
        Artisan::call("env:set PUSHER_APP_SECRET='". $request->app_secret ."'");
        Artisan::call("env:set PUSHER_APP_CLUSTER='". $request->app_cluster ."'");


        $notification = trans('admin_validation.Update Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
