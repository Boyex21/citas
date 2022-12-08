<div class="wsus__chat_single single_chat_2">
    <div class="wsus__chat_single_img">
        <img src="{{ $auth->image ? asset($auth->image) : asset($defaultProfile->image) }}" alt="user" class="img-fluid">
    </div>
    <div class="wsus__chat_single_text">
        <p>{{ $message->message }}</p>
        <span>{{ $message->created_at->format('d F, Y, H:i A') }}</span>
    </div>
</div>
