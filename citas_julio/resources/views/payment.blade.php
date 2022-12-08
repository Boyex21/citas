@extends('layout')
@section('title')
    <title>{{__('user.Payment')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Payment')}}">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Payment')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Payment')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Event Start-->
<div class="event-area bg-area pb_70 pt_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="wsus__pay_item">
                    <h2>{{__('user.Payment Methods')}} :</h2>
                    <ul class="d-flex flex-wrap">

                        @if ($doctor_stripe)
                            @if ($doctor_stripe->status == 1)
                                <li>
                                    <img src="{{ asset($stripe->image) }}" alt="payment" class="img-fluid w-100">
                                    <a href="javascript:;" data-bs-toggle="modal" data-toggle="modal" data-target="#stripePayment">{{__('user.Pay via Stripe')}}</a>
                                </li>
                            @endif
                        @endif

                        @if ($doctor_paypal)
                            @if ($doctor_paypal->status == 1)
                                <li>
                                    <img src="{{ asset($paypal->image) }}" alt="payment" class="img-fluid w-100">
                                    <a href="{{ route('pay-with-paypal') }}">{{__('user.Pay via Paypal')}}</a>
                                </li>
                            @endif
                        @endif

                        @if ($doctor_razorpay)
                            @if ($doctor_razorpay->status == 1)
                                <li>
                                    <img src="{{ asset($razorpay->image) }}" alt="payment" class="img-fluid w-100">

                                        <form action="{{ route('pay-with-razorpay') }}" method="POST" >
                                            @csrf
                                            @php
                                                $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $appointment['price']);
                                                $payable_amount = $total_fee * $doctor_razorpay->currency_rate;
                                                $payable_amount = round($payable_amount, 2);
                                            @endphp
                                            <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                    data-key="{{ $doctor_razorpay->key }}"
                                                    data-currency="{{ $doctor_razorpay->currency_code }}"
                                                    data-amount= "{{ $payable_amount * 100 }}"
                                                    data-buttontext="{{__('user.Pay via Razorpay')}}"
                                                    data-name="{{ $razorpay->name }}"
                                                    data-description="{{ $razorpay->description }}"
                                                    data-image="{{ asset($razorpay->image) }}"
                                                    data-prefill.name=""
                                                    data-prefill.email=""
                                                    data-theme.color="{{ $razorpay->color }}">
                                            </script>
                                        </form>
                                </li>
                            @endif
                        @endif

                        @if ($doctor_flutterwave)
                            @if ($doctor_flutterwave->status == 1)
                                <li>
                                    <img src="{{ asset($flutterwave->logo) }}" alt="payment" class="img-fluid w-100">
                                    <a href="javascript:;" onclick="makePayment()">{{__('user.Pay via Flutterwave')}}</a>
                                </li>
                            @endif
                        @endif

                        @if ($doctor_paystack)
                            @if ($doctor_paystack->status == 1)
                                <li>
                                    <img src="{{ asset($paystack->paystack_image) }}" alt="payment" class="img-fluid w-100">
                                    <a href="javascript:;" onclick="payWithPaystack()">{{__('user.Pay via Paystack')}}</a>
                                </li>
                            @endif
                        @endif

                        @if ($doctor_mollie)
                            @if ($doctor_mollie->status == 1)
                                <li>
                                    <img src="{{ asset($mollie->mollie_image) }}" alt="payment" class="img-fluid w-100">
                                    <a href="{{ route('pay-with-mollie') }}" onclick="payWithPaystack()">{{__('user.Pay via Mollie')}}</a>
                                </li>
                            @endif
                        @endif

                        @if ($doctor_instamojo)
                            @if ($doctor_instamojo->status == 1)
                                <li>
                                    <img src="{{ asset($instamojo->image) }}" alt="payment" class="img-fluid w-100">
                                    <a href="{{ route('pay-with-instamojo') }}">{{__('user.Pay via Instamojo')}}</a>
                                </li>
                            @endif
                        @endif

                        @if ($doctor_bank)
                            @if ($doctor_bank->status == 1)
                                <li>
                                    <img src="{{ asset($bankPayment->image) }}" alt="payment" class="img-fluid w-100">
                                    <a href="javascript:;" data-bs-toggle="modal" data-toggle="modal" data-target="#exampleModal">{{__('user.Pay via Bank')}}</a>
                                </li>
                            @endif
                        @endif

                        @if ($appointment['options']['consultation_type'] == 0)
                            @if ($doctor_bank)
                                @if ($doctor_bank->hand_cash_status == 1)
                                    <li>
                                        <img src="{{ asset($bankPayment->hc_image) }}" alt="payment" class="img-fluid w-100">
                                        <a href="{{ route('pay-with-handcash') }}">{{__('user.Pay Hand Cash')}}</a>
                                    </li>
                                @endif
                            @endif
                        @endif

                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>{{__('user.Doctor')}}</td>
                            <td>{{ $appointment['name'] }}</td>
                        </tr>
                        <tr>
                            <td>{{__('user.Chamber')}}</td>
                            <td>{{ $appointment['options']['chamber'] }}</td>
                        </tr>
                        <tr>
                            <td>{{__('user.Schedule')}}</td>
                            <td>{{ $appointment['options']['schedule'] }}</td>
                        </tr>
                        <tr>
                            <td>{{__('user.Date')}}</td>
                            <td>{{ $appointment['options']['date'] }}</td>
                        </tr>
                        <tr>
                            <td>{{__('user.Consultation Type')}}</td>
                            <td>{{ $appointment['options']['consultation_type'] == 0 ? trans('Offline') : trans('Online') }}</td>
                        </tr>
                        <tr>
                            <td>{{__('user.Fee')}}</td>
                            <td>{{ $setting->currency_icon }}{{ $appointment['price'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="wsus__payment_modal modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{__('user.Pay via Bank')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('payment-with-bank') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            @if ($doctor_bank)
                            <p>{!! clean(nl2br($doctor_bank->account_info)) !!}</p>
                            @endif

                        </div>
                        <div class="col-xl-12">
                            <textarea cols="3" rows="3" placeholder="{{__('user.Payment Information')}}" name="tnx_info" required></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('user.Close')}}</button>
                <button type="submit" class="btn btn-danger">{{__('user.Payment')}}</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <div class="wsus__payment_modal modal fade" id="stripePayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{__('user.Pay via Stripe')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form role="form" action="{{ route('payment-with-stripe') }}" method="POST" class="require-validation"
            data-cc-on-file="false"
            data-stripe-publishable-key="{{ @$doctor_stripe->stripe_key }}"
            id="payment-form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12">
                        <input required class="card-number" name="card_number" type="text" placeholder="{{__('user.Card Number')}}" autocomplete="off">
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <input required class="card-expiry-month" name="month" type="text" placeholder="{{__('user.Month')}}" autocomplete="off">
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <input required class="card-expiry-year" name="year" type="text" placeholder="{{__('user.Year')}}" autocomplete="off">
                    </div>
                    <div class="col-xl-12">
                        <input required class="card-cvc" name="cvc" type="text" placeholder="{{__('user.CVC')}}" autocomplete="off">
                    </div>

                    <div class="col-xl-12 error d-none">
                        <div class='alert-danger alert '>{{__('user.Please provide your valid card information')}}</div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('user.Close')}}</button>
                <button type="submit" class="btn btn-danger">{{__('user.Payment')}}</button>
            </div>
        </form>
        </div>
    </div>
    </div>


