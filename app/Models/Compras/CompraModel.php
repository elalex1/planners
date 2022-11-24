<?php

namespace App\Models\Compras;

use App\Models\Doctos\DoctoCompraDetModel;
use App\Models\Doctos\DoctoCompraModel;
use App\Models\RecepcionMercancia\RecepcionModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompraModel extends Model
{
    //
    protected $Doctos_compras;
    public function __construct()
    {
        $this->Doctos_compras=new DoctoCompraModel();
    }
    public function CompraGetAll($modulo,$filtro){
        //return $this->Usuario." ".$this->Rol." ".$filtro;
        $qry="call COMPRAVISTA('$modulo', '$filtro')";
        try{
            // $data=DoctoCompraModel::where('dc.tipo_docto','=','C')
            // ->join('proveedores','proveedores.proveedor_id','=','dc.proveedor_id')
            // ->join('almacenes','almacenes.almacen_id','=','dc.almacen_id')
            // ->select('dc.docto_compra_id',
            // 'dc.folio',
            // 'proveedores.nombre as proveedor',
            // 'almacenes.nombre as almacen',
            // 'dc.fecha',
            // DB::raw('(CASE dc.estatus when \'P\' then \'Pendiente\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' when \'N\' then \'Terminado\' end) as estatus'),
            // DB::raw('(CASE dc.aplicado when \'S\' then \'Si\' when \'N\' then \'No\' end) as aplicado'),
            // DB::raw('(select count(*) from doctos_compras_ligas dcl where dcl.docto_compra_des_id=dc.docto_compra_id) as ligada')
            // )
            // ->get(); 
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function NewCompraStrore($proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento){
        $qry="CALL COMPRANUEVA('$proveedor','$almacen','$fecha','$folio','$moneda','$usuario',$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,'$tipoDescuento',$importeDescuento);";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        //$data=$tipoCambio." Este es el camnbop";
        return $data;
    }
    public function getDataCompra($id){
        $qry="select count(*) from doctos_compras_ligas where docto_compra_des_id=$id";
        try{
            $data['compra']=DoctoCompraModel::where('dc.docto_compra_id','=',$id)
                ->join('proveedores','proveedores.proveedor_id','=','dc.proveedor_id')
                ->join('almacenes','almacenes.almacen_id','=','dc.almacen_id')
                ->join('conceptos_compras','conceptos_compras.concepto_compra_id','=','dc.concepto_compra_id')
                ->leftjoin('monedas','monedas.moneda_id','=','dc.moneda_id')
                ->select('dc.docto_compra_id',
                            'dc.folio',
                            'dc.folio_proveedor',
                            //DB::raw('(select dc.folio from doctos_compras dc where dc.docto_compra_id='.$id.'),(select dc.folio from doctos_compras dc where dc.docto_compra_id=(select dcl.docto_compra_fte_id from doctos_compras_ligas dcl where  dcl.docto_compra_des_id='.$id.')) as folio'),
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
                            //'doctos_compras.estatus',
                            DB::raw('(CASE dc.estatus when \'P\' then \'Pendiente\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' when \'N\' then \'Terminado\' end) as estatus'),
                            DB::raw('(select count(*) from doctos_compras_ligas dcl where dcl.docto_compra_des_id='.$id.') as ligada'),
                            //DB::raw('(CASE doctos_compras.tipo_descuento when \'P\' then \'Porcentaje\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' end) as estatus'),
                            'dc.importe_descuento',
                            'conceptos_compras.nombre as concepto_compra')->first();
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
    public function GetRecepciones(){
        //return $this->Usuario." ".$this->Rol." ".$filtro;
        $qry="call COMPRAVISTARECEPCIONES();";
        try{
            /*$data=DoctoCompraModel::where('dc.tipo_docto','=','R')
            ->where('dc.estatus','=','N')
            //left join
            //leftjoin('proveedores','proveedores.proveedor_id','=','doctos_compras.proveedor_id')
            //inner join
            ->join('proveedores','proveedores.proveedor_id','=','dc.proveedor_id')
            ->join('almacenes','almacenes.almacen_id','=','dc.almacen_id')
            ->select('dc.docto_compra_id',
            'dc.folio',
            'proveedores.nombre as proveedor',
            'almacenes.nombre as almacen',
            'dc.fecha',
            DB::raw('(CASE dc.estatus when \'P\' then \'Pendiente\' when \'C\' then \'Cancelado\' when \'T\' then \'Terminado\' when \'N\' then \'Terminado\' end) as estatus'),
            DB::raw('(CASE dc.aplicado when \'S\' then \'Si\' when \'N\' then \'No\' end) as aplicado'),
            DB::raw('(select count(*) from doctos_compras_ligas dcl where dcl.docto_compra_des_id=dc.docto_compra_id) as ligada')
            )
            ->get();*/ 
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getConceptosCompras(){
		$qry="call GETCONCEPTOSCOMPRAS('CO')";
        $data=DB::select($qry,array());
        return $data;
    }
    public function AddRecepciones($doctos,$usuario){
        $qry="call COMPRADESDERECEPCION('$doctos','$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function actualizarCompra($doctoid,$importeDescuento,$tipoDescuento,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$usuario){
        $qry="call COMPRAUPDATE($doctoid,$importeDescuento,'$tipoDescuento',$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function CompraImagenAdd($idrecepcion, $archivo, $extension, $nombre, $descripcion, $usuario){
        $qry="CALL COMPRAARCHIVOADD($idrecepcion, '$archivo', '$extension', '$nombre', '$descripcion', '$usuario');";
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
    public function CompraImagenDelete($compra_id, $archivo_id, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' COMPRAARCHIVODELETE ';
		$qry .= ' ( ';
		$qry .=  '\'' . $compra_id . '\'';
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
    public function guardarRenglon($cantidad,$articulo,$precio,$doctoid,$usuario){
        $qry="call COMPRAADDRENGLON($cantidad,'$articulo',$precio,$doctoid,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function eliminarRenglon($compra_id,$compra_det_id,$usuario){
        $qry="call COMPRADELETERENGLON($compra_id,$compra_det_id,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function FinalizarCompra($compra_id,$usuario){
        $qry="call COMPRAFINALIZAR($compra_id,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function CompraCancelar($doctoid,$motivo,$usuario){
        $qry="call COMPRACANCELAR('$doctoid','$motivo','$usuario');";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
