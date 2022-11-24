$(document).ready(function() {





  $("#frm-login").submit(function(event){

    // event.preventDefault();

    setTimeout(() => {

      // $(this).find('#password').trigger('reset');

      $(this).find('#password').val('');

    }, 50);

    // console.log($(this).attr('action'));

    // $.ajax({

    //   type: "POST",

    //   // url: path_url_login,

    //   url: $(this).attr('action'),

    //   //dataType: 'json',



    //   headers: {

    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    //   },

    //   data: $("#frm-login").serialize(),

    //   //contentType: "application/json; charset=utf-8",

    //   beforeSend: function(x) {



    //   },

    //   success: function(response) {



    //         M.toast({ html: 'Inicio de sesión exitosa' })

    //         document.location= response;

    //   },

    //   error: function(request, status, error) {

    //     M.toast({ html: error });

    //   },

    //   complete: function(msg) {}

    // });

  });


});

$(function(){
    var $nuevoreg = $("#nuevoRegistro");
    if($nuevoreg.length){
        $nuevoreg.validate({
            rules:{
                usuario:{
                    required: true
                },

                empresa:{
                    required: true
                },

                email:{
                    required: true,
                    email: true
                }
            },
            messages:{
                usuario:{
                    required: "Completa este campo"
                },

                empresa:{
                    required: "Completa este campo"
                },

                email:{
                    required: "Completa este campo",
                    email: "Ingresa una direccion de correo valida"
                }
            },
            errorElement : 'span'
            
        })
    }
});



