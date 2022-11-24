$(document).ready(function() {

$('#modal').modal();
  Number.isInteger = Number.isInteger || function(value) {
    return typeof value === "number" &&
           isFinite(value) &&
           Math.floor(value) === value;
};
//var tableArticles = $('#tableArticlesApp').DataTable();
$('#tableActivities').DataTable({
  paging: true, responsive: true,
  columnDefs: [
  { responsivePriority: 1},
  { responsivePriority: 2},
  { responsivePriority: 3}
],
"order": [[ 0, 'des' ]],
  "language": {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst":    "Primero",
      "sLast":     "Último",
      "sNext":     "Siguiente",
      "sPrevious": "Anterior"
    },
    "oAria": {
      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  },
  "drawCallback": function() {
    $('.tooltipped').tooltip();
  }

});

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('.timepicker').timepicker({
    twelveHour: false
  });

  $('#slccuadrilla').select2({

    ajax: {
      url: path_url_groupsbyterm,
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          term: params.term, // search term
          page: params.page || 1,
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;

        return {
          results: data.results,
          pagination: {
            more: (params.page * 30) < data.results.length
          }
        };
      },
      cache: true
    },
    escapeMarkup: function (markup) {
      return markup;
    },
    //        minimumInputLength: 1,
    placeholder: "Seleccione una cuadrilla",
    allowClear: true,
    language: "es",
    delay: 1500,
    closeOnSelect: true
  });

  $('#slcactividad').select2({

    ajax: {
      url: path_url_activity,
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          term: params.term, // search term
          page: params.page || 1,
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;

        return {
          results: data.results,
          pagination: {
            more: (params.page * 30) < data.results.length
          }
        };
      },
      cache: true
    },
    escapeMarkup: function (markup) {
      return markup;
    },
    //        minimumInputLength: 1,
    placeholder: "Seleccione una actividad",
    allowClear: true,
    language: "es",
    delay: 1500,
    closeOnSelect: true,
    dropdownParent: $("#mdlActivity")
  });

  $('#slcloteact').select2({

    ajax: {
      url: path_url_lots_activity,
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var rancho = document.getElementById("rancho").value;
        return {
          term: params.term, // search term
          page: params.page || 1,
          rancho: rancho,
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;

        return {
          results: data.results,
          pagination: {
            more: (params.page * 30) < data.results.length
          }
        };
      },
      cache: true
    },
    escapeMarkup: function (markup) {
      return markup;
    },
    //        minimumInputLength: 1,
    placeholder: "Seleccione un lote",
    allowClear: true,
    language: "es",
    delay: 1500,
    closeOnSelect: true,
    dropdownParent: $("#mdlActivity")
  });


  $('#slcloteact').on('change', function (e) {

    var lote = this.value;

    $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
      processData: false,
      url: path_url_applotinfo + '/' + lote,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      //data: {lote: lote},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
        //$('#loader-img').show();
      },
      success: function(response) {

        var inputcosecha = document.getElementById("cosecha");
        inputcosecha.value = response.results[0].cosecha;
        var inputsuperficie = document.getElementById("superficie")
        inputsuperficie.value = response.results[0].superficie;
        document.getElementById("lblsuperficie").classList.add("active");
        document.getElementById("lblcosecha").classList.add("active");
        document.getElementById("lblrancho").classList.add("active");
        //console.log(response);
      },
      error: function(request, status, error) {
      },
      complete: function(msg) {}
    });


  });

  $("#formActivity").validate({
    rules: {
      rancho: {
        required: true,
      },
      slccuadrilla: {
        required: true,
      },
      fecha_proceso: {
        required: true,
      },
      hora_proceso: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      rancho:{
        required: "Completa este campo",
      },
      slccuadrilla:{
        required: "Completa este campo",
      },
      fecha_proceso:{
        required: "Completa este campo",
      },
      hora_proceso:{
        required: "Completa este campo",
      },
    },
    errorElement : 'div',
    errorClass: "invalid",
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {

      var post = $('#formActivity').serializeArray();

      $.ajax({
        type: "POST",
        url: path_url_submit_act,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {

        },
        success: function(response) {

          //Si no es un número, es un error de la bd
          if (typeof response[0].listaencabezado !== 'undefined') {
            M.toast({ html: 'Actividad guardada' });
              document.location.href="edit/" + response[0].listaencabezado;
          }else{
            M.toast({ html: response[0].Proceso });
          }
        },
        error: function(request, status, error) {
          console.log(error);
        },
        complete: function(msg) {}
      });
    }
  });

  $("#formActivityLote").validate({
    rules: {
      slcloteact: {
        required: true,
      },
      slcactividad: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      slcloteact:{
        required: "Completa este campo",
      },
      slcactividad:{
        required: "Completa este campo",
      },
    },
    errorElement : 'div',
    errorClass: "invalid",
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {

      var post = $('#formActivityLote').serializeArray();
      var path = window.location.pathname;
      var actividades_empleados_producciones_id = path.substring(path.lastIndexOf('/') + 1);
      var element = {};
      element.name = 'actividades_empleados_producciones_id';
      element.value = actividades_empleados_producciones_id;
      post.push(element);

      $.ajax({
        type: "POST",
        url: path_url_submit_lot_act,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {
        },
        success: function(response) {

          if (typeof response[0].Proceso !== 'undefined') {
            //Si no es un número, es un error de la bd

            if (isNaN(response[0].Proceso)) {
              M.toast({ html: response[0].Proceso });
            }else{
              M.toast({ html: 'Actividad guardada' });
              setTimeout(location.reload(), 2000);
              //document.location.href="/edit/" + actividades_empleados_producciones_id;
            }
          }
        },
        error: function(request, status, error) {
          console.log(error);
        },
        complete: function(msg) {}
      });
    },
  });

  $("#formEmpleado").validate({
    rules: {
      paternod: {
        required: true,
      },
      nombred: {
        required: true,
      },
      rfcd: {
        required: true,
      },
      curpd: {
        required: true,
      },
      fechanacimientod: {
        required: true,
      },
      puestod: {
        required: true,
      },
      departamentod: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      paternod:{
        required: "Completa este campo",
      },
      nombred:{
        required: "Completa este campo",
      },
      rfcd:{
        required: "Completa este campo",
      },
      curpd:{
        required: "Completa este campo",
      },
      fechanacimientod:{
        required: "Completa este campo",
      },
      puestod:{
        required: "Completa este campo",
      },
      departamentod:{
        required: "Completa este campo",
      },
    },
    errorElement : 'div',
    errorClass: "invalid",
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function (form) {

      var post = $('#formEmpleado').serializeArray();
      var dpto = document.getElementById('cuadrilla').value;
      var element = {};
      element.name = 'departamentod';
      element.value = dpto;
      post.push(element);

      $.ajax({
        type: "POST",
        url: path_url_submit_empl,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {
        },
        success: function(response) {

          if (typeof response[0]["last_insert_id()"] !== 'undefined') {
            //Si no es un número, es un error de la bd
            if (isNaN(response[0]["last_insert_id()"])) {
              M.toast({ html: response[0] });
            }else{
              M.toast({ html: 'Empleado guardado' });
              setTimeout(location.reload(), 2000);
              //document.location.href="/edit/" + actividades_empleados_producciones_id;
              }
          }else{
            M.toast({ html: response[0].Respuesta });
          }

        },
        error: function(request, status, error) {
          console.log(error);
        },
        complete: function(msg) {}
      });
    },
  });

  $( ".horas" ).change(function() {
    var horas = this.value;
    var path = window.location.pathname;
    var listaid = path.substring(path.lastIndexOf('/') + 1);
    var post = {};
    var xd = this.getAttribute('x');
    var yd = this.getAttribute('y');
    post['listaid'] = listaid;
    post['xd'] = xd;
    post['yd'] = yd;
    post['horas'] = horas;

    $.ajax({
      type: "POST",
      url: path_url_activity_lista,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      data: post,

      beforeSend: function(x) {
        //$('#loader-img').show();
      },
      success: function(response) {
        if (response.length === 0) {
          M.toast({ html: 'Registro actualizado' })
        }else{
          M.toast({ html: response });
        }

      },
      error: function(request, status, error) {
        M.toast({ html: request.responseText });
      },
      complete: function(msg) {}
    });
  });

  $(document).on("click", ".view-record-act", function (event) {

    var id = this.getAttribute('id-record');
    var iframe = document.getElementById("if-actividad");
    var url = path_url_iframe_act;
    var id_ant = url.substring(url.lastIndexOf('/') + 1);
    url = url.replace(id_ant, id);
    iframe.setAttribute("src", url);
    var elem = document.getElementById("mdl-iframe");
    var modal = M.Modal.getInstance(elem);
    modal.open();

  });



  $("#finaliza-actividad").on('click', function() {
    var path = window.location.pathname;
    var produccion_id = path.substring(path.lastIndexOf('/') + 1);

    $.ajax({
      type: "POST",
      url: path_url_appactivity,
      dataType: 'json',

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {produccion_id: produccion_id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {

      },
      success: function(response) {
        if ((response[1][0]["Proceso Terminado."])) {
          M.toast({ html: response[1][0]["Proceso Terminado."] });
          document.location.href="/erp-web/actividad/manoobra";
        }else{
          M.toast({ html: response[0][0] });
        }


      },
      error: function(request, status, error) {
        M.toast({ html: error });
      },
      complete: function(msg) {}
    });

  });

  $("#auth-activity").on('click', function() {

    var path = window.location.pathname;
    var actividad_id = path.substring(path.lastIndexOf('/') + 1);

    $.ajax({
      type: "POST",
      //url: path_url_auth_act,
      //dataType: 'json',

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {actividad_id: actividad_id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {

      },
      success: function(response) {

          M.toast({ html: response })
          if (response.search("Folio") > 0) {
            SendEmailPDFAuth(requisicion_id);
          setTimeout(  document.location.href="/erp-web/requisicion", 3000);
        }

      },
      error: function(request, status, error) {
        M.toast({ html: error });
      },
      complete: function(msg) {}
    });
  });

  $(document).on("click", ".edit-record-act", function (event) {
    var actividad_id = this.getAttribute('id-record');
    document.location.href="manoobra/edit/" + actividad_id;
  });

  $(document).on("click", ".email-record-act", function (event) {
    var actividad_empleado_produccion_id = this.getAttribute('id-record');
    sendEmailAct(actividad_empleado_produccion_id);
  });


  function sendEmailAct(id) {

    $.ajax({
      type: "POST",
      url: path_url_sendemail_act,
      dataType: 'json',

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {actividad_empleado_produccion_id: id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {

      },
      success: function(response) {
        M.toast({ html: response.data });

      },
      error: function(request, status, error) {
        M.toast({ html: error });
      },
      complete: function(msg) {}
    });
  }





});
