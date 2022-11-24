<?php

namespace App\Models\ContrladorGeneral;

use App\Models\Catalogos\AlmacenModel;
use App\Models\Catalogos\ArticulosModel;
use App\Models\Catalogos\MonedaModel;
use App\Models\Catalogos\ProveedorModel;
use App\Models\Compras\RecepcionModel;
use App\Models\Doctos\DoctoCompraModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerModel extends Model
{
    /**********************************************************************************************/
    /****                                     Recepciones                                      ****/
    /**********************************************************************************************/
    public function GetAll(){
        //$data=RecepcionModel::all();
        $qry="call RECEPCIONMERCANCIAVISTA()";
        try{
        /*$data=RecepcionModel::where('doctos_compras.tipo_docto','=','R')
            //left join
            //leftjoin('proveedores','proveedores.proveedor_id','=','doctos_compras.proveedor_id')
            //inner join
            ->join('proveedores','proveedores.proveedor_id','=','doctos_compras.proveedor_id')
            ->join('almacenes','almacenes.almacen_id','=','doctos_compras.almacen_id')
            ->select('doctos_compras.docto_compra_id',
            'doctos_compras.folio',
            'proveedores.nombre as proveedor',
            'almacenes.nombre as almacen',
            'doctos_compras.fecha',
            DB::raw('(CASE doctos_compras.estatus when \'P\' then \'Pendiente\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' when \'N\' then \'Terminado\' end) as estatus'),
            DB::raw('(CASE doctos_compras.aplicado when \'S\' then \'Si\' when \'N\' then \'No\' end) as aplicado'),
            DB::raw('(select dc.folio from doctos_compras dc where dc.docto_compra_id in (select dcl.docto_compra_fte_id from doctos_compras_ligas dcl where  dcl.docto_compra_des_id= doctos_compras.docto_compra_id) limit 1) as pedido'),
            DB::raw('(select count(*) from doctos_compras_ligas dcl where dcl.docto_compra_des_id=doctos_compras.docto_compra_id) as ligada')
            )
            ->get();*/
            $data=DB::select($qry,array()); 
        }catch(\Exception $e){
            $data=$e->getMessage();   
        }
        return $data;
    }
    public function getAlmacenesSelect(){
        //return "entro";
        $data=AlmacenModel::select('nombre')->get();
        return $data;
    }
    public function getMonedasSelect(){
        $data=MonedaModel::select('nombre')->get();
        return $data;
    }
    public function getConceptos(){
        // $qry="select concepto_compra_id,
        // nombre 
        // from 
        // conceptos_compras;";
		$qry="call GETCONCEPTOSCOMPRAS('RM')";
        $data=DB::select($qry,array());
        return $data;
    }
    public function storenewRecepcion($proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion,$concepto){
        $qry="CALL RECEPCIONMERCANCIANUEVA('$proveedor','$almacen','$fecha','$folio','$moneda','$usuario',$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,'$tipoDescuento',$importeDescuento,'$descripcion','$concepto');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        //$data=$tipoCambio." Este es el camnbop";
        return $data;
    }
    public function actualizarRecepcionMercancia($doctoid,$proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion){
        $qry="CALL RECEPCIONMERCANCIAUPDATE($doctoid,'$proveedor','$almacen','$fecha','$folio','$moneda','$usuario',$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,'$tipoDescuento',$importeDescuento,'$descripcion');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getDataRecepcion($id){
        $qry="select count(*) from doctos_compras_ligas where docto_compra_des_id=$id";
        try{
            $data['recepcion']=RecepcionModel::where('docto_compra_id','=',$id)
                ->join('proveedores','proveedores.proveedor_id','=','doctos_compras.proveedor_id')
                ->join('almacenes','almacenes.almacen_id','=','doctos_compras.almacen_id')
                ->join('conceptos_compras','conceptos_compras.concepto_compra_id','=','doctos_compras.concepto_compra_id')
                ->leftjoin('monedas','monedas.moneda_id','=','doctos_compras.moneda_id')
                ->select('doctos_compras.docto_compra_id',
                            'doctos_compras.folio_proveedor',
                            //DB::raw('(select dc.folio from doctos_compras dc where dc.docto_compra_id='.$id.'),(select dc.folio from doctos_compras dc where dc.docto_compra_id=(select dcl.docto_compra_fte_id from doctos_compras_ligas dcl where  dcl.docto_compra_des_id='.$id.')) as folio'),
                            'proveedores.nombre as proveedor',
                            'almacenes.nombre as almacen',
                            'doctos_compras.fecha',
                            'doctos_compras.impuestos_retencion',
                            'doctos_compras.total',
                            'monedas.nombre as moneda',
                            'doctos_compras.tipo_cambio',
                            'doctos_compras.gastos_aduanales',
                            'doctos_compras.fletes',
                            'doctos_compras.otros_gastos',
                            'doctos_compras.arancel',
                            'doctos_compras.tipo_descuento',
                            'doctos_compras.descripcion',
                            //'doctos_compras.estatus',
                            DB::raw('(CASE doctos_compras.estatus when \'P\' then \'Pendiente\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' when \'N\' then \'Terminado\' end) as estatus'),
                            DB::raw('(select count(*) from doctos_compras_ligas dcl where dcl.docto_compra_des_id='.$id.') as ligada'),
                            //DB::raw('(CASE doctos_compras.tipo_descuento when \'P\' then \'Porcentaje\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' end) as estatus'),
                            'doctos_compras.importe_descuento',
                            'conceptos_compras.nombre as concepto')->first();
            $data['almacenes']=$this->getAlmacenesSelect();
            $data['recepcionDet']=RecepcionDetModel::where('docto_compra_id','=',$id)
                                    //->where('claves_articulos.rol_clave_art_id','=',1)
                                    ->join('articulos','articulos.articulo_id','=','doctos_compras_det.articulo_id')
                                    ->leftjoin('articulos_lotes_vencimientos','articulos_lotes_vencimientos.articulo_id','=','articulos.articulo_id')
                                    ->leftjoin('desgloces_lotes_compras','desgloces_lotes_compras.articulo_lote_vence_id','=','articulos_lotes_vencimientos.articulo_lote_vence_id')
                                    ->select('doctos_compras_det.docto_compra_det_id',
                                        'articulos.nombre as articulo',
                                        'doctos_compras_det.cantidad',
                                        'doctos_compras_det.precio_unitario',
                                        'doctos_compras_det.total',
                                        'doctos_compras_det.impuestos_retenidos',
                                        DB::raw('(select ca.clave_articulo from claves_articulos ca where articulos.articulo_id=ca.articulo_id and ca.rol_clave_art_id=1)as clave_articulo'),
                                        'articulos.unidad_compra',
                                        'articulos.articulo_id',
                                        'articulos.seguimiento_lotes',
                                        'articulos_lotes_vencimientos.clave as seriefolio',
                                        'articulos_lotes_vencimientos.fecha as fecha_lote',
                                        'articulos_lotes_vencimientos.tipo as tipo_lote',
                                        'desgloces_lotes_compras.cantidad as cantidad_lote')
                                    ->get();
            $data['monedas']=$this->getMonedasSelect();
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function validarMoneda($moneda){
        try{
            $data=MonedaModel::where('nombre','=',$moneda)
                                    ->select("es_local")->first();
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function verificarProveedor($proveedor){
        try{
            $data=ProveedorModel::where('nombre','=',$proveedor)
                                      ->select('extranjero')->first();
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function eliminarRenglon($compra_id,$compra_det_id,$usuario){
        $qry="call RECEPCIONMERCANCIADELETERENGLON($compra_id,$compra_det_id,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function guardarRenglon($cantidad,$articuloid,$precio,$recepcionid,$usuario){
        $qry="call RECEPCIONMERCANCIAAGREGARRENGLON($cantidad,$articuloid,$precio,$recepcionid,'$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function finalizarRececpcion($recepcionid,$usuario){
        $qry="call RECEPCIONMERCANCIAFINALIZAR($recepcionid,'$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function cancelarRececpcion($recepcionid,$usuario,$motivo){
        $qry="call RECEPCIONMERCANCIACANCELAR($recepcionid,'$usuario','$motivo');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getOrdenesCompra(){
        $qry="call RECEPCIONMERCANCIAVISTAORDENESPORRECIBIR();";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getDataInsert($doctocompraid){
        try{
            $data['docto_compra']=DoctoCompraModel::where('dc.docto_compra_id','=',$doctocompraid)
            ->join('proveedores','proveedores.proveedor_id','=','dc.proveedor_id')
            ->join('almacenes','almacenes.almacen_id','=','dc.almacen_id')
            ->leftjoin('monedas','monedas.moneda_id','=','dc.moneda_id')
            ->select('dc.docto_compra_id',
                        'dc.folio',
                        'proveedores.nombre as proveedor',
                        'almacenes.nombre as almacen',
                        'dc.fecha',
                        'dc.impuestos_retencion',
                        'dc.total',
                        'monedas.nombre',
                        //DB::raw('coalesce(monedas.nombre,(select m.nombre from monedas m where m.es_local="S")) as moneda'),
                        DB::raw('coalesce(dc.tipo_cambio,1) tipo_cambio'),
                        DB::raw('coalesce(dc.gastos_aduanales,0) gastos_aduanales'),
                        DB::raw('coalesce(dc.fletes,0) fletes'),
                        DB::raw('coalesce(dc.otros_gastos,0) otros_gastos'),
                        DB::raw('coalesce(dc.arancel,0) arancel'),
                        'dc.tipo_descuento',
                        //DB::raw('(CASE doctos_compras.tipo_descuento when \'P\' then \'Porcentaje\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' end) as estatus'),
                        DB::raw('coalesce(dc.importe_descuento,0) importe_descuento'))->first();
            // $data['docto_compra']=DoctoCompraModel::where('dc.docto_compra_id','=',$doctocompraid)
            //                             ->select('*')->first();
            $data['docto_compra_det']=RecepcionDetModel::where('doctos_compras_det.docto_compra_id','=',$doctocompraid)
                                        ->select('cantidad','articulo_id','precio_unitario')->get();                          
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function guardarRecepcionLigada($id,$proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento){
        $qry="call RECEPCIONMERCANCIALIGADA($id,'$proveedor','$almacen','$fecha','$folio','$moneda','$usuario',$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,'$tipoDescuento',$importeDescuento);";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function finalizardetalleligado($recepcionid,$articuloid,$pedidas,$recibidas,$usuario){
        $qry="call RECEPCIONMERCANCIAACTUALIZARRECIBIDAS($recepcionid,$articuloid,$pedidas,$recibidas,'$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function finalizarrecepcionligado($recepcionid,$usuario){
        $qry="call RECEPCIONMERCANCIAFINALIZARLIGADA($recepcionid,'$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function ligardocto($idorigen,$nuevoid){
        $qry="call RECEPCIONMERCANCIALIGARDOCTOSCOMPRAS($idorigen,$nuevoid)";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function agregarordenesarecepcion($ordenes,$usuario){
        $qry="call RECEPCIONMERCANCIAORDENCOMPRA('$ordenes','$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function insertarDataDetLigada($recepcionid){
        $qry="call RECEPCIONMERCANCIAAGREGARRENGLONLIGADAARRAY($recepcionid)";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function ActualizatLote($articuloid,$compradetid,$tipo,$serie,$fecha,$cantidad){
        $qry="call RECEPCIONMERCANCIAACTUALIZARLOTE($articuloid,$compradetid,'$tipo','$serie','$fecha','$cantidad')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
