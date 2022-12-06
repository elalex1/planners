/*Preloader*/
$(window).on('load', function() {
    setTimeout(function() {
      $('body').addClass('loaded');
    }, 200);
  
  
  });
  
  $(document).ready(function() {
  
    
    Number.isInteger = Number.isInteger || function(value) {
      return typeof value === "number" &&
             isFinite(value) &&
             Math.floor(value) === value;
  };
  
    dataTable = $('#tableArticles').DataTable({
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
       $('.selectArticles').select2({
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
         dropdownParent: $("#modal1")
       });
       //$('.selectArticles').formSelect();
    }
    });
  
    $('.selectArticles').select2({
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
          dropdownParent: $("#modal1")
    });
   
  
    // dataTable.on( 'draw', function () {
    //
    // } );
  
  
  
  
  
  
    $('#loader-articles').hide();
    $('#loader-img').hide();
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $('.collapsible2').collapsible();
    $('.carousel').carousel();
    $('.materialboxed').materialbox();
  
  
    $('.dropify').dropify({
      messages: {
        'default': 'Arrastra y suelta el archivo o clic aquí para subirlo',
        'replace': 'Arrastra y suelta el archivo o clic aquí para reemplazarlo',
        'remove':  'Eliminar',
      },
  
      error: {
        'fileSize': 'EL tamaño del archivo es demasiado grande ({{ value }} max).',
        'minWidth': 'The image width is too small ({{ value }}}px min).',
        'maxWidth':'The image width is too big ({{ value }}}px max).',
        'minHeight': 'The image height is too small ({{ value }}}px min).',
        'maxHeight': 'The image height is too big ({{ value }}px max).',
        'imageFormat': 'The image format is not allowed ({{ value }} only).'
      }
    });
  
    $(document).on("click", ".view-record", function (event) {
  
      var id = this.getAttribute('id-record');
      var iframe = document.getElementById("if-requisicion");
      var url = path_url_iframe;
      var id_ant = url.substring(url.lastIndexOf('/') + 1);
      url = url.replace(id_ant, id);
      iframe.setAttribute("src", url);
      var elem = document.getElementById("modal5");
      var modal = M.Modal.getInstance(elem);
      modal.open();
  
    });
  
    $(document).on("click", ".delete-record", function (event) {
      deleteRecord(this);
  
    });
  
    $(document).on("click", ".edit-record", function (event) {
      editRecord(this);
    });
  
    $(document).on("click", ".email-record", function (event) {
      var requisicion_id = this.getAttribute('id-record');
      sendEmail(requisicion_id);
    });
  
    // $(document).on("click", "#btnAddArticles", function (event) {
    //   drawDataTableArticles();
    // });
  
  
  
  
  
  
  
    $('#save-articles').on('click', function() {
  
      getChecked(dataTable);
  
    });
  
  
  
    var tableArticles = $('#tableArticles').DataTable();
    var tabla2 = $("#tableArticles");
  
    $('#tableRequisitions').DataTable({
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
  
  $("#finaliza-requisicion").on('click', function() {
    var path = window.location.pathname;
    var requisicion_id = path.substring(path.lastIndexOf('/') + 1);
  
    appRequisition(requisicion_id);
  
  });
  
  $("#formRequisitionImages").validate({
    rules: {
      descripcionimg: {
        required: true,
      },
      uploadedfile: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      descripcionimg:{
        required: "Completa este campo",
      },
      uploadedfile:{
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
      var requisicion_id = path.substring(path.lastIndexOf('/') + 1);
      var form = $('#formRequisitionImages')[0];
      var post = new FormData(form);
      post.append('id_requisicion',requisicion_id);
      // post.id_requisicion = requisicion_id;
      // post.file = document.getElementById('uploadedfile').files[0];
  
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        processData: false,
        url: path_url_requisitionimages,
        //dataType: 'dataForm',
  
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        contentType: false,
        beforeSend: function(x) {
          $('#loader-img').show();
        },
        success: function(response) {
  
          M.toast({ html: response[0]['Proceso'] });
          $('.dropify-clear').click();
          $('#loader-img').hide();
          if (response[0]['Proceso'] === 'Imagen agregada') {
            setTimeout(location.reload(), 2000);
          }
          //console.log(response);
  
        },
        error: function(request, status, error) {
          $('#loader-img').hide();
        },
        complete: function(msg) {}
      });
    }
  });
  
  // $("#btnAddImage").on('click', function() {
  //   var path = window.location.pathname;
  //   var requisicion_id = path.substring(path.lastIndexOf('/') + 1);
  //   var form = $('#formRequisitionImages')[0];
  //   var post = new FormData(form);
  //   post.append('id_requisicion',requisicion_id);
  //   // post.id_requisicion = requisicion_id;
  //   // post.file = document.getElementById('uploadedfile').files[0];
  //
  //   $.ajax({
  //     type: "POST",
  //     enctype: 'multipart/form-data',
  //     processData: false,
  //     url: path_url_requisitionimages,
  //     //dataType: 'dataForm',
  //
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     },
  //     data: post,
  //     contentType: false,
  //     beforeSend: function(x) {
  //       $('#loader-img').show();
  //     },
  //     success: function(response) {
  //
  //       M.toast({ html: response[0]['Proceso'] });
  //       $('.dropify-clear').click();
  //       $('#loader-img').hide();
  //       if (response[0]['Proceso'] === 'Imagen agregada') {
  //         setTimeout(, 2000);
  //       }
  //       //console.log(response);
  //
  //     },
  //     error: function(request, status, error) {
  //       $('#loader-img').hide();
  //     },
  //     complete: function(msg) {}
  //   });
  //
  // });
  
  // $("#save-requisition").on('click', function() {
  //
  //   var post = $('#formRequisition').serializeArray();
  //
  //   $.ajax({
  //     type: "POST",
  //     url: "/requisicion/submit",
  //     dataType: 'json',
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     },
  //     data: post,
  //     //contentType: "application/json; charset=utf-8",
  //     beforeSend: function(x) {
  //
  //     },
  //     success: function(response) {
  //
  //       //Si no es un número, es un error de la bd
  //       if (isNaN(response.id_requisicion)) {
  //         M.toast({ html: response.id_requisicion });
  //
  //       }else{
  //         M.toast({ html: 'Requisición guardada' })
  //         document.location.href="/requisicion/edit/" + response.id_requisicion;
  //       }
  //
  //     },
  //     error: function(request, status, error) {
  //       console.log(error);
  //     },
  //     complete: function(msg) {}
  //   });
  // });
  
  $("#formRequisitionEdit").validate({
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
      var post = $('#formRequisitionEdit').serializeArray();
  
      $.ajax({
        type: "POST",
        url: "/erp-dev/requisicion/update",
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
            M.toast({ html: 'Requisición actualizada' })
          }
  
        },
        error: function(request, status, error) {
          M.toast({ html: error })
        },
        complete: function(msg) {}
      });
    }
  });
  
  // $("#update-requisition").on('click', function() {
  //
  //   var post = $('#formRequisitionEdit').serializeArray();
  //
  //   $.ajax({
  //     type: "POST",
  //     url: "/requisicion/update",
  //     //dataType: 'json',
  //     headers: {
  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     },
  //     data: post,
  //     dataType: 'json',
  //     //contentType: "application/json; charset=utf-8",
  //     beforeSend: function(x) {
  //
  //     },
  //     success: function(response) {
  //
  //       if (response.data.length != 0) {
  //
  //         M.toast({ html: response })
  //
  //       }else{
  //         M.toast({ html: 'Requisición actualizada' })
  //       }
  //
  //     },
  //     error: function(request, status, error) {
  //       M.toast({ html: error })
  //     },
  //     complete: function(msg) {}
  //   });
  // });
  
  $("#auth-requisition").on('click', function() {
  
    var path = window.location.pathname;
    var requisicion_id = path.substring(path.lastIndexOf('/') + 1);
  
    $.ajax({
      type: "POST",
      url: path_url_authrequisition,
      //dataType: 'json',
  
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {requisicion_id: requisicion_id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
  
      },
      success: function(response) {
          console.log(response)
          M.toast({ html: response })
          if (response.search("Folio") > 0) {
            SendEmailPDFAuth(requisicion_id);
          setTimeout(  document.location.href="/erp-dev/requisicion", 3000);
        }
  
      },
      error: function(request, status, error) {
        M.toast({ html: error });
      },
      complete: function(msg) {}
    });
  });
  
  $("#cancel-requisition").on('click', function() {
  
    var path = window.location.pathname;
    var requisicion_id = path.substring(path.lastIndexOf('/') + 1);
  
    $.ajax({
      type: "POST",
      url: path_url_cancelrequisition,
      //dataType: 'json',
  
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {requisicion_id: requisicion_id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
  
      },
      success: function(response) {
        if (response === []) {
          M.toast({ html: 'Requisición cancelada' })
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
  });
  
  $(".delete-img").on('click', function() {
    var imagen_id = this.id;
    var url = window.location.pathname;
    var requisicion_id = url.substring(url.lastIndexOf('/') + 1);
    var post = {};
    post['imagen_id'] = imagen_id;
    post['requisicion_id'] = requisicion_id;
  
    $.ajax({
      type: "POST",
      url: path_url_deleteimages,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: post,
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
        $('#carrusel-img').hide();
      },
      success: function(response) {
  
        M.toast({ html: response[0]['Proceso'] });
        if (response[0]['Proceso'] === 'Imagen eliminada') {
          setTimeout(location.reload(), 2000);
        }
        else{
          $('#carrusel-img').show();
        }
  
  
  
      },
      error: function(request, status, error) {
        console.log(error);
      },
      complete: function(msg) {
  
      }
    });
  
  });
  
  // $("#new-password").on("focusout", function (e) {
  //     if ($(this).val() != $("#new-password-confirm").val() || $(this).val() == "") {
  //         $("#new-password-confirm").removeClass("valid").addClass("invalid");
  //     } else {
  //         $("#new-password-confirm").removeClass("invalid").addClass("valid");
  //     }
  // });
  //
  // $("#new-password-confirm").on("keyup", function (e) {
  //     if ($("#new-password").val() != $(this).val() || $(this).val() == "") {
  //         $(this).removeClass("valid").addClass("invalid");
  //     } else {
  //         $(this).removeClass("invalid").addClass("valid");
  //     }
  // });
  //
  // $("#new-password-confirm").on("focusout", function (e) {
  //     if ($(this).val() != $("#new-password").val() || $(this).val() == "") {
  //       $("#new-password-confirm").removeClass("valid").addClass("invalid");
  //   } else {
  //       $("#new-password-confirm").removeClass("invalid").addClass("valid");
  //   }
  // });
  
  $("#frm-cambiapassword").validate({
    rules: {
      newpassword: {
        required: true,
        minlength: 6
      },
      newpasswordconfirmation: {
        required: true,
        equalTo: "#new-password"
      },
    },
    //For custom messages
    messages: {
      newpassword:{
        required: "Completa este campo",
        minlength: "Mínimo 6 caracteres"
      },
      newpasswordconfirmation:{
        required: "Completa este campo",
        equalTo: "Las contraseñas no coinciden"
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
  
      var post = $('#frm-cambiapassword').serializeArray();
  
      $.ajax({
        type: "POST",
        url: $("#frm-cambiapassword").attr('action'),
        //dataType: 'json',
  
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {
  
        },
        success: function(response) {
          if (response.length === 0) {
            M.toast({ html: 'Contraseña actualizada' })
          }else{
            M.toast({ html: response });
          }
          var elem = document.getElementById("modal6");
          var modal = M.Modal.getInstance(elem);
          modal.close();
        },
        error: function(request, status, error) {
          M.toast({ html: error });
        },
        complete: function(msg) {}
      });
    }
  });
  
  $("#formRequisition").validate({
    rules: {
      concepto_requisicion: {
        required: true,
      },
      descripciond: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      concepto_requisicion:{
        required: "Completa este campo",
      },
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
  
      var post = $('#formRequisition').serializeArray();
  
      $.ajax({
        type: "POST",
        url: path_url_submit,
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
          if (isNaN(response.id_requisicion)) {
            M.toast({ html: response.id_requisicion });
  
          }else{
            M.toast({ html: 'Requisición guardada' });
            document.location.href="edit/" + response.id_requisicion;
          }
  
        },
        error: function(request, status, error) {
          console.log(error);
        },
        complete: function(msg) {}
      });
    }
  });
  
  
  //   function show_loader() {
  //             $('#loader-img').fadeIn();
  //         }
  //
  // function hide_loader() {
  //             $('#loader-img').fadeOut();
  //         }
  
  $("#finaliza-particion").on('click', function() {
    var path = window.location.pathname;
    var requisicion_id = path.substring(path.lastIndexOf('/') + 1);
    var tblArticles = document.getElementById('tblArticlesStatic');
    var listArticleschecked = [];
    var j=0;
    for (var i = 1; i < tblArticles.rows.length; i++) {
            cellsOfRow = tblArticles.rows[i].getElementsByTagName('td');
            var check = document.getElementById("check-" + cellsOfRow[0].id);
            if (check.checked) {
              listArticleschecked[j] = cellsOfRow[0].id;
              j++;
            }
        }
        $.ajax({
          type: "POST",
          url: path_url_particion,
          dataType: 'json',
  
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {requisicion_id: id},
          //contentType: "application/json; charset=utf-8",
          beforeSend: function(x) {
  
          },
          success: function(response) {
            if (response.data == "exitoso") {
              sendEmail(id);
              document.location.href="/erp-dev/requisicion";
            }else{
              M.toast({ html: response });
            }
          },
          error: function(request, status, error) {
            M.toast({ html: error });
          },
          complete: function(msg) {}
        });
  });
  
  
$(function () {
    var pgurl = window.location.href;
    //let urlactive1=quitarDiagRutaR(pgurl,1);
    //let urlactive2=quitarDiagRutaR(pgurl,2);
    $(".li-ppal-menu li a").each(function () {
        /*if ($(this).attr("href") == pgurl || $(this).attr("href") == '' ||
        $(this).attr("href") == urlactive1 || $(this).attr("href") == urlactive2) {*/
        //$(this).css("font-weight", "lighter");
        if (pgurl.includes($(this).attr("href")) && $(this).attr("href").length>3) {
            $(this)[0].parentElement.classList.add("active")
            $(this)[0].parentElement.classList.add("red")
            $(this)[0].parentElement.classList.add("lighten-4")
            $(this).css("color", "black");
            if($(this).closest('.collapsible-body')[0]){
                let l=$(this).closest('.collapsible-body')[0].parentElement;
                //l.classList.add("active");
                l.classList.add("red");
                l.classList.add("lighten-5");
            }

        }
    })
});


$('#tableBitacoraRequisiciones').DataTable({
    // scrollY:        "300px",
    //       scrollX:        true,
    //       scrollCollapse: true,
    //       paging:         false,
    //       columnDefs: [
    //           { width: '20%', targets: 0 }
    //       ],
    //       fixedColumns: true,
    "aaSorting": [],
    responsive: true,
    dom: 'Bfrtip',
    buttons: [
        'copy', 'excel', 'pdf', 'print'
    ]
});


function appRequisition(id) {

    $.ajax({
        type: "POST",
        url: path_url_apprequisition,
        dataType: 'json',

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {requisicion_id: id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
  
      },
      success: function(response) {
        if (response.data == "exitoso") {
          sendEmail(id);
          document.location.href="/erp-dev/requisicion";
        }else{
          M.toast({ html: response.data });
        }
  
  
      },
      error: function(request, status, error) {
        M.toast({ html: error });
      },
      complete: function(msg) {}
    });
  }
  
  function sendEmail(id) {
  
    $.ajax({
      type: "POST",
      url: path_url_sendemail,
      dataType: 'json',
  
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {requisicion_id: id},
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
  
  function SendEmailPDFAuth(id) {
  
    $.ajax({
      type: "POST",
      url: path_url_sendemail_auth,
      dataType: 'json',
  
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {requisicion_id: id},
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
  
  
  
  function drawTableArticles() {
  
  
    var content_articles = document.getElementById('contentArticles');
  
    var url = window.location.pathname;
    var requisicion_id = url.substring(url.lastIndexOf('/') + 1);
  
    $.ajax({
      type: "POST",
      url: "/requisicion/articles",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      data: {requisicion_id: requisicion_id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
        $(content_articles).html('');
      },
      success: function (response) {
        createTableArticles(response.articulos_requisicion, requisicion_id);
  
      },
      error: function (request, status, error) {
      },
      complete: function (msg)
      {
      }
    });
  
  }
  
    function createTableArticles(data, id) {
  
    var content_articles = document.getElementById('contentArticles');
    content_articles.innerHTML = '';
  
    var table =  document.createElement('table');
    table.id = 'tblArticlesStatic';
  
    var thead = document.createElement('thead');
  
    var th1 = document.createElement('th');
    th1.innerHTML = 'Cantidad';
    var th2 = document.createElement('th');
    th2.innerHTML = 'Artículo';
    var th3 = document.createElement('th');
    th3.innerHTML = 'Centro Costos';
    var th4 = document.createElement('th');
    th4.innerHTML = 'Nota';
    var th5 = document.createElement('th');
  
    thead.appendChild(th1);
    thead.appendChild(th2);
    thead.appendChild(th3);
    thead.appendChild(th4);
    thead.appendChild(th5);
  
    table.appendChild(thead);
  
    var tbody = document.createElement('tbody');
  
    for (var i = 0; i < data.length; i++) {
      var tr = document.createElement('tr');
      content_articles.appendChild(tr);
  
  
      var td1 = document.createElement('td');
      td1.innerHTML = data[i]["cantidad"];
      td1.classList.add("tblArticles");
  
      var td2 = document.createElement('td');
      td2.innerHTML = data[i]["nombre"];
      td2.classList.add("tblArticles");
  
      var td3 = document.createElement('td');
      td3.innerHTML = data[i]["centrocosto"];
      td3.classList.add("tblArticles");
  
      var td4 = document.createElement('td');
      td4.innerHTML = data[i]["nota_articulo"];
      td4.classList.add("tblArticles");
  
      var td5 = document.createElement('td');
      td5.classList.add("tblArticles");
  
      var iDelete = document.createElement('i');
      iDelete.setAttribute('class', "material-icons delete-record");
      iDelete.setAttribute('id-record', data[i]["articulo_id"]);
      iDelete.setAttribute('id-asign', id);
      iDelete.innerHTML = "delete_forever";
      td5.appendChild(iDelete);
  
      tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      tr.appendChild(td4);
      tr.appendChild(td5);
  
      tbody.appendChild(tr);
      table.appendChild(tbody);
      content_articles.appendChild(table);
    }
  
  
  
  }
  
  function drawDataTableArticles() {
  
    var elem = document.getElementById("modal1");
    var modal = M.Modal.getInstance(elem);
    modal.open();
  
    var content_articles = document.getElementById('content-datableArticles');
  
    var url = window.location.pathname;
    var requisicion_id = url.substring(url.lastIndexOf('/') + 1);
  
    $.ajax({
      type: "POST",
      url: "/requisicion/articlesbytype",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      data: {requisicion_id: requisicion_id},
      //contentType: "application/json; charset=utf-8",
      beforeSend: function(x) {
        $('#loader-catalogarticles').show();
      },
      success: function (response) {
        createDataTableArticles(response, requisicion_id);
        $('#loader-catalogarticles').hide();
  
      },
      error: function (request, status, error) {
      },
      complete: function (msg)
      {
      }
    });
  
  }
  
  function createDataTableArticles(data, id) {
  
  
  
    var content_articles = document.getElementById('content-datableArticles');
    content_articles.innerHTML = '';
  
    var table =  document.createElement('table');
    table.id = 'tableArticles';
  
    var thead = document.createElement('thead');
    var tr = document.createElement('tr');
  
    var th1 = document.createElement('th');
    th1.innerHTML = 'Cantidad';
    var th2 = document.createElement('th');
    th2.innerHTML = 'U. Medida';
    var th3 = document.createElement('th');
    th3.innerHTML = 'Centro Costos';
    var th4 = document.createElement('th');
    th4.innerHTML = 'Artículo';
    var th5 = document.createElement('th');
    th5.innerHTML = 'Nota';
  
    tr.appendChild(th1);
    tr.appendChild(th2);
    tr.appendChild(th3);
    tr.appendChild(th4);
    tr.appendChild(th5);
  
    thead.appendChild(tr);
  
    table.appendChild(thead);
  
    var tbody = document.createElement('tbody');
    tbody.id = 'tblArticles';
    tbody.className = 'tblArticles';
  
    for (var i = 0; i < data.articulos.length; i++) {
      var tr = document.createElement('tr');
      tr.id =  data.articulos[i]["articulo_id"];
      tbody.appendChild(tr);
  
  
      var td1 = document.createElement('td');
      td1.id = 'cantidad';
      td1.classList.add("tblArticles");
  
      var input1 = document.createElement('input');
      input1.classList.add("cantidadnumeric");
      input1.id = "cantidad-" + data.articulos[i]["articulo_id"];
      input1.setAttribute("type", "number");
      input1.setAttribute("name", "cantidad-" + data.articulos[i]["articulo_id"]);
  
      var input2 = document.createElement('input');
      input2.id = "req-" + data.articulos[i]["articulo_id"];
      input2.setAttribute("type", "hidden");
      input2.setAttribute("name", "req-" + data.articulos[i]["articulo_id"]);
      input2.value = id;
  
      var input3 = document.createElement('input');
      input3.id = "nombre-" +data.articulos[i]["articulo_id"];
      input3.setAttribute("type", "hidden");
      input3.setAttribute("name", "nombre-" + data.articulos[i]["articulo_id"]);
      input3.value =  data.articulos[i]["nombre"];
  
      td1.appendChild(input1);
      td1.appendChild(input2);
      td1.appendChild(input3);
  
  
      var td2 = document.createElement('td');
      td2.innerHTML = data.articulos[i]["unidad_compra"];
      td2.classList.add("tblArticles");
  
      var td3 = document.createElement('td');
      td3.classList.add("tblArticles");
  
      var select = document.createElement('select');
      select.setAttribute("class","selectArticles js-data-example-ajax browser-default");
      select.id = "input-articles-" + data.articulos[i]["articulo_id"];
      select.setAttribute("name", "seleccionado-" + data.articulos[i]["articulo_id"]);
  
      td3.appendChild(select);
  
      // var optiondefault = document.createElement('option');
      // optiondefault.disabled = true;
      // optiondefault.selected = true;
      // optiondefault.innerHTML = 'Seleccione una opción';
      // select.appendChild(optiondefault);
  
      // for (var j = 0; j < data.centros_costos.length; j++) {
      //   var option = document.createElement('option');
      //   option.value = data.centros_costos[j]["nombre"];
      //   option.innerHTML = data.centros_costos[j]["nombre"];
      //   select.appendChild(option);
      // }
  
      var td4 = document.createElement('td');
      td4.innerHTML = data.articulos[i]["nombre"];
      td4.classList.add("tblArticles");
  
      var td5 = document.createElement('td');
      td5.classList.add("tblArticles");
  
      var input4 = document.createElement('input');
      input4.id = "nota-" + data.articulos[i]["articulo_id"];
      input4.setAttribute("name", "nota-" + data.articulos[i]["articulo_id"]);
  
      td5.appendChild(input4);
  
      tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      tr.appendChild(td4);
      tr.appendChild(td5);
  
      tbody.appendChild(tr);
      table.appendChild(tbody);
      content_articles.appendChild(table);
    }
  
  
  
  
  }
  
  function editRecord(item) {
    var requisicion_id = item.getAttribute('id-record');
    document.location.href="requisicion/edit/" + requisicion_id;
  
  }
  
  function deleteRecord(item) {
  
    var articulo_id = item.getAttribute('id-record');
    var requisicion_id = item.getAttribute('id-asign');
    var post = {};
    post['articulo_id'] = articulo_id;
    post['requisicion_id'] = requisicion_id;
  
    $.ajax({
      type: "POST",
      url: "/erp-dev/requisicion/deletearticle",
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
  
        if (response != "[]") {
  
          M.toast({ html: response })
          $('#tblArticlesStatic').show();
          $('#loader-articles').hide();
  
        }else{
          M.toast({ html: 'Registro eliminado exitosamente' })
          setTimeout(location.reload(), 2000);
        }
  
  
  
      },
      error: function(request, status, error) {
        console.log(error);
      },
      complete: function(msg) {
  
      }
    });
  
  }
  
  function getChecked(dataTable) {
  
    var data = dataTable.rows({ selected: true }).data();
    var data2 = dataTable.$('input,select').serializeArray();
  
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
        url: path_url_submitarticles,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { jsonArticles: JSON.stringify(datosf) },
        //dataType: 'json',
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {
  
        },
        success: function(response) {
  
          if (Number.isInteger(parseInt(response))) {
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
  }

  

  
  