@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Achievement')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Edit Achievement')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.achievement.index') }}">{{__('admin.Achievement')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Edit Achievement')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.achievement.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Achievements')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.achievement.update',$achievement->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="title" class="form-control"  name="title" value="{{ $achievement->title }}">
                                </div>
                                <div class="form-group col-12">
                                    <label>{{__('admin.Icon')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="slug" class="form-control custom-icon-picker"  name="icon" value="{{ $achievement->icon }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Qty')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="qty" class="form-control"  name="qty" value="{{ $achievement->qty }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option {{ $achievement->status == 1 ? 'selected' : '' }} value="1">{{__('admin.Active')}}</option>
                                        <option {{ $achievement->status == 0 ? 'selected' : '' }} value="0">{{__('admin.Inactive')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Update')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

@endsection
