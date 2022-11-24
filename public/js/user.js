/*Preloader*/
$(window).on('load', function() {
  setTimeout(function() {
    $('body').addClass('loaded');
  }, 200);


});

$(document).ready(function() {
M.updateTextFields();

  $("#frm-edituser").validate({
    rules: {
      nombreusuario: {
        required: true,
      },
      correousuario: {
        required: true,
      },
      rolusuario: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      nombreusuario:{
        required: "Completa este campo",
      },
      correousuario:{
        required: "Completa este campo",
      },
      rolusuario:{
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

      var post = $(form).serializeArray();

      $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        //dataType: 'json',

        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {

        },
        success: function(response) {
          if (response === "[]") {
            M.toast({ html: 'Datos Actualizados' });
            setTimeout(location.reload.bind(location), 2000);
          }else{
          }
          var elem = document.getElementById("mdl-edituser");
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

  $("#frm-newuser").validate({
    rules: {
      nuevonombreusuario: {
        required: true,
      },
      nuevocorreousuario: {
        required: true,
      },
      nuevorolusuario: {
        required: true,
      },
    },
    //For custom messages
    messages: {
      nuevonombreusuario:{
        required: "Completa este campo",
      },
      nuevocorreousuario:{
        required: "Completa este campo",
      },
      nuevorolusuario:{
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

      var post = $(form).serializeArray();

      $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        //dataType: 'json',

        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function(x) {

        },
        success: function(response) {
          console.log(response);
          if (response === "[]") {
            M.toast({ html: 'Usuario Agregado' });
            setTimeout(location.reload.bind(location), 2000);
          }else{
          }
          var elem = document.getElementById("mdl-new-user");
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

  $(".btn-edituser").on('click', function() {
    var user_id = this.getAttribute('id-record');
    var inputusuario = document.getElementById("nombreusuario");
    var inputcorreo = document.getElementById("correousuario");
    var selectrol = document.getElementById("slc-rol");
    var inputid = document.getElementById("edit_item_id");
    for (var i = 0; i < content.length; i++) {
      if (content[i].usuario_web_id == user_id) {
        inputusuario.value = content[i].nombre;
        inputcorreo.value = content[i].correo;
        selectrol.value = content[i].usuario_id;
        inputid.value = user_id;
      }
    }
    var elem = document.getElementById("mdl-edituser");
    var modal = M.Modal.getInstance(elem);
    modal.open();
  });
});
