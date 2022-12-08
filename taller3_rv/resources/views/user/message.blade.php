@extends('layout')
@section('title')
    <title>{{__('user.Message')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Message')}}">
@endsection

@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Message')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Message')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Dashboard Start-->
<div class="dashboard-area pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-xl-4 col-md-5 col-lg-4">
                        <div class="wsus__chatlist">
                            <h2>{{__('user.Expert List')}}</h2>
                            <div class="wsus__chatlist_body">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    @foreach ($doctors as $doctor)
                                        @php
                                            $user = Auth::guard('web')->user();
                                            $unRead = App\Models\Message::where(['user_id' => $user->id, 'doctor_id' => $doctor->doctor->id, 'user_view' => 0])->count();
                                        @endphp

                                        <li class="nav-item" role="presentation" onclick="loadChatBox('{{ $doctor->doctor->id }}')">
                                            <a class="nav-link " id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                                                <div class="wsus_chat_list_img">
                                                    <img src="{{ $doctor->doctor->image ? asset($doctor->doctor->image) : asset($defaultProfile->image) }}" alt="user" class="img-fluid">
                                                    <span id="pending-{{ $doctor->doctor->id }}" class="{{ $unRead == 0 ? 'd-none' : '' }}">{{ $unRead }}</span>
                                                </div>
                                                <div class="wsus_chat_list_text">
                                                    <h4>{{ $doctor->doctor->name }}</h4>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach



                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-md-7 col-lg-8">
                        <div class="wsus__chat_main_area">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection


