$(window).on('load', function () {
    setTimeout(function () {
        $('body').addClass('loaded');
    }, 200);

var dataTable_oc;
});
//tabla responsive de ordenes de compra------------------------------------------
$(document).ready(function () {
    
    Number.isInteger = Number.isInteger || function (value) {
        return typeof value === "number" &&
            isFinite(value) &&
            Math.floor(value) === value;
    };
    if(document.location.href.includes("ordencompra/edit/")){
        let ordencompraid = document.location.href.substring(document.location.href.lastIndexOf('/') + 1)
        ordencompraid=removerasht(ordencompraid);
        listar(ordencompraid);
        //listarReq();
    }
    if(document.location.href.includes("recepcionmercancia/editar/")){
        if($('.verify_moneda').attr('url-record')){
            let url=$('.verify_moneda').attr('url-record');
            url=url.replace('/000','/'+$('.verify_moneda').val())
            //console.log(url);
            validarMoneda(url,'GET','')
        }
        let ordencompraid = document.location.href.substring(document.location.href.lastIndexOf('/') + 1)
        ordencompraid=removerasht(ordencompraid);
        listarArticulos(ordencompraid);
        //console.log(ordencompraid)
    }
   /* document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.fixed-action-btn');
        var instances = M.FloatingActionButton.init(elems, {
          direction: 'top',
          hoverEnabled: false
        });
      });*/
    $('#tableGeneral').DataTable({

        "aaSorting": [],
        paging: true,
        responsive: true,
        columnDefs: [{
                responsivePriority: 3
            },
            {
                responsivePriority: 8
            },
            {
                responsivePriority: 2
            },
        ],

        "language":idiomaEp,
        "drawCallback": function () {
            $('.tooltipped').tooltip();
        }
    });

    /*dataTable_oc = $('#tableArticles-oc').DataTable({
        paging: true,
        responsive: true,
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
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        /*
        "drawCallback": function () {
            $('.selectProveedor').select2({
                ajax: {
                    url: path_url_costsbytype_oc,
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
                    console.log(path_url_costsbytype_oc);
                    return markup;
                },
                //        minimumInputLength: 1,
                placeholder: "Seleccione una opción",
                allowClear: true,
                language: "es",
                delay: 1500,
                //se utiliza para mostrar en modal
                //dropdownParent: $("#modal1b")
            });
            //$('.selectArticles').formSelect();
        }*
    });*/
    /*$('#tableRequisitions-oc').DataTable({
        paging: true,
        responsive: true,
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
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
    });*/
//---------Selectorde proveedor--------------------------
    $('.selectProveedor').select2({
        ajax: {
            url: path_url_costsbytype_oc,
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
        //dropdownParent: $("#modal1b")
    });
    //---------fin selector proveedor---------------------
    // dataTable.on( 'draw', function () {
    //
    // } );






   /* $('#loader-articles-oc').hide();
    $('#loader-img').hide();
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $('.carousel').carousel();
    $('.materialboxed').materialbox();*/
    $('.tabs').tabs();


   /* $('.dropify').dropify({
        messages: {
            'default': 'Arrastra y suelta la imagen o clic aquí para subirla',
            'replace': 'Arrastra y suelta la imagen o clic aquí para reemplazarla',
            'remove': 'Eliminar',
        },

        error: {
            'fileSize': 'EL tamaño del archivo es demasiado grande ({{ value }} max).',
            'minWidth': 'The image width is too small ({{ value }}}px min).',
            'maxWidth': 'The image width is too big ({{ value }}}px max).',
            'minHeight': 'The image height is too small ({{ value }}}px min).',
            'maxHeight': 'The image height is too big ({{ value }}px max).',
            'imageFormat': 'The image format is not allowed ({{ value }} only).'
        }
    });*/

    $(document).on("click", ".view-record-oc", function (event) {

        var id = this.getAttribute('id-record');
        var iframe = document.getElementById("if-requisicion");
        var url = path_url_iframe_oc;
        var id_ant = url.substring(url.lastIndexOf('/') + 1);
        url = url.replace(id_ant, id);
        iframe.setAttribute("src", url);
        var elem = document.getElementById("modal5");
        var modal = M.Modal.getInstance(elem);
        modal.open();

    });
    $(document).on("click", ".view-record-oc2", function (event) {

        var id = this.getAttribute('id-record');
        var iframe = document.getElementById("if-requisicion2");
        var url = path_url_iframe_oc;
        var id_ant = url.substring(url.lastIndexOf('/') + 1);
        url = url.replace(id_ant, id);
        //console.log(url);
        iframe.setAttribute("src", url);
        var elem = document.getElementById("modal5b");
        var modal = M.Modal.getInstance(elem);
        modal.open();

    });

    $(document).on("click", ".delete-record-oc", function (event) {
        deleteRecordOC(this);

    });

    $(document).on("click", ".edit-recordOC", function (event) {
        var ordencompra_id = this.getAttribute('id-record');
        editRecordOC(ordencompra_id);
    });

    $(document).on("click", ".email-record-oc", function (event) {
        var ordencompra_id = this.getAttribute('id-record');
        sendEmailOC(ordencompra_id);
    });

    $(document).on("click",".agregar_requ_oc",function(event){
        //alert('click en agregar requ');
        var requisitionid=this.getAttribute('id-record');
        agregarRequisitionAOC(requisitionid);
    });

    // $(document).on("click", "#btnAddArticles-oc", function (event) {
    // drawDataTableArticles();
    // });
    $('#save-articles-oc').on('click', function () {

        getCheckedOC(dataTable_oc);

    });

    //var tableArticles = $('#tableArticles-oc').DataTable();
    var tabla2 = $("#tableArticles-oc");

    $('#tableOrdenesCompras').DataTable({

        "aaSorting": [],
        paging: true,
        responsive: true,
        columnDefs: [{
                responsivePriority: 3
            },
            {
                responsivePriority: 8
            },
            {
                responsivePriority: 2
            },
        ],

        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "drawCallback": function () {
            $('.tooltipped').tooltip();
        }
    });

    //$('.modal').modal();
    //$('.fixed-action-btn').floatingActionButton();
    //$('.tooltipped').tooltip();
    //for right or left click(any)
    // $('.tooltipped').mousedown(function () {
    //     $('.material-tooltip').css("visibility", "hidden");
    // });

    // leaving after click in case you open link in new tab
    // $('.tooltipped').mouseleave(function () {
    //     $('.material-tooltip').css("visibility", "hidden");
    // });
    // $('select').formSelect();
    //-------------------------------------------
});
//fin tabla responsive ordenes compras-----------------------------------
//comiensa formulario nueva orden de compra-----------------------------------------
$("#formOrdenCompra").validate({
    rules: {
        concepto_compra: {
            required: true,
        },
        descripciond: {
            required: true,
        },
        proveedor: {
            required: true,
        },
        almacen:{
            required: true,
        },
    },
    //For custom messages
    messages: {
        concepto_compra: {
            required: "Completa este campo",
        },
        descripciond: {
            required: "Completa este campo",
        },
        proveedor: {
            required: "Completa este campo",
        },
        almacen: {
            required: "Completa este campo",
        },
    },
    errorElement: 'div',
    errorClass: "invalid",
    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function (form) {

        var post = $('#formOrdenCompra').serializeArray();

        $.ajax({
            type: "POST",
            url: path_url_submit_new_oc,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: post,
            //contentType: "application/json; charset=utf-8",
            beforeSend: function (x) {
                
            },
            
            success: function (response) {

                //Si no es un número, es un error de la bd
                if (isNaN(response.id_ordencompra)) {
                    M.toast({
                        html: response.id_ordencompra
                    });

                } else {
                    M.toast({
                        html: 'Orden Compra guardada'
                    });
                    document.location.href = "edit/" + response.id_ordencompra;
                }

            },
            error: function (request, status, error) {
                console.log(request);
                console.log(error);
            },
            //complete: function (msg) {}
            
            complete: function (msg) {}
        });
    }
});

// fin formulario nueva orden de compra---------------------------------------

//formulario agregar articulo a orden compra----------------------------------
function drawTableArticles() {


    var content_articles = document.getElementById('contentArticlesOrdenCompra');

    var url = window.location.pathname;
    var ordencompra_id = url.substring(url.lastIndexOf('/') + 1);

    $.ajax({
        type: "POST",
        url: "/ordencompra/articles",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        data: {
            ordencompra_id: ordencompra_id
        },
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {
            $(content_articles).html('');
        },
        success: function (response) {
            createTableArticles(response.articulos_ordencompra, ordencompra_id);

        },
        error: function (request, status, error) {},
        complete: function (msg) {}
    });

}
//-----------------------------------------------------------------------------
//
function getCheckedOC(dataTable_oc) {

    var data = dataTable_oc.rows({
        selected: true
    }).data();
    var data2 = dataTable_oc.$('input,select').serializeArray();

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
            url: path_url_submitarticles_oc,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                jsonArticles: JSON.stringify(datosf)
            },
            //dataType: 'json',
            //contentType: "application/json; charset=utf-8",
            beforeSend: function (x) {

            },
            success: function (response) {

                if (Number.isInteger(parseInt(response))) {
                    M.toast({
                        html: 'Registro agregado exitosamente'
                    });
                    setTimeout(location.reload(), 2000);

                } else {
                    M.toast({
                        html: response
                    });
                }

            },
            error: function (request, status, error) {
                M.toast({
                    html: error
                });
            },
            complete: function (msg) {}
        });
    }
}
//
function editRecordOC(ordencompra_id) {
    //var requisicion_id = item.getAttribute('id-record');
    document.location.href = "ordencompra/edit/" + ordencompra_id;

}
function drawDataTableArticlesOC() {

    var elem = document.getElementById("modal1b");
    var modal = M.Modal.getInstance(elem);
    modal.open();

    var content_articles = document.getElementById('content-datableArticles-oc');

    var url = window.location.pathname;
    var ordencompra_id = url.substring(url.lastIndexOf('/') + 1);

    $.ajax({
        type: "POST",
        url: "/ordencompra/articlesbytype",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        data: {
            ordencompra_id: ordencompra_id
        },
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {
            $('#loader-catalogarticles').show();
        },
        success: function (response) {
            createDataTableArticlesOC(response, ordencompra_id);
            $('#loader-catalogarticles').hide();

        },
        error: function (request, status, error) {},
        complete: function (msg) {}
    });

}
/*function createDataTableArticlesOC(data, id) {
   var content_articles = document.getElementById('content-datableArticles-oc');
    content_articles.innerHTML = '';

    var table = document.createElement('table');
    table.id = 'tableArticles-oc';

    var thead = document.createElement('thead');
    var tr = document.createElement('tr');

    var th1 = document.createElement('th');
    th1.innerHTML = 'Cantidad';
    var th2 = document.createElement('th');
    th2.innerHTML = 'U. Medida';
    var th3 = document.createElement('th');
    th3.innerHTML = 'Centro Costosss';
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
    tbody.id = 'tblArticles-oc';
    tbody.className = 'tblArticles-oc';

    for (var i = 0; i < data.articulos.length; i++) {
        var tr = document.createElement('tr');
        tr.id = data.articulos[i]["articulo_id"];
        tbody.appendChild(tr);


        var td1 = document.createElement('td');
        td1.id = 'cantidad';
        td1.classList.add("tblArticles-oc");

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
        input3.id = "nombre-" + data.articulos[i]["articulo_id"];
        input3.setAttribute("type", "hidden");
        input3.setAttribute("name", "nombre-" + data.articulos[i]["articulo_id"]);
        input3.value = data.articulos[i]["nombre"];

        td1.appendChild(input1);
        td1.appendChild(input2);
        td1.appendChild(input3);


        var td2 = document.createElement('td');
        td2.innerHTML = data.articulos[i]["unidad_compra"];
        td2.classList.add("tblArticles-oc");

        var td3 = document.createElement('td');
        td3.classList.add("tblArticles-oc");

        var select = document.createElement('select');
        select.setAttribute("class", "selectArticles-oc js-data-example-ajax browser-default");
        select.id = "input-articles-oc-" + data.articulos[i]["articulo_id"];
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
        td4.classList.add("tblArticles-oc");

        var td5 = document.createElement('td');
        td5.classList.add("tblArticles-oc");

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
    //elimina articulo de la orden de compra
    
}*/
function deleteRecordOC(item) {

    var articulo_id = item.getAttribute('id-record');
    var requisicion_id = item.getAttribute('id-asign');
    var post = {};
    post['articulo_id'] = articulo_id;
    post['ordencompra_id'] = requisicion_id;

    $.ajax({
        type: "POST",
        url: "ordencompra/deletearticle",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {
            $('#tblArticlesStatic-oc').hide();
            $('#loader-articles-oc').show();
        },
        success: function (response) {
            //console.log(response);
            if (response.length != 0) {
                //setTimeout(location.reload(), 2000);
                M.toast({
                    html: response
                })
                $('#tblArticlesStatic-oc').show();
                $('#loader-articles-oc').hide();
                

            } else {
                M.toast({
                    html: 'Registro eliminado exitosamente'
                })
                
                setTimeout(location.reload(), 2000);
            }



        },
        error: function (request, status, error) {
            console.log(error);
        },
        complete: function (msg) {

        }
    });

}
function drawDataTableRequisitionsOC() {

    var elem = document.getElementById("modal2b");
    var modal = M.Modal.getInstance(elem);
    modal.open();

    var content_requisitions = document.getElementById('content-datableRequisitions-oc');

    var url = window.location.pathname;
    var ordencompra_id = url.substring(url.lastIndexOf('/') + 1);
    console.log(url);
    $.ajax({
        type: "POST",
        url: "/ordencompra/requisicionesbytype",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        data: {
            ordencompra_id: ordencompra_id
        },
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {
            $('#loader-catalogarticles').show();
        },
        success: function (response) {
            createDataTableArticlesOC(response, ordencompra_id);
            $('#loader-catalogarticles').hide();

        },
        error: function (request, status, error) {},
        complete: function (msg) {}
    });

}
//------Editar OrdenCOmpra-----------------------------
$("#formOrdenCompraEdit").validate({
    rules: {
        descripciond: {
            required: true,
        },
    },
    //For custom messages
    messages: {
        descripciond: {
            required: "Completa este campo",
        },
    },
    errorElement: 'div',
    errorClass: "invalid",
    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function (form) {
        //console.log(form);
        var post = $('#formOrdenCompraEdit').serializeArray();

        $.ajax({
            type: "POST",
            url: "../compra/update",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: post,
            //dataType: 'json',
            //contentType: "application/json; charset=utf-8",
            
            beforeSend: function (x) {
                
            },
            success: function (response) {
                //console.log(response);
                if (response.data.length != 0) {

                    M.toast({
                        html: response
                    })

                } else {
                    M.toast({
                        html: 'Orden Compra actualizada'
                    })
                }

            },
            error: function (request, status, error) {
                //console.log(request);
                
                M.toast({
                    html: error
                })
            },
            complete: function (msg) {
                //console.log(msg);
            }
        });
    }
});
//------Fin editar Orden Compra
//-------------agregar requisicion a orden de compra
function agregarRequisitionAOC(requid){
   var ordenCom=document.getElementById('modal2b');
   var OCid=ordenCom.getAttribute('itemid');
   var post = {};
    post['requisicion_id'] = requid;
    post['ordencompra_id'] = OCid;

    $.ajax({
        type: "POST",
        url: path_url_agregar_requicition_orden_compra,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        
        data: post,
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {
            $('#tblArticlesStatic-oc').hide();
            $('#loader-articles-oc').show();
        },
        success: function (response) {
            //console.log(response);
            if (response.status == false) {
                //setTimeout(location.reload(), 2000);
                M.toast({
                    html: response.data
                })
                $('#tblArticlesStatic-oc').show();
                $('#loader-articles-oc').hide();
                

            } else {
                
                M.toast({
                    html: 'Requisición agregada exitosamente'
                })
                setTimeout(location.reload(), 2000);
                
            }



        },
        error: function (request, status, error) {
            console.log(error);
        },
        complete: function (msg) {

        }
    });

}
//-------fin agreagr-------------------
//------funcion para finalizar orden de compra
$("#finaliza-ordencompra").on('click', function () {
    var path = window.location.pathname;
    var ordencompra_id = path.substring(path.lastIndexOf('/') + 1);
    //alert(ordencompra_id);
    appOrdenCompra(ordencompra_id);

});
function appOrdenCompra(id) {

    $.ajax({
        type: "POST",
        url: path_url_appordencompra,
        dataType: 'json',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            ordencompra_id: id
        },
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {

        },
        success: function (response) {
            if (response.data == "exitoso") {
                sendEmailOC(id);
                document.location.href = path_url_Ordencompra_home;
            } else {
                M.toast({
                    html: response.data
                });
            }


        },
        error: function (request, status, error) {
            M.toast({
                html: error
            });
        },
        complete: function (msg) {}
    });
}
//-----fin funcion para finalizar orden compra----------
//-----funcion para enviar email---------------
function sendEmailOC(id) {

    $.ajax({
        type: "POST",
        url: path_url_sendemailOC,
        dataType: 'json',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            ordencompra_id: id
        },
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {

        },
        success: function (response) {
            console.log(response);
            M.toast({
                html: response.data
            });

        },
        error: function (request, status, error) {
            M.toast({
                html: error
            });
        },
        complete: function (msg) {}
    });
}

