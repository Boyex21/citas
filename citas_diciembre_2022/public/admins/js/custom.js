/*
=========================================
|                                       |
|           Scroll To Top               |
|                                       |
=========================================
*/ 
$('.scrollTop').click(function() {
  $("html, body").animate({scrollTop: 0});
});


$('.navbar .dropdown.notification-dropdown > .dropdown-menu, .navbar .dropdown.message-dropdown > .dropdown-menu ').click(function(e) {
  e.stopPropagation();
});

/*
=========================================
|                                       |
|       Multi-Check checkbox            |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

  var checker = $('#' + clickchk);
  var multichk = $('.' + relChkbox);


  checker.click(function () {
    multichk.prop('checked', $(this).prop('checked'));
  });    
}


/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

/*
    This MultiCheck Function is recommanded for datatable
    */

    function multiCheck(tb_var) {
      tb_var.on("change", ".chk-parent", function() {
        var e=$(this).closest("table").find("td:first-child .child-chk"), a=$(this).is(":checked");
        $(e).each(function() {
          a?($(this).prop("checked", !0), $(this).closest("tr").addClass("active")): ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
        })
      }),
      tb_var.on("change", "tbody tr .new-control", function() {
        $(this).parents("tr").toggleClass("active")
      })
    }

/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

  var checker = $('#' + clickchk);
  var multichk = $('.' + relChkbox);


  checker.click(function () {
    multichk.prop('checked', $(this).prop('checked'));
  });    
}

/*
=========================================
|                                       |
|               Tooltips                |
|                                       |
=========================================
*/

$('.bs-tooltip').tooltip();

/*
=========================================
|                                       |
|               Popovers                |
|                                       |
=========================================
*/

$('.bs-popover').popover();


/*
================================================
|                                              |
|               Rounded Tooltip                |
|                                              |
================================================
*/

$('.t-dot').tooltip({
  template: '<div class="tooltip status rounded-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
})


/*
================================================
|            IE VERSION Dector                 |
================================================
*/

function GetIEVersion() {
  var sAgent = window.navigator.userAgent;
  var Idx = sAgent.indexOf("MSIE");

  // If IE, return version number.
  if (Idx > 0) 
    return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));

  // If IE 11 then look for Updated user agent string.
  else if (!!navigator.userAgent.match(/Trident\/7\./)) 
    return 11;

  else
    return 0; //It is not IE
}

//////// Scripts ////////
function errorNotification() {
  Lobibox.notify('error', {
    title: 'Error',
    sound: true,
    msg: 'Ha ocurrido un problema, inténtelo de nuevo.'
  });
}

