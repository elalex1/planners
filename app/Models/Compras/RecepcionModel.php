<?php

namespace App\Models\Compras;

use App\Models\Catalogos\MonedaModel;
use App\Models\Catalogos\ProveedorModel;
use App\Models\Doctos\DoctoCompraDetModel;
use App\Models\Doctos\DoctoCompraModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecepcionModel extends Model
{
    protected $table="doctos_compras";

    public function GetAll($tipo){
        $qry="call RECEPCIONMERCANCIAVISTA('$tipo')";
        try{
            $data=DB::select($qry,array()); 
        }catch(\Exception $e){
            $data=$e->getMessage();   
        }
        return $data;
    }
    public function storenewRecepcion($proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion){
        $qry="CALL RECEPCIONMERCANCIANUEVA('$proveedor','$almacen','$fecha','$folio','$moneda','$usuario',$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,'$tipoDescuento',$importeDescuento,'$descripcion');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        //$data=$tipoCambio." Este es el camnbop";
        return $data;
    }
    public function getDataRecepcion($id){
        $qry="select count(*) from doctos_compras_ligas where docto_compra_des_id=$id";
        try{
            $data['recepcion']=DoctoCompraModel::where('dc.docto_compra_id','=',$id)
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
            $data['recepcionDet']=DoctoCompraDetModel::where('docto_compra_id','=',$id)
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
                                        'doctos_compras_det.articulo_id',
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
    public function guardarRenglon($cantidad,$articulo,$precio,$recepcionid,$usuario){
        $qry="call RECEPCIONADDRENGLON($cantidad,'$articulo',$precio,$recepcionid,'$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
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
    public function RecepcionImagenAdd($idrecepcion, $archivo, $extension, $nombre, $descripcion, $usuario){
        $qry="CALL RECEPCIONARCHIVOADD($idrecepcion, '$archivo', '$extension', '$nombre', '$descripcion', '$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getImagenes($id){
        $qry="SELECT ra.repositorio_archivo_id,ra.nombre_archivo,ra.tipo,
                    ra.archivo,dca.descripcion,dca.docto_cpra_archivo_id
                FROM repositorio_archivos ra 
                LEFT JOIN doctos_cpras_archivos dca 
                ON ra.repositorio_archivo_id = dca.repositorio_archivo_id
                where dca.docto_cpra_id=$id;";
        $data=DB::select($qry,array());
        return $data;
    }
    public function RecepcionImagenDelete($recepcion_id, $archivo_id, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' RECEPCIONARCHIVODELETE ';
		$qry .= ' ( ';
		$qry .=  '\'' . $recepcion_id . '\'';
		$qry .=  ' , \'' . $archivo_id . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		try{
			$data = DB::select($qry,array());
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
        $qry="call RECEPCIONMERCANCIAVERORDENES();";
        try{
            $data=DB::select($qry,array());
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
    // public function finalizardetalleligado($recepcionid,$articuloid,$pedidas,$recibidas,$usuario){
    //     $qry="call RECEPCIONMERCANCIAACTUALIZARRECIBIDAS($recepcionid,$articuloid,$pedidas,$recibidas,'$usuario');";
    //     try{
    //         $data=DB::select($qry,array());
    //         $data=$data[0]->Respuesta;
    //     }catch(\Exception $e){
    //         $data=$e->getMessage();
    //     }
    //     return $data;
    // }
    public function finalizarrecepcionligado($articulos,$usuario){
        $qry="call RECEPCIONMERCANCIAFINALIZARLIGADA('$articulos','$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function ActualizatLote($articuloid,$compradetid,$tipo,$serie,$fecha,$cantidad){
        $qry="call RECEPCIONUPDATELOTE($articuloid,$compradetid,'$tipo','$serie','$fecha','$cantidad')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