//-----fin funcion enviar email
//-------Autorizacion de orden de compra-------
$("#auth-ordencompra").on('click', function () {

    var path = window.location.pathname;
    var ordencompra_id = path.substring(path.lastIndexOf('/') + 1);

    $.ajax({
        type: "POST",
        url: path_url_authordencompra,
        //dataType: 'json',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            ordencompra_id: ordencompra_id
        },
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {

        },
        success: function (response) {

            M.toast({
                html: response
            })
            if (response.search("Folio") > 0) {
                SendEmailPDFAuthOC(ordencompra_id);
                setTimeout(document.location.href = path_irdenes_compras_home, 3000);
            }

        },
        error: function (request, status, error) {
            M.toast({
                html: error
            });
        },
        complete: function (msg) {}
    });
});
/*$("#cancel-ordencompra").on('click', function () {
    //$('#modal4-oc').on
    var post = $('#descripcion_cancel_oc').serializeArray();
    var path = window.location.pathname;
    var ordencompra_id = path.substring(path.lastIndexOf('/') + 1);
    //var mdlcancel=document.getElementById('modal4-oc');
    //var descrip_cancel=document.fin
    //console.log(mdlcancel);

    $.ajax({
        type: "POST",
        url: path_url_cancelordencompra,
        //dataType: 'json',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            descripcion: post[0].value,
            ordencompra_id: ordencompra_id
        },
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {

        },
        success: function (response) {
            //console.log(response);
            if (response.length == 0) {
                M.toast({
                    html: 'Requisición cancelada'
                })
                setTimeout(document.location.href = path_irdenes_compras_home, 3000);
            } else {
                M.toast({
                    html: response
                });
                //setTimeout(location.reload(), 2000);
            }
        },
        error: function (request, status, error) {
            M.toast({
                html: error
            });
        },
        complete: function (msg) {}
    });
});*/
//---------------------------------

