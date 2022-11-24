$( document ).ready(function() {
  $("#auth-requisition").on('click', function() {

    var requisicion_id = this.getAttribute('id-record');

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
        if (response.data == "exitoso") {
          sendEmail(requisicion_id);
        }
        M.toast({ html: response });

      },
      error: function(request, status, error) {
        M.toast({ html: error });
      },
      complete: function(msg) {}
    });
  });
});
