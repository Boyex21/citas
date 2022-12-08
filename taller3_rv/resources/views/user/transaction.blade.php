@extends('layout')
@section('title')
    <title>{{__('user.Transaction')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Transaction')}}">
@endsection

@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Transaction')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Transaction')}}</span></li>
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
                <div class="detail-dashboard add-form">
                    <h2 class="d-headline">{{__('user.Transaction History')}}</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('user.SN')}}</th>
                                    <th>{{__('user.Doctor')}}</th>
                                    <th>{{__('user.Fee')}}</th>
                                    <th>{{__('user.Date')}}</th>
                                    <th>{{__('user.Transaction')}}</th>
                                    <th>{{__('user.Payment Method')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $order->doctor->name }}</td>
                                        <td>{{ $setting->currency_icon }}{{ $order->total_fee }}</td>
                                        <td>{{ $order->created_at->format('d F, Y') }}</td>
                                        <td>{!! clean(nl2br($order->transaction_id)) !!}</td>
                                        <td>{{ $order->payment_method }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection

