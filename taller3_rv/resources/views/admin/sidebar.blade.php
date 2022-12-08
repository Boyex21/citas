@php
    $setting = App\Models\Setting::first();
@endphp


<div class="main-sidebar">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">{{ $setting->sidebar_lg_header }}</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('admin.dashboard') }}">{{ $setting->sidebar_sm_header }}</a>
      </div>
      <ul class="sidebar-menu">
          <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>{{__('admin.Dashboard')}}</span></a></li>


          <li class="{{ Route::is('admin.order') || Route::is('admin.order-show') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.order') }}"><i class="fas fa-shopping-cart"></i> <span>{{__('admin.Orders')}}</span></a></li>

          <li class="nav-item dropdown {{ Route::is('admin.day.*') || Route::is('admin.medicine.*') || Route::is('admin.appointment') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fa fa-stethoscope"></i><span>{{__('admin.Appointments')}}</span></a>

            <ul class="dropdown-menu">

                <li class="{{ Route::is('admin.appointment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.appointment') }}">{{__('admin.Appointment')}}</a></li>

                <li class="{{ Route::is('admin.day.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.day.index') }}">{{__('admin.Day')}}</a></li>

                <li class="{{ Route::is('admin.medicine.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.medicine.index') }}">{{__('admin.Medicine')}}</a></li>


            </ul>
          </li>


          <li class="{{ Route::is('admin.pricing-plan.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pricing-plan.index') }}"><i class="fa fa-cube"></i> <span>{{__('admin.Pricing Plan')}}</span></a></li>

          <li class="{{ Route::is('admin.payment-method') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.payment-method') }}"><i class="fas fa-ad"></i> <span>{{__('admin.Payment Method')}}</span></a></li>

          <li class="nav-item dropdown {{ Route::is('admin.doctor') || Route::is('admin.show-doctor') || Route::is('admin.staff') || Route::is('admin.chamber') || Route::is('admin.review') || Route::is('admin.department.*') || Route::is('admin.location.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>{{__('admin.Manage Doctors')}}</span></a>

            <ul class="dropdown-menu">
                <li class="{{ Route::is('admin.doctor') || Route::is('admin.show-doctor') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.doctor') }}">{{__('admin.Doctors')}}</a></li>

                <li class="{{ Route::is('admin.department.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.department.index') }}">{{__('admin.Department')}}</a></li>

                <li class="{{ Route::is('admin.location.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.location.index') }}">{{__('admin.Location')}}</a></li>

                <li class="{{ Route::is('admin.staff') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.staff') }}">{{__('admin.Staff')}}</a></li>

                <li class="{{ Route::is('admin.chamber') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.chamber') }}">{{__('admin.Chamber')}}</a></li>

                <li class="{{ Route::is('admin.review') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.review') }}">{{__('admin.Reviews')}}</a></li>


            </ul>
          </li>


          <li class="nav-item dropdown {{  Route::is('admin.customer-list') || Route::is('admin.customer-show') || Route::is('admin.pending-customer-list') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>{{__('admin.Users')}}</span></a>
            <ul class="dropdown-menu">
                <li class="{{ Route::is('admin.customer-list') || Route::is('admin.customer-show') || Route::is('admin.send-email-to-all-customer') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.customer-list') }}">{{__('admin.User List')}}</a></li>

                <li class="{{ Route::is('admin.pending-customer-list') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.pending-customer-list') }}">{{__('admin.Pending Users')}}</a></li>

            </ul>
          </li>


          <li class="nav-item dropdown {{ Route::is('admin.feature.*') || Route::is('admin.slider.*') || Route::is('admin.achievement.*') || Route::is('admin.about-us-section.*') || Route::is('admin.our-partner.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i><span>{{__('admin.All Sections')}}</span></a>

            <ul class="dropdown-menu">

                <li class="{{ Route::is('admin.feature.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.feature.index') }}">{{__('admin.Feature')}}</a></li>

                <li class="{{ Route::is('admin.slider.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.slider.index') }}">{{__('admin.Slider')}}</a></li>

                <li class="{{ Route::is('admin.achievement.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.achievement.index') }}">{{__('admin.Achievement')}}</a></li>

                <li class="{{ Route::is('admin.our-partner.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.our-partner.index') }}">{{__('admin.Our Partner')}}</a></li>
            </ul>
          </li>



          <li class="nav-item dropdown {{ Route::is('admin.about-us.*') || Route::is('admin.custom-page.*') || Route::is('admin.terms-and-condition.*') || Route::is('admin.privacy-policy.*') || Route::is('admin.faq.*') || Route::is('admin.faq-category.*') || Route::is('admin.error-page.*') || Route::is('admin.contact-us.*') || Route::is('admin.login-page') || Route::is('admin.service.*') || Route::is('admin.testimonial.*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i><span>{{__('admin.Pages')}}</span></a>

            <ul class="dropdown-menu">

                <li class="{{ Route::is('admin.faq-category.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.faq-category.index') }}">{{__('admin.FAQ Category')}}</a></li>

                <li class="{{ Route::is('admin.faq.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.faq.index') }}">{{__('admin.FAQ')}}</a></li>



                <li class="{{ Route::is('admin.terms-and-condition.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.terms-and-condition.index') }}">{{__('admin.Terms And Conditions')}}</a></li>

                <li class="{{ Route::is('admin.privacy-policy.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.privacy-policy.index') }}">{{__('admin.Privacy Policy')}}</a></li>

                <li class="{{ Route::is('admin.contact-us.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.contact-us.index') }}">{{__('admin.Contact Us')}}</a></li>

                <li class="{{ Route::is('admin.custom-page.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.custom-page.index') }}">{{__('admin.Custom Page')}}</a></li>

                <li class="{{ Route::is('admin.about-us.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.about-us.index') }}">{{__('admin.About Us')}}</a></li>

                <li class="{{ Route::is('admin.service.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.service.index') }}">{{__('admin.Service')}}</a></li>

                <li class="{{ Route::is('admin.testimonial.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.testimonial.index') }}">{{__('admin.Testimonial')}}</a></li>

                <li class="{{ Route::is('admin.error-page.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.error-page.index') }}">{{__('admin.Error Page')}}</a></li>

            </ul>
          </li>




          <li class="nav-item dropdown {{ Route::is('admin.maintainance-mode') || Route::is('admin.mega-menu-banner')  || Route::is('admin.banner-image.index') || Route::is('admin.topbar-contact') || Route::is('admin.homepage-one-visibility') || Route::is('admin.cart-bottom-banner') || Route::is('admin.seo-setup') || Route::is('admin.menu-visibility') || Route::is('admin.product-detail-page') || Route::is('admin.default-avatar') || Route::is('admin.footer.*') || Route::is('admin.social-link.*') || Route::is('admin.homepage-content') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-globe"></i><span>{{__('admin.Manage Website')}}</span></a>

            <ul class="dropdown-menu">

                <li class="{{ Route::is('admin.seo-setup') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.seo-setup') }}">{{__('admin.SEO Setup')}}</a></li>

                <li class="{{ Route::is('admin.topbar-contact') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.topbar-contact') }}">{{__('admin.Topbar Contact')}}</a></li>

                <li class="{{ Route::is('admin.footer.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.footer.index') }}">{{__('admin.Footer')}}</a></li>

                <li class="{{ Route::is('admin.social-link.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.social-link.index') }}">{{__('admin.Social Link')}}</a></li>


                <li class="{{ Route::is('admin.homepage-one-visibility') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.homepage-one-visibility') }}">{{__('admin.HomePage Visibility')}}</a></li>

                <li class="{{ Route::is('admin.homepage-content') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.homepage-content') }}">{{__('admin.Homepage Content')}}</a></li>

                <li class="{{ Route::is('admin.menu-visibility') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.menu-visibility') }}">{{__('admin.Menu Visibility')}}</a></li>

                <li class="{{ Route::is('admin.maintainance-mode') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.maintainance-mode') }}">{{__('admin.Maintainance Mode')}}</a></li>

                <li class="{{ Route::is('admin.banner-image.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.banner-image.index') }}">{{__('admin.Banner Image')}}</a></li>

                <li class="{{ Route::is('admin.default-avatar') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.default-avatar') }}">{{__('admin.Default Avatar')}}</a></li>

            </ul>
          </li>

          <li class="nav-item dropdown {{ Route::is('admin.blog-category.*') || Route::is('admin.blog.*') || Route::is('admin.popular-blog.*') || Route::is('admin.blog-comment.*') || Route::is('admin.reply-comment') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i><span>{{__('admin.Blogs')}}</span></a>

            <ul class="dropdown-menu">
                <li class="{{ Route::is('admin.blog-category.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.blog-category.index') }}">{{__('admin.Categories')}}</a></li>

                <li class="{{ Route::is('admin.blog.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.blog.index') }}">{{__('admin.Blogs')}}</a></li>

                <li class="{{ Route::is('admin.popular-blog.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.popular-blog.index') }}">{{__('admin.Popular Blogs')}}</a></li>

                <li class="{{ Route::is('admin.blog-comment.*') || Route::is('admin.reply-comment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.blog-comment.index') }}">{{__('admin.Comments')}}</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown {{ Route::is('admin.email-configuration') || Route::is('admin.email-template') || Route::is('admin.edit-email-template') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-envelope"></i><span>{{__('admin.Email Configuration')}}</span></a>

            <ul class="dropdown-menu">
                <li class="{{ Route::is('admin.email-configuration') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.email-configuration') }}">{{__('admin.Setting')}}</a></li>

                <li class="{{ Route::is('admin.email-template') || Route::is('admin.edit-email-template') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.email-template') }}">{{__('admin.Email Template')}}</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown {{ Route::is('admin.admin-language') || Route::is('admin.admin-validation-language') || Route::is('admin.website-language') || Route::is('admin.website-validation-language') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i><span>{{__('admin.Language')}}</span></a>

            <ul class="dropdown-menu">
                <li class="{{ Route::is('admin.admin-language') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.admin-language') }}">{{__('admin.Admin Language')}}</a></li>

                <li class="{{ Route::is('admin.admin-validation-language') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.admin-validation-language') }}">{{__('admin.Admin Validation')}}</a></li>

                <li class="{{ Route::is('admin.website-language') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.website-language') }}">{{__('admin.Frontend Language')}}</a></li>
                <li class="{{ Route::is('admin.website-validation-language') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.website-validation-language') }}">{{__('admin.Frontend Validation')}}</a></li>
            </ul>
          </li>

          <li class="{{ Route::is('admin.general-setting') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.general-setting') }}"><i class="fas fa-cog"></i> <span>{{__('admin.Setting')}}</span></a></li>

          @php
              $logedInAdmin = Auth::guard('admin')->user();
          @endphp
          @if ($logedInAdmin->admin_type == 1)
          <li  class="{{ Route::is('admin.clear-database') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.clear-database') }}"><i class="fas fa-trash"></i> <span>{{__('admin.Clear Database')}}</span></a></li>
          @endif

          <li class="{{ Route::is('admin.subscriber') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.subscriber') }}"><i class="fas fa-fire"></i> <span>{{__('admin.Subscribers')}}</span></a></li>

          <li class="{{ Route::is('admin.contact-message') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.contact-message') }}"><i class="fas fa-fa fa-envelope"></i> <span>{{__('admin.Contact Message')}}</span></a></li>

          @if ($logedInAdmin->admin_type == 1)
            <li class="{{ Route::is('admin.admin.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.admin.index') }}"><i class="fas fa-user"></i> <span>{{__('admin.Admin list')}}</span></a></li>
          @endif



        </ul>

    </aside>
  </div>