$("#formCancelarOC").validate({
    rules: {
        descripciond: {
            required: true,
        },
    },
    rules:{
        ordencompra_id:{
            required:true,
        },
    },
    //For custom messages
    messages: {
        descripciond: {
            required: "Completa este campo",
        },
    },
    errorElement: 'div',
    errorClass: "invalid",
    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function (form) {
        var post = $('#formCancelarOC').serializeArray();
        //console.log(post);
        $.ajax({
            type: "POST",
            url: path_url_cancelordencompra,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: post,
            
            beforeSend: function (x) {

            },
            success: function (response) {
                console.log(response[0]);
                if (response.length == 0) {
                    M.toast({
                        html: 'Requisición cancelada'
                    })
                    setTimeout(document.location.href = path_irdenes_compras_home, 3000);
                } else {
                    M.toast({
                        html: response[0].Proceso
                    });
                    //setTimeout(location.reload(), 2000);
                }
            },
            error: function (request, status, error) {
                M.toast({
                    html: error
                });
            },
            complete: function (msg) {}
        });
    }
});
//----------------------------------
//--------Fin Autorizar
//send Email PDF
function SendEmailPDFAuthOC(id) {

    $.ajax({
        type: "POST",
        url: path_url_sendemail_auth_oc,
        dataType: 'json',

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            ordencompra_id: id
        },
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {

        },
        success: function (response) {
            M.toast({
                html: response.data
            });

        },
        error: function (request, status, error) {
            M.toast({
                html: error
            });
        },
        complete: function (msg) {}
    });
}
$('.validarformulario').click(function(event){
    event.preventDefault();
    //console.log($(this).attr('form'))
    validarFormularioUrl($(this).attr('form'))
});
function validarFormularioUrl(formularioid){
    let form = $('#'+formularioid),
        url = form.attr('action'),
        //method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT'; 
        metodo=form.attr('method');       
    form.find('.helper-text').remove();
    form.find('.invalid').removeClass('invalid');
    form.find('.input-field').removeClass('error');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $.ajax({
        url : url,
        method: metodo,
        data : form.serialize(),
        success: function (response) { 
            // 
            console.log(response);
            // form.trigger('reset');
            if(response.estatus==true){
                form.trigger('reset')
                if(response.message){
                    console.log(response)
                    M.toast({ 
                        html: response.message,
                    });
                    //     alertify.success(response.message);
                    setTimeout(function(){location.href=response.data},3000);
                    
                }else{
                    console.log(response)
                    location.href=response.data
                }
            }else{
                console.log(response)
                M.toast({ 
                    html: response.data,
                });
                // alertify.error(response.data);
            }
        },
        error : function (xhr) {
            console.log(xhr);
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, value) {
                    //let input=$('#' + key).after('<span class="helper-text red-text">'+value+'</span>')
                    let input=$("[name="+key+"]").after('<span class="helper-text red-text">'+value+'</span>')
                    input.addClass('invalid')
                    .addClass('error')
                    //.addClass('requerido')
                    //.append('<span class="helper-text">'+value+'</span>');
                    form.find('.invalid')[0].focus();
                });
                
            }
        }
    })
}
$('.activarbloque').on('click',function(){
    // var x = document.getElementsByClassName('bloque');
    let x = $('.bloque');
    let s=x.attr('style')
    if (s === "display: none;") {
        x.attr('style','display: block;');
    } else {
        x.attr('style','display: none;');
    }
})
$('.verify_moneda').on('change',function(){
    let url=$(this).attr('url-record')
    url=url.replace('/000','/'+$(this).val())
    //console.log(url);
    validarMoneda(url,'GET','')
})
function validarMoneda(url,metodo,data){
    $.ajax({
        url : url,
        method: metodo,
        data : data,
        success: function (response) { 
            let b = $('.buttonmonedaextranjera');
            if(response.estatus==true){
                b.addClass('hide')
                //b[0].firstChild.addClass('white-text');
                //b[0].childNodes[0].classList.add('white-text');
            } else {
                M.toast({ 
                    html: "Se tiene que configurar otros datos",
                });
                b.removeClass('hide')
                //b[0].childNodes[0].classList.remove('white-text');
                //b[0].firstChild.removeClass('red-text');
            }
        },
        error : function (xhr) {
            console.log(xhr);
        }
    })
}
var listar = function(ordencompraid){
    dataTable_oc= $('#tableArticles-oc').DataTable({
        // destroy: true,
        // data: data,
        ajax:{
            "method":"GET",
            "url": peth_url_get_articulos_oc,
            // "dataSrc":""
        },
            
        "columns":[
            // {"defaultContent":null,'data':"id"},
            {"defaultContent":'<input class="cantidadnumeric" id="cantidad-nadad" type="number" min="0" name="cantidad-na" /><input type="hidden" id="req-na" name="req-na" value="'+ordencompraid+'"/> '},
            {'data':"unidad_compra"},
            {'data':"nombre","defaultContent":'<input type="hidden" id="nombre-art" name="nombre-art" value="{{"data":"nombre"}}"/>'},
            {"defaultContent":'<input id="nota-na" name="nota-na">'}
        ],
        "language":idiomaEp
            
    });
}
var idiomaEp={
    "searchPlaceholder": "Buscar artículo",
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};
/*var listarReq = function(){
    // let ordencompraid=30;
    
    $('#tableRequisitions-oc').DataTable({
            destroy: true,
            "drawCallback": function () {
                $('.tooltipped').tooltip();
            },
            // data: data,
            ajax:{
                "method":"GET",
                "url": peth_url_get_requisitions_oc,
                "dataSrc":""
            },
            "columns":[
                // {"defaultContent":null,'data':"id"},
                
                {"data":"folio"},
                {"data":"fecha"},
                {"data":"descripcion"},
                {"data":'estatus'},
                {"data":"usuario_creacion"},
                // {"defaultContent":`<a class="auth-record" href="#">
                //     <i class="material-icons agregar_requ_oc tooltipped"  data-tooltip="Agregar"  id-record="`+{"data":"docto_requisicion_id"}.value+`" >check_box</i>
                //     </a>
                //     <i class="material-icons view-record-oc2 tooltipped" data-tooltip="Visualizar" id-record="`+{"data":"docto_requisicion_id"}.value+`">remove_red_eye</i>`},
                {"render":
                function ( data, type, row ) {
                    // console.log(row.docto_requisicion_id)
                    return (`<a class="auth-record" href="#">
                    <i class="material-icons agregar_requ_oc tooltipped"  data-tooltip="Agregar"  id-record="`+row.docto_requisicion_id+`" >check_box</i>
                    </a>
                    <i class="material-icons view-record-oc2 tooltipped" data-tooltip="Visualizar" id-record="`+row.docto_requisicion_id+`">remove_red_eye</i>`);
                }
                },
                {
                    "visible": false,
                    "data":"docto_requisicion_id"}
            ],
            "data":function(){
                console.log(data)
            },
            "language":idiomaEp
            
        },
    );
    
}*/
function removerasht(txt){
    txt=txt.replace('!','')
    txt=txt.replace('#','')
    return txt;
}
/*var listarArticulos = function(ordencompraid){
    let url=$('#tableArticles-oc')[0].getAttribute('url-record');
    //console.log(url)
    dataTable_oc= $('#tableArticles-oc').DataTable({
        //paging: false,
        //searching: false,
        destroy: true,
        // data: data,
        ajax:{
            "method":"GET",
            "url": url,
            // "dataSrc":""
        },
        "columns":[
            // {"defaultContent":null,'data':"id"},
            {"defaultContent":'<input class="cantidadnumeric" id="cantidad-nadad" type="number" min="0" name="cantidad-na" /><input type="hidden" id="req-na" name="req-na" value="'+ordencompraid+'"/> '},
            {'data':"unidad_compra"},
            {'data':"nombre","defaultContent":'<input type="hidden" id="nombre-art" name="nombre-art" value="{{"data":"nombre"}}"/>'},
            {"defaultContent":'<input id="nota-na" name="nota-na">'}
        ],
        "data":function(){
            console.log(data)
        },
        "language":idiomaEp
    },);
}*/