</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
// start stripe payment
$(function() {
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                            'input[type=text]', 'input[type=file]',
                            'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('d-none');

        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('d-none');
                e.preventDefault();
            }
        });

        if (!$form.data('cc-on-file')) {
        e.preventDefault();
        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);
        }

    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('d-none')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});
</script>


{{-- start flutterwave payment --}}
<script src="https://checkout.flutterwave.com/v3.js"></script>
@if ($doctor_flutterwave)
@php
    $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $appointment['price']);
    $payable_amount = $total_fee * $doctor_flutterwave->currency_rate;
    $payable_amount = round($payable_amount, 2);
@endphp

<script>
    function makePayment() {
      FlutterwaveCheckout({
        public_key: "{{ $doctor_flutterwave->public_key }}",
        tx_ref: "RX1",
        amount: {{ $payable_amount }},
        currency: "{{ $doctor_flutterwave->currency_code }}",
        country: "{{ $doctor_flutterwave->country_code }}",
        payment_options: " ",
        customer: {
          email: "{{ $user->email }}",
          phone_number: "{{ $user->phone }}",
          name: "{{ $user->name }}",
        },
        callback: function (data) {
            var tnx_id = data.transaction_id;
            var _token = "{{ csrf_token() }}";

            $.ajax({
                type: 'post',
                data : {tnx_id,_token},
                url: "{{ route('pay-with-flutterwave') }}",
                success: function (response) {
                    if(response.status == 'success'){
                        toastr.success(response.message);
                        window.location.href = "{{ route('user.transaction') }}";
                    }else{
                        toastr.error(response.message);
                        window.location.reload();
                    }
                },
                error: function(err) {}
            });

        },
        customizations: {
          title: "{{ $flutterwave->title }}",
          logo: "{{ asset($flutterwave->logo) }}",
        },
      });
    }
</script>
@endif
{{-- end flutterwave payment --}}


@if ($doctor_paystack)
<script src="https://js.paystack.co/v1/inline.js"></script>
@php
    $public_key = $doctor_paystack->public_key;
    $currency = $doctor_paystack->currency_code;
    $currency = strtoupper($currency);

    $total_fee = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', $appointment['price']);
    $ngn_amount = $total_fee * $doctor_paystack->currency_rate;
    $ngn_amount = $ngn_amount * 100;
    $ngn_amount = round($ngn_amount);
@endphp
<script>
function payWithPaystack(){
  var handler = PaystackPop.setup({
    key: '{{ $public_key }}',
    email: '{{ $user->email }}',
    amount: '{{ $ngn_amount }}',
    currency: "{{ $currency }}",
    callback: function(response){
      let reference = response.reference;
      let tnx_id = response.transaction;
      let _token = "{{ csrf_token() }}";
      $.ajax({
          type: "post",
          data: {reference, tnx_id, _token},
          url: "{{ route('pay-with-paystack') }}",
          success: function(response) {
            if(response.status == 'success'){
                window.location.href = "{{ route('user.transaction') }}";
            }else{
                window.location.reload();
            }
          }
      });
    },
    onClose: function(){
        alert('window closed');
    }
  });
  handler.openIframe();
}
</script>
@endif

@endsection
