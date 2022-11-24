<?php

namespace App\Models\Compras;

use App\Models\Doctos\DoctoCompraDetModel;
use App\Models\Doctos\DoctoCompraModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DevCompraModel extends Model
{
    public function DevCompraGetAll($modulo,$filtro){
        $qry="call COMPRAVISTA('$modulo', '$filtro')";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function DevCompraTNL(){
        $qry="call DEVCOMPRAVISTACOMPRAST()";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function storenewDevCompra($proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion){
        $qry="CALL DEVCOMPRANUEVA('$proveedor','$almacen','$fecha','$folio','$moneda','$usuario',$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,'$tipoDescuento',$importeDescuento,'$descripcion');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function DevCompraUpdate($doctoid,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion){
        $qry="CALL DEVCOMPRAUPDATE($doctoid,'$usuario',$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,'$tipoDescuento',$importeDescuento,'$descripcion');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getDataDevCompra($id){
        $qry="select count(*) from doctos_compras_ligas where docto_compra_des_id=$id";
        try{
            $data['compra']=DoctoCompraModel::where('dc.docto_compra_id','=',$id)
                ->join('proveedores','proveedores.proveedor_id','=','dc.proveedor_id')
                ->join('almacenes','almacenes.almacen_id','=','dc.almacen_id')
                ->join('conceptos_compras','conceptos_compras.concepto_compra_id','=','dc.concepto_compra_id')
                ->leftjoin('monedas','monedas.moneda_id','=','dc.moneda_id')
                ->select('dc.docto_compra_id',
                            'dc.folio_proveedor',
                            'proveedores.nombre as proveedor',
                            'almacenes.nombre as almacen',
                            'dc.fecha',
                            'dc.impuestos_retencion',
                            'dc.total',
                            'monedas.nombre as moneda',
                            'dc.tipo_cambio',
                            'dc.gastos_aduanales',
                            'dc.fletes',
                            'dc.otros_gastos',
                            'dc.arancel',
                            'dc.tipo_descuento',
                            'dc.descripcion',
                            //'dc.estatus',
                            DB::raw('(CASE dc.estatus when \'P\' then \'Pendiente\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' when \'N\' then \'Terminado\' end) as estatus'),
                            DB::raw('(select count(*) from doctos_compras_ligas dcl where dcl.docto_compra_des_id='.$id.') as ligada'),
                            //DB::raw('(CASE dc.tipo_descuento when \'P\' then \'Porcentaje\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' end) as estatus'),
                            'dc.importe_descuento',
                            'conceptos_compras.nombre as concepto')->first();
            $data['compraDet']=DoctoCompraDetModel::where('docto_compra_id','=',$id)
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
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function guardarRenglon($cantidad,$articulo,$precio,$devrecepcionid,$usuario){
        $qry="call DEVCOMPRAADDRENGLON($cantidad,'$articulo',$precio,$devrecepcionid,'$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function eliminarRenglon($compra_id,$compra_det_id,$usuario){
        $qry="call DEVCOMPRADELETERENGLON($compra_id,$compra_det_id,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function agregardesdecompra($ordenes,$usuario){
        $qry="call DEVCOMPRADESDECOMPRA('$ordenes','$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    
    public function DevCompraFinalizar($compraid,$usuario){
        $qry="call DEVCOMPRAFINALIZAR($compraid,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function DevCompraCancelar($doctoid,$motivo,$usuario){
        $qry="call DEVCOMPRACANCELAR('$doctoid','$motivo','$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