$(document).ready(function() {
  //Validación para introducir solo números
  $('.number, #phone').keypress(function() {
    return event.charCode >= 48 && event.charCode <= 57;
  });
  //Validación para introducir solo letras y espacios
  $('#name, #lastname, .only-letters').keypress(function() {
    return event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122 || event.charCode==32;
  });
  //Validación para solo presionar enter y borrar
  $('.date').keypress(function() {
    return event.charCode == 32 || event.charCode == 127;
  });

  //select2
  if ($('.select2').length) {
    $('.select2').select2({
      language: "es",
      placeholder: "Seleccione",
      tags: true
    });
  }

  //Datatables normal
  if ($('.table-normal').length) {
    $('.table-normal').DataTable({
      "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>><'table-responsive'tr><'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
      "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Resultados del _START_ al _END_ de un total de _TOTAL_ registros",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sProcessing":     "Procesando...",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún resultado disponible en esta tabla",
        "sInfoEmpty":      "No hay resultados",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      },
      "stripeClasses": [],
      "lengthMenu": [10, 20, 50, 100, 200, 500],
      "pageLength": 10
    });
  }

  if ($('.table-export').length) {
    $('.table-export').DataTable({
      dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
      buttons: {
        buttons: [
        { extend: 'copy', className: 'btn' },
        { extend: 'csv', className: 'btn' },
        { extend: 'excel', className: 'btn' },
        { extend: 'print', className: 'btn' }
        ]
      },
      "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Resultados del _START_ al _END_ de un total de _TOTAL_ registros",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sProcessing":     "Procesando...",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún resultado disponible en esta tabla",
        "sInfoEmpty":      "No hay resultados",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
          "copy": "Copiar",
          "print": "Imprimir"
        }
      },
      "stripeClasses": [],
      "lengthMenu": [10, 20, 50, 100, 200, 500],
      "pageLength": 10
    });
  }

  //dropify para input file más personalizado
  if ($('.dropify').length) {
    $('.dropify').dropify({
      messages: {
        default: 'Arrastre y suelte una imagen o da click para seleccionarla',
        replace: 'Arrastre y suelte una imagen o haga click para reemplazar',
        remove: 'Remover',
        error: 'Lo sentimos, el archivo es demasiado grande'
      },
      error: {
        'fileSize': 'El tamaño del archivo es demasiado grande ({{ value }} máximo).',
        'minWidth': 'El ancho de la imagen es demasiado pequeño ({{ value }}}px mínimo).',
        'maxWidth': 'El ancho de la imagen es demasiado grande ({{ value }}}px máximo).',
        'minHeight': 'La altura de la imagen es demasiado pequeña ({{ value }}}px mínimo).',
        'maxHeight': 'La altura de la imagen es demasiado grande ({{ value }}px máximo).',
        'imageFormat': 'El formato de imagen no está permitido (Debe ser {{ value }}).'
      }
    });
  }

  //datepicker material
  if ($('.dateMaterial').length) {
    $('.dateMaterial').bootstrapMaterialDatePicker({
      lang : 'es',
      time: false,
      cancelText: 'Cancelar',
      clearText: 'Limpiar',
      format: 'DD-MM-YYYY',
      maxDate : new Date()
    });
  }

  // flatpickr
  if ($('#flatpickr').length) {
    flatpickr(document.getElementById('flatpickr'), {
      locale: 'es',
      enableTime: false,
      dateFormat: "d-m-Y",
      maxDate : "today"
    });
  }

  if ($('#flatpickrDateMin').length) {
    flatpickr(document.getElementById('flatpickrDateMin'), {
      locale: 'es',
      enableTime: false,
      dateFormat: "d-m-Y",
      minDate : "today"
    });
  }

  if ($('#flatpickrStartTime').length && $('#flatpickrEndTime').length) {
    var flatpickrStart=flatpickr(document.getElementById('flatpickrStartTime'), {
      locale: 'es',
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      time_24hr: true,
      minTime: "00:00",
      maxTime: "23:59",
      disableMobile: "true"
    });

    var flatpickrEnd=flatpickr(document.getElementById('flatpickrEndTime'), {
      locale: 'es',
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      time_24hr: true,
      minTime: "00:00",
      maxTime: "23:59",
      disableMobile: "true"
    });
  }

  //touchspin
  if ($('.int-positive').length) {
    $(".int-positive").TouchSpin({
      min: 1,
      max: 999999999,
      buttondown_class: 'btn btn-primary pt-2 pb-3',
      buttonup_class: 'btn btn-primary pt-2 pb-3'
    });
  }

  // Dmuploader
  if ($('#documents-files').length) {
    $('#documents-files').dmUploader({
      url: '/admin/documentos/archivo',
      maxFileSize: 20000000,
      allowedTypes: "*",
      extFilter: ["jpg", "jpeg", "png", "webp", "pdf"],
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      onDragEnter: function(){
        this.addClass('active');
      },
      onDragLeave: function(){
        this.removeClass('active');
      },
      onBeforeUpload: function(){
        $('button[type="submit"]').attr('disabled', true);
        $("#response").text('Subiendo Archivo...');
      },
      onUploadSuccess: function(id, data){
        var obj=data;

        if (obj.status) {
          $("#files").append($('<div>', {
            'class': 'form-group col-lg-3 col-md-3 col-sm-6 col-12',
            'element': id
          }).append($('<div>', {
            'class': 'card'
          }).append($('<div>', {
            'class': 'card-body p-2'
          }).append($('<i>', {
            'class': 'fa fa-2x fa-file mb-2'
          })).append($('<p>', {
            'text': obj.name,
            'class': 'text-truncate mb-0'
          }))).append($('<input>', {
            'type': 'hidden',
            'name': 'files[]',
            'value': obj.name
          })).append($('<button>', {
            'type': 'button',
            'class': 'btn btn-danger btn-absolute-right',
            'file': id,
            'urlFile': '/admins/img/documents/'+obj.name,
            'onclick': 'deleteFileCreate("'+id+'");'
          }).append('<i class="fa fa-trash">'))));

          $('button[type="submit"]').attr('disabled', false);
          $("#response").text('Correcto');
        } else {
          $('button[type="submit"]').attr('disabled', false);
          $("#response").text('Error');
        }
      },
      onUploadError: function(id, xhr, status, message){  
        $('button[type="submit"]').attr('disabled', false);
        $("#response").text('Error');
      },
      onFileSizeError: function(file){
        $('button[type="submit"]').attr('disabled', false);
        $("#response").text('El archivo \'' + file.name + '\' excede el tamaño máximo permitido.');
      }
    });
  }

  if ($('#document-files-edit').length) {
    $('#document-files-edit').dmUploader({
      url: '/admin/documentos/archivo/editar',
      maxFileSize: 20000000,
      allowedTypes: "*",
      extFilter: ["jpg", "jpeg", "png", "webp", "pdf"],
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      extraData: function() {
        return {
          "id": $('#id').val()
        };
      },
      onDragEnter: function(){
        this.addClass('active');
      },
      onDragLeave: function(){
        this.removeClass('active');
      },
      onBeforeUpload: function(){
        $('button[type="submit"]').attr('disabled', true);
        $("#response").text('Subiendo Archivo...');
      },
      onUploadSuccess: function(id, data){
        var obj=data;

        if (obj.status) {
          $("#files").append($('<div>', {
            'class': 'form-group col-lg-3 col-md-3 col-sm-6 col-12',
            'element': id
          }).append($('<div>', {
            'class': 'card'
          }).append($('<div>', {
            'class': 'card-body p-2'
          }).append($('<i>', {
            'class': 'fa fa-2x fa-file mb-2'
          })).append($('<p>', {
            'text': obj.name,
            'class': 'text-truncate mb-0'
          }))).append($('<button>', {
            'type': 'button',
            'class': 'btn btn-danger btn-absolute-right removeFile',
            'file': id,
            'urlFile': obj.url
          }).append('<i class="fa fa-trash">'))));
          $('button[type="submit"]').attr('disabled', false);
          $("#response").text('Correcto');
          Lobibox.notify('success', {
            title: 'Registro exitoso',
            sound: true,
            msg: 'El archivo ha sido agregado exitosamente.'
          });

          // Function to delete files
          $('.removeFile').on('click', function(event) {
            removeFile($(this), event);
          });
        } else {
          $('button[type="submit"]').attr('disabled', false);
          $("#response").text('Error');
          Lobibox.notify('error', {
            title: 'Registro Fallido',
            sound: true,
            msg: 'Ha ocurrido un problema, intentelo nuevamente.'
          });
        }
      },
      onUploadError: function(id, xhr, status, message){  
        $('button[type="submit"]').attr('disabled', false);
        $("#response").text('Error');
        Lobibox.notify('error', {
          title: 'Registro Fallido',
          sound: true,
          msg: 'Ha ocurrido un problema, intentelo nuevamente.'
        });
      },
      onFileSizeError: function(file){
        $('button[type="submit"]').attr('disabled', false);
        $("#response").text('El archivo \'' + file.name + '\' excede el tamaño máximo permitido.');
      }
    });
  }
});

