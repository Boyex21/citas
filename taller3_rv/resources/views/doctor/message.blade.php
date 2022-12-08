@extends('doctor.layout')
@section('title')
<title>{{__('user.Message')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Message')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Message')}}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row justify-content-center">
              <div class="col-12 col-sm-6 col-lg-4">
                <div class="card">
                  <div class="card-header">
                    <h4>{{__('user.Patient List')}}</h4>
                  </div>
                  <div class="card-body seller_chat_list">
                    <ul class="list-unstyled list-unstyled-border">
                        @foreach ($users as $user)
                            @php
                                $doctor = Auth::guard('doctor')->user();
                                $unRead = App\Models\Message::where(['doctor_id'=>$doctor->id,'user_id'=>$user->user->id,'doctor_view'=>0])->count();
                            @endphp

                            <li id="customer-list-{{ $user->user->id }}" class="media mt-2 doctor-chat-list" onclick="loadChatBox('{{ $user->user->id }}')">
                                <img alt="image" class="mr-3 ml-3 rounded-circle" width="50" src="{{ $user->user->image ? asset($user->user->image) : asset($defaultProfile->image) }}">
                                <span class="pending {{ $unRead == 0 ? 'd-none' : '' }}" id="pending-{{ $user->user->id }}">{{ $unRead }}</span>
                                <div class="media-body mt-4">
                                    <div class="font-weight-bold">{{ $user->user->name }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-8">
                <div class="card chat-box" id="mychatbox">

                </div>
              </div>

            </div>
          </div>
        </section>
      </div>
@endsection
