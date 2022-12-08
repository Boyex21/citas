@extends('doctor.layout')
@section('title')
<title>{{__('user.Review')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Review')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Review')}}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('user.SN')}}</th>
                                    <th>{{__('user.Patient')}}</th>
                                    <th>{{__('user.Rating')}}</th>
                                    <th>{{__('user.Comment')}}</th>
                                    <th>{{__('user.Status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $index => $review)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $review->user->name }}</td>
                                        <td>{{ $review->rating }}</td>
                                        <td>{!! clean($review->comment) !!}</td>
                                        <td>
                                            @if($review->status == 1)
                                                <span class="badge badge-success">{{__('user.Active')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{__('user.Inactive')}}</span>
                                            @endif

                                        </td>

                                    </tr>
                                  @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

@endsection
