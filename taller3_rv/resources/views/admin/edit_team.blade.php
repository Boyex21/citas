@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Our Partner')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Edit Partner')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.our-partner.index') }}">{{__('admin.Our Partner')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Edit Partner')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.our-partner.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Our Partner')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.our-partner.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Existing Image')}}</label>
                                    <div>
                                        <img src="{{ asset($team->image) }}" alt="" width="150px">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Image')}} <span class="text-danger">*</span></label>
                                    <input type="file" id="title" class="form-control-file"  name="image">
                                </div>

                                <div class="form-group col-12">
                                    <label for="">{{__('admin.Link')}}</label>
                                    <input type="text" class="form-control" name="link" value="{{ $team->link }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option  {{ $team->status == 1 ? 'selected' : '' }} value="1">{{__('admin.Active')}}</option>
                                        <option  {{ $team->status == 0 ? 'selected' : '' }} value="0">{{__('admin.Inactive')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Save')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

<script>
    (function($) {
        "use strict";
        $(document).ready(function () {

            $("#addNewIcon").on("click", function(){
                var html = $("#socialIconHiddenBox").html();
                $("#socialBox").append(html);
                $('.custom-icon-picker').iconpicker({
                templates: {
                    popover: '<div class="iconpicker-popover popover"><div class="arrow"></div>' +
                        '<div class="popover-title"></div><div class="popover-content"></div></div>',
                    footer: '<div class="popover-footer"></div>',
                    buttons: '<button class="iconpicker-btn iconpicker-btn-cancel btn btn-default btn-sm">Cancel</button>' +
                        ' <button class="iconpicker-btn iconpicker-btn-accept btn btn-primary btn-sm">Accept</button>',
                    search: '<input type="search" class="form-control iconpicker-search" placeholder="Type to filter" />',
                    iconpicker: '<div class="iconpicker"><div class="iconpicker-items"></div></div>',
                    iconpickerItem: '<a role="button" href="javascript:;" class="iconpicker-item"><i></i></a>'
                }
            })

            })

            $(document).on('click', '.removeSocialBox', function () {
                $(this).closest('.remove-box').remove();
            });


        });
    })(jQuery);

    function deleteSocialLink(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url: "{{ url('admin/remove-team-social-link/') }}"+"/"+ id,
            success: function (response) {
                if(response.success){
                    toastr.success(response.success)
                    $("#existingSocialLink-"+id).remove()
                }

            },
            error: function(err) {
                console.log(err);
            }
        });
    }
</script>
@endsection
