@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Chamber List')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Chamber List')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Chamber List')}}</div>
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
                                    <th >{{__('admin.SN')}}</th>
                                    <th >{{__('admin.Name')}}</th>
                                    <th >{{__('admin.Address')}}</th>
                                    <th >{{__('admin.Author')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($chambers as $index => $chamber)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $chamber->name }}</td>
                                        <td>{{ $chamber->address }}</td>
                                        <td>{{ $chamber->doctor->name }}</td>
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