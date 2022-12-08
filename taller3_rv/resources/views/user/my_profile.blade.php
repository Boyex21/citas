@extends('layout')
@section('title')
    <title>{{__('user.Dashboard')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Dashboard')}}">
@endsection

@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Dashboard')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Dashboard')}}</span></li>
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
                    <h2 class="d-headline">{{__('user.Edit Account')}}</h2>
                    <form action="{{ route('user.update-profile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row row">
                            <div class="form-group col-12">
                                <label>{{__('user.Image')}} </label>
                                <input type="file" class="form-control"  name="image">
                            </div>

                            <div class="form-group col-12">
                                <label>{{__('user.Name')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $user->name }}" name="name">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Email')}} <span class="text-danger">*</span></label>
                                    <input type="email" readonly class="form-control" value="{{ $user->email }}" name="email">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Phone')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->phone }}" name="phone">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Address')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->address }}" name="address">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Age')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->age }}" name="age">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>{{__('user.Weight')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->weight }}" name="weight">
                                </div>


                                <div class="form-group col-md-6 option-item">
                                    <label for="">{{__('user.Gender')}} <span>*</span></label>
                                    <select class="form-control" name="gender">
                                        <option value="">{{__('user.Select Gender')}}</option>
                                        <option {{ trans('Male') == $user->gender ? 'selected' : '' }} value="Male">{{__('user.Male')}}</option>
                                        <option {{ trans('Female') == $user->gender ? 'selected' : '' }} value="Female">{{__('user.Female')}}</option>
                                        <option {{ trans('Others') == $user->gender ? 'selected' : '' }} value="Others">{{__('user.Others')}}</option>
                                    </select>
                                </div>



                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary">{{__('user.Update')}}</button>
                                </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection

