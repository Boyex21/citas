<div class="wsus__chat_area">
    <div class="wsus__chat_area_header">
        <h2>{{__('user.chat with')}} {{ $doctor->name }}</h2>
    </div>
    <div class="wsus__chat_area_body">

        @foreach ($messages as $message)
            @if ($message->send_user == $auth->id)
                <div class="wsus__chat_single single_chat_2">
                    <div class="wsus__chat_single_img">
                        <img src="{{ $auth->image ? asset($auth->image) : asset($defaultProfile->image) }}" alt="user" class="img-fluid">
                    </div>
                    <div class="wsus__chat_single_text">
                        <p>{{ $message->message }}</p>
                        <span>{{ $message->created_at->format('d F, Y, H:i A') }}</span>
                    </div>
                </div>
            @else
                <div class="wsus__chat_single">
                    <div class="wsus__chat_single_img">
                        <img src="{{ $doctor->image ? asset($doctor->image) : asset($defaultProfile->image) }}" alt="user" class="img-fluid">
                    </div>
                    <div class="wsus__chat_single_text">
                        <p>{{ $message->message }}</p>
                        <span>{{ $message->created_at->format('d F, Y, H:i A') }}</span>
                    </div>
                </div>
            @endif

        @endforeach
    </div>
    <div class="wsus__chat_area_footer">
        <form id="userToExpertMessageForm">
            <input type="text" placeholder="{{__('user.Type')}}" autocomplete="off" id="doctor_message">
            <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctor->id }}">
            <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </form>
    </div>
    </div>
</div>



<script>

    (function($) {
    "use strict";
    $(document).ready(function () {
        scrollToBottomFunc()
        $("#userToExpertMessageForm").on("submit", function(event){
            event.preventDefault()
            var isDemo = "{{ env('APP_VERSION') }}"
            if(isDemo == 0){
                toastr.error('This Is Demo Version. You Can Not Change Anything');
                return;
            }

            let doctor_message = $("#doctor_message").val();
            let doctor_id = $("#doctor_id").val();
            $("#doctor_message").val('');
            if(doctor_message){
                $.ajax({
                    type:"get",
                    data : {message: doctor_message , doctor_id : doctor_id},
                    url: "{{ route('user.send-message') }}",
                    success:function(response){
                        $(".wsus__chat_area_body").append(response)
                        scrollToBottomFunc()
                    },
                    error:function(err){
                    }
                })
            }

        })
    });
  })(jQuery);

    function scrollToBottomFunc() {
        $('.wsus__chat_area_body').animate({
            scrollTop: $('.wsus__chat_area_body').get(0).scrollHeight
        }, 50);
    }
</script>