// funcion para cambiar el input hidden al cambiar el switch de estado
$('#stateCheckbox').change(function(event) {
  if ($(this).is(':checked')) {
    $('#stateHidden').val(1);
  } else {
    $('#stateHidden').val(0);
  }
});

//funciones para desactivar y activar
function deactiveUser(slug) {
  $("#deactiveUser").modal();
  $('#formDeactiveUser').attr('action', '/admin/usuarios/' + slug + '/desactivar');
}

function activeUser(slug) {
  $("#activeUser").modal();
  $('#formActiveUser').attr('action', '/admin/usuarios/' + slug + '/activar');
}

function deactiveDoctor(slug) {
  $("#deactiveDoctor").modal();
  $('#formDeactiveDoctor').attr('action', '/admin/doctores/' + slug + '/desactivar');
}

function activeDoctor(slug) {
  $("#activeDoctor").modal();
  $('#formActiveDoctor').attr('action', '/admin/doctores/' + slug + '/activar');
}

function deactiveSecretary(slug) {
  $("#deactiveSecretary").modal();
  $('#formDeactiveSecretary').attr('action', '/admin/secretarias/' + slug + '/desactivar');
}

function activeSecretary(slug) {
  $("#activeSecretary").modal();
  $('#formActiveSecretary').attr('action', '/admin/secretarias/' + slug + '/activar');
}

