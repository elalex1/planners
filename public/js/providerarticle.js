$(document).ready(function() {
  $('#slcproveedor').select2({
    ajax: {
      url: path_url_providers,
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
    placeholder: "Seleccione un proveedor",
    allowClear: true,
    language: "es",
    delay: 1500,
    closeOnSelect: true
  });

  $("#formSearchProvider").validate({
    rules: {
      slcproveedor: {
        required: true,
      },
      slcestatusartic: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      slcproveedor:{
        required: "Completa este campo",
      },
      slcestatusartic:{
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

      var post = $('#formSearchProvider').serializeArray();
      var provedor = post[0].value;
      var estatus = post[1].value;
      document.location.href="/erp-web/proveedor/articulos/" + provedor + "/" + estatus;

    }
  });

  $('#tableArticulosProveedores').DataTable({
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

  var pathname = window.location.pathname;
  var parts = pathname.split('/');

  /*$('#slcestatus').val((pathname.substring(pathname.lastIndexOf('/') + 1)).replace("%20", " "));
  $('#slcproveedor').val((parts[4]).replace(/%20/g, " ")).trigger('change');*/

  $(document).on("click", ".assign-article", function (event) {
    var articulo_id = this.getAttribute('id-record');
    var articulo_proveedor_id = this.getAttribute('id-asign');
    var input_id = "input-articuloproveedor_" + articulo_proveedor_id + "_" + articulo_id;
    var contenido_compra = document.getElementById(input_id).value;
    var td_id = "td-articuloproveedor_" + articulo_proveedor_id + "_" + articulo_id;
    var articulod = document.getElementById(td_id).innerText;
    var post = {};
    post['articulod'] = articulod;
    post['articulo_proveedor_id'] = articulo_proveedor_id;
    post['contenido_compra'] = contenido_compra;

    $.ajax({
      type: "POST",
      url: "/erp-web/proveedor/articulo/asignar",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: post,
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
      },
      success: function(response) {

        if (isNaN(response[0]["articuloproveedorid"])) {
          M.toast({ html: response[0] })

        }else{
          M.toast({ html: 'Artículo asignado exitosamente' })
          setTimeout(location.reload(), 2000);
        }



      },
      error: function(request, status, error) {
        console.log(error);
      },
      complete: function(msg) {

      }
    });

  });
});
