@extends('doctor.layout')
@section('title')
<title>{{__('user.Payment Methods')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Payment Methods')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
            </div>
          </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3">
                                    <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">


                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link active" id="paypal-tab" data-toggle="tab" href="#paypalTab" role="tab" aria-controls="paypalTab" aria-selected="true">{{__('user.Paypal')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="stripe-tab" data-toggle="tab" href="#stripeTab" role="tab" aria-controls="stripeTab" aria-selected="true">{{__('user.Stripe')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="razorpay-tab" data-toggle="tab" href="#razorpayTab" role="tab" aria-controls="razorpayTab" aria-selected="true">{{__('user.Razorpay')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="flutterwave-tab" data-toggle="tab" href="#flutterwaveTab" role="tab" aria-controls="flutterwaveTab" aria-selected="true">{{__('user.Flutterwave')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="mollie-tab" data-toggle="tab" href="#mollieTab" role="tab" aria-controls="mollieTab" aria-selected="true">{{__('user.Mollie')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="pay-stack-tab" data-toggle="tab" href="#payStackTab" role="tab" aria-controls="payStackTab" aria-selected="true">{{__('user.PayStack')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="instamojo-tab" data-toggle="tab" href="#instamojoTab" role="tab" aria-controls="instamojoTab" aria-selected="true">{{__('user.Instamojo')}}</a>
                                        </li>

                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="bank-account-tab" data-toggle="tab" href="#bankAccountTab" role="tab" aria-controls="bankAccountTab" aria-selected="true">{{__('user.Bank Account')}}</a>
                                        </li>
                                        @if ($bank)
                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link" id="cash-tab" data-toggle="tab" href="#cashTab" role="tab" aria-controls="cashTab" aria-selected="true">{{__('user.Hand Cash')}}</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="col-12 col-sm-12 col-md-9">
                                    <div class="border rounded">
                                        <div class="tab-content no-padding" id="settingsContent">

                                            <div class="tab-pane fade show active" id="paypalTab" role="tabpanel" aria-labelledby="paypal-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('doctor.update-paypal') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            @if ($paypal)
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Paypal Status')}}</label>
                                                                    <div>
                                                                        @if ($paypal->status == 1)
                                                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                            @else
                                                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Account Mode')}}</label>
                                                                    <select name="account_mode" id="account_mode" class="form-control">
                                                                        <option {{ $paypal->account_mode == 'live' ? 'selected' : '' }} value="live">{{__('user.Live')}}</option>
                                                                        <option {{ $paypal->account_mode == 'sandbox' ? 'selected' : '' }} value="sandbox">{{__('user.Sandbox')}}</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option {{ $paypal->country_code == $country->code ? 'selected' : '' }} value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{ __('Currency Name')}}</label>
                                                                    <select name="currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option {{ $paypal->currency_code == $currency->code ? 'selected' : '' }} value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency rate')}} ( {{__('user.Per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate" value="{{ $paypal->currency_rate }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Paypal Client Id')}}</label>
                                                                    <input type="text" class="form-control" name="paypal_client_id" value="{{ $paypal->client_id }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Paypal Secret Key')}}</label>
                                                                    <input type="text" class="form-control" name="paypal_secret_key" value="{{ $paypal->secret_id }}">
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Account Mode')}}</label>
                                                                    <select name="account_mode" id="account_mode" class="form-control">
                                                                        <option value="live">{{__('user.Live')}}</option>
                                                                        <option value="sandbox">{{__('user.Sandbox')}}</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{ __('Currency Name')}}</label>
                                                                    <select name="currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency rate')}} ( {{__('user.Per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Paypal Client Id')}}</label>
                                                                    <input type="text" class="form-control" name="paypal_client_id">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Paypal Secret Key')}}</label>
                                                                    <input type="text" class="form-control" name="paypal_secret_key" >
                                                                </div>
                                                            @endif

                                                            <button class="btn btn-primary">{{__('user.Save')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="stripeTab" role="tabpanel" aria-labelledby="stripe-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('doctor.update-stripe') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            @if ($stripe)
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Stripe Status')}}</label>
                                                                    <div>
                                                                        @if ($stripe->status == 1)
                                                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                            @else
                                                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option {{ $stripe->country_code == $country->code ? 'selected' : '' }} value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option {{ $stripe->currency_code == $currency->code ? 'selected' : '' }} value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency rate')}} ( {{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate" value="{{ $stripe->currency_rate }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Stripe Key')}}</label>
                                                                    <input type="text" class="form-control" name="stripe_key" value="{{ $stripe->stripe_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Stripe Secret')}}</label>
                                                                    <input type="text" class="form-control" name="stripe_secret" value="{{ $stripe->stripe_secret }}">
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Stripe Status')}}</label>
                                                                    <div>
                                                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency rate')}} ( {{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Stripe Key')}}</label>
                                                                    <input type="text" class="form-control" name="stripe_key">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Stripe Secret')}}</label>
                                                                    <input type="text" class="form-control" name="stripe_secret">
                                                                </div>

                                                            @endif

                                                            <button class="btn btn-primary">{{__('user.Save')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="razorpayTab" role="tabpanel" aria-labelledby="razorpay-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('doctor.update-razorpay') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            @if ($razorpay)
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Razorpay Status')}}</label>
                                                                    <div>
                                                                        @if ($razorpay->status == 1)
                                                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                            @else
                                                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Razorpay Key')}}</label>
                                                                    <input type="text" class="form-control" name="razorpay_key" value="{{ $razorpay->key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Razorpay Secret Key')}}</label>
                                                                    <input type="text" class="form-control" name="razorpay_secret" value="{{ $razorpay->secret_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option {{ $razorpay->country_code == $country->code ? 'selected' : '' }} value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option {{ $razorpay->currency_code == $currency->code ? 'selected' : '' }} value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Rate')}} ({{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate" value="{{ $razorpay->currency_rate }}">
                                                                </div>

                                                            @else
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Razorpay Status')}}</label>
                                                                    <div>
                                                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Razorpay Key')}}</label>
                                                                    <input type="text" class="form-control" name="razorpay_key">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Razorpay Secret Key')}}</label>
                                                                    <input type="text" class="form-control" name="razorpay_secret">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Rate')}} ({{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate">
                                                                </div>
                                                            @endif

                                                            <button class="btn btn-primary">{{__('user.Update')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="flutterwaveTab" role="tabpanel" aria-labelledby="flutterwave-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('doctor.update-flutterwave') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            @if ($flutterwave)
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Flutterwave Status')}}</label>
                                                                    <div>
                                                                        @if ($flutterwave->status == 1)
                                                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                            @else
                                                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Public Key')}}</label>
                                                                    <input type="text" class="form-control" name="public_key" value="{{ $flutterwave->public_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Secret Key')}}</label>
                                                                    <input type="text" class="form-control" name="secret_key" value="{{ $flutterwave->secret_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option {{ $flutterwave->country_code == $country->code ? 'selected' : '' }} value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option {{ $flutterwave->currency_code == $currency->code ? 'selected' : '' }} value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Rate')}} ({{__('user.Per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate" value="{{ $flutterwave->currency_rate }}">
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Flutterwave Status')}}</label>
                                                                    <div>
                                                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Public Key')}}</label>
                                                                    <input type="text" class="form-control" name="public_key">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Secret Key')}}</label>
                                                                    <input type="text" class="form-control" name="secret_key">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Rate')}} ({{__('user.Per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate">
                                                                </div>
                                                            @endif

                                                            <button class="btn btn-primary">{{__('user.Update')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="mollieTab" role="tabpanel" aria-labelledby="mollie-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('doctor.update-mollie') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            @if ($mollie)
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Mollie Status')}}</label>
                                                                    <div>
                                                                        @if ($mollie->status == 1)
                                                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                            @else
                                                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Mollie Key')}}</label>
                                                                    <input type="text" class="form-control" name="mollie_key" value="{{ $mollie->mollie_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="mollie_country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option {{ $mollie->country_code == $country->code ? 'selected' : '' }} value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="mollie_currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option {{ $mollie->currency_code == $currency->code ? 'selected' : '' }} value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Rate')}} ({{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="mollie_currency_rate" value="{{ $mollie->currency_rate }}">
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Mollie Status')}}</label>
                                                                    <div>
                                                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Mollie Key')}}</label>
                                                                    <input type="text" class="form-control" name="mollie_key">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="mollie_country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="mollie_currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Rate')}} ({{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="mollie_currency_rate">
                                                                </div>
                                                            @endif

                                                            <button class="btn btn-primary">{{__('user.Update')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="payStackTab" role="tabpanel" aria-labelledby="pay-stack-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('doctor.update-paystack') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            @if ($paystack)
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.PayStack Status')}}</label>
                                                                    <div>
                                                                        @if ($paystack->status == 1)
                                                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                            @else
                                                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Public Key')}}</label>
                                                                    <input type="text" name="paystack_public_key" class="form-control" value="{{ $paystack->public_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Secret Key')}}</label>
                                                                    <input type="text" name="paystack_secret_key" class="form-control" value="{{ $paystack->secret_key }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="paystack_country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                    </option>
                                                                    @foreach ($countires as $country)
                                                                    <option {{ $paystack->country_code == $country->code ? 'selected' : '' }} value="{{ $country->code }}">{{ $country->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="paystack_currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option {{ $paystack->currency_code == $currency->code ? 'selected' : '' }} value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Rate')}} ({{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="paystack_currency_rate" value="{{ $paystack->currency_rate }}">
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.PayStack Status')}}</label>
                                                                    <div>
                                                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Public Key')}}</label>
                                                                    <input type="text" name="paystack_public_key" class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Secret Key')}}</label>
                                                                    <input type="text" name="paystack_secret_key" class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Country Name')}}</label>
                                                                    <select name="paystack_country_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Country')}}
                                                                        </option>
                                                                        @foreach ($countires as $country)
                                                                        <option value="{{ $country->code }}">{{ $country->name }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Name')}}</label>
                                                                    <select name="paystack_currency_name" id="" class="form-control select2">
                                                                        <option value="">{{__('user.Select Currency')}}
                                                                    </option>
                                                                    @foreach ($currencies as $currency)
                                                                    <option value="{{ $currency->code }}">{{ $currency->name }}
                                                                    </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Currency Rate')}} ({{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="paystack_currency_rate">
                                                                </div>
                                                            @endif


                                                            <button class="btn btn-primary">{{__('user.Update')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="instamojoTab" role="tabpanel" aria-labelledby="instamojo-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('doctor.update-instamojo') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            @if ($instamojo)
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Instamojo Status')}}</label>
                                                                    <div>
                                                                        @if ($instamojo->status == 1)
                                                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                            @else
                                                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Account Mode')}}</label>
                                                                    <select name="account_mode" id="account_mode" class="form-control">
                                                                        <option {{ $instamojo->account_mode == 'Sandbox' ? 'selected' : '' }} value="Sandbox">{{__('user.Sandbox')}}</option>
                                                                        <option {{ $instamojo->account_mode == 'Live' ? 'selected' : '' }} value="Live">{{__('user.Live')}}</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Api Key')}}</label>
                                                                    <input type="text" name="api_key" class="form-control" value="{{ $instamojo->api_key }}">
                                                                </div>



                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Auth Token')}}</label>
                                                                    <input type="text" name="auth_token" class="form-control" value="{{ $instamojo->auth_token }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.INR Currency Rate')}} ({{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate" value="{{ $instamojo->currency_rate }}">
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Instamojo Status')}}</label>
                                                                    <div>
                                                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Account Mode')}}</label>
                                                                    <select name="account_mode" id="account_mode" class="form-control">
                                                                        <option value="Sandbox">{{__('user.Sandbox')}}</option>
                                                                        <option value="Live">{{__('user.Live')}}</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Api Key')}}</label>
                                                                    <input type="text" name="api_key" class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Auth Token')}}</label>
                                                                    <input type="text" name="auth_token" class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.INR Currency Rate')}} ({{__('user.per')}} {{ $setting->currency_name }})</label>
                                                                    <input type="text" class="form-control" name="currency_rate">
                                                                </div>
                                                            @endif

                                                            <button class="btn btn-primary">{{__('user.Update')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="bankAccountTab" role="tabpanel" aria-labelledby="bank-account-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('doctor.update-bank') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            @if ($bank)
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Bank Payment Status')}}</label>
                                                                    <div>
                                                                        @if ($bank->status == 1)
                                                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                            @else
                                                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Account Information')}}</label>
                                                                    <textarea name="account_info" id="" cols="30" rows="10" class="text-area-5 form-control">{{ $bank->account_info }}</textarea>
                                                                </div>
                                                            @else
                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Bank Payment Status')}}</label>
                                                                    <div>
                                                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">{{__('user.Account Information')}}</label>
                                                                    <textarea name="account_info" id="" cols="30" rows="10" class="text-area-5 form-control"></textarea>
                                                                </div>
                                                            @endif


                                                            <button class="btn btn-primary">{{__('user.Save')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($bank)
                                            <div class="tab-pane fade" id="cashTab" role="tabpanel" aria-labelledby="cash-tab">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="">{{__('user.Hand Cash')}}</label>
                                                            <div>
                                                                @if ($bank->hand_cash_status == 1)
                                                                    <a onclick="changeCashOnDeliveryStatus()" href="javascript:;">
                                                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </a>
                                                                    @else
                                                                    <a onclick="changeCashOnDeliveryStatus()" href="javascript:;">
                                                                        <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
      </div>

      <script>
        function changeCashOnDeliveryStatus(id){
            var isDemo = "{{ env('APP_VERSION') }}"
            if(isDemo == 0){
                toastr.error('This Is Demo Version. You Can Not Change Anything');
                return;
            }
            $.ajax({
                type:"put",
                data: { _token : '{{ csrf_token() }}' },
                url: "{{ route('doctor.update-cash-on-delivery') }}",
                success:function(response){
                    toastr.success(response)
                },
                error:function(err){
                    console.log(err);

                }
            })
        }
    </script>
@endsection
