<?php

namespace App\Models\Compras;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CotizacionModel extends Model
{
    public function CotizacionGetAll($modulo,$estatus,$auth){
        $qry="CALL COTIZACIONVISTA('$modulo','$estatus','$auth');";
        try{
            $data=DB::select($qry,array());
        }catch(Exception $e){
            $data= $e->getMessage();
        }
        return $data;
    }
    public function CotizacionStore($proveedor,$moneda,$usuario){
        $qry="call COTIZACIONNUEVA('$proveedor','$moneda','$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function GetDataDocto($id,$usuario){
        $qry="call ORDENCOMPRAEDITAR($id,'$usuario')";
        $qryDet="SELECT ca.clave_articulo,a.articulo_id,a.unidad_compra, d.docto_compra_det_id, ROUND(d.cantidad, 2) AS cantidad
                    ,a.nombre articulo, d.precio_unitario, d.total, d.nota_articulo
                FROM doctos_compras_det d
                INNER JOIN articulos a ON d.articulo_id=a.articulo_id
                LEFT JOIN claves_articulos ca ON ca.articulo_id=a.articulo_id and rol_clave_art_id=1
                WHERE d.docto_compra_id=$id;";
        $data=array();
        try{
            //$data['docto_compra_id']=$id;
            $datos=DB::select($qry,array());
            $data['compra']=$datos[0];
            $data['compraDet']=DB::select($qryDet,array());
        }catch(Exception $e){
            $data= $e->getMessage();
        }
        return $data;
    }
    public function AddRenglon($cotizacion_id,$cantidad,$precio,$articulo,$usuario){
        $qry="call COTIZACIONADDRENGLON($cotizacion_id,$cantidad,$precio,'$articulo','$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function DeleteRenglon($doctoid,$articuloid,$usuario){
        $qry="call COTIZACIONDELETERENGLON($doctoid,$articuloid,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function GetContactosProv($proveedor){
        $qry="select ps.proveedor_sucursal_id,concat(c.nombre,', ',e.nombre_corto) localizacion,ps.correo,ps.nombre,ps.persona_contacto,ps.telefono,ps.movil from proveedores p
		            inner join proveedores_sucursales ps on ps.proveedor_id=p.proveedor_id
                    inner join ciudades c on c.ciudad_id=ps.ciudad_id
                    inner join estados e on e.estado_id=c.estado_id
	            where p.nombre='$proveedor';";
        try{
            $data=DB::select($qry,array());
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function FinalizarDocto($doctoid,$usuario){
        $qry="call COTIZACIONFINALIZAR($doctoid,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function CotizacionAddRequs($requisiciones,$proveedor,$moneda,$familia,$usuario){
        $qry="call COTIZACIONDESDEREQ('$requisiciones','$proveedor','$moneda','$familia','$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function CotizacionCancelar($cotizacionid,$usuario){
        $qry="call COTIZACIONCANCELAR($cotizacionid,'$usuario')";
        try{
            $data=DB::select($qry,array());
            $data=$data[0]->Respuesta;
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getDataDoctoPDF($id){
        $qry="SELECT
                COALESCE(dc.folio, 'No') folio , 
                REPLACE(REPLACE(REPLACE(dc.fecha_autorizacion, ':', '' ), '-', ''), ' ', '') fecha_autorizacion
                , cc.nombre concepto_compra
                , dc.docto_compra_id 
                , dc.descripcion 
                , (CASE dc.autorizado WHEN 'N' THEN 'No' WHEN 'S' THEN 'Si' END) AS autorizado 
                , p.nombre as proveedor
                , a.nombre as almacen
                , dc.fecha 
                , uw.nombre as usuario_creacion 
                , dc.usuario_creador as email
                , dc.total
                ,m.nombre moneda
                ,(select count(*)from doctos_compras_det dcd where dcd.docto_compra_id=dc.docto_compra_id) partidas
            FROM doctos_compras dc 
            INNER JOIN conceptos_compras cc ON cc.concepto_compra_id=dc.concepto_compra_id
            INNER JOIN usuarios_web uw ON uw.correo=dc.usuario_creador
            INNER JOIN proveedores p ON p.proveedor_id=dc.proveedor_id
            left JOIN almacenes a ON a.almacen_id=dc.almacen_id 
            left JOIN monedas m ON m.moneda_id=dc.moneda_id 
            WHERE 
            dc.docto_compra_id ='$id';";
        $qry2="SELECT 
                dcd.cantidad
                ,dcd.precio_unitario 
                ,dcd.total
                ,a.nombre articulo
                ,ca.clave_articulo
                ,a.unidad_compra
            FROM doctos_compras_det dcd
            INNER JOIN articulos a ON a.articulo_id=dcd.articulo_id
            left join claves_articulos ca on ca.articulo_id=dcd.articulo_id and ca.rol_clave_art_id=1
            where dcd.docto_compra_id='$id'";
        try{
            $docto=DB::select($qry,array());
            $data['docto']=$docto[0];
            $data['docto_det']=DB::select($qry2,array());
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
