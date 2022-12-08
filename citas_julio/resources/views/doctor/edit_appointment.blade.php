@extends('doctor.layout')
@section('title')
<title>{{__('user.Appointment')}}</title>
@endsection

@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Appointment')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Appointment')}}</div>
            </div>
          </div>

            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    @php
                                        $user = $appointment->user;
                                    @endphp
                                    <div class="col-md-6">
                                        <address>
                                            <strong>{{__('user.Patient Information')}}:</strong><br>
                                            {{ $user->name }}<br>
                                            @if ($user->email)
                                            {{ $user->email }}<br>
                                            @endif
                                            @if ($user->phone)
                                            {{ $user->phone }}<br>
                                            @endif
                                            {{__('user.Age')}} : {{ $user->age }}<br>
                                            {{__('user.Weight')}} : {{ $user->weight }}<br>
                                        </address>
                                    </div>

                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>{{__('user.Appointment Information')}}:</strong><br>
                                            {{__('user.Chamber')}}: {{ $appointment->chamber->name }}<br>
                                            {{__('user.Date')}}: {{ date('d F, Y', strtotime($appointment->date)) }}<br>
                                            {{__('user.Schedule')}} : {{ date('h:i A', strtotime($appointment->schedule->start_time)) }} - {{ date('h:i A', strtotime($appointment->schedule->end_time)) }} <br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="hiddenPrescribeRow" class="vh d-none">
                <div id="delete-prescribe-row">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">{{__('user.Medicine')}}</label>
                                <select name="medicines[]" id="medicine_hidden_id" class="form-control">
                                    <option value="">{{__('user.Select')}}</option>
                                    @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->name }}">{{ $medicine->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">{{__('user.Dosage')}}</label>
                                <select name="dosages[] id="" class="form-control">
                                    <option value="0-0-0">0-0-0</option>
                                    <option value="0-0-1">0-0-1</option>
                                    <option value="0-1-0">0-1-0</option>
                                    <option value="0-1-1">0-1-1</option>
                                    <option value="1-0-0">1-0-0</option>
                                    <option value="1-0-1">1-0-1</option>
                                    <option value="1-1-0">1-1-0</option>
                                    <option value="1-1-1">1-1-1</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">{{__('user.Day')}}</label>
                                <select name="days[]" id="" class="form-control">
                                    @for($i=1;$i<=90;$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2" >
                            <div class="form-group">
                                <label for="">{{__('user.Time')}}</label>
                                <select name="times[]" id="" class="form-control">
                                    <option value="{{__('user.After Meal')}}">{{__('user.After Meal')}}</option>
                                    <option value="{{__('user.Before Meal')}}">{{__('user.Before Meal')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3" >
                            <div class="form-group">
                                <label for="">{{__('user.Comment')}}</label>
                                <input type="text" name="comments[]" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-1 add_btn" >
                            <button type="button" id="removePrescribeRow" class="btn btn-danger"><i class="fas fa-trash" aria-hidden="true"></i></button>
                        </div>

                    </div>
                </div>
            </div>

            <form action="{{ route('doctor.update-prescription', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="section-body">
                    <div class="row mt-4">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{__('user.Physical Information')}}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">{{__('user.Blood Pressure')}}</label>
                                                <input type="text" class="form-control" name="blood_pressure" value="{{ $appointment->blood_pressure }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">{{__('user.Pulse Rate')}}</label>
                                                <input type="text" class="form-control" name="pulse_rate" value="{{ $appointment->pulse_rate }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">{{__('user.Temperature')}}</label>
                                                <input type="text" class="form-control" name="temperature" value="{{ $appointment->temperature }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">{{__('user.Problem Description')}}</label>
                                                <textarea name="problem_description" class="form-control text-area-3" id="" cols="30" rows="10">{{ $appointment->problem_description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row mt-4">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <button type="button" data-toggle="modal" data-target="#createMedicine" class="btn btn-primary float-end"><i class="fa fa-plus" aria-hidden="true"></i> {{__('user.New Medicine')}}</button>
                                </div>
                                <div class="card-body" id="medicineRow">
                                    @foreach ($appointment->prescribes as $prescribe)
                                        <div class="row old-prescribe-{{ $prescribe->id }}">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="">{{__('user.Medicine')}}</label>
                                                    <select name="medicines[]" id="medicine_id" class="form-control">
                                                        <option value="">{{__('user.Select')}}</option>
                                                        @foreach ($medicines as $medicine)
                                                        <option {{ $medicine->name == $prescribe->medicine_name ? 'selected' : '' }} value="{{ $medicine->name }}">{{ $medicine->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="">{{__('user.Dosage')}}</label>
                                                    <select name="dosages[] id="" class="form-control">
                                                        <option {{ $prescribe->dosage=='0-0-0' ? 'selected':'' }} value="0-0-0">0-0-0</option>
                                                        <option {{ $prescribe->dosage=='0-0-1' ? 'selected':'' }} value="0-0-1">0-0-1</option>
                                                        <option {{ $prescribe->dosage=='0-1-0' ? 'selected':'' }} value="0-1-0">0-1-0</option>
                                                        <option {{ $prescribe->dosage=='0-1-1' ? 'selected':'' }} value="0-1-1">0-1-1</option>
                                                        <option {{ $prescribe->dosage=='1-0-0' ? 'selected':'' }} value="1-0-0">1-0-0</option>
                                                        <option {{ $prescribe->dosage=='1-0-1' ? 'selected':'' }} value="1-0-1">1-0-1</option>
                                                        <option {{ $prescribe->dosage=='1-1-0' ? 'selected':'' }} value="1-1-0">1-1-0</option>
                                                        <option {{ $prescribe->dosage=='1-1-1' ? 'selected':'' }} value="1-1-1">1-1-1</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="">{{__('user.Day')}}</label>
                                                    <select name="days[]" id="" class="form-control">
                                                        @for($i=1;$i<=90;$i++)
                                                        <option {{ $prescribe->number_of_day==$i ? 'selected' :'' }} value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2" >
                                                <div class="form-group">
                                                    <label for="">{{__('user.Time')}}</label>
                                                    <select name="times[]" id="" class="form-control">
                                                        <option {{ $prescribe->time== trans('After Meal') ? "selected" : "" }} value="{{__('user.After Meal')}}">{{__('user.After Meal')}}</option>
                                                        <option {{ $prescribe->time== trans('Before Meal') ? "selected" : "" }} value="{{__('user.Before Meal')}}">{{__('user.Before Meal')}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3" >
                                                <div class="form-group">
                                                    <label for="">{{__('user.Comment')}}</label>
                                                    <input value="{{ $prescribe->comment }}" type="text" name="comments[]" class="form-control" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-md-1 add_btn" >
                                                <button onclick="oldPrescribeDelete({{ $prescribe->id }})" type="button" class="btn btn-danger"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                            </div>



                                        </div>
                                    @endforeach

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">{{__('user.Medicine')}}</label>
                                                <select name="medicines[]" id="medicine_id" class="form-control">
                                                    <option value="">{{__('user.Select')}}</option>
                                                    @foreach ($medicines as $medicine)
                                                    <option value="{{ $medicine->name }}">{{ $medicine->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">{{__('user.Dosage')}}</label>
                                                <select name="dosages[] id="" class="form-control">
                                                    <option value="0-0-0">0-0-0</option>
                                                    <option value="0-0-1">0-0-1</option>
                                                    <option value="0-1-0">0-1-0</option>
                                                    <option value="0-1-1">0-1-1</option>
                                                    <option value="1-0-0">1-0-0</option>
                                                    <option value="1-0-1">1-0-1</option>
                                                    <option value="1-1-0">1-1-0</option>
                                                    <option value="1-1-1">1-1-1</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">{{__('user.Day')}}</label>
                                                <select name="days[]" id="" class="form-control">
                                                    @for($i=1;$i<=90;$i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2" >
                                            <div class="form-group">
                                                <label for="">{{__('user.Time')}}</label>
                                                <select name="times[]" id="" class="form-control">
                                                    <option value="{{__('user.After Meal')}}">{{__('user.After Meal')}}</option>
                                                    <option value="{{__('user.Before Meal')}}">{{__('user.Before Meal')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="">{{__('user.Comment')}}</label>
                                                <input type="text" name="comments[]" class="form-control" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-1 add_btn" >
                                            <button id="addMedicineRow" type="button" class="btn btn-primary"><i class="fas fa-plus" aria-hidden="true"></i></button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row mt-4">
                        <div class="col">
                            <div class="card">
                                <div class="card-body" id="medicineRow">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">{{__('user.Test')}}</label>
                                                <textarea name="test" class="form-control text-area-5" id="" cols="30" rows="10">{{ $appointment->test }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">{{__('user.Advice')}}</label>
                                                <textarea name="advice" class="form-control text-area-5" id="" cols="30" rows="10">{{ $appointment->advice }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">{{__('user.Next Visit')}}</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <select class="custom-select" id="inputGroupSelect01" name="next_visit_qty">
                                                            <option value="">{{__('user.Select')}}</option>
                                                            @for($i=1; $i<=31 ;$i++)
                                                                <option {{ $appointment->next_visit_qty == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <select class="custom-select" id="inputGroupSelect01" name="next_visit_time">
                                                        <option value="">{{__('user.Select')}}</option>
                                                        <option {{ $appointment->next_visit_time == trans('Days') ? 'selected' : '' }} value="{{__('user.Days')}}">{{__('user.Days')}}</option>
                                                        <option {{ $appointment->next_visit_time == trans('Months') ? 'selected' : '' }} value="{{__('user.Months')}}">{{__('user.Months')}}</option>
                                                        <option {{ $appointment->next_visit_time == trans('Years') ? 'selected' : '' }} value="{{__('user.Years')}}">{{__('user.Years')}}</option>
                                                    </select>
                                                  </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">{{__('user.Update')}}</button>
                                            <a href="{{ route('doctor.show-prescription', $appointment->id) }}" type="button" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i> {{__('user.Show')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </section>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="createMedicine" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                      <div class="modal-header">
                              <h5 class="modal-title">{{__('user.New Medicine')}}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                          </div>
                  <div class="modal-body">
                      <div class="container-fluid">
                          <form id="modalMedicineFrom">
                              @csrf
                              <div class="form-group col-12">
                                <label>{{__('user.Name')}} <span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
                            </div>
                            <button class="btn btn-primary">{{__('user.Save')}}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('user.Close')}}</button>
                          </form>
                      </div>
                  </div>

              </div>
          </div>
      </div>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function() {
            // add new prescribe medicine input field
            $("#addMedicineRow").on('click',function () {
                var html=$("#hiddenPrescribeRow").html();
                $("#medicineRow").append(html)
                // $('.select2').select2();
            });

            // remove prescribe medicine input field row
            $(document).on('click', '#removePrescribeRow', function () {
                $(this).closest('#delete-prescribe-row').remove();
            });

            $("#modalMedicineFrom").on('submit', function(e){
                e.preventDefault();
                var isDemo = "{{ env('APP_VERSION') }}"
                if(isDemo == 0){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                $.ajax({
                    url: "{{ route('doctor.medicne-store') }}",
                    type:"post",
                    data:$('#modalMedicineFrom').serialize(),
                    success:function(response){
                        if(response.status == 1){
                            $("#medicine_id").html(response.medicines)
                            $("#medicine_hidden_id").html(response.medicines)
                            $("#modalMedicineFrom").trigger("reset");
                            toastr.success("{{__('user.Created Successfully')}}")
                            $("#createMedicine").modal('hide');
                        }
                    },
                    error:function(response){
                        if(response.responseJSON.errors.name)toastr.error(response.responseJSON.errors.name[0])
                    }
                });

            })
        });
    })(jQuery);

    function oldPrescribeDelete(id){

        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }

        $.ajax({
            type: 'GET',
            url: "{{ url('doctor/delete-appointment-prescribe/') }}"+"/"+ id,
            success: function (response) {
                var old_prescirbe_row="old-prescribe-"+id;
                $("."+old_prescirbe_row).remove()
                toastr.success(response.success);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }


    </script>


@endsection
