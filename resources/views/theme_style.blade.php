@php
 $setting = App\Models\Setting::first();
@endphp

<style>
    /* for blue color */
    .header-area,
    .faq-header button.faq-button.collapsed,
    .faq-header button.faq-button:before,
    .home-button a,
    .video-section-home .video-button:before,
    .doctor-search .s-button button,
    .team-detail-text ul li a,
    .event-detail-tab ul,
    .event-detail-tab ul li a,
    .service-widget-contact,
    .event-form .btn,
    .blog-page .blog-author,
    .sidebar-item ul li.active a,
    .sidebar-item ul li a:hover,
    .comment-form .btn,
    .contact-info-item.bg2
    .contact-form .btn,
    .bank.contact-info-item.bg2,
    .dash-item.db-blue,
    .dashboard-account-info,
    .dashboard-widget li a,
    .add-form .btn,
    ul.page-numbers li a,
    .contact-info-item.bg2,
    .contact-form .btn,
    .slide-carousel .owl-dots .owl-dot.active,
    .banner_search ul li button,
    .wsus__chatlist h2,
    .wsus__chat_area_header h2,
    .single_chat_2 .wsus__chat_single_text p,
    .wsus__chat_area_footer form button {
        background: {{ $setting->theme_one }} !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: {{ $setting->theme_one }} !important;
        color: white;
    }

    .home-button a{
        border: 1px solid {{ $setting->theme_one }}
    }


    .case-item .case-content h4:before,
    .service-widget ul li.active a, .service-widget ul li a:hover{
        background-color: {{ $setting->theme_one }} !important;
    }

    .event-detail-tab ul li a.active{
        background: #fff !important;
    }

    .choose-item:before{
        background: {{ $setting->theme_one }} !important;
    }
    .header-area:before,
    .header-area:after{
        border-top: 18px solid {{ $setting->theme_one }}  !important;
    }

    .header-area:before{
        border-right: 18px solid {{ $setting->theme_one }} !important;
    }

    .header-area:after{
        border-left: 18px solid {{ $setting->theme_one }} !important;
    }

    .main-headline h1 span,
    .testi-info h4,
    .blog-item.sm_btn,
    .blog-item h3 a:hover,
    .blog-item .sm_btn,
    ul.nav-menu li:hover>a,
    ul.nav-menu li.menu-item-has-children:hover:before {
        color: {{ $setting->theme_one }} !important;
    }
    .owl-testimonial .owl-dots .owl-dot,
    .owl-carousel.team-carousel .owl-dots .owl-dot,
    .owl-carousel.blog-carousel .owl-dots .owl-dot
    {
        border: 5px solid {{ $setting->theme_one }} !important
    }
    .about-skey:before,
    .mission-img:before,
    .video-item:before
    {
        border-top:170px solid {{ $setting->theme_one }} !important;

    }
    .about-skey:after,
    .mission-img:after,
    .video-item:after{
        border-bottom: 170px solid {{ $setting->theme_one }} !important;
    }

    .brand-item:before,
    .dashboard-widget li.active a,
    .dashboard-widget li a:hover
    {
        border-right: 3px solid {{ $setting->theme_one }} !important;
        border-left: 3px solid {{ $setting->theme_one }} !important;

    }

    .brand-item:after{
        border-bottom: 3px solid {{ $setting->theme_one }} !important;
        border-top: 3px solid {{ $setting->theme_one }} !important;
    }
    .brand-colume:after {
        border-bottom: 25px solid {{ $setting->theme_one }} !important;
    }

    .about1-inner img{
        border: 10px solid {{ $setting->theme_one }};
    }

    /* end blue color */




    /* start red color */
    .special-button a ,
    .doc-search-section .doc-search-button button,
    .faq-header button.faq-button.collapsed:before,
    .faq-header button.faq-button,
    .subscribe-form .btn-sub,
    .scroll-top,
    .video-section-home .video-button:after,
    .footer-item h3:after,
    .doctor-search,
    .team-social li a:hover,
    .event-detail-tab ul li a.active:before,
    .wh-table .sch,
    .event-form .btn:hover,
    .comment-form .btn:hover,
    .contact-info-item.bg1,
    .contact-info-item.bg3,
    .contact-form .btn:hover,
    .payment-order-button button,
    .payment-order-button a,
    .dash-item.db-red,
    .dashboard-widget li a:hover,
    .dashboard-widget li.active a,
    ul.page-numbers li span,
    .razorpay-payment-button,
    .wsus__chat_area_footer form button:hover,
    .gallery_item .plus {
        background: {{ $setting->theme_two }} !important;
    }

    .comment-form .btn:hover,
    .event-form .btn:hover,
    .contact-form .btn:hover{
        border: 1px solid {{ $setting->theme_two }} !important;
    }

    .testimonial-page .testi-link{
        border-color:{{ $setting->theme_two }} transparent !important;
    }


    .blog-page .blog-author,
    .dashboard-widget li a{
        border-left: 5px solid {{ $setting->theme_two }} !important;
        border-right: 5px solid {{ $setting->theme_two }} !important;
    }

    .case-item .case-content h4:after,
    .catagory-hover li a{
        background-color: {{ $setting->theme_two }} !important;
    }

    .owl-testimonial .owl-dots .owl-dot.active,
    .owl-carousel.team-carousel .owl-dots .owl-dot.active,
    .owl-carousel.blog-carousel .owl-dots .owl-dot.active{
        border: 5px solid {{ $setting->theme_two }} !important
    }
    .choose-col:nth-of-type(2n) .choose-item:before {
        background: {{ $setting->theme_two }} !important;
    }

    .service-item i, .service-item2 i,
    .service-item a,
    .testimonial-item:before,
    .team-text a:hover,
    .footer-address ul li i,
    .counter-item .counter-icon,
    h5.appointment-cost,
    .event-detail-tab ul li a.active,
    .comment-list .c-number,
    .comment-list .com-text span.date i,

    .footer-item a:hover, .footer-item li a:hover,
    .footer-social a:hover,
    .choose-icon i,
    .blog-carousel .blog-author span i {
        color: {{ $setting->theme_two }} !important
    }
    /* end red color  */


    .wsus__pay_item ul li a,
    .wsus__pay_item ul li input {
        background: {{ $setting->theme_one }} !important;
        opacity: 0.9 !important;
    }

    .wsus__pay_item ul li :hover,
    .wsus__pay_item ul li input:hover {
        background: {{ $setting->theme_one }} !important;
        opacity: 1 !important;
    }

</style>