function deactivePatient(slug) {
  $("#deactivePatient").modal();
  $('#formDeactivePatient').attr('action', '/admin/pacientes/' + slug + '/desactivar');
}

function activePatient(slug) {
  $("#activePatient").modal();
  $('#formActivePatient').attr('action', '/admin/pacientes/' + slug + '/activar');
}

function deactiveSpecialty(slug) {
  $("#deactiveSpecialty").modal();
  $('#formDeactiveSpecialty').attr('action', '/admin/especialidades/' + slug + '/desactivar');
}

function activeSpecialty(slug) {
  $("#activeSpecialty").modal();
  $('#formActiveSpecialty').attr('action', '/admin/especialidades/' + slug + '/activar');
}

function deactiveDepartment(slug) {
  $("#deactiveDepartment").modal();
  $('#formDeactiveDepartment').attr('action', '/admin/departamentos/' + slug + '/desactivar');
}

function activeDepartment(slug) {
  $("#activeDepartment").modal();
  $('#formActiveDepartment').attr('action', '/admin/departamentos/' + slug + '/activar');
}

function deactiveMedicine(slug) {
  $("#deactiveMedicine").modal();
  $('#formDeactiveMedicine').attr('action', '/admin/medicinas/' + slug + '/desactivar');
}

function activeMedicine(slug) {
  $("#activeMedicine").modal();
  $('#formActiveMedicine').attr('action', '/admin/medicinas/' + slug + '/activar');
}

function deactiveSchedule(id) {
  $("#deactiveSchedule").modal();
  $('#formDeactiveSchedule').attr('action', '/admin/horarios/' + id + '/desactivar');
}

function activeSchedule(id) {
  $("#activeSchedule").modal();
  $('#formActiveSchedule').attr('action', '/admin/horarios/' + id + '/activar');
}

function deactiveLocation(slug) {
  $("#deactiveLocation").modal();
  $('#formDeactiveLocation').attr('action', '/admin/locaciones/' + slug + '/desactivar');
}

function activeLocation(slug) {
  $("#activeLocation").modal();
  $('#formActiveLocation').attr('action', '/admin/locaciones/' + slug + '/activar');
}

//funciones para preguntar al eliminar
function deleteUser(slug) {
  $("#deleteUser").modal();
  $('#formDeleteUser').attr('action', '/admin/usuarios/' + slug);
}

function deleteDoctor(slug) {
  $("#deleteDoctor").modal();
  $('#formDeleteDoctor').attr('action', '/admin/doctores/' + slug);
}

function deleteSecretary(slug) {
  $("#deleteSecretary").modal();
  $('#formDeleteSecretary').attr('action', '/admin/secretarias/' + slug);
}

