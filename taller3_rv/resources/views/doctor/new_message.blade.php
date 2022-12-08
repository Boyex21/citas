@php
    $header_user = Auth::guard('doctor')->user();
    $defaultProfile = App\Models\BannerImage::whereId('15')->first();

    $newMessages = App\Models\Message::orderBy('id','desc')->where(['doctor_id' => $header_user->id, 'doctor_view' => 0])->groupBy('user_id')->select('user_id','id','message','created_at')->get()->take(5);
@endphp

@if ($newMessages->count() > 0)
    <div class="dropdown-header">{{__('user.Messages')}}
        <div class="float-right">
        <a href="{{ route('doctor.real-all-message') }}">{{__('user.Mark All As Read')}}</a>
        </div>
    </div>
    <div class="dropdown-list-content dropdown-list-message">
        @foreach ($newMessages as $newMessage)
            <a href="#" class="dropdown-item dropdown-item-unread">
            <div class="dropdown-item-avatar">
                <img alt="image" src="{{ $newMessage->user->image ? asset($newMessage->user->image) : asset($defaultProfile->image) }}" class="rounded-circle">
                <div class="is-online"></div>
            </div>
            <div class="dropdown-item-desc">
                <b>{{ $newMessage->user->name }}</b>
                <p> {!! clean(nl2br($newMessage->message)) !!}</p>
                <div class="time">{{ $newMessage->created_at->diffForHumans() }}</div>
            </div>
            </a>
        @endforeach
</div>
<div class="dropdown-footer text-center">
    <a href="{{ route('doctor.message') }}">{{__('user.View All')}} <i class="fas fa-chevron-right"></i></a>
</div>
@else
<p class="text-danger text-center mt-2 py-4">{{__('user.Message Not Found')}}</p>
@endif
