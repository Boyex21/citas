@extends('layout')
@section('title')
    <title>{{ $blog->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $blog->seo_description }}">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{  asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $blog->title }}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Blog')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Blog Start-->
<div class="blog-page single-blog pt_40 pb_90">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="blog-item">
                    <div class="single-blog-image">
                        <img src="{{ asset($blog->image) }}" alt="">
                        <div class="blog-author">
                            <span><i class="fa fa-user"></i> {{__('user.Admin')}}</span>
                            <span><i class="fa fa-calendar-o"></i> {{ $blog->created_at->format('d F, Y') }}</span>
                            <span><i class="fa fa-tag" aria-hidden="true"></i> {{ $blog->category->name }}</span>
                        </div>
                    </div>
                    <div class="blog-text pt_40">
                        <h3>{{ $blog->title }}</h3>
                        <p>
                            {{ $blog->short_description }}
                        </p>
                        {!! clean($blog->description) !!}
                    </div>
                </div>

                @if ($facebookComment->comment_type == 1)
                    @if ($blog->comments->where('status', 1)->count() > 0)
                        <div class="comment-list mt_30">
                            <h4>{{__('user.Comments')}} <span class="c-number">({{ $blog->comments->where('status', 1)->count() }})</span></h4>
                            <ul>
                                @foreach ($blog->comments->where('status', 1) as $comment)
                                <li>
                                    <div class="comment-item">
                                        <div class="thumb">
                                            <img src="http://www.gravatar.com/avatar/75d23af433e0cea4c0e45a56dba18b30" alt="">
                                        </div>
                                        <div class="com-text">
                                            <h5>{{ $comment->name }}</h5>
                                            <span class="date"><i class="fa fa-calendar"></i> {{ $comment->created_at->format('d M, Y') }}</span>
                                            <p>
                                                {!! clean($comment->comment) !!}
                                            </p>
                                        </div>
                                    </div>

                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="comment-form mt_30">
                        <h4>{{__('user.Submit a Comment')}}</h4>
                        <form id="blogCommentForm">
                            @csrf
                            <div class="form-row row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" placeholder="{{__('user.Name')}}" name="name">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" placeholder="{{__('user.Email')}}" name="email">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" placeholder="{{__('user.Phone')}}" name="phone">
                                </div>
                                <div class="form-group col-12">
                                    <textarea class="form-control" name="comment" placeholder="{{__('user.Comment')}}"></textarea>
                                </div>
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <div class="form-group col-md-12">
                                    @if($recaptchaSetting->status==1)
                                        <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn">{{__('user.Submit')}}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                @else
                <div class="fb-comments" data-href="{{ Request::url() }}" data-width="" data-numposts="10"></div>
                @endif
            </div>
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="sidebar-item">
                        <h3>{{__('user.Categories')}}</h3>
                        <ul>
                            @foreach ($categories as $cat)
                            <li class="{{ $blog->blog_category_id == $cat->id ? 'active' : '' }}"><a href="{{ route('search-blog', ['category' => $cat->slug]) }}"><i class="fa fa-chevron-right"></i> {{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @if ($popularPosts->count() > 0)
                        <div class="sidebar-item">
                            <h3>{{__('user.Popular Post')}}</h3>
                            @foreach ($popularPosts as $popularPost)
                                <div class="blog-recent-item">
                                    <div class="blog-recent-photo">
                                        <a href="{{ route('blog-detail', $popularPost->blog->slug) }}"><img src="{{ asset($popularPost->blog->image) }}" alt=""></a>
                                    </div>
                                    <div class="blog-recent-text">
                                        <a href="{{ route('blog-detail', $popularPost->blog->slug) }}">{{ $popularPost->blog->title }}</a>
                                        <div class="blog-post-date">{{ $popularPost->blog->created_at->format('d M, Y') }}</div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif


                </div>
                <!--Sidebar End-->
            </div>
        </div>
    </div>
</div>
<!--Blog End-->

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0&appId={{ $facebookComment->app_id }}&autoLogAppEvents=1" nonce="MoLwqHe5"></script>

<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#blogCommentForm").on('submit', function(e){
                e.preventDefault();
                var isDemo = "{{ env('APP_VERSION') }}"
                if(isDemo == 0){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }
                $.ajax({
                    type: 'POST',
                    data: $('#blogCommentForm').serialize(),
                    url: "{{ route('blog-comment') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#blogCommentForm").trigger("reset");
                        }
                    },
                    error: function(response) {
                        if(response.responseJSON.errors.name)toastr.error(response.responseJSON.errors.name[0])
                        if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                        if(response.responseJSON.errors.comment)toastr.error(response.responseJSON.errors.comment[0])

                        if(!response.responseJSON.errors.name || !response.responseJSON.errors.email || !response.responseJSON.errors.comment){
                            toastr.error("{{__('user.Please complete the recaptcha to submit the form')}}")
                        }
                    }
                });
            })


        });
    })(jQuery);

</script>

@endsection
