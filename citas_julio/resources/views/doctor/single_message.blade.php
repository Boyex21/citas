<div class="chat-item chat-right" >
    <img src="{{ $auth->image ? asset($auth->image) : asset($defaultProfile->image) }}">
    <div class="chat-details">
        <div class="chat-text">{{ $message->message }}</div>
        <div class="chat-time">{{ $message->created_at->format('d F, Y, H:i A') }}</div>
    </div>
</div>
