@extends('doctor.layout')
@section('title')
<title>{{__('user.Payment')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Payment')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Payment')}}</div>
            </div>
          </div>
          <div class="section-body">
            <div class="row">

                @if ($stripe->status == 1)
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card text-center">
                            <div class="card-header">
                                <img class="card-img payment-card-image" src="{{ asset($stripe->image) }}" alt="">
                            </div>
                            <div class="card-body">
                                <a href="javascript:;" data-toggle="modal" data-target="#stripeId" class="btn btn-primary">{{__('user.Pay via Stripe')}}</a>
                            </div>
                        </div>
                    </div>
                @endif


                @if ($paypal->status == 1)
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card text-center">
                            <div class="card-header">
                                <img class="card-img payment-card-image" src="{{ asset($paypal->image) }}" alt="">
                            </div>
                            <div class="card-body">
                                <a href="{{ route('doctor.pay-with-paypal', $package->slug) }}" class="btn btn-primary">{{__('user.Pay via Paypal')}}</a>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($razorpay->status == 1)
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card text-center">
                            <div class="card-header">
                                <img class="card-img payment-card-image" src="{{ asset($razorpay->image) }}" alt="">
                            </div>
                            <div class="card-body">
                                <form action="{{ route('doctor.pay-with-razorpay', $package->slug) }}" method="POST" >
                                    @csrf
                                    @php
                                        $total_price = $package->price;
                                        $payable_amount = $total_price * $razorpay->currency_rate;
                                        $payable_amount = round($payable_amount, 2);
                                    @endphp
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ $razorpay->key }}"
                                            data-currency="{{ $razorpay->currency_code }}"
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
                            </div>
                        </div>
                    </div>
                @endif


                @if ($flutterwave->status == 1)
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card text-center">
                            <div class="card-header">
                                <img class="card-img payment-card-image" src="{{ asset($flutterwave->logo) }}" alt="">
                            </div>
                            <div class="card-body">
                                <a href="javascript:;" onclick="makePayment()" class="btn btn-primary">{{__('user.Pay via Flutterwave')}}</a>
                            </div>
                        </div>
                    </div>
                @endif


                @if ($paystackAndMollie->mollie_status)
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card text-center">
                        <div class="card-header">
                            <img class="card-img payment-card-image" src="{{ asset($paystackAndMollie->mollie_image) }}" alt="">
                        </div>
                        <div class="card-body">
                            <a href="{{ route('doctor.pay-with-mollie', $package->slug) }}" class="btn btn-primary">{{__('user.Pay via Mollie')}}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if ($paystackAndMollie->paystack_status == 1)
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card text-center">
                            <div class="card-header">
                                <img class="card-img payment-card-image" src="{{ asset($paystackAndMollie->paystack_image) }}" alt="">
                            </div>
                            <div class="card-body">
                                <a href="javascript:;" onclick="payWithPaystack()" class="btn btn-primary">{{__('user.Pay via Paystack')}}</a>
                            </div>
                        </div>
                    </div>
                @endif


                @if ($instamojo->status == 1)
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card text-center">
                        <div class="card-header">
                            <img class="card-img payment-card-image" src="{{ asset($instamojo->image) }}" alt="">
                        </div>
                        <div class="card-body">
                            <a href="{{ route('doctor.pay-with-instamojo', $package->slug) }}" class="btn btn-primary">{{__('user.Pay via Instamojo')}}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if ($bank->status == 1)
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card text-center">
                            <div class="card-header">
                                <img class="card-img payment-card-image" src="{{ asset($bank->image) }}" alt="">
                            </div>
                            <div class="card-body">
                                <a href="javascript:;" data-toggle="modal" data-target="#bankPayment" class="btn btn-primary">{{__('user.Pay via Bank')}}</a>
                            </div>
                        </div>
                    </div>
                @endif


              </div>
          </div>
        </section>
      </div>


      <!-- Modal -->
      <div class="modal fade" id="stripeId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="container-fluid">
                            <form role="form" action="{{ route('doctor.pay-with-stripe') }}" method="POST" class="require-validation"
                                data-cc-on-file="false"
                                data-stripe-publishable-key="{{ $stripe->stripe_key }}"
                                id="payment-form">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">{{__('user.Card Number')}}</label>
                                        <input type="text" class="form-control card-number" name="card_number" autocomplete="off">
                                    </div>
                                    <input type="hidden" name="package_slug" value="{{ $package->slug }}">
                                    <div class="form-group col-md-12">
                                        <label for="">{{__('user.CVC')}}</label>
                                        <input type="text" class="form-control card-cvc" name="cvc" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">{{__('user.Month')}}</label>
                                        <input type="text" class="form-control card-expiry-month" name="month" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">{{__('user.Year')}}</label>
                                        <input type="text" class="form-control card-expiry-year" name="year" autocomplete="off">
                                    </div>

                                    <div class="col-xl-12 error d-none">
                                        <div class='alert-danger alert '>{{__('user.Please provide your valid card information')}}</div>
                                      </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">{{__('user.Payment')}}</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('user.Close')}}</button>
                                    </div>
                                </div>
                          </form>
                      </div>
                  </div>

              </div>
          </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="bankPayment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="container-fluid">
                          <form action="{{ route('doctor.pay-with-bank', $package->slug) }}" method="POST">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        {!! clean(nl2br($bank->account_info)) !!}
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="">{{__('user.Payment Details')}}</label>
                                        <textarea required name="payment_details" class="form-control text-area-5"  id="" cols="30" rows="10"></textarea>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">{{__('user.Payment')}}</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('user.Close')}}</button>
                                    </div>
                                </div>
                          </form>
                      </div>
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
@php
    $total_price = $package->price;
    $payable_amount = $total_price * $flutterwave->currency_rate;
    $payable_amount = round($payable_amount, 2);
