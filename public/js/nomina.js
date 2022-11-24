var id_docto_principal;
$(document).on('change','[name="estado"].select_dep',function(event){
    event.preventDefault();
    let cl=$(this).attr('select-seg')
    let url=$('[name="ciudad"].'+cl).attr('url-record');
    let entidad=$(this).val();
    $('[name="ciudad"].'+cl).val("");
    $('[name="ciudad"].'+cl).select2({
        ajax: {
            // url: pat_url_proveedorByTerm,
            url: url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                params.entidad=entidad;
                return {
                    entidad: params.entidad,
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
        closeOnSelect: true
    });
    $('.select2').attr('style','width: 100%;');
    $('[name="ciudad"].'+cl).removeAttr('disabled')
    //console.log($(this).val())
});
$(document).on('change','[name="naturaleza"]',function(event){
    event.preventDefault();
    let cl=$('[name="clave_fiscal"]')
    let url=$(this).attr('url-record');
    let nat=$(this).val();
    cl.val("");
    console.log(nat);
    cl.select2({
        ajax: {
            // url: pat_url_proveedorByTerm,
            url: url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                params.tipo=nat;
                return {
                    tipo: params.tipo,
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
        delay: 500,
        closeOnSelect: true,
        dropdownParent:$('#modalnewE')
    });
    $('.select2').attr('style','width: 100%;');
    //console.log($(this).val())
});
if($('.select_search_url').attr('url-record')){
    selectInModalByTerm('select_search_url');
}
if($('.select_search_url2').attr('url-record')){
    selectInModalByTerm('select_search_url2');
}
if($('.select_search_url3').attr('url-record')){
    selectInModalByTerm('select_search_url3');
}
$(document).on('click','.cancelar_aplicar_contrato',function(event){
    event.preventDefault();
    //let doctoid=this.getAttribute('id-record');
    if($(this).hasClass('with-modal')){
        let modalid=this.getAttribute('modal-record');
        // console.log(modalid)
        abrirModal(modalid);
    }
    /*if($(this).attr('with-modal')){
        let nombre=this.getAttribute('campo_id_name');
        let modalid=this.getAttribute('with-modal');
        $('[name='+nombre+']').attr('value',doctoid)
        abrirModal(modalid);
    }else{
        let uri=this.getAttribute('url-record');
        let data={docto_id:doctoid};
        urlDatosArray(uri,'POST',data);
    }*/
});
/*if($('select[val-seleccionado]')){
    let val=$('select[val-seleccionado]').attr('val-seleccionado')
    changeSele($('select[val-seleccionado]'),val);
}*/
/*function changeSele(elemento,valor){
    console.log('entro');
    //elemento.val(valor).trigger('change.select2');
    $('select[val-seleccionado]').val('ZACATECAS').trigger('change.select2');
}*/
// $(document).on('click','[name=estado_civil]',function(event){
//     console.log('entro');
//     $('#entidadd').val('ZACATECAS').trigger('change.select');
//     $("#entidadd option[value=\"ZACATECAS\"]").attr("selected",true);
// })
// $('#entidadd[val-seleccionado]').val('ZACATECAS').trigger('change.select2');
/*//console.log($('#tableGeneral.withurl'))
$('#tableGeneral2.withurl').DataTable({
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
        },
        ajax:{
            "method":"GET",
            "url": $('#tableGeneral2.withurl').attr('url-record'),
            "dataSrc":"",
            complete: function (msg) {
                let a=document.getElementsByClassName('card-withTable')
                a[0].removeAttribute('hidden')
                // console.log($(document).find('div.card.card-withTable'));
                // console.log($(this));
                // $('.card.withTable').removeAttr('hidden');
                // console.log('msg');
            }
        },
        "columns":[
            {"data":"nombre"},
            {"render":function ( data, type, row ) {
                if(row.estatus=='Baja'){
                    return (`<span class="status text-cancel">•</span>`+row.estatus);
                }
                else if(row.estatus=='Activo'){
                    return (`<span class="status text-authorized">•</span>`+row.estatus);
                }
            }},
            {"data":"rfc"},
            {"data":"nss"},
            {"data":"puesto"},
            {"data":"departamento"},
            {"data":"centro_costo"},
            //{"data":"empleado_id"},
            {"render":function ( data, type, row ) {
                if(row.estatus=='Baja'){
                    return (`<i href="{{--route('catempleados.edit',$empleado->empleado_id)-}}"
                                class="disabled-btn  material-icons tooltipped" data-delay="50"
                                    data-tooltip="No se puede editar">edit
                            </i>
                            <i href="" 
                                class="disabled-btn material-icons tooltipped" data-delay="50"
                                    data-tooltip="no se puede dar de baja">delete_forever
                            </i>`);
                }
                else if(row.estatus=='Activo'){
                    return (`<i href="{{--route('catempleado.edit',$empleado->empleado_id)-}}"
                                class="amber-text  material-icons tooltipped puntero" data-delay="50"
                                    data-tooltip="Editar Empleado">edit
                            </i>
                            <i href="" 
                                class="red-text material-icons tooltipped puntero" data-delay="50"
                                    data-tooltip="Eliminar Empleado">delete_forever
                            </i>`);
                }
            }},
            // {"data":'estatus'},
            // {"data":"usuario_creacion"},
            // {"render": function ( data, type, row ) {
            //         return (`
            //         <label>
            //             <input type="checkbox" name="cantidad-`+row.docto_requisicion_id+`" value="1"  class="filled-in"/>
            //             <span></span>
                        
            //         </label>
            //         <input hidden type="number" name="requ-`+row.docto_requisicion_id+`" value="`+row.docto_requisicion_id+`" />
                    
            //         <i href="`+url_ver+row.docto_requisicion_id+`" class="visualizardocto puntero material-icons tooltipped teal-text" data-tooltip="Visualizar" >remove_red_eye</i>
            //         `);
            //     }
            // }
        ],
});*/
$(document).on('click','input[name="nombre_corto"]',function(){
    $('input[name="nombre_corto"]').val($('input[name="nombre"]').val());
});
if(document.location.href.includes('empleado/edit/')){
    datos_tabla=$('#tabla-cat-conceptos_nom').DataTable({
        order:[],
        responsive:true,
        // destroy: true,
        // "drawCallback": function () {
        //     $('.tooltipped').tooltip();
        // },
        // data: data,
        ajax:{
            "method":"GET",
            "url": $('#tabla-cat-conceptos_nom').attr('url-record'),
            "dataSrc":"",
            beforeSend: function (x) {
                id_docto_principal=$('#tabla-cat-conceptos_nom').attr('id-record');
                //console.log(id_empleado);
            },
            /*success: function (response) {
                console.log(response)
                
            },
            error: function (request, status, error) {
                console.log(error);
            },*/
            complete: function (msg) {
            //console.log(datos_tabla)
                $('a[href*="#modalArt"]').removeAttr('disabled');
            },
            
        },
        "columns":[
            {"data":"nombre"},
            {"data":"clave"},
            // {"render": function ( data, type, row ) {
            //     return (
            //         `<p class="descripcion tooltipped" data-tooltip="`+row.proveedor+`">`+row.proveedor+`</p>`
            //     );
            // }},
            {"data":'naturaleza'},
            {"data":'clave_fiscal'},
            {"data":'tipo_calculo'},
            {"data":'tipo_proceso'},
            {"render": function ( data, type, row ) {
                    return (`
                    <label>
                        <input type="checkbox" name="cantidad-`+row.concepto_nomina_id+`" value="`+row.concepto_nomina_id+`"  class="filled-in"/>
                        <span></span>
                        
                    </label>
                    <input hidden type="number" name="idgeneral-`+row.concepto_nomina_id+`" value="`+id_docto_principal+`" />
                    
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
if($('.validate_for_enable').val()){
    if($('.validate_for_enable').attr('url-record') && !$('.validate_for_enable').attr('disabled') ){
        validarparadesabilitar('.validate_for_enable')
    }
}
$(document).on('change','.validate_for_enable',function(event){
    if($(this).attr('url-record')){
        validarparadesabilitar('.validate_for_enable')
        /*let nextN=$(this).attr('next_node');
        let url=$(this).attr('url-record');
        let value=$(this).val();
        let res=verificarTrueFalse(url,'GET',{term:value});
        if(res){
            $(nextN).removeAttr('disabled');
        }else{
            $(nextN).val('');
            $(nextN).attr('disabled',true);
            $(nextN).removeClass('invalid');
            $(nextN+'-error').remove();
        }*/
        
    }
});
function validarparadesabilitar(nodoVal){
    let nextN=$(nodoVal).attr('next_node');
        let url=$(nodoVal).attr('url-record');
        let value=$(nodoVal).val();
        let res=verificarTrueFalse(url,'GET',{term:value},nextN);
        
}
 function verificarTrueFalse(url,metodo,data,nextN){
    let resultado;
    $.ajax({
        // async:false,
        url : url,
        method: metodo,
        data : data,
        success: function (response) { 
            if(response.data){
                console.log(response.data);
            }else if(response.status==true){
                    $(nextN).removeAttr('disabled');
                    
                resultado = true;
            }else if(response.status==false){
                $(nextN).val('');
                    $(nextN).attr('disabled',true);
                    $(nextN).removeClass('invalid');
                    $(nextN+'-error').remove();
                resultado = false;
            }
        },
        error: function (request, status, error) {
            console.log(request)
            resultado=false
        },
    });
    return resultado;
}
