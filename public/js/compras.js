var tiemposession=parseInt($('[name=sessionlifetime]').attr('value'),10);
var finsession=nowmasmin(tiemposession);
function nowmasmin(minutos=0){
    let currentDateObj = new Date();
    let numberOfMlSeconds = currentDateObj.getTime();
    let addMlSeconds = minutos * 60000;
    let newDateObj = new Date(numberOfMlSeconds + addMlSeconds);
    return newDateObj;
}
$(document).on('mouseenter',function(){
    if(new Date() > finsession){
        finsession=nowmasmin(1);
        $('body').removeClass('loaded');
        this.location.reload();
    }
})
$(document).on('mouseleave',function(){
    finsession=nowmasmin(tiemposession);
})
//var finsession=nowmasmin(1);
$('[name=sessionlifetime]').remove();
var sessionTerminada=true;
$(window).on('load', function () {
    setTimeout(function () {
        $('body').addClass('loaded');
    }, 200);
});

/*function mueveReloj(){
    tiempoTranscurridoSeg++;
    if(tiempoTranscurridoSeg==60){
        tiempoTranscurridoSeg=0;
        tiempoTranscurridoMin++;
    }
    if(tiempoTranscurridoMin >= tiempoEspera){
        sessionTerminada=true;
    }else{
        setTimeout("mueveReloj()",1000)
    }
}*/
var dataTable_oc;
var tabla_det;
var datos_fin_liga;
var datos_tabla;
var datos_tabla2;
var datos_tabla_articulos
var tabla_contactos_email;
//tabla responsive de ordenes de compra------------------------------------------
$(document).ready(function () {
    
    Number.isInteger = Number.isInteger || function (value) {
        return typeof value === "number" &&
            isFinite(value) &&
            Math.floor(value) === value;
    };
    
  	//console.log('recorrio js');
//   if(document.location.href.includes("ordencompra/edit/")){
//         let ordencompraid = document.location.href.substring(document.location.href.lastIndexOf('/') + 1)
//         ordencompraid=removerasht(ordencompraid);
//         // tablaArticulos(ordencompraid);
//     	//console.log(ordencompraid)
//         listar(ordencompraid);
//         //listarReq();
//         // llenar_articulos(ordencompraid);
//     }
    /*if(document.location.href.includes("recepcionmercancia/editar/")){
        // if($('.verify_moneda').attr('url-record')){
        //     let url=$('.verify_moneda').attr('url-record');
        //     url=url.replace('/000','/'+$('.verify_moneda').val())
        //     //console.log(url);
        //     validarMoneda(url,'GET','')
        //     url=$('.selectProveedor1').attr('url-record')
        //     verificarProveedor(url,'GET','');
        // }
        let ordencompraid = document.location.href.substring(document.location.href.lastIndexOf('/') + 1)
        ordencompraid=removerasht(ordencompraid);
        listarArticulos(ordencompraid);
        //console.log(ordencompraid)
    }*/
    if($('.verify_moneda').attr('url-record')){
        let url=$('.verify_moneda').attr('url-record');
        url=url.replace('/000','/'+$('.verify_moneda').val())
        //console.log(url);
        validarMoneda(url,'GET','')
        url=$('.selectProveedor').attr('url-verify')
        //console.log(url)
        if(!url.includes("000")){
            verificarProveedor(url,'GET','');
        }
    }
    
    tabla_det=$('#tabladet').DataTable({
        paging:false,
        searching:false,
        ordering: false,
        scrollY: "400px",
        scrollCollapse:true,
        info:false
    });
    // var ordenar=null
    // if($('#tableGeneral').attr('order')){
    //     let o=$('#tableGeneral').attr('order').split(',')
    //     if(o.length==1){
    //         ordenar=[[o[0],'desc']]
    //     }else{
    //         ordenar=[[o[0],o[1]]]
    //     }
    // }
    $('#tableGeneral').DataTable({
        "aaSorting": [],
        destroy:true,
        //order:false,
        //"aaSorting": [1],
        //order: [[if($('#tableGeneral').attr('order')) , 'desc']],
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
    
//---------Selectorde proveedor--------------------------
if($('.selectProveedor').attr('url-record')){
    selectInModalByTerm('selectProveedor');
}
    /*$('.selectProveedor').select2({
        ajax: {
            url: pat_url_proveedorByTerm,
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
        //dropdownParent: $("#"+$('.selectProveedor').attr('modal-parent'))
        //dropdownParent:$('#NuevaOCRequ')
    });*/
    //---------fin selector proveedor---------------------
    // dataTable.on( 'draw', function () {
    //
    // } );
    //select con buscador------------------------------------
    $('.selectBuscador').select2({
        destroy:true,
        ajax: {
            url: $('.selectBuscador').attr('url-select'),
            //url:path_url_costsbytype_oc,
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
        language: selectEsp,
        delay: 1500,
        closeOnSelect: true,
        // function(){
        //     if($('.selectBuscador').attr('modal-parent')){
        //         {'dropdownParent':$("#modalnewE")},
        //     }
        // },
        //'dropdownParent': $("#modalnewE")
    });
    //----------fin           -------------------------






    $('#loader_det_articulos').hide();
    $('#loader_archivos').hide();
    $('.carousel.indicadores').carousel({
        indicators: true
    });
    $('.materialboxed').materialbox();
    $('.tabs').tabs();

    $(document).on("click", ".view-record-oc", function (event) {

        var id = this.getAttribute('id-record');
        var iframe = document.getElementById("if-requisicion");
        let url = path_url_iframe_oc+"elim";
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
        url = url.replace("/"+id_ant, "/"+id);
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
        let data = {docto_id:this.getAttribute('id-record')};
        let url=this.getAttribute('url-record');
        //console.log(data);
        urlDatosArray(url,"POST",data);
        //sendEmailOC(data,url);
    });
    $(document).on('click','.email-cotizacion',function(event){
        event.preventDefault();
        let proveedor=this.getAttribute('prov-record');
        let doctoid=this.getAttribute('id-record')
        listarTablacontactos(proveedor,doctoid);
        abrirModal('SendEmailContactos');
        //console.log(doctoid)
    })
    $(document).on('click','.cancelar-docto',function(event){
        event.preventDefault();
        let doctoid=this.getAttribute('id-record');
        if($(this).attr('with-modal')){
            let nombre=this.getAttribute('campo_id_name');
            let modalid=this.getAttribute('with-modal');
            $('[name='+nombre+']').attr('value',doctoid)
            abrirModal(modalid);
        }else{
            let uri=this.getAttribute('url-record');
            let data={docto_id:doctoid};
            urlDatosArray(uri,'POST',data);
        }
    });

    // $(document).on("click", "#btnAddArticles-oc", function (event) {
    // drawDataTableArticles();
    // });


    $('#save-articles-oc').on('click', function () {

        getCheckedOC(dataTable_oc);

    });

    //var tableArticles = $('#tableArticles-oc').DataTable();
    //var tabla2 = $("#tableArticles-oc");

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

        "language": idiomaEp,
        "drawCallback": function () {
            $('.tooltipped').tooltip();
        }
    });

    $('.modal').modal();
    $('.fixed-action-btn').floatingActionButton();
    $('.tooltipped').tooltip();
    //for right or left click(any)
    $('.tooltipped').mousedown(function () {
        $('.material-tooltip').css("visibility", "hidden");
    });

    // leaving after click in case you open link in new tab
    $('.tooltipped').mouseleave(function () {
        $('.material-tooltip').css("visibility", "hidden");
    });
    $('select').formSelect();

    
    //-------------------------------------------
    
    
});
//fin tabla responsive ordenes compras-----------------------------------
//comiensa formulario nueva orden de compra-----------------------------------------
/*$("#formOrdenCompra").validate({
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
        moneda:{
            required:true,
        }
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
        moneda:{
            required:"Completa este campo",
        }
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
});*/

// fin formulario nueva orden de compra---------------------------------------

//formulario agregar articulo a orden compra----------------------------------

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
            //console.log(data2[i].name)
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

		/*$('#tableArticles-oc tbody tr').each(function(index, item) {
        	let cantidad, idordencompra, articulo,nota;
            $(this).children('td').each(function(index2){
                switch (index2) {
                    case 0:
                        cantidad=$(this).find('input')[0].value
                        idordencompra=$(this).find('input')[1].value
                        break;
                    case 1:
                        break;
                    case 2:
                        articulo=$(this).text();
                        break;
                    case 3:
                        nota=$(this).find('input')[0].value
                        break;
                }
                if(cantidad !='' && cantidad != 0){
                    arreglo[index]={
                    'cantidad':cantidad,
                    'req':idordencompra,
                    'nombre':articulo,
                    'nota':nota
                    }
            
                }
            })
        });*/
        
        //console.log(datosf);
        $.ajax({
            type: "POST",
            url: path_url_submitarticles_oc,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                jsonArticles: JSON.stringify(datosf)
            },
            beforeSend: function (x) {

            },
            success: function (response) {
                console.log(response)
                if(response.status==false){
                    M.toast({
                        html: response.data
                    });
                }else{
                    M.toast({
                        html: 'Registro agregado exitosamente'
                    });
                    setTimeout(location.reload(), 100);
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
                
                setTimeout(location.reload(), 100);
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
/*$("#formOrdenCompraEdit").validate({
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
});*/
//------Fin editar Orden Compra

//-------fin agreagr-------------------
//------funcion para finalizar orden de compra
// $("#finaliza-ordencompra").on('click', function (event) {
//     event.preventDefault();
//     let url=this.getAttribute('href');
//     let data={ordencompra_id:this.getAttribute('id-record')};
//     let url2=this.getAttribute('url-record');
//     AplicarDocto(url,data,url2);

// });
$("#auth-ordencompra").on('click', function (event) {
    event.preventDefault();
    let url=this.getAttribute('href');
    let data={docto_id:this.getAttribute('id-record')};
    let url2=this.getAttribute('url-record');
    console.log(url+" <> "+url2);
    AplicarDocto(url,data,url2);
});
function AplicarDocto(url,data,url2) {

    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            jsonData: JSON.stringify(data)
        },
        beforeSend: function (x) {

        },
        success: function (response) {
            console.log(response)
            if(response.status == true){
                urlDatosArray(url2,"POST",data,false);
                setTimeout(document.location.href = response.data, 100);
            }else{
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
/*function sendEmailOC(id,uri) {

    $.ajax({
        type: "POST",
        url: uri,
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
}*/

//-----fin funcion enviar email
//-------Autorizacion de orden de compra-------
/*$("#auth-ordencompra").on('click', function () {

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
});*/
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

/*$("#formCancelarOC").validate({
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
});*/
//----------------------------------
//--------Fin Autorizar
//send Email PDF
/*function SendEmailPDFAuthOC(id) {

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
}*/
var tablaArticulos = function (ordencompraid){
        axios.get('/ordencompra/articulos')
        .then(function (response) {
            // handle success
            //const ordencompraid = document.location.href.substring(document.location.href.lastIndexOf('/') + 1)
            var mesge='';
            console.log(response);
            let lista = document.getElementById("tblArticles-oc");
            // let tr = document.createElement("tr");
            // let columna = document.createElement("td")
            
            let element=document.createElement("input")
            $.each(response.data.data,function(i,item){
                let tr = document.createElement("tr");
                let atributo=document.createAttribute('id')
                atributo.value=item['id']
                tr.setAttributeNode(atributo);
                
                // // console.log(item)
                atributo=document.createAttribute('id')
                atributo.value="cantidad"
                let columna = document.createElement("td")
                columna.setAttributeNode(atributo);
                columna.classList.add('tblArticles-oc')
    
                columna.innerHTML = `<input class="cantidadnumeric" id="cantidad-`+item['id']+`" type="number" min="0" name="cantidad-`+item['id']+`"/>
                    <input type="hidden" id="req-`+item['id']+`" name="req-`+item['id']+`" value="`+ordencompraid+`"/>
                    <input type="hidden" id="nombre-`+item['id']+`" name="nombre-`+item['id']+`" value="`+item['nombre']+`"/>`;
                tr.appendChild(columna)
    
                columna = document.createElement("td")
                columna.classList.add('tblArticles-oc')
                columna.innerHTML=item['unidad_compra']
                tr.appendChild(columna)
                
                columna = document.createElement("td")
                columna.classList.add('tblArticles-oc')
                columna.innerHTML=item['nombre']
                tr.appendChild(columna)
    
                columna = document.createElement("td")
                columna.classList.add('tblArticles-oc')
                columna.innerHTML=`<input id="nota-`+item['id']+`" name="nota-`+item['id']+`">`
                tr.appendChild(columna)
                    // let columna = document.createElement("td")
                    // columna.innerHTML = item[key];
                    // //console.log(item[key]);
                    // tr.appendChild(columna)
                //     mesge=item['id']
                // atributo.value=item['id']
                // tr.setAttributeNode(atributo);
                // atributo=document.createAttribute(id);
                // atributo.value="cantidad";
                // columna.setAttributeNode(atributo);
                // columna.innerHTML=`<input class="cantidadnumeric" id="cantidad-`+item['id']+`" type="number" min="0" name="cantidad-`+item['id']+`"/>
                //                     <input type="hidden" id="req-`+item['id']+`" name="req-`+item['id']+`" value="{{ Request::route('id') }}"/>
                //                     <input type="hidden" id="nombre-`+item['id']+`" name="nombre-`+item['id']+`" value="`+item['nombre']+`"/>`
                // columna.innerHTML=`<input type="hidden" id="req-{{ $articulo->articulo_id }}" name="req-{{ $articulo->articulo_id }}" value="{{ Request::route('id') }}"/>`
                // tr.appendChild(columna)
    
                // columna=document.createElement("td");
                // columna.innerHTML=item['unidad_compra']
                // tr.appendChild(columna)
                lista.appendChild(tr);
            })
            
            updatetabla("tableArticles-oc");
            dataTable_oc=$('#tableArticles-oc').DataTable();
            //  let sele=document.getElementsByName('tableArticles-oc_length')
            //  sele.classList('hide').remove();
            console.log(ordencompraid);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });
}
//var listar = function(ordencompraid){
    // let ordencompraid=30;
    //console.log(peth_url_get_requisitions_oc)
    
    // dataTable_oc= $('#tableArticles-oc').DataTable({
    //         destroy: true,
    //         // data: data,
    //         ajax:{
    //             "method":"GET",
    //             "url": peth_url_get_articulos_oc,
    //             "dataSrc":""
    //         },
            
    //         "columns":[
    //             // {"defaultContent":null,'data':"id"},
    //             //{"defaultContent":' '},
    //             {"render": function ( data, type, row ) {
    //                 // console.log(row.docto_requisicion_id)
    //                 return (
    //                     `<input class="cantidadnumeric" id="cantidad-`+row.articulo_id+`" type="number" min="0" name="cantidad-`+row.articulo_id+`" />
    //                     <input type="hidden" id="req-`+row.articulo_id+`" name="req-`+row.articulo_id+`" value="`+ordencompraid+`"/>
    //                     <input type="hidden" id="nombre-`+row.articulo_id+`" name="nombre-`+row.articulo_id+`" value="`+row.nombre+`"/>`
    //                 );
    //                 }
    //             },
    //             {'data':"unidad_compra"},
    //             {'data':"nombre"},
    //             //{"defaultContent":'<input id="nota-na" name="nota-na">'},
    //             {"render": function ( data, type, row ) {
    //                 // console.log(row.docto_requisicion_id)
    //                 return (
    //                     `<input id="nota-`+row.articulo_id+`" name="nota-`+row.articulo_id+`">`
    //                 );
    //                 }
    //             }
    //         ],
    //         "language":idiomaEp
            
    //     });
//}
var updatetabla =  function (table){
    $('#'+table).DataTable({
        // serverSide: true,
        // destroy: true,
        paging: true,
        responsive: true,
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
         }],
        lengthMenu: [
            [10, 25, 50, 100, -1], 
            [10, 25, 50, 100, "All"]
        ],
        "pagingType": "full_numbers",
        pageLength: 10,

        "language": idiomaEp,
    });
}
/*var listarReq = function(){
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
            {"render": function ( data, type, row ) {
                    // console.log(row.docto_requisicion_id)
                    return (`<a class="auth-record" href="#">
                    <i class="material-icons agregar_requ_oc tooltipped"  data-tooltip="Agregar"  id-record="`+row.docto_requisicion_id+`" >check_box</i>
                    </a>
                    <i class="material-icons view-record-oc2 tooltipped" data-tooltip="Visualizar" id-record="`+row.docto_requisicion_id+`">remove_red_eye</i>`);
                }
            },
            {
                "visible": false,
                "data":"docto_requisicion_id"
            }
        ],
        "data":function(){
            console.log(data)
        },
        "language":idiomaEp
                
    },);  
}*/
function removerasht(txt){
    txt=txt.replace('!','')
    txt=txt.replace('#','')
    return txt;
}
var idiomaEp={
    
    "searchPlaceholder": "Buscar",
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
var modificarRequisicion = function(){
    $('#tableRequisitions-oc tbody tr').each(function(index, item) {
        console.log($(this))
        console.log(index)
        $(this).children('td').each(function(index2){
            console.log(index2)
            switch (index2) {
                // case 0:
                //     cantidad=$(this).find('input')[0].value
                //     // console.log($(this).find('input')[0].value);
                //     // console.log($(this).find('input')[1].value);
                //     idordencompra=$(this).find('input')[1].value
                //     break;
                // case 1:
                //     // console.log($(this).text());
                //     break;
                // case 2:
                //     // console.log($(this).text());
                //     articulo=$(this).text();
                //     break;
                // case 3:
                //     // console.log($(this).find('input')[0].value);
                //     nota=$(this).find('input')[0].value
                //     break;
            }
        })
    })
}
$('.verify_moneda').on('change',function(){
    let url=$(this).attr('url-record')
    url=url.replace('/000','/'+$(this).val())
    //console.log(url);
    validarMoneda(url,'GET','')
})
//$('.selectProveedor').change(function(event){
$(document).on('change','.selectProveedor',function(event){
    if($(this).attr('url-verify')){
    //if(!document.location.href.includes('nueva') || document.location.href.includes('recepcionmercancia/nueva')){
        console.log('cambio prov')
    event.preventDefault();
    let url=$(this).attr('url-verify')
    url=url.replace('/000','/'+$(this).val())
    verificarProveedor(url,'GET','');
    }
})
function verificarProveedor(url,metodo,data){
    $.ajax({
        url : url,
        method: metodo,
        data : data,
        success: function (response) { 
            //console.log(response)
            let a= $('input[name=gastos_aduanales]')
            let b = $('input[name=arancel]');
            //console.log(b[0]);
            if(response.status==true){
                //a.removeClass('hide')
                //b.removeClass('hide')
                a.attr('disabled',false)
                b.attr('disabled',false)
            } else {
                a.attr('disabled',true)
                b.attr('disabled',true)
                //a.addClass('hide')
                //b.addClass('hide')
            }
        },
        error : function (xhr) {
            console.log(xhr);
        }
    })
}
function validarMoneda(url,metodo,data){
    $.ajax({
        url : url,
        method: metodo,
        data : data,
        success: function (response) { 
            let b = $('.buttonmonedaextranjera');
            if(response.status==true){
                b.addClass('hide')
                //b[0].firstChild.addClass('white-text');
                //b[0].childNodes[0].classList.add('white-text');
            } else {
                if(!document.location.href.toString().includes('recepcionmercancia/visualizar/'))
                {
                    let tipCambio = parseFloat($('[name=tipo_cambio]').attr('value')).toFixed(2)
                    console.log(tipCambio);
                    if(tipCambio<=0){
                        M.toast({ 
                            html: "Debe indicar el tipo de cambio",
                        });
                    }
                }
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
/*var listarArticulos = function(ordencompraid){
    //console.log($('#tableArticles'))
    let url=$('#tableArticles')[0].getAttribute('url-record');
    //console.log(dataTable_oc)
    dataTable_oc= $('#tableArticles').DataTable({
        //paging: false,
        //searching: false,
        destroy: true,
        // data: data,
        ajax:{
            "method":"GET",
            "url": url,
            "dataSrc":""
        },
        "columns":[
            // {"defaultContent":null,'data':"id"},
            {"render": function ( data, type, row ) {
                // console.log(row.docto_requisicion_id)
                return (
                    `<input class="cantidadnumeric" id="cantidad-`+row.articulo_id+`" type="number" min="0" name="cantidad-`+row.articulo_id+`" />
                    <input type="hidden" id="req-`+row.articulo_id+`" name="req-`+row.articulo_id+`" value="`+ordencompraid+`"/>
                    <input type="hidden" id="nombre-`+row.articulo_id+`" name="nombre-`+row.articulo_id+`" value="`+row.articulo_id+`"/>`
                );
                }
            },
            {'data':"unidad_compra"},
            {"render": function ( data, type, row ) {
                // console.log(row.docto_requisicion_id)
                return (
                    `<input id="precio-`+row.articulo_id+`" type="number" class="noarrows" min="0" name="precio-`+row.articulo_id+`" value="`+row.precio+`"/>`
                );
                }
            },
            {'data':"nombre"},
            {"data":'pesar'},
            // {"render": function ( data, type, row ) {
            //     // console.log(row.docto_requisicion_id)
            //     return (
            //         `<input id="nota-`+row.articulo_id+`" name="nota-`+row.articulo_id+`">`
            //     );
            //     }
            // }
        ],
        "data":function(){
            console.log(data)
        },
        "language":idiomaEp
    });
    //console.log(dataTable_oc)
}*/
//Obtiene los datos que tienen cantidad de la tabla enviada

$(document).on('click','.agregar_tabla_articulos',function(event){
    event.preventDefault();
    let data=getChekedTable(datos_tabla);
    let uri;
    console.log(data);
    uri=$(this).attr('url-record');
   if(Object.values(data).length>0){
        urlDatosArray(uri,"POST",data);
    }
})
$(document).on('click','.agregar_tabla',function(event){
    event.preventDefault();
    let data=getChekedTable(datos_tabla);
    let uri;
    console.log(data);
    if($(this).attr('url-record')){
        uri=$(this).attr('url-record');
    }else{
        uri=document.location.href+"/ordenescompraporrecibir/agregar";
    }
   if(Object.values(data).length>0){
        urlDatosArray(uri,"POST",data);
    }
})
$(document).on('click','.agregar_tabla_ligada',function(event){
    event.preventDefault();
    let data=getChekedTable(datos_tabla);
    //console.log($(this).attr('href'));
    let uri=$(this).attr('href');
    // let uri=document.location.href+"/ordenescompraporrecibir/agregar";
    if(Object.values(data).length>0){
         urlDatosArray(uri,"POST",data);
    }
})
$(document).on('click','.agregar_seleccionados_gen',function(event){
    event.preventDefault();
    let data=getChekedTable(datos_tabla);
    //console.log($(this).attr('href'));
    let uri=$(this).attr('href');
    let idsarray=obtenerArregloString(data,'cantidad');
    
    //console.log(idsarray.doctosArray);
    // let uri=document.location.href+"/ordenescompraporrecibir/agregar";
    if(Object.values(data).length>0){
        let idgeneral=Object.values(data)[0]['idgeneral'];
        //console.log({'idsArrays':idsarray.doctosArray,'idgeneral':idgeneral})
        urlDatosArray(uri,"POST",{'idsArrays':idsarray.doctosArray,'idgeneral':idgeneral});
    }
})
function obtenerArregloString(data,campo){
    let reqs='';
    for(var i=0;i<Object.values(data).length;i++){
        reqs+=Object.values(data)[i][campo];
        if(i!=Object.values(data).length-1){
            reqs+=',';
        }
    }
    reqs={doctosArray:reqs};
    return reqs;
}
$(document).on('click','.agregar_tabla_ligada_rec_co',function(event){
    event.preventDefault();
    let data=getChekedTable(datos_tabla);
    //console.log(data)
    if(Object.values(data).length>0){
        let doctos=obtenerArregloString(data,'recepcion');
        let uri=$(this).attr('href');
        //console.log(doctos);
        urlDatosArray(uri,"POST",doctos);
    }
})
$(document).on('click','.agregar_tabla_ligada_oc_rec',function(event){
    event.preventDefault();
    let data=getChekedTable(datos_tabla);
    //console.log(data);
    if(Object.values(data).length>0){
        let ordenes=obtenerArregloString(data,'ordenid');
        let uri=$(this).attr('href');
        urlDatosArray(uri,"POST",ordenes);
    }
})
$(document).on('click','.agregar_tabla_ligada_array_detalle',function(event){
    event.preventDefault();
    let data=getChekedTable(datos_tabla);
    //console.log(data);
    if($(this).attr('tabla-record')){
        data=getChekedTable(datos_tabla2);
    }
    //console.log(data);
    if(Object.values(data).length>0){
        let reqs=obtenerArregloString(data,'requ');
        if(reqs.doctosArray=='undefined'){
            reqs=obtenerArregloString(data,'cantidad');
        }
        console.log(reqs)
        let doctos=$("[name=doctos_ids]")
        doctos.attr('value',reqs.doctosArray);
        if($(".selectFamilia")){
            let familiaSelect=$(".selectFamilia")
            familiaSelect.attr('data-record',reqs.doctosArray);
            if(familiaSelect.attr('url-record')){
                selectInModalByTerm('selectFamilia');
            }
        }
        abrirModal($(this).attr('href'))
        //console.log($('.selectProveedor_modal').attr('modal-parent'));
        selectInModalByTerm('selectProveedor_modal');
    }
    //console.log(reqs);
    //let uri=$(this).attr('href');
    // let uri=document.location.href+"/ordenescompraporrecibir/agregar";
    /*if(Object.values(data).length>0){
         urlDatosArray(uri,"POST",data);
    }*/
})
/*$(document).on('click','.agregar_tabla_ligada_array_detalle2',function(event){
    event.preventDefault();
    let data=getChekedTable(datos_tabla2);
    console.log(data);
    if(Object.values(data).length>0){
        let reqs=obtenerArregloString(data,'requ');
        //console.log(reqs)
        let doctos=$("[name=doctos_ids]")
        doctos.attr('value',reqs.doctosArray);
        if($(".selectFamilia")){
            let familiaSelect=$(".selectFamilia")
            familiaSelect.attr('data-record',reqs.doctosArray);
            if(familiaSelect.attr('url-record')){
                selectInModalByTerm('selectFamilia');
            }
        }
        abrirModal($(this).attr('href'))
        //console.log($('.selectProveedor_modal').attr('modal-parent'));
        selectInModalByTerm('selectProveedor_modal');
    }
    //console.log(reqs);
    //let uri=$(this).attr('href');
    // let uri=document.location.href+"/ordenescompraporrecibir/agregar";
    
})*/
$('.finalizar_ligada').click(function(event){
    event.preventDefault();
    let completo=1;
    let condatos=0;
    //let data=getChekedTable(dataTable_oc);
    let data=getChekedTable(tabla_det);
    //console.log(data)
    Object.keys(data).forEach( function(value,index,array,Object){
        // console.log(data[value].cantidad)
        // console.log(data[value].recibidas)
        if(parseFloat(data[value].recibidas) > 0){
            condatos=1;
        }
        if(parseFloat(data[value].cantidad) > parseFloat(data[value].recibidas)){
            completo=0;
        }
    })
    if(condatos==1){
        if (completo==0){
            datos_fin_liga=data;
            //console.log(datos_fin_liga)
            abrirModal('modalfinalizarligadaincompleta')
        }else{
            //console.log($(this).attr('form'))
            let elemnt=$('#'+$(this).attr('form'))
            peticionAjaxconData(elemnt.attr('action'),data,elemnt.attr('method'))
            //finalizarecepcionligada(data,'#'+$(this).attr('form'));
        }
    }else{
        M.toast({html:"No se puede finalizar sin agregar artículos"})
    }
})
$(document).on("click",".finalizar_oc_ligada_mod",function(event){
    event.preventDefault();
    //href="#modalfinalizarligada" hrefincom="modalfinalizarligadaincompleta"
    let completo=1;
    let iniciado=0;
    let data=getChekedTable(tabla_det);
    Object.keys(data).forEach( function(value,index,array,Object){
        if(parseFloat(data[value].recibidas) > 0){
           
            iniciado=1;
        }
        if(parseFloat(data[value].cantidad) > parseFloat(data[value].recibidas)){
         
            completo=0;
        }
    })
    if(iniciado==1){
        datos_fin_liga=data;
        if (completo==0){
            abrirModal('modalfinalizarligadaincompleta')
        }else{
            abrirModal('modalfinalizarligada')
        }
    }else{
        M.toast({html:"No se puede finalizar sin agregar artículos"})
    }
})
$('.finalizar_oc_ligada').click(function(event){
    event.preventDefault();
    peticionAjaxconData($(this).attr('action'),datos_fin_liga,$(this).attr('method'))
    //finalizarecepcionligada(datos_fin_liga,'#'+$(this).attr('id'));
})
function getChekedTable(dataTable){
    let datosf = {}
    var data = dataTable.rows({
        selected: true
    }).data();
    var data2 = dataTable.$('input,select').serializeArray();
    var arreglo = new Object();
    var largo = data2.length;
    console.log(largo)
    if (largo > 0) {
        for (var i = 0; i < largo; i++) {
            if (data2[i].value != '') {
                var str = data2[i].name;
                var res = str.split("-");
                    if (typeof arreglo[res[1]] == 'undefined') {
                        arreglo[res[1]] = {};
                        arreglo[res[1]][res[0]] = data2[i].value;
                    } else {
                        arreglo[res[1]][res[0]] = data2[i].value;
                    }
            }
        }
        var index = 0;
        //var datosf = {};

        for (var clave in arreglo) {
            if (arreglo[clave].hasOwnProperty('cantidad')) {
                if(arreglo[clave]['cantidad']>0){
                    datosf[clave] = arreglo[clave];
                }
            }
        }
    }
    return datosf;
}
function agregarArticulosArray(url,datos){
    /*console.log(url)
    console.log(datos)
    console.log($('meta[name="csrf-token"]').attr('content'))*/
    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            jsonArticles: JSON.stringify(datos)
        },
        //dataType: 'json',
        //contentType: "application/json; charset=utf-8",
        beforeSend: function (x) {

        },
        success: function (response) {
            console.log(response)
            if(response.status==true){
                if(response.message){
                    M.toast({
                        html: response.message
                    });
                }
                if(response.data){
                    let result=response.data;
                    if(result==="reload"){
                        setTimeout(location.reload(), 100);
                    }else{
                        setTimeout(location.href=result, 100);
                    }
                }
            }else{
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
$('.guardar_articulos').click(function(event){
    event.preventDefault();
    let uri=$(this).attr('href');
    let data=getChekedTable(datos_tabla);
    console.log(data);
    if(Object.values(data).length>0){
        deleteAddRenglonG(uri,{jsonArticles: JSON.stringify(data)},'POST')
    }
})
$('.eliminar_renglon').click(function(event){
    event.preventDefault();
    let art=$(this).attr('id-record')
    let doctoid=$(this).attr('id-asign')
    let datos={articulo_id:art,docto_id:doctoid};
    let url=$(this).attr('url-record')
    deleteAddRenglonG(url,datos,'DELETE')
})
$('.eliminar_renglon_gen').click(function(event){
    event.preventDefault();
    let art=$(this).attr('id-record')
    let doctoid=$(this).attr('id-asign')
    let datos={iddet:art,idencabezado:doctoid};
    let url=$(this).attr('url-record')
    //console.log(datos);
    peticionAjaxconData(url,datos,'post')
})
$(document).on('click','.eliminar_archivo',function(event){
    event.preventDefault();
    let archivoid=$(this).attr('id-record')
    let doctoid=$(this).attr('id-asign')
    let datos={archivo_id:archivoid,docto_id:doctoid};
    let url=$(this).attr('url-record')
    peticionAjaxconData(url,datos,'DELETE')
})
function deleteAddRenglonG(url,datos,metodo){
    $.ajax({
        type: metodo,
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: datos,
        beforeSend: function (x) {
            $('#det_articulos').hide();
            $('#loader_det_articulos').show();
        },
        success: function (response) {
            console.log(response);
            if(response.status==true){
                if(response.message){
                    M.toast({
                        html: response.message
                    })
                }
                if(response.data){
                    if(response.data=='reload'){
                        setTimeout(location.reload(), 100);
                    }else{
                        setTimeout(location.href=response.data, 100);
                    }
                }
            }else{
                M.toast({
                    html: response.data
                })
                $('#det_articulos').show()
                $('#loader_det_articulos').hide()
            }
        },
        error: function (request, status, error) {
            console.log(error);
        },
        complete: function (msg) {

        }
    });
}
$(document).on('click','.validarformulario-urls',function(event){
    event.preventDefault();
    
    if($(this).hasClass('2forms')){
        let form1=$(this).attr('form')
        let form2=$(this).attr('second-form')
        let res=validarFormularioUrl2(form2);
        if(res.status){
            if($(this).attr('dataval-record')){
                //console.log('entro1')
                let data=getChekedTable(datos_tabla2);
                if(Object.values(data).length > 0){
                    if(verificarDatosDevolucion(data)){
                        //console.log(data);
                        let campo=$('[name="jsonArticles"]');
                        //let metodo=$('#'+formulario).attr('method')
                        //data={jsonArticles: JSON.stringify(data)}
                        //console.log(metodo+" <> "+uri)
                        campo.val(JSON.stringify(data))
                        validarFormularioUrl(form1);
                        //peticionAjaxconData(uri,data,metodo)
                    }else{
                        M.toast({ 
                            html: 'verificar cantidades',
                        });
                    }
                }else{
                    M.toast({ 
                        html: 'ningún artículo seleccionado',
                    });
                }
            }else{
                validarFormularioUrl(form1)
            }
        }else{
            M.toast({
                html: "Campo obligatorio vacío"
            })
        }
    }else{
        //console.log('entropba2');
        let url2=this.getAttribute('url-record');
        //  AplicarDocto(url,data,url2);
        //console.log($(this).attr('form'));
        let res=validarFormularioUrl2($(this).attr('form'));
        if(res.status){
            if(res.message){
                M.toast({ 
                    html: res.message,
                });
            }
            if(res.doctoid_mail){
                urlDatosArray(url2,"POST",{docto_id:res.doctoid_mail});
            }
            if(res.data){
                setTimeout(document.location.href = res.data, 100);
            }
        }
    }
});
function validarFormularioUrl2(formularioid){
    let resultado={status:false};
    let form = $('#'+formularioid),
        url = form.attr('action'),
        //method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT'; 
        metodo=form.attr('method'); 
    form.addClass('verificandoForm');     
    form.find('.textError').remove();
    form.find('.invalid').removeClass('invalid');
    form.find('.input-field').removeClass('error');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });

    $.ajax({
        async:false,
        url : url,
        method: metodo,
        data : form.serialize(),
        success: function (response) { 
            //console.log(response);
            resultado=response;
            if(!response.status){
                M.toast({ 
                    html: response.data,
                });
            }
            /*if(response.status==true){
                if(response.message){
                    M.toast({ 
                        html: response.message,
                    });
                    if(response.data){
                        setTimeout(function(){location.href=response.data},1000);
                    }
                }else{
                    location.href=response.data;
                }
            }else{
                M.toast({ 
                    html: response.data,
                });
            }*/
        },
        error : function (xhr) {
            console.log(xhr);
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, value) {
                    let input=$("[name="+key+"]").after('<div id="'+key+'-error" class="invalid textError">'+value+'</div>')
                    input.addClass('invalid')
                    .addClass('error')
                    .addClass('validandoElemento')
                    form.find('.invalid')[0].focus();
                });
            }
        }
    })
    return resultado;
}
//-----------------------------------------finalizar ligada desde devolucion recepcion ----------------------------------------
//-----------------------------------------------valida cualquier formulario ----------------------------------------------------
$(document).on('click','.validarformulario',function(event){
    event.preventDefault();
    let formulario=$(this).attr('form');
    if($(this).attr('dataval-record')){
        let data=getChekedTable(datos_tabla2);
        if(Object.values(data).length > 0){
            if(verificarDatosDevolucion(data)){
               // console.log(data);
                let uri=$('#'+formulario).attr('action')
                let metodo=$('#'+formulario).attr('method')
                data={jsonArticles: JSON.stringify(data)}
                //console.log(metodo+" <> "+uri)
                peticionAjaxconData(uri,data,metodo)
            }else{
                M.toast({ 
                    html: 'verificar cantidades',
                });
            }
        }else{
            M.toast({ 
                html: 'ningún artículo seleccionado',
            });
        }
    }else if($(this).attr('dataval-recordRM')){
        let data=getChekedTable(datos_tabla2);
        console.log(data);
        let completo=1;
        let condatos=0;
        Object.keys(data).forEach( function(value,index,array,Object){
            if(parseFloat(data[value].newcantidad) > 0){
                condatos=1;
            }
            if(parseFloat(data[value].cantidad) > parseFloat(data[value].newcantidad)){
                completo=0;
            }
        })
        if(condatos==1){
            if (completo==0){
                if($(this).attr('fin-anyway')){
                    let uri=$('#'+formulario).attr('action')
                    let metodo=$('#'+formulario).attr('method')
                    data={jsonArticles: JSON.stringify(data)}
                    peticionAjaxconData(uri,data,metodo)
                    //console.log(uri,data,metodo)
                }else{
                    abrirModal('modalFinIncompleta')
                }
            }else{
                let uri=$('#'+formulario).attr('action')
                let metodo=$('#'+formulario).attr('method')
                data={jsonArticles: JSON.stringify(data)}
                peticionAjaxconData(uri,data,metodo)
                //console.log(uri,data,metodo)
            }
        }else{
            M.toast({html:"No se puede finalizar sin agregar artículos"})
        }
    }else{
        validarFormularioUrl(formulario)
    }
});
$(document).on('click','.validarformularioimg',function(event){
    event.preventDefault();
    let formulario=$(this).attr('form');
    // console.log(formulario)
    validarFormularioUrlIMG(formulario)
});
//valida el formulario y los campos obligatorios los pone como invalidos
function validarFormularioUrl(formularioid){
    let form = $('#'+formularioid),
        url = form.attr('action'),
        //method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT'; 
        metodo=form.attr('method'); 
    form.addClass('verificandoForm');     
    form.find('.textError').remove();
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
            if(response.status==true){
                //form.trigger('reset')
                if(response.message){
                    //console.log(response)
                    M.toast({ 
                        html: response.message,
                    });
                    //     alertify.success(response.message);
                    if(response.data){
                        if(response.data=='reload'){
                            setTimeout(function(){window.location.reload()},200);
                        }else{
                            setTimeout(function(){location.href=response.data},200);
                        }
                    }
                    
                }else{
                    //console.log(response)
                    location.href=response.data;
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
                    let input=$("[name="+key+"]").after('<div id="'+key+'-error" class="invalid textError">'+value+'</div>')
                    input.addClass('invalid')
                    .addClass('error')
                    .addClass('validandoElemento')
                    form.find('.invalid')[0].focus();
                });
                
            }
        }
    })
}
function validarFormularioUrlIMG(formularioid){
    let form = $('#'+formularioid),
    url = form.attr('action'),
    metodo=form.attr('method');
    let form2 = $('#'+formularioid)[0];
    let post = new FormData(form2);
    // console.log(post)
    form.addClass('verificandoForm');     
    form.find('.textError').remove();
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
        type: "POST",
        enctype: 'multipart/form-data',
        processData: false,
        data : post,
        contentType: false,
        success: function (response) { 
            // 
            console.log(response);
            if(response.status==true){
                if(response.message){
                    M.toast({ 
                        html: response.message,
                    });
                }
                if(response.data){
                    if(response.data == 'reload'){
                        setTimeout(location.reload(), 100);
                    }else{
                        setTimeout(function(){location.href=response.data},100);
                    }
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
                    let input=$("[name="+key+"]").after('<div id="'+key+'-error" class="invalid textError">'+value+'</div>')
                    input.addClass('invalid')
                    .addClass('error')
                    .addClass('validandoElemento')
                    form.find('.invalid')[0].focus();
                });
                
            }
        }
    })
}
// valida si se ingreso un letra o cambio para eliminar o agregar mensaje de error
$(document).on('input change','.validandoElemento',function(event){
    let name=$(this).attr('name');
if($(this).val().length > 0){
    $(this).removeClass('invalid');
    $('#'+name+"-error").remove();
}else{
    addMensajeError(name,'Campo obligatorio')
}
});
function addMensajeError(key,value){
    let input=$("[name="+key+"]").after('<div id="'+key+'-error" class="invalid textError">'+value+'</div>')
    input.addClass('invalid')
}
$('.recepcion-email').click(function(event){
    event.preventDefault();
    console.log($(this).attr('href'))
    
});
$('.ver-pdf').click(function(event){
    event.preventDefault();
    if($(this).attr('href')){
        window.open($(this).attr('href'));
    }
});
$(document).on('click','.visualizardocto',function(event){
    event.preventDefault();
    //console.log($(this).attr('href'))
    visualizarDocumento($(this).attr('href'));
})
$(document).on('click','.agregarDocto',function(event){
    event.preventDefault();
    let url=$(this).attr('href');
    let data={}
    data['doctoid']=$(this).attr('id-record')
    //console.log(data)
    peticionAjaxconData(url,data,'POST')
    //visualizarDocumento($(this).attr('href'));
})
function visualizarDocumento(url) {

    var iframe = document.getElementById("if-docto");
    iframe.setAttribute("src", url);
    var elem = document.getElementById("modalVerDocto");
    var modal = M.Modal.getInstance(elem);
    modal.open();

};
if($('#tablaWithUrl')){
    //console.log('existe');
    TableWhithUrl('tablaWithUrl');
}
if($('#tableRequisitions-oc').attr('url-record')){
    let url=$('#tableRequisitions-oc').attr('url-record')
    let url_ver=document.location.href;
    url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/requisicion/ver/";
    //console.log(url_ver);
    let url_agregar=document.location.href+"/ordenescompra/agregar";
    //console.log(url_agregar);
    datos_tabla=$('#tableRequisitions-oc').DataTable({
       
        responsive:true,
        destroy: true,
        "drawCallback": function () {
            $('.tooltipped').tooltip();
        },
        // data: data,
        ajax:{
            "method":"GET",
            "url": url,
            "dataSrc":""
        },
        "columns":[
            // {"defaultContent":null,'data':"id"},
            {"data":"fecha"},
            {"data":"folio"},
            //{"data":"proveedor"},
            {"render": function ( data, type, row ) {
                // console.log(row.docto_requisicion_id)
                return (
                    `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                );
            }},
            {"data":'almacen'},
            // {"defaultContent":`<a class="auth-record" href="#">
            //     <i class="material-icons agregar_requ_oc tooltipped"  data-tooltip="Agregar"  id-record="`+{"data":"docto_requisicion_id"}.value+`" >check_box</i>
            //     </a>
            //     <i class="material-icons view-record-oc2 tooltipped" data-tooltip="Visualizar" id-record="`+{"data":"docto_requisicion_id"}.value+`">remove_red_eye</i>`},
           {"render": function ( data, type, row ) {
                    // console.log(row.docto_requisicion_id)
                    return (`
                    <label>
                        <input type="checkbox" name="cantidad-`+row.docto_compra_id+`" value="1"  class="filled-in"/>
                        <span></span>
                        
                    </label>
                    <input hidden type="number" name="requ-`+row.docto_compra_id+`" value="`+row.docto_compra_id+`" />
                    
                    <i href="`+url_ver+row.docto_compra_id+`" class="visualizardocto puntero material-icons tooltipped" data-tooltip="Visualizar" >remove_red_eye</i>
                    `);
                    /*<i href="`+url_agregar+`" class="puntero material-icons agregarDocto tooltipped" data-position="top" data-tooltip="Agregar"  id-record="`+row.docto_compra_id+`" >check_box</i> */
                }
            }
        ],
        "data":function(){
            console.log(data)
        },
        //extends: $("#verOrdenesCompra"),
        "language":idiomaEp
                    
    },);
}

/*if($('#tableOrdenesXRecibir').attr('url-record')){
    let url=$('#tableOrdenesXRecibir').attr('url-record')
    let url_ver=document.location.href;
    url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/ordencompra/ver/";
    let url_agregar=document.location.href+"/ordenescompraporrecibir/agregar";
    //console.log(url_agregar);
    datos_tabla=$('#tableOrdenesXRecibir').DataTable({
       
        responsive:true,
        destroy: true,
        "drawCallback": function () {
            $('.tooltipped').tooltip();
        },
        // data: data,
        ajax:{
            "method":"GET",
            "url": url,
            "dataSrc":""
        },
        "columns":[
            // {"defaultContent":null,'data':"id"},
            {"data":"fecha"},
            {"data":"folio"},
            //{"data":"proveedor"},
            {"render": function ( data, type, row ) {
                // console.log(row.docto_requisicion_id)
                return (
                    `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                );
            }},
            {"data":'almacen'},
            // {"defaultContent":`<a class="auth-record" href="#">
            //     <i class="material-icons agregar_requ_oc tooltipped"  data-tooltip="Agregar"  id-record="`+{"data":"docto_requisicion_id"}.value+`" >check_box</i>
            //     </a>
            //     <i class="material-icons view-record-oc2 tooltipped" data-tooltip="Visualizar" id-record="`+{"data":"docto_requisicion_id"}.value+`">remove_red_eye</i>`},
           {"render": function ( data, type, row ) {
                    // console.log(row.docto_requisicion_id)
                    return (`
                    <label>
                        <input type="checkbox" name="cantidad-`+row.docto_compra_id+`" value="1"  class="filled-in"/>
                        <span></span>
                        
                    </label>
                    <input hidden type="number" name="ordenid-`+row.docto_compra_id+`" value="`+row.docto_compra_id+`" />
                    
                    <i href="`+url_ver+row.docto_compra_id+`" class="visualizardocto puntero material-icons tooltipped" data-tooltip="Visualizar" >remove_red_eye</i>
                    `);
                    //<i href="`+url_agregar+`" class="puntero material-icons agregarDocto tooltipped" data-position="top" data-tooltip="Agregar"  id-record="`+row.docto_compra_id+`" >check_box</i> 
                }
            }
        ],
        "data":function(){
            console.log(data)
        },
        //extends: $("#verOrdenesCompra"),
        "language":idiomaEp
                    
    },);
}*/
/*if($('#tableRecepcionesTerminadas').attr('url-record')){
    let url=$('#tableRecepcionesTerminadas').attr('url-record')
    let url_ver=document.location.href;
    url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/recepcionmercancia/visualizar/";
    let url_agregar=document.location.href+"/recepciones/agregar";
    //console.log(url_agregar);
    datos_tabla=$('#tableRecepcionesTerminadas').DataTable({
       
        responsive:true,
        destroy: true,
        "drawCallback": function () {
            $('.tooltipped').tooltip();
        },
        // data: data,
        ajax:{
            "method":"GET",
            "url": url,
            "dataSrc":""
        },
        "columns":[
            // {"defaultContent":null,'data':"id"},
            {"data":"fecha"},
            {"data":"folio"},
            //{"data":"proveedor"},
            {"render": function ( data, type, row ) {
                // console.log(row.docto_requisicion_id)
                return (
                    `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                );
            }},
            {"data":'almacen'},
            // {"defaultContent":`<a class="auth-record" href="#">
            //     <i class="material-icons agregar_requ_oc tooltipped"  data-tooltip="Agregar"  id-record="`+{"data":"docto_requisicion_id"}.value+`" >check_box</i>
            //     </a>
            //     <i class="material-icons view-record-oc2 tooltipped" data-tooltip="Visualizar" id-record="`+{"data":"docto_requisicion_id"}.value+`">remove_red_eye</i>`},
           {"render": function ( data, type, row ) {
                    // console.log(row.docto_requisicion_id)
                    return (`
                    <label>
                        <input type="checkbox" name="cantidad-`+row.docto_compra_id+`" value="1"  class="filled-in"/>
                        <span></span>
                        
                    </label>
                    <input hidden type="number" name="ordenid-`+row.docto_compra_id+`" value="`+row.docto_compra_id+`" />
                    
                    <i href="`+url_ver+row.docto_compra_id+`" class="visualizardocto puntero material-icons tooltipped" data-tooltip="Visualizar" >remove_red_eye</i>
                    `);
                    //<i href="`+url_agregar+`" class="puntero material-icons agregarDocto tooltipped" data-position="top" data-tooltip="Agregar"  id-record="`+row.docto_compra_id+`" >check_box</i> 
                }
            }
        ],
        "data":function(){
            console.log(data)
        },
        //extends: $("#verOrdenesCompra"),
        "language":idiomaEp
                    
    },);
}*/
function peticionAjaxconData(url,data,metodo){
    $.ajax({
        type: metodo,
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        beforeSend: function (x) {
        },
        success: function (response) {
            console.log(response);
            if(response.status==true){
                if(response.message){
                    M.toast({ 
                        html: response.message,
                    });
                }
                if(response.data){
                    if(response.data=='reload'){
                        setTimeout(location.reload(), 100);
                    }else{
                        setTimeout(function(){location.href=response.data},100);
                    }
                }
            }else{
                M.toast({ 
                    html: response.data,
                });
            }
        },
        error: function (request, status, error) {
            console.log(error);
        },
        complete: function (msg) {

        }
    });
}
function abrirModal(idmodal){
    var elem = document.getElementById(idmodal);
    var modal = M.Modal.getInstance(elem);
    modal.open();
}
$(document).on('click','.editar-documento',function(event){
    event.preventDefault();
    document.location.href=$(this).attr('href');
    //console.log($(this).attr('href'));
})
function urlDatosArray(url,metodo,datos,ass=true){
    $.ajax({
        async: ass,
        type: metodo,
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            jsonData: JSON.stringify(datos)
        },
        beforeSend: function (x) {

        },
        success: function (response) {
            console.log(response)
            if(response.status){
                if(response.message){
                    M.toast({ 
                        html: response.message,
                    });
                }
                if(response.data){
                    if(response.data=='reload'){
                        setTimeout(location.reload(), 100);
                    }else{
                        setTimeout(function(){location.href=response.data},100);
                    }
                }
            }else{
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
$(document).on('click','.modallote',function(event){
    event.preventDefault();
    // $("[name=articuloid]").attr('value',$(this).attr('idarticulo'));
    // $("[name=compradetid]").attr('value',$(this).attr('idcompradet'));
    abrirModal($(this).attr('href'))
    //console.log($(this).attr('idarticulo')+" "+$(this).attr('idcompradet'));
})
var selectEsp={
    noResults: function() {
      return "No hay resultado";        
    },
    searching: function() {
      return "Buscando..";
    }
}
/*dataTable_oc= $('#tablaAticulos').DataTable({
    destroy: true,
    // data: data,
    ajax:{
        "method":"GET",
        "url": $('#tablaAticulos').attr('url-record'),
        "dataSrc":""
    },
    "columns":[
        // {"defaultContent":null,'data':"id"},
        {"render": function ( data, type, row ) {
            let ordencompraid=$('#tablaAticulos').attr('id-record')
            // console.log(row.docto_requisicion_id)
            return (
                `<input class="cantidadnumeric" id="cantidad-`+row.articulo_id+`" type="number" min="0" name="cantidad-`+row.articulo_id+`" />
                <input type="hidden" id="req-`+row.articulo_id+`" name="req-`+row.articulo_id+`" value="`+ordencompraid+`"/>
                <input type="hidden" id="articulo_id-`+row.articulo_id+`" name="articulo_id-`+row.articulo_id+`" value="`+row.articulo_id+`"/>`
            );
            }
        },
        {'data':"unidad_compra"},
        {"render": function ( data, type, row ) {
            // console.log(row.docto_requisicion_id)
            return (
                `<input id="precio-`+row.articulo_id+`" type="number" class="noarrows" min="0" name="precio-`+row.articulo_id+`" value="`+row.precio+`"/>`
            );
            }
        },
        {'data':"nombre"},
        // {"render": function ( data, type, row ) {
        //     // console.log(row.docto_requisicion_id)
        //     return (
        //         `<input id="nota-`+row.articulo_id+`" name="nota-`+row.articulo_id+`">`
        //     );
        //     }
        // }
    ],
    "data":function(){
        console.log(data)
    },
    "language":idiomaEp
});*/
function prueba(){
    return 
}
function selectInModalByTerm(select){
    let url=$('.'+select).attr('url-record');
    if($('.'+select).attr('modal-parent')){
        let modalParent=$('.'+select).attr('modal-parent');
        $('.'+select).select2({
            ajax: {
                // url: pat_url_proveedorByTerm,
                url: url,
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
            dropdownParent: $("#"+modalParent),
        });
        $('.select2').attr('style','width: 100%;');
    }else if($('.'+select).attr('data-record')){
        let datos=$('.'+select).attr('data-record')
        $('.'+select).select2({
            ajax: {
                // url: pat_url_proveedorByTerm,
                url: url,
                dataType: 'json',
                delay: 250,
                data: {doctosJson:datos},
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
        $('.select2').attr('style','width: 100%;');
        
    }else{
        $('.'+select).select2({
            ajax: {
                // url: pat_url_proveedorByTerm,
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term, // search term
                        page: params.page || 1,
                    };
                },
                processResults: function (data, params) {
                    //console.log(data);
                    params.page = params.page || 1;
        
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 30) < data.results.length
                        }
                    };
                },
                success:function(data){
                    //console.log(data);
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            //        minimumInputLength: 1,
            placeholder: /*$('.'+select+'[val-seleccionado]') ? $('.'+select+'[val-seleccionado]').attr('val-seleccionado'):*/"Seleccione una opción",
            allowClear: true,
            language: "es",
            delay: 1500,
            closeOnSelect: true,
        });
        $('.select2').attr('style','width: 100%;');
    }
    
}

function TableWhithUrl(tablaId){
    let url=$('#'+tablaId).attr('url-record');
    $('#'+tablaId).removeAttr('url-record')
    /*--------------------------------------Reqisiciones para ordenes de compra y cotizaciones-----------*/
    if(document.location.href.includes('ordencompra') && !document.location.href.includes('/edit/')){
        let url_ver=document.location.href;
        url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/requisicion/ver/";
        RequOrdenCompraTable(tablaId,url,url_ver);
    }else if(document.location.href.includes('cotizacion') && !document.location.href.includes('/editar/')){
        let url_ver=document.location.href;
        url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/requisicion/ver/";
        RequOrdenCompraTable(tablaId,url,url_ver);
    }else if(document.location.href.includes('ordencompra/edit/')){
        ArticulosComprasTable(tablaId,url);
        //console.log('entro');
    }else if(document.location.href.includes('recepcionmercancia') && !document.location.href.includes('/edit/')){
        let url_ver=document.location.href;
        if($('#'+tablaId).attr('radio-record')){
            url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/recepcionmercancia/visualizar/";
        }else{
            url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/ordencompra/ver/";
        }
        //let url_agregar=document.location.href+"/ordenescompraporrecibir/agregar";
        OrdenCompraRecepcionTable(tablaId,url,url_ver);
    }else if(document.location.href.includes('recepcionmercancia/edit/')){
        ArticulosComprasTable(tablaId,url);
        //console.log('entro');
    }else if(document.location.href.includes('compra') && !document.location.href.includes('compra/')){
        let url_ver=document.location.href;
        if($('#'+tablaId).attr('radio-record')){
            url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/compra/ver/";
        }else{
            url_ver=url_ver.replace(url_ver.substring(url_ver.lastIndexOf('/')),'')+"/recepcionmercancia/visualizar/";
        }
        RecepcionCompra(tablaId,url,url_ver);
    }else if(document.location.href.includes('compra/editar/')){
        ArticulosComprasTable(tablaId,url);
        //console.log('compras edit');
    }else if(document.location.href.includes('cotizacion/editar/')){
        ArticulosComprasTable(tablaId,url);
    }
    
}
function ArticulosComprasTable(tabla,url){
    //console.log('entro')
    let modulo=$('#'+tabla).attr('mod-record');
    $('#'+tabla).removeAttr('mod-record');
    let doctoid=$('#'+tabla).attr('id-record');
    $('#'+tabla).removeAttr('id-record');
    //console.log(modulo+' '+doctoid+' '+url)
    if(modulo === "OC"){
        //console.log(modulo+' '+doctoid+' '+url)
        datos_tabla= $('#'+tabla).DataTable({
            order:[],
            destroy: true,
            // data: data,
            ajax:{
                "method":"GET",
                "url": url,
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#modalArt"]').removeAttr('disabled');
                }
            },
            "columns":[
                // {"defaultContent":null,'data':"id"},
                //{"defaultContent":' '},
                {"render": function ( data, type, row ) {
                    // console.log(row.docto_requisicion_id)
                    return (
                        `<input widht="10%" class="cantidadnumeric" id="cantidad-`+row.articulo_id+`" type="number" min="0" name="cantidad-`+row.articulo_id+`" />
                        <input type="hidden" id="req-`+row.articulo_id+`" name="req-`+row.articulo_id+`" value="`+doctoid+`"/>
                        <input type="hidden" id="nombre-`+row.articulo_id+`" name="nombre-`+row.articulo_id+`" value="`+row.nombre+`"/>`
                    );
                    }
                },
                {'data':"unidad_compra"},
                {"render":function ( data, type, row ) {
                    // console.log(row.docto_requisicion_id)
                    const precio = row.precio;
                    function round(num) {
                        var m = Number((Math.abs(num) * 100).toPrecision(15));
                        return Math.round(m) / 100 * Math.sign(num);
                    }
                    let prec=round(precio);
                    function trunc (x) {
                        return Number.parseFloat(x).toFixed(2);
                    }
                    prec=trunc(prec);
                    return (
                        `<input id="precio-`+row.articulo_id+`" type="number" class="noarrows" min="0" name="precio-`+row.articulo_id+`" value="`+prec+`"/>`
                    );
                    }
                },
                {'data':"nombre"},
                //{"defaultContent":'<input id="nota-na" name="nota-na">'},
                {"render": function ( data, type, row ) {
                    // console.log(row.docto_requisicion_id)
                    return (
                        `<input id="nota-`+row.articulo_id+`" name="nota-`+row.articulo_id+`">`
                    );
                    }
                }
            ],
            "language":idiomaEp
            
        });
    }else if(modulo === "RM"){
        datos_tabla= $('#'+tabla).DataTable({
            order:[],
            destroy: true,
            ajax:{
                "method":"GET",
                "url": url,
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#modalArt"]').removeAttr('disabled');
                }
            },
            "columns":[
                {"render": function ( data, type, row ) {
                    return (
                        `<input class="cantidadnumeric" id="cantidad-`+row.articulo_id+`" type="number" min="0" name="cantidad-`+row.articulo_id+`" />
                        <input type="hidden" id="req-`+row.articulo_id+`" name="req-`+row.articulo_id+`" value="`+doctoid+`"/>
                        <input type="hidden" id="nombre-`+row.articulo_id+`" name="nombre-`+row.articulo_id+`" value="`+row.nombre+`"/>`
                    );
                    }
                },
                {'data':"unidad_compra"},
                {"render": function ( data, type, row ) {
                    return (
                        `<input id="precio-`+row.articulo_id+`" type="number" class="noarrows" min="0" name="precio-`+row.articulo_id+`" value="`+row.precio+`"/>`
                    );
                    }
                },
                {'data':"nombre"},
                {"data":'pesar'},
            ],
            "data":function(){
                console.log(data)
            },
            "language":idiomaEp
        });
    }else if(modulo === 'CO'){
        datos_tabla= $('#'+tabla).DataTable({
            order:[],
            destroy: true,
            drawCallback: function () {
                $('.tooltipped').tooltip();
            },
            ajax:{
                "method":"GET",
                "url": url,
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#modalArt"]').removeAttr('disabled');
                }
            },
            "columns":[
                {"render": function ( data, type, row ) {
                    return (
                        `<input class="cantidadnumeric" id="cantidad-`+row.articulo_id+`" type="number" min="0" name="cantidad-`+row.articulo_id+`" />
                        <input type="hidden" id="doctoid-`+row.articulo_id+`" name="doctoid-`+row.articulo_id+`" value="`+doctoid+`"/>
                        <input type="hidden" id="articulo-`+row.articulo_id+`" name="articulo-`+row.articulo_id+`" value="`+row.nombre+`"/>`
                    );
                    }
                },
                {'data':"unidad_compra"},
                {"render": function ( data, type, row ) {
                    return (
                        `<input id="precio-`+row.articulo_id+`" type="number" class="noarrows" min="0" name="precio-`+row.articulo_id+`" value="`+row.precio+`"/>`
                    );
                    }
                },
                //{'data':"nombre"},
                {"render": function ( data, type, row ) {
                    return (
                        `<p class="descripcion tooltipped" data-tooltip="`+row.nombre+`">`+row.nombre+`</p>`
                    );
                }},
            ],
            "data":function(){
                console.log(data)
            },
            "language":idiomaEp
        });
    }else if(modulo === 'CT'){
        console.log('entro');
        datos_tabla= $('#'+tabla).DataTable({
            order:[],
            destroy: true,
            drawCallback: function () {
                $('.tooltipped').tooltip();
            },
            ajax:{
                "method":"GET",
                "url": url,
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#modalArt"]').removeAttr('disabled');
                }
            },
            "columns":[
                {"render": function ( data, type, row ) {
                    return (
                        `<input class="cantidadnumeric" id="cantidad-`+row.articulo_id+`" type="number" min="0" name="cantidad-`+row.articulo_id+`" />
                        <input type="hidden" id="doctoid-`+row.articulo_id+`" name="doctoid-`+row.articulo_id+`" value="`+doctoid+`"/>
                        <input type="hidden" id="articulo-`+row.articulo_id+`" name="articulo-`+row.articulo_id+`" value="`+row.nombre+`"/>`
                    );
                    }
                },
                {'data':"unidad_compra"},
                {"render": function ( data, type, row ) {
                    return (
                        `<input id="precio-`+row.articulo_id+`" type="number" class="noarrows" min="0" name="precio-`+row.articulo_id+`" value="`+row.precio+`"/>`
                    );
                    }
                },
                //{'data':"nombre"},
                {"render": function ( data, type, row ) {
                    return (
                        `<p class="descripcion tooltipped" data-tooltip="`+row.nombre+`">`+row.nombre+`</p>`
                    );
                }},
            ],
            "data":function(){
                console.log(data)
            },
            "language":idiomaEp
        });
    }
}
function RequOrdenCompraTable(tabla,url,url_ver){
    datos_tabla=$('#'+tabla).DataTable({
        order: [],
        responsive:false,
        destroy: true,
        "drawCallback": function () {
            $('.tooltipped').tooltip();
        },
        ajax:{
            "method":"GET",
            "url": url,
            "dataSrc":"",
            complete: function (msg) {
                $('a[href*="#verRequisiciones"]').removeAttr('disabled');
            }
        },
        "columns":[
            {"data":"folio"},
            {"data":"fecha"},
            {"render": function ( data, type, row ) {
                return (
                    `<p class="descripcion tooltipped" data-tooltip="`+row.descripcion+`">`+row.descripcion+`</p>`
                );
            }},
            {"data":'estatus'},
            {"data":"usuario_creacion"},
            {"render": function ( data, type, row ) {
                    return (`
                    <label>
                        <input type="checkbox" name="cantidad-`+row.docto_requisicion_id+`" value="1"  class="filled-in"/>
                        <span></span>
                        
                    </label>
                    <input hidden type="number" name="requ-`+row.docto_requisicion_id+`" value="`+row.docto_requisicion_id+`" />
                    
                    <i href="`+url_ver+row.docto_requisicion_id+`" class="visualizardocto puntero material-icons tooltipped teal-text" data-tooltip="Visualizar" >remove_red_eye</i>
                    `);
                }
            }
        ],
        "data":function(){
            //console.log(data)
        },
        "language":idiomaEp,
        /*success: function (response) {
            
        },*/
        
                    
    },);
    if($('#'+tabla+"2")){
        let url_ver2=document.location.href;
        url_ver2=url_ver2.replace(url_ver2.substring(url_ver2.lastIndexOf('/')),'')+"/cotizacion/ver/";
        datos_tabla2=$('#'+tabla+"2").DataTable({
            order: [],
            responsive:true,
            destroy: true,
            "drawCallback": function () {
                $('.tooltipped').tooltip();
            },
            ajax:{
                "method":"GET",
                "url": $('#'+tabla+"2").attr('url-record'),
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#verCotizaciones"]').removeAttr('disabled');
                }
            },
            "columns":[
                {"data":"folio"},
                {"data":"fecha"},
                {"render": function ( data, type, row ) {
                    return (
                        `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                    );
                }},
                {"data":'moneda'},
                {"data":'partidas'},
                {"data":"estatus"},
                {"render": function ( data, type, row ) {
                        return (`
                        <label>
                            <input type="radio" name="cantidad-0" value="`+row.docto_compra_id+`"  class="filled-in"/>
                            <span></span>
                            
                        </label>
                        <input hidden type="number" name="requ-`+row.docto_compra_id+`" value="`+row.docto_compra_id+`" />
                        
                        <i href="`+url_ver2+row.docto_compra_id+`" class="visualizardocto puntero material-icons tooltipped teal-text" data-tooltip="Visualizar" >remove_red_eye</i>
                        `);
                    }
                }
            ],
            "data":function(){
                //console.log(data)
            },
            "language":idiomaEp
                        
        },);
    }
}
function OrdenCompraRecepcionTable(tabla,url,url_ver){
    if($('#'+tabla).attr('radio-record')){
        datos_tabla=$('#'+tabla).DataTable({
            order:[],
            responsive:true,
            destroy: true,
            "drawCallback": function () {
                $('.tooltipped').tooltip();
            },
            // data: data,
            ajax:{
                "method":"GET",
                "url": url,
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#verRecepciones"]').removeAttr('disabled');
                }
            },
            "columns":[
                {"data":"fecha"},
                {"data":"folio"},
                {"render": function ( data, type, row ) {
                    return (
                        `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                    );
                }},
                {"data":'almacen'},
                {"render": function ( data, type, row ) {
                        return (`
                        <label>
                            <input type="radio" name="cantidad-0" value="`+row.docto_compra_id+`"  class="filled-in"/>
                            <span></span>
                            
                        </label>
                        
                        <i href="`+url_ver+row.docto_compra_id+`" class="visualizardocto puntero material-icons teal-text tooltipped" data-tooltip="Visualizar" >remove_red_eye</i>
                        `);
                    }
                }
            ],
            "data":function(){
                console.log(data)
            },
            "language":idiomaEp
                        
        },);
    }else{
        datos_tabla=$('#'+tabla).DataTable({
            order:[],
            responsive:false,
            destroy: true,
            "drawCallback": function () {
                $('.tooltipped').tooltip();
            },
            // data: data,
            ajax:{
                "method":"GET",
                "url": url,
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#verOrdenesCompra"]').removeAttr('disabled');
                }
            },
            "columns":[
                {"data":"fecha"},
                {"data":"folio"},
                {"render": function ( data, type, row ) {
                    return (
                        `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                    );
                }},
                {"data":'partidas'},
                {"data":'almacen'},
                {"render": function ( data, type, row ) {
                        return (`
                        <label>
                            <input type="checkbox" name="cantidad-`+row.docto_compra_id+`" value="1"  class="filled-in"/>
                            <span></span>
                            
                        </label>
                        <input hidden type="number" name="ordenid-`+row.docto_compra_id+`" value="`+row.docto_compra_id+`" />
                        
                        <i href="`+url_ver+row.docto_compra_id+`" class="visualizardocto puntero material-icons teal-text tooltipped" data-tooltip="Visualizar" >remove_red_eye</i>
                        `);
                    }
                }
            ],
            "data":function(){
                console.log(data)
            },
            "language":idiomaEp
                        
        },);
    }
}
function RecepcionCompra(tabla,url,url_ver){
    if($('#'+tabla).attr('radio-record')){
        datos_tabla=$('#'+tabla).DataTable({
            order:[],
            responsive:false,
            destroy: true,
            "drawCallback": function () {
                $('.tooltipped').tooltip();
            },
            ajax:{
                "method":"GET",
                "url": url,
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#verCompras"]').removeAttr('disabled');
                }
            },
            "columns":[
                {"data":"fecha"},
                {"data":"folio"},
                {"render": function ( data, type, row ) {
                    return (
                        `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                    );
                }},
                {"data":'almacen'},
                {"render": function ( data, type, row ) {
                        return (`
                        <label>
                            <input type="radio" name="cantidad-0" value="`+row.docto_compra_id+`"  class="filled-in"/>
                            <span></span>
                            
                        </label>
                        <input hidden type="number" name="recepcion-`+row.docto_compra_id+`" value="`+row.docto_compra_id+`" />
                        
                        <i href="`+url_ver+row.docto_compra_id+`" class="visualizardocto puntero material-icons teal-text tooltipped" data-tooltip="Visualizar" >remove_red_eye</i>
                        `);
                    }
                }
            ],
            "data":function(){
                console.log(data)
            },
            "language":idiomaEp
        },);
    }else{
        datos_tabla=$('#'+tabla).DataTable({
            order:[],
            responsive:false,
            destroy: true,
            "drawCallback": function () {
                $('.tooltipped').tooltip();
            },
            ajax:{
                "method":"GET",
                "url": url,
                "dataSrc":"",
                complete: function (msg) {
                    $('a[href*="#verRecepciones"]').removeAttr('disabled');
                }
            },
            "columns":[
                {"data":"fecha"},
                {"data":"folio"},
                {"render": function ( data, type, row ) {
                    return (
                        `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                    );
                }},
                {"data":'almacen'},
                {"render": function ( data, type, row ) {
                        return (`
                        <label>
                            <input type="checkbox" name="cantidad-`+row.docto_compra_id+`" value="1"  class="filled-in"/>
                            <span></span>
                            
                        </label>
                        <input hidden type="number" name="recepcion-`+row.docto_compra_id+`" value="`+row.docto_compra_id+`" />
                        
                        <i href="`+url_ver+row.docto_compra_id+`" class="visualizardocto puntero material-icons teal-text tooltipped" data-tooltip="Visualizar" >remove_red_eye</i>
                        `);
                    }
                }
            ],
            "data":function(){
                console.log(data)
            },
            "language":idiomaEp
        },);
    }
}
$(document).on('click','.enviar_email_cot',function(event){
    event.preventDefault();
    let dta=getChekedTable(tabla_contactos_email);
    let url=this.getAttribute('url-record');
    if(Object.values(dta).length>0){
        urlDatosArray(url,"POST",dta);
        //console.log(url);
   }
})
//$('#tablaContactos').DataTable();
function listarTablacontactos(prov,doctoid){
    let datos={proveedor:prov};
    tabla_contactos_email=$('#tablaContactos').DataTable({
        paging:false,
        searching:false,
        responsive:true,
        destroy: true,
        /*"drawCallback": function () {
            $('.tooltipped').tooltip();
        },*/
        ajax:{
            "method":"GET",
            "url": $('#tablaContactos').attr('url-record'),
            "dataSrc":'',
            'data':datos
        },
        "columns":[
            {"data":"nombre"},
            {"data":"persona_contacto"},
            {"data":"telefono"},
            {"data":"movil"},
            {"data":"correo"},
            {"data":"localizacion"},
            {"render": function ( data, type, row ) {
                return (`
                <label>
                    <input type="checkbox" name="cantidad-`+row.proveedor_sucursal_id+`" value="1"  class="filled-in"/>
                    <span></span>
                    
                </label>
                <input hidden type="number" name="cotizacion-`+row.proveedor_sucursal_id+`" value="`+doctoid+`" />
                <input hidden type="text" name="correo-`+row.proveedor_sucursal_id+`" value="`+row.correo+`" />
                <input hidden type="text" name="contacto-`+row.proveedor_sucursal_id+`" value="`+row.persona_contacto+`" />
                `);
            }},
            
            /*{"render": function ( data, type, row ) {
                return (
                    `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
                );
            }},
            {"data":'almacen'},
            {"render": function ( data, type, row ) {
                    return (`
                    <label>
                        <input type="checkbox" name="cantidad-`+row.docto_compra_id+`" value="1"  class="filled-in"/>
                        <span></span>
                        
                    </label>
                    <input hidden type="number" name="recepcion-`+row.docto_compra_id+`" value="`+row.docto_compra_id+`" />
                    
                    <i href="`+url_ver+row.docto_compra_id+`" class="visualizardocto puntero material-icons tooltipped" data-tooltip="Visualizar" >remove_red_eye</i>
                    `);
                }
            }*/
        ],
        "data":function(){
            console.log(data)
        },
        "language":idiomaEp
    },);
}
//ferifica el tipo de descuento
$(document).on('change','[name=tipo_descuento]',function(event){
    if(this.getAttribute('value')===""){
        $('.selectnone').attr('hidden',true)
    }else{
        $('.selectnone').attr('hidden',false)
    }
})
/*----------------------------------------------------------------------------------------------------------------*/
/*--------------------------DoctosCotizaciones--------------------------------------------------------------------*/
/*----------------------------------------------------------------------------------------------------------------*/
$(document).on('click','.docto-edit',function(event){
    event.preventDefault();
    let url=this.getAttribute('href');
    //peticionAjaxconData(url,'','GET');
    location.href=url;
});
$(document).on('click','.editar_renglon',function(event){
    event.preventDefault();
    $('.cantidad').children('input').val();
    let btn=$(this).text();
    console.log(btn);
    if(btn=='edit'){
        $(this).text('check');
        let renglon=$(this).parent('td').parent('tr');
        let htmlcantidad=renglon.children('.cantidad')
        let htmlprecio_u=renglon.children('.precio_unitario')
        let textoinput=`<input class="noarows" type="number" value="`+$(htmlcantidad[0]).text()+`">`
        $(htmlcantidad[0]).empty();
        $(htmlcantidad[0]).append(textoinput)
        textoinput=`<input class="noarows" type="number" value="`+$(htmlprecio_u[0]).text()+`">`
        $(htmlprecio_u[0]).empty()
        $(htmlprecio_u[0]).append(textoinput)
    }
});
if($('#det_articulos').attr('update-table')){
    // if($('#det_articulos').attr('order')){
    //     let o=$('#det_articulos').attr('order').split(',');
    //     console.log(o.length)
    //     if(o.length == 1){
    //         agregar_data_tabla_det(o[0])
    //     }else{
    //         agregar_data_tabla_det(o[0],o[1])
    //     }
    // }else{
    //     console.log('no order')
    agregar_data_tabla_det()
    // }
}
function agregar_data_tabla_det(ordenarpor=null){
    datos_tabla2=$('#det_articulos').DataTable({
        order: [], 
        //order:false,
        searching:false,
        responsive:false,
        paging:false,
        destroy:true,
        info:false,
        // columnDefs: [
        //     {
        //         orderable: false,
        //         targets: ['0,4,6'],
        //     },
        // ],
        "language":idiomaEp
    });
}
$(document).on('input','.verificar_cantidad',function(event){
    let data=getChekedTable(datos_tabla2);
    verificarDatosDevolucion(data);
})
function verificarDatosDevolucion(data){
    let errores=0;
    if(Object.values(data).length > 0){
        for(let i=0;i<Object.values(data).length;i++){
            let id=Object.values(data)[i]['articuloid'];
            let max=parseFloat($('[name=newcantidad-'+id+'').attr('max'));
            let min=parseFloat($('[name=newcantidad-'+id+'').attr('min'));
            let devuelta=0;
            if(Object.values(data)[i]['newcantidad']){
                devuelta=Object.values(data)[i]['newcantidad'];
            }
            if(!location.href.includes('devrecepcionmercancia')){
                $('[name=newcantidad-'+id+'').removeClass('green')
                $('[name=newcantidad-'+id+'').removeClass('amber')
            }
            if(devuelta > max || devuelta < min){
                $('[name=newcantidad-'+id+'').addClass('invalid')
                $('[name=newcantidad-'+id+'').addClass('red-text')
                errores++;
            }else{
                $('[name=newcantidad-'+id+'').removeClass('invalid')
                $('[name=newcantidad-'+id+'').removeClass('red-text')
                if(!location.href.includes('devrecepcionmercancia')){
                    if(devuelta == max){
                        $('[name=newcantidad-'+id+'').addClass('green')
                    }else if(max > devuelta && devuelta > 0){
                        $('[name=newcantidad-'+id+'').addClass('amber')
                    }
                }
            }
        } 
    }else{
        $('.verificar_cantidad').removeClass('invalid')
        $('.verificar_cantidad').removeClass('red-text')
    }
    if(errores > 0){
        return false;
    }
    return true;
}
$(document).on('change','#total_rows',function(){
    
    if($(this).is(':checked')){
        $('.total_rows').prop('checked',true);
    }else{
        $('.total_rows').prop('checked',false);
    }
    let data=getChekedTable(datos_tabla2);
    verificarDatosDevolucion(data);
})
$(document).on('change','.total_rows',function(){
    let data=getChekedTable(datos_tabla2);
    verificarDatosDevolucion(data);
    if($('.total_rows').toArray().length == $('.total_rows:checked').toArray().length){
        $('#total_rows').prop('checked',true);
    }else{
        $('#total_rows').prop('checked',false);
    }
})
//mouseleave
/********************************************flecha desplegada o no desplegada***************/
$('.collapsible-header').on('click',function(){
    let c=$(this)[0].children;
    if(!$(this)[0].parentElement.classList.contains('active')){
        c[0].innerHTML="arrow_drop_up";
    }else{
        c[0].innerHTML="arrow_drop_down";
    }
})
$('.collapsible-header.in').on('click',function(event){
    /*event.preventDefault();
    let a=$(this).parent('li').find('div.collapsible-body.in').children('li');
    a.attr('style','display: block;')
    console.log(a[0]);*/
    
    /*let c=$(this)[0].children('i');
    if(!$(this)[0].parentElement.classList.contains('active')){
        c[0].innerHTML="arrow_drop_up";
    }else{
        c[0].innerHTML="arrow_drop_down";
    }*/
})
// $('li ul').mouseenter(function(){
//     if($(this).attr('class') && $(this).attr('class').includes('collapsible-accordion')){
//         $(this).find('.collapsible-header').parent('li').addClass('active')
//         $(this).find('.collapsible-header').children('i.left').html('arrow_drop_up');
//         $(this).find('.collapsible-body').css({
//             "display":"block"
//         })
//     }
// })
// $('li ul').mouseleave(function(){
//     if($(this).attr('class') && $(this).attr('class').includes('collapsible-accordion')){
//         $(this).find('.collapsible-header').parent('li').removeClass('active')
//         $(this).find('.collapsible-header').children('i.left').html('arrow_drop_down');
//         $(this).find('.collapsible-body').removeAttr('style')
//     }
// })