function deletePatient(slug) {
  $("#deletePatient").modal();
  $('#formDeletePatient').attr('action', '/admin/pacientes/' + slug);
}

function deleteAppointment(id) {
  $("#deleteAppointment").modal();
  $('#formDeleteAppointment').attr('action', '/admin/citas/' + id);
}

function deleteDocument(id) {
  $("#deleteDocument").modal();
  $('#formDeleteDocument').attr('action', '/admin/documentos/' + id);
}

function deleteSpecialty(slug) {
  $("#deleteSpecialty").modal();
  $('#formDeleteSpecialty').attr('action', '/admin/especialidades/' + slug);
}

function deleteDepartment(slug) {
  $("#deleteDepartment").modal();
  $('#formDeleteDepartment').attr('action', '/admin/departamentos/' + slug);
}

function deleteMedicine(slug) {
  $("#deleteMedicine").modal();
  $('#formDeleteMedicine').attr('action', '/admin/medicinas/' + slug);
}

function deleteSchedule(id) {
  $("#deleteSchedule").modal();
  $('#formDeleteSchedule').attr('action', '/admin/horarios/' + id);
}

function deleteLocation(slug) {
  $("#deleteLocation").modal();
  $('#formDeleteLocation').attr('action', '/admin/locaciones/' + slug);
}

function deleteRole(id) {
  $("#deleteRole").modal();
  $('#formDeleteRole').attr('action', '/admin/roles/' + id);
}

// funciones adicionales para preguntar
function scheduleDoctor(id, schedules) {
  $("#formScheduleDoctor select[name='schedule_id[]'] option").attr('selected', false);
  $(".selectpicker").selectpicker("refresh");
  for (var i=0; i<schedules.length; i++) {
    $("#formScheduleDoctor select[name='schedule_id[]'] option[value='"+schedules[i]+"']").attr('selected', true);
  }
  $(".selectpicker").selectpicker("refresh");
  $("#scheduleDoctor").modal();
  $('#formScheduleDoctor').attr('action', '/admin/doctores/' + id + '/horarios');
}

function attendAppointment(id) {
  $("#attendAppointment").modal();
  $('#formAttendAppointment').attr('action', '/admin/citas/' + id + '/atender');
}

function cancelAppointment(id) {
  $("#cancelAppointment").modal();
  $('#formCancelAppointment').attr('action', '/admin/citas/' + id + '/cancelar');
}

function permissionRole(id, permissions) {
  $("#formPermissionRole select[name='permission_id[]'] option").attr('selected', false);
  $(".selectpicker").selectpicker("refresh");
  for (var i=0; i<permissions.length; i++) {
    $("#formPermissionRole select[name='permission_id[]'] option[value='"+permissions[i]+"']").attr('selected', true);
  }
  $(".selectpicker").selectpicker("refresh");
  $("#permissionRole").modal();
  $('#formPermissionRole').attr('action', '/admin/roles/' + id + '/permisos');
}

// Function to delete files
function deleteFileCreate(file){
  $("div[element="+file+"]").remove();
}

// Function to delete files
$('.removeFile').click(function(event) {
  removeFile($(this), event);
});

function removeFile(element, event) {
  var file=element.attr('file'), id=$('#id').val(), urlFile=event.currentTarget.attributes[3].value;
  urlFile=urlFile.split('/');
  if (id!="") {
    $.ajax({
      url: '/admin/documentos/archivo/eliminar',
      type: 'POST',
      dataType: 'json',
      data: {id: id, url: urlFile[6]},
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
    .done(function(obj) {
      if (obj.status) {
        $("div[element='"+file+"']").remove();
        Lobibox.notify('success', {
          title: 'Eliminación Exitosa',
          sound: true,
          msg: 'El archivo ha sido eliminado exitosamente.'
        });
      } else {
        Lobibox.notify('error', {
          title: 'Eliminación Fallida',
          sound: true,
          msg: 'Ha ocurrido un problema, intentelo nuevamente.'
        });
      }
    })
    .fail(function() {
      errorNotification();
    });
  }
}