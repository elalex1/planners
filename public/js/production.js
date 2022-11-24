$(document).ready(function() {

$('#modal').modal();
  Number.isInteger = Number.isInteger || function(value) {
    return typeof value === "number" &&
           isFinite(value) &&
           Math.floor(value) === value;
};
//var tableArticles = $('#tableArticlesApp').DataTable();
$('#tableApplications').DataTable({
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
$('.selectArticlesApp').select2({

        ajax: {
            url: path_url_objective,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term, // search term
                    page: params.page || 1,
                    articulo_id: this[0].id.split("input-articles-app-")[1]
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
      placeholder: "Seleccione una opción",
      allowClear: true,
      language: "es",
      delay: 1500,
      closeOnSelect: true,
      dropdownParent: $("#mdlArticlesApp")
});

$('.selectArticlesApp').on('change', function (e) {

  var objetivo = this.value;
  var articulo_id = this.name.split("seleccionado-")[1];
  var superficie = document.getElementsByName("superficie")[0].value;
  var post = {};
  post['articulo_id'] = articulo_id;
  post['objetivo'] = objetivo;
  post['superficie'] = superficie;

  $.ajax({
    type: "POST",
    url: path_url_appobjinfo,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    dataType: 'json',
    data: post,
    //contentType: "application/json; charset=utf-8",
    beforeSend: function(x) {
      //$('#loader-img').show();
    },
    success: function(response) {
      var articulo_id = response["articulo_id"];
      var inputdosis = document.getElementById("cantidad-" + articulo_id);
      var tdcarencia = document.getElementById("carencia-" + articulo_id);
      var tdespera = document.getElementById("espera-" + articulo_id);
      inputdosis.setAttribute("placeholder", response["objetivoinfo"][0].dosis_minimo + "-" + response["objetivoinfo"][0].dosis_maximo);
      tdcarencia.innerHTML = response["objetivoinfo"][0].tiempo_carencia;
      tdespera.innerHTML = response["objetivoinfo"][0].tiempo_espera;

    },
    error: function(request, status, error) {

    },
    complete: function(msg) {

    },
  });


});



dataTableApp = $('#tableArticlesApp').DataTable({
  paging: true, responsive: true,
  "language": {
    "searchPlaceholder": "Buscar artículo",
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
   $('.selectArticles').select2({
     escapeMarkup: function (markup) {
         return markup;
     },
//        minimumInputLength: 1,
     placeholder: "Seleccione una opción",
     allowClear: true,
     language: "es",
     delay: 1500,
     dropdownParent: $("#mdlArticlesApp")
   });
   //$('.selectArticles').formSelect();
}
});
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
  });
  $('.timepicker').timepicker({
    twelveHour: false
  });

  $('#slclote').select2({
    ajax: {
      url: path_url_lots,
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
    placeholder: "Seleccione un lote",
    allowClear: true,
    language: "es",
    delay: 1500,
    closeOnSelect: true
  });


  $('#slclote').on('change', function (e) {

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
        var inputrancho = document.getElementById("rancho")
        inputrancho.value = response.results[0].rancho;
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

  $("#formApplication").validate({
    rules: {
      rancho: {
        required: true,
      },
      concepto_produccion: {
        required: true,
      },
      fecha_proceso: {
        required: true,
      },
      hora_proceso: {
        required: true,
      },
      slclote: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      rancho:{
        required: "Completa este campo",
      },
      concepto_produccion:{
        required: "Completa este campo",
      },
      fecha_proceso:{
        required: "Completa este campo",
      },
      hora_proceso:{
        required: "Completa este campo",
      },
      slclote:{
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

      $('#superficie').removeAttr('disabled');
      var post = $('#formApplication').serializeArray();
      $('#superficie').attr('disabled', 'disabled');

      $.ajax({
        type: "POST",
        url: path_url_submit_app,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {

        },
        success: function(response) {

          var concepto_produccion = document.getElementsByName("concepto_produccion")[0].value;
          //Si no es un número, es un error de la bd
          if (isNaN(response.docto_produccion_id)) {
            M.toast({ html: response.docto_produccion_id });
          }else{
            M.toast({ html: 'Aplicación guardada' });
              document.location.href="edit/" + response.docto_produccion_id;
          }
        },
        error: function(request, status, error) {
          console.log(error);
        },
        complete: function(msg) {}
      });
    }
  });

  $('#save-articlesapp').on('click', function() {

    var data = dataTableApp.rows({ selected: true }).data();
    var data2 = dataTableApp.$('input,select').serializeArray();

    //console.log(data);
    //console.log(data2);
    var arreglo = new Object();
    var largo = data2.length;

    if (largo > 0) {
      for (var i = 0; i < largo; i++) {

        if (data2[i].value != '') {
          var str = data2[i].name;
          var res = str.split("-");

          if (typeof arreglo[res[1]] == 'undefined') {
            arreglo[res[1]] = {};
            arreglo[res[1]][res[0]] = data2[i].value;
            // arreglo[res[1]] = data2[i].value;


          } else {
            arreglo[res[1]][res[0]] = data2[i].value;
            //arreglo[res[1]] = data2[i].value;

          }

        }
      } //endfor

      //console.log(arreglo);
      var index = 0;
      var datosf = {};

      for (var clave in arreglo) {
        if (arreglo[clave].hasOwnProperty('cantidad')) {
          datosf[clave] = arreglo[clave];
        }
      }


      $.ajax({
        type: "POST",
        url: path_url_submitarticles_app,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { jsonArticles: JSON.stringify(datosf) },
        //dataType: 'json',
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {

        },
        success: function(response) {
          if (response.length != 0) {

            M.toast({ html: response[0].Respuesta })

          }else{
            M.toast({ html: 'Registro agregado exitosamente' });
            setTimeout(location.reload(), 2000);
          }

        },
        error: function(request, status, error) {
          M.toast({ html: error });
        },
        complete: function(msg) {}
      });
    }

  });



  $(document).on("click", ".view-record-app", function (event) {


    var id = this.getAttribute('id-record');
    var iframe = document.getElementById("if-aplicacion");
    var url = path_url_iframe_app;
    var id_ant = url.substring(url.lastIndexOf('/') + 1);
    url = url.replace(id_ant, id);
    iframe.setAttribute("src", url);
    var elem = document.getElementById("mdl-iframe");
    var modal = M.Modal.getInstance(elem);
    modal.open();

  });

  $('#slc-con-produccion').on('change', function (e) {

    var fecha_obligatoria = this.options[this.selectedIndex].getAttribute('fechaobli');
    var hora_obligatoria = this.options[this.selectedIndex].getAttribute('horaobli');
    if (fecha_obligatoria === 'S') {
      document.getElementById("fechacontent").style.display = "block";
    }else {
      document.getElementById("fechacontent").style.display = "none";
    }
    if (hora_obligatoria === 'S') {
      document.getElementById("horacontent").style.display = "block";
    }else {
      document.getElementById("horacontent").style.display = "none";
    }

  });

  $(document).on("click", ".edit-record-app", function (event) {
    var produccion_id = this.getAttribute('id-record');
    document.location.href="aplicacion/edit/" + produccion_id;
  });

  $(document).on("click", ".delete-record-app", function (event) {
    var articulo = this.getAttribute('id-record');
    var docto_produccion_id = this.getAttribute('id-asign');
    var post = {};
    post['articulo_nombre'] = articulo;
    post['docto_produccion_id'] = docto_produccion_id;

    $.ajax({
      type: "POST",
      url: "/erp-web/aplicacion/deletearticle",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: post,
      dataType: 'json',
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
        $('#tblArticlesStatic').hide();
        $('#loader-articles').show();
      },
      success: function(response) {

        M.toast({ html: response[0].Respuesta });
        if ((response[0].Respuesta).includes("Se Eliminó el artículo")) {
          setTimeout(location.reload(), 2000);
        } else{
          $('#tblArticlesStatic').show();
          $('#loader-articles').hide();
        }

      },
      error: function(request, status, error) {
        console.log(error);
      },
      complete: function(msg) {

      }
    });


  });

  $("#formAplicador").validate({
    rules: {
      aplicador: {
        required: true,
      },
      horas: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      aplicador:{
        required: "Completa este campo",
      },
      horas:{
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
      var path = window.location.pathname;
      var post = $("#formAplicador").serializeArray();
      var docto_produccion_id = path.substring(path.lastIndexOf('/') + 1);
      var element = {};
      element.name = 'docto_produccion_id';
      element.value = docto_produccion_id;
      post.push(element);

      $.ajax({
        type: "POST",
        url: path_url_submit_aplicador,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {

        },
        success: function(response) {


          M.toast({ html: response[0].Respuesta });
          if ((response[0].Respuesta).includes("Se agrego exitósamente")) {
            document.getElementById("save-aplicador").disabled = true;
          }



        },
        error: function(request, status, error) {
          console.log(error);
        },
        complete: function(msg) {}
      });
    }
  });

  $("#finaliza-aplicacion").on('click', function() {
    var path = window.location.pathname;
    var produccion_id = path.substring(path.lastIndexOf('/') + 1);

    $.ajax({
      type: "POST",
      url: path_url_appapplication,
      dataType: 'json',

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {produccion_id: produccion_id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {

      },
      success: function(response) {
        M.toast({ html: response[0].Respuesta });
        if ((response[0].Respuesta).includes("Documento aplicado correctamente")) {
          document.location.href="/erp-web/aplicacion";
        }


      },
      error: function(request, status, error) {
        M.toast({ html: error });
      },
      complete: function(msg) {}
    });

  });


  $("#formReceta").validate({
    rules: {
      fecha_proceso: {
        required: true,
      },
      hora_proceso: {
        required: true,
      },
      aplicador: {
        required: true,
      },
      via_aplicacion: {
        required: true,
      },
      horas: {
        required: true,
      },
      pozo: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      fecha_proceso:{
        required: "Completa este campo",
      },
      hora_proceso:{
        required: "Completa este campo",
      },
      aplicador:{
        required: "Completa este campo",
      },
      via_aplicacion:{
        required: "Completa este campo",
      },
      horas:{
        required: "Completa este campo",
      },
      pozo:{
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

      document.getElementsByName("concepto_produccion")[0].disabled = false;
      document.getElementsByName("receta")[0].disabled = false;
      var post = $('#formReceta').serializeArray();
      document.getElementsByName("concepto_produccion")[0].disabled = true;
      document.getElementsByName("receta")[0].disabled = true;

      $.ajax({
        type: "POST",
        url: path_url_appreceta,
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
          if (isNaN(response[0].Proceso)) {
            M.toast({ html: response[0].Proceso });
          }else{
            M.toast({ html: 'Aplicación existosa' });
              document.location.href="/erp-web/aplicacion";
          }
        },
        error: function(request, status, error) {
          console.log(error);
        },
        complete: function(msg) {}
      });
    }
  });


  $('#tableBitacora').DataTable( {
      responsive: true,
       dom: 'Bfrtip',
       buttons: [
           'copy', 'excel', 'pdf', 'print'
       ]
   } );

   $('#tableReporteAplicaciones').DataTable( {
       responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    } );


   $('#slclotebitacora').select2({

     ajax: {
       url: path_url_lots,
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
     placeholder: "Seleccione un lote",
     allowClear: true,
     language: "es",
     delay: 1500,
     closeOnSelect: true,
     value: function (){
       var url = window.location.pathname;
       var id = url.substring(url.lastIndexOf('/') + 1);
     },
     "drawCallback": function() {

      //$('.selectArticles').formSelect();
   }
   });


   $('#slclotebitacora').on('change', function (e) {
     document.location.href= this.value;
   });
   $("#formDateBitaAgro").validate({
     rules: {
       fechaibitacora: {
         required: true,
       },
       fechafbitacora: {
         required: true,
       },
     },
     //For custom messages
     messages: {
       fechaibitacora:{
         required: "Completa este campo",
       },
       fechafbitacora:{
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

       var post = $('#formDateBitaAgro').serializeArray();
       document.location.href= "fecha_inicial=" + post[0].value + "&fecha_final=" + post[1].value;
       //document.location.href="/aplicacion/bitacoraplaguicida/" + post[0].value + "/" + post[1].value;

       // $.ajax({
       //   type: "POST",
       //   url: path_url_searchbitagr,
       //   dataType: 'json',
       //   headers: {
       //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       //   },
       //   data: post,
       //   //contentType: "application/json; charset=utf-8",
       //   beforeSend: function(x) {
       //
       //   },
       //   success: function(response) {
       //     document.location.href= "/" + post[0].value;
       //     //document.location.href="aplicacion/edit/" + post;
       //
       //   },
       //   error: function(request, status, error) {
       //     console.log(error);
       //   },
       //   complete: function(msg) {}
       // });
     }
   });

   $('#slclotebitacora').val((window.location.pathname).substring(window.location.pathname.lastIndexOf('/') + 1));

   $('#tablefertilizantenpk').DataTable( {
       responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    } );

   $('#slclotenpk').select2({

     ajax: {
       url: path_url_lots,
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
     placeholder: "Seleccione un lote",
     allowClear: true,
     language: "es",
     delay: 1500,
     closeOnSelect: true,
     value: function (){
       var url = window.location.pathname;
       var id = url.substring(url.lastIndexOf('/') + 1);
     },
     "drawCallback": function() {

      //$('.selectArticles').formSelect();
   }
   });

   $('#slclotenpk').on('change', function (e) {
     document.location.href= this.value;
   });

   $('#slclotenpk').val((window.location.pathname).substring(window.location.pathname.lastIndexOf('/') + 1));



});
