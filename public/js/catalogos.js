$('#tableGeneral tbody').on('click', 'tr', function () {
    if (!$(this).hasClass('selected')) {
    //     $(this).removeClass('selected');
    // } else {
        $('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
});
// $('#button').click(function () {
//     table.row('.selected').remove().draw(false);
// });
$('#tableGeneral tbody').on('dblclick', 'tr', function () {
    if($(this).attr('modal-record')){
        //console.log($('#'+$(this).attr('modal-record'))[0]);
        abrirModal($(this).attr('modal-record'));
        if($(this).attr('id-record') !== $('[name="articulo_id"]').val()[0]){
            $('[name="articulo_id"]').val($(this).attr('id-record'))
            $('[name="unidades_entradas"]').val(0);
            $('[name="unidades_salidas"]').val(0);
            $('[name="unidades_total"]').val(0);
            $('[name="costo_entradas"]').val('$'+0+'.00');
            $('[name="costo_salidas"]').val('$'+0+'.00');
            $('[name="costo_total"]').val('$'+0+'.00');
            $('#tablaKardex').children('tbody').hide()
        
            $('[name="existencia_actual"]').val(Number(0).toFixed(2));
            $('[name="costo_unitario_promedio"]').val('$'+0);
            $('[name="costo_unitario"]').val('$'+0);
            $('[name="fecha_ultima_compra"]').val('');
            $('[name="valor_total_promedio"]').val('$'+0);
            $('[name="valor_total"]').val('$'+0);
            $('[name="salidas"]').val(0);
            $('[name="inv_promedio"]').val(0);
            $('[name="rotacion"]').val(0)
        }
        /*if (!$(this).hasClass('selected')) {
        //     $(this).removeClass('selected');
        // } else {
            $('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }*/
    }
});
$(document).on('click','.actualizar-info',function(event){
    event.preventDefault();
    let formulario=$(this).attr('form');
    
    // console.log(idarticulo)
    //form.serialize()
    // let articulo_id=$('#'+$(this).attr('form')).attr('action');
    // let almacen_id=$('#'+$(this).attr('form')).attr('method');
    // let form = $('#'+$(this).attr('form')).serializeArray();
    //let formDatos = $('#'+$(this).attr('form')).serialize();
    
    //peticionAjaxconData($('#tablaKardex').attr('url-record'),formDato,'POST');
    // if($(this).hasClass('kardex')){
        let idarticulo=getFormData(formulario,'articulo_id')
        let idalmacen=getFormData(formulario,'almacen')
        let fecha_in=getFormData(formulario,'fecha_inicio')
        let fecha_fi=getFormData(formulario,'fecha_fin')
        let formDato={articulo_id:idarticulo,
                        almacen:idalmacen,
                        fecha_inicio:fecha_in,
                        fecha_fin:fecha_fi};
        
    //}
    let res=validarFormularioUrl2($(this).attr('form'));
    console.log(res)
    if(res.status==true){
        if($(this).hasClass('kardex')){
            actualizarKardex(formDato);
            $('[name="unidades_entradas"]').val(Number(res.data.uni_total_ent).toFixed(2));
            $('[name="unidades_salidas"]').val(Number(res.data.uni_total_sal).toFixed(2));
            $('[name="unidades_total"]').val(Number(res.data.uni_total_ent-res.data.uni_total_sal).toFixed(2));
            $('[name="costo_entradas"]').val('$'+Number(res.data.costo_total_ent).toFixed(2));
            $('[name="costo_salidas"]').val('$'+Number(res.data.costo_total_sal).toFixed(2));
            $('[name="costo_total"]').val('$'+Number(res.data.costo_total_ent-res.data.costo_total_sal).toFixed(2));
        }else{
            console.log(res)
            $('[name="existencia_actual"]').val(Number(res.data.totales.uni_total_ent-res.data.totales.uni_total_sal).toFixed(2));
            $('[name="costo_unitario_promedio"]').val('$'+Number(res.data.existencias.costo_promedio).toFixed(2));
            $('[name="costo_unitario"]').val('$'+Number(res.data.existencias.valor_unitario).toFixed(2));
            $('[name="fecha_ultima_compra"]').val(res.data.existencias.fecha_ultimacompra);
            $('[name="valor_total_promedio"]').val('$'+Number(res.data.existencias.valor_total).toFixed(2));
            $('[name="valor_total"]').val('$'+Number(res.data.existencias.valor_total_s).toFixed(2));
            $('[name="salidas"]').val(Number(res.data.rotacion.salidas).toFixed(2));
            $('[name="inv_promedio"]').val(Number(res.data.rotacion.inv_promedio).toFixed(2));
            $('[name="rotacion"]').val(Number(res.data.rotacion.rotacion).toFixed(2));

        }
        getFormData($(this).attr('form'))
    }
})
function getFormData(formId,getvalor){
    let a=$('#'+formId).serializeArray()
    let dato;
    a.forEach((element, index)=>{
        if(element.name==getvalor){
            dato=element.value
        }
    })
    return dato;

  }
function actualizarKardex(datos){
    $('#tablaKardex').DataTable({
        "aaSorting": [],
        destroy:true,
        scrollY: '25vh',
        scrollCollapse: true,
        paging: false,
        searching:false,
        ordering: false,
        language: idiomaEp,
        //dropdownParent:$('#modalInfo')
        ajax:{
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "method":"POST",
            "url": $('#tablaKardex').attr('url-record'),
            "data":datos,
            "dataSrc":"",
            // success: function (response) {
            //     console.log(response)
            // },
            // error: function (request, status, error) {
            //     console.log(request);
            //     console.log(error);
            // },
            complete: function (msg) {
                $('#tablaKardex').children('tbody').show()
                // console.log(msg);
                // let a=document.getElementsByClassName('card-withTable')
                // a[0].removeAttribute('hidden')
                // console.log($(document).find('div.card.card-withTable'));
                // console.log($(this));
                // $('.card.withTable').removeAttr('hidden');
                // console.log('msg');
            },
            
        },
        "columns":[
                         {"data":"fecha"},
                         {"data":"concepto"},
                        //  {"data":"entradas"},
                         {"render": function ( data, type, row ) {
                            return (
                                `<div class="right" style="padding-right: 10px;">$`+Number(row.entradas).toFixed(2)+`</div>`
                            );
                            }
                        },
                        //  {"data":"salidas"},
                         {"render": function ( data, type, row ) {
                            return (
                                `<div class="right" style="padding-right: 10px;">$`+Number(row.salidas).toFixed(2)+`</div>`
                            );
                            }
                        },
                        //  {"data":"unidades"},
                        {"render": function ( data, type, row ) {
                            return (
                                `<div class="right" style="padding-right: 10px;">`+Number(row.unidades).toFixed(2)+`</div>`
                            );
                            }
                        },
                        //  {"data":"invcostofin"},
                         {"render": function ( data, type, row ) {
                            return (
                                `<div class="right" style="padding-right: 10px;">$`+Number(row.invcostofin).toFixed(2)+`</div>`
                            );
                            }
                        },
                        //  {"data":"invunidadesfinal"},
                        {"render": function ( data, type, row ) {
                            return (
                                `<div class="right" style="padding-right: 10px;">`+Number(row.invunidadesfinal).toFixed(2)+`</div>`
                            );
                            }
                        },
                    ]
        ,
        
    });
}