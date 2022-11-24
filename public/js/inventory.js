/*Preloader*/
$(window).on('load', function() {
  setTimeout(function() {
    $('body').addClass('loaded');
  }, 200);


});

$(document).ready(function() {


  $('#tableInventory').DataTable({
    "aaSorting": [],
    paging: true, responsive: true,
    columnDefs: [
    { responsivePriority: 5},
    { responsivePriority: 1},
    { responsivePriority: 2},
],

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

  $("#formInventario").validate({
    rules: {
      concepto_inventario: {
        required: true,
      },
      descripciond: {
        required: true,
      },
      almacend: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      concepto_inventario:{
        required: "Completa este campo",
      },
      descripciond:{
        required: "Completa este campo",
      },
      almacend:{
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

      var post = $('#formInventario').serializeArray();

      $.ajax({
        type: "POST",
        url: path_url_submit_inventory,
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
          if (isNaN(response.id_inventario["last_insert_id()"])) {
            M.toast({ html: response.id_inventario });

          }else{
            M.toast({ html: 'Inventario guardado' });
            document.location.href="./edit/" + response.id_inventario["last_insert_id()"];
          }

        },
        error: function(request, status, error) {
          console.log(error);
        },
        complete: function(msg) {}
      });
    }
  });

  $("#formInventoryEdit").validate({
    rules: {
      descripciond: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      descripciond:{
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
      var post = $('#formInventoryEdit').serializeArray();

      $.ajax({
        type: "POST",
        url: "../update",
        //dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        dataType: 'json',
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {

        },
        success: function(response) {

          if (response.data.length != 0) {

            M.toast({ html: response })

          }else{
            M.toast({ html: 'Inventario actualizado' })
          }

        },
        error: function(request, status, error) {
          M.toast({ html: error })
        },
        complete: function(msg) {}
      });
    }
  });

  dataTableInv = $('#tableArticlesInv').DataTable({
    paging: true, responsive: true,
    'columnDefs': [{
      'targets': 0,
      'searchable': false,
      'orderable': false,
      'className': 'dt-body-center',


    }],
    lengthMenu: [
      [5, 10, 25, -1],
      [5, 10, 25, "All"]
    ],
    pageLength: 10,

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
  }
  });


  $(document).on("click", ".delete-record-inv", function (event) {
    var articulod = this.getAttribute('id-record');
    var inventario_id = this.getAttribute('id-asign');
    var post = {};
    post['articulod'] = articulod;
    post['inventario_id'] = inventario_id;

    $.ajax({
      type: "POST",
      url: "../deletearticle",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: post,
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

  $('#save-articles-inv').on('click', function() {

    var data = dataTableInv.rows({ selected: true }).data();
    var data2 = dataTableInv.$('input,select').serializeArray();

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
        url: path_url_submitarticlesinv,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { jsonArticles: JSON.stringify(datosf) },
        //dataType: 'json',
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {

        },
        success: function(response) {

          if (Number.isInteger(parseInt(response["last_insert_id()"])) || Number.isInteger(parseInt(response["renglondoctoid"]))) {
            M.toast({ html: 'Registro agregado exitosamente' });
            setTimeout(location.reload(), 2000);

          }else{
            M.toast({ html: response });
          }

        },
        error: function(request, status, error) {
          M.toast({ html: error });
        },
        complete: function(msg) {}
      });
    }

  });

  $('.selectCC').select2({
        ajax: {
            url: path_url_costsbytype,
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
        placeholder: "Seleccione una opción",
        allowClear: true,
        language: "es",
        delay: 1500,
        closeOnSelect: true,
  });

  $('#slc-conceptoinventario').on('change', function (e) {

    var concepto = this.value;

    $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
      processData: false,
      url: path_url_requiere_cc + '/' + concepto,
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

        if (response[0].requiere_cc=='S') {
          var selectcc = document.getElementById("slc-cc");
          selectcc.disabled = false;
        }else{

          var selectcc = document.getElementById("slc-cc");
          selectcc.value = null;
          selectcc.disabled = true;
        }

        //console.log(response);
      },
      error: function(request, status, error) {
      },
      complete: function(msg) {}
    });


  });

  $("#finaliza-inventario").on('click', function() {
    var path = window.location.pathname;
    var inventario_id = path.substring(path.lastIndexOf('/') + 1);

    $.ajax({
      type: "POST",
      url: path_url_appinventory,

      dataType: 'json',

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {inventario_id: inventario_id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {

      },
      success: function(response) {
        M.toast({ html: response.data });
        if (response.data == "Documento guardado.") {
          document.location.href="../";
        }


      },
      error: function(request, status, error) {
        M.toast({ html: error });
      },
      complete: function(msg) {}
    });

  });

  $('.modal').modal();
  $('.fixed-action-btn').floatingActionButton();
  $('.tooltipped').tooltip();
  //for right or left click(any)
  $('.tooltipped').mousedown(function(){
    $('.material-tooltip').css("visibility", "hidden");
  });

  // leaving after click in case you open link in new tab
  $('.tooltipped').mouseleave(function(){
    $('.material-tooltip').css("visibility", "hidden");
  });
  $('select').formSelect();



});