@endphp

<script>
    function makePayment() {
      FlutterwaveCheckout({
        public_key: "{{ $flutterwave->public_key }}",
        tx_ref: "RX1",
        amount: {{ $payable_amount }},
        currency: "{{ $flutterwave->currency_code }}",
        country: "{{ $flutterwave->country_code }}",
        payment_options: " ",
        customer: {
          email: "{{ $doctor->email }}",
          phone_number: "{{ $doctor->phone }}",
          name: "{{ $doctor->name }}",
        },
        callback: function (data) {
            var tnx_id = data.transaction_id;
            var _token = "{{ csrf_token() }}";
            var slug = "{{ $package->slug }}";
            $.ajax({
                type: 'post',
                data : {tnx_id,_token,slug},
                url: "{{ route('doctor.pay-with-flutterwave') }}",
                success: function (response) {
                    if(response.status == 'success'){
                        toastr.success(response.message);
                        window.location.href = "{{ route('doctor.order') }}";
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
{{-- end flutterwave payment --}}



<script src="https://js.paystack.co/v1/inline.js"></script>
@php
    $paystack = $paystackAndMollie;
    $public_key = $paystack->paystack_public_key;
    $currency = $paystack->paystack_currency_code;
    $currency = strtoupper($currency);

    $total_price = $package->price;
    $ngn_amount = $total_price * $paystack->paystack_currency_rate;
    $ngn_amount = $ngn_amount * 100;
    $ngn_amount = round($ngn_amount);
@endphp
<script>
function payWithPaystack(){
  var handler = PaystackPop.setup({
    key: '{{ $public_key }}',
    email: '{{ $doctor->email }}',
    amount: '{{ $ngn_amount }}',
    currency: "{{ $currency }}",
    callback: function(response){
      let reference = response.reference;
      let tnx_id = response.transaction;
      let _token = "{{ csrf_token() }}";
      var slug = "{{ $package->slug }}";
      $.ajax({
          type: "post",
          data: {reference, tnx_id, _token, slug},
          url: "{{ route('doctor.pay-with-paystack') }}",
          success: function(response) {
            if(response.status == 'success'){
                window.location.href = "{{ route('doctor.order') }}";
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


@endsection
