<?php

namespace App\Models\Compras;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraModel extends Model
{
    
    public function getPurchaseOrders($email){
        $qry = 'CALL';
		$qry .= ' VISTAORDENCOMPRA';
		$qry .= ' ( ';
		$qry .=  '\'' . $email . '\'';
		$qry .=  ' , \'\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
    }
    public function getProveedores(){
        $qry="select proveedor_id,
        nombre 
        from 
        proveedores;";
        $data=DB::select($qry,array());
        return $data;
    }
    // public function getConceptosCompras(){
    //     // $qry="select concepto_compra_id,
    //     // nombre 
    //     // from 
    //     // conceptos_compras;";
	// 	$qry="call GETCONCEPTOSCOMPRAS('OC')";
    //     $data=DB::select($qry,array());
    //     return $data;
    // }
    public function insertOrdenCompra($proveedor,$fecha,$usuario,$almacen,$descripcion,$moneda){
        
		$qry="CALL ORDENCOMPRANUEVO (
            '".$proveedor."'
            ,'".$fecha."'
            ,'".$usuario."'
			,'".$almacen."'
			,'".$descripcion."'
			,'".$moneda."');";
		try{
        	$data=DB::select($qry,array());
			$data=$data[0]->Proceso;
		}catch(Exception $e){
			$data=$e->getMessage();
		}
        return $data;
    }
	public function InsertRequisicionOrdenCompra($requisiciones,$proveedor,$lugar_entrega,$moneda,$familia,$usuario){
		$qry="call ORDENCOMPRADESDEREQ('$requisiciones','$proveedor','$lugar_entrega','$moneda','$familia','$usuario')";
		try{
        	$data=DB::select($qry,array());
			$data=$data[0]->Respuesta;
		}catch(Exception $e){
			$data=$e->getMessage();
		}
        return $data;
	}
	public function InsertCotizacionOrdenCompra($idcotizacion,$lugar_entrega,$usuario){
		$qry="call ORDENCOMPRADESDECOTIZACION('$idcotizacion','$lugar_entrega','$usuario')";
		try{
        	$data=DB::select($qry,array());
			$data=$data[0]->Respuesta;
		}catch(Exception $e){
			$data=$e->getMessage();
		}
        return $data;
	}
    public function validateOrdenCompraid($id){
        $qry = ' SELECT ';
		$qry .= ' docto_compra_id ';
		$qry .= ' FROM doctos_compras ';
		$qry .= ' WHERE ' ;
		$qry .= ' docto_compra_id = ' . $id;
		return (DB::select($qry));
    }
    public function validateOrdenCompraidUsuario($id,$usuario){
        $qry = ' SELECT ';
		$qry .= ' docto_compra_id ';
		$qry .= ' FROM doctos_compras ';
		$qry .= ' WHERE ' ;
		$qry .= ' usuario_creador = \'' . $usuario . ' \' ';
		$qry .= ' AND ' ;
		$qry .= ' docto_compra_id = ' . $id;
		return (DB::select($qry));
    }
    public function getDoctoOrdenCompra($id,$usuario){
        /*$qry = 'SELECT';
		$qry .= ' COALESCE(r.folio, \'No\') folio  ';
		$qry .= ', REPLACE(REPLACE(REPLACE(r.fecha_autorizacion, \':\', \'\' ), \'-\', \'\'), \' \', \'\') fecha_autorizacion';
		$qry .= ', c.nombre ';
		$qry .= ', r.docto_compra_id ';
		$qry .= ' , r.descripcion ';
		$qry .= ' , (CASE r.autorizado WHEN \'N\' THEN \'No\' WHEN \'S\' THEN \'Si\' END) AS autorizado ';
        $qry .= ' , p.nombre as proveedor ';
        $qry .= ' , a.nombre as almacen ';
		$qry .= ' , r.fecha ';
		$qry .= ' , uw.nombre as usuario_creacion ';
		$qry .= ' , r.usuario_creador as email ';
		$qry .= ' , r.total ';
		$qry .= ' , ( ';
		$qry .= ' CASE r.estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'T\' THEN \'Terminado\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' WHEN \'S\' THEN \'Surtido\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus, ';
		$qry .= ' m.nombre moneda ';
		$qry .= ' FROM doctos_compras r ';
		$qry .= ' INNER JOIN conceptos_compras c';
		$qry .= ' ON  ';
		$qry .= ' r.concepto_compra_id ';
		$qry .= ' = c.concepto_compra_id ';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  r.usuario_creador = uw.correo';
        $qry .= ' INNER JOIN proveedores p ON p.proveedor_id=r.proveedor_id ';
        $qry .= ' INNER JOIN almacenes a ON a.almacen_id=r.almacen_id ';
        $qry .= ' left JOIN monedas m ON m.moneda_id=r.moneda_id ';
		$qry .= ' WHERE ';
		$qry .= ' r.docto_compra_id = ' . $id;*/
		$qry="call ORDENCOMPRAEDITAR($id,'$usuario')";
		try{
			$data = DB::select($qry,array());
		}catch(Exception $e){
			$data=$e->getMessage();
		}
		return $data;
    }
    public function getArticulosOrdenCompra($id){
        $qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		$qry .= ' , d.docto_compra_det_id ';
		$qry .= ' , ROUND(d.cantidad, 2) AS cantidad ';
		$qry .= ' , a.nombre ';
		$qry .= ' , d.precio_unitario ';
		$qry .= ' , d.total';
		$qry .= ' , d.nota_articulo ';
		$qry .= ' FROM doctos_compras_det d';
		$qry .= ' INNER JOIN articulos a';
		$qry .= ' ON ';
		$qry .= ' d.articulo_id ';
		$qry .= ' = a.articulo_id ';
		// $qry .= ' LEFT JOIN centros_costos c';
		// $qry .= ' ON ';
		// $qry .= ' c.centro_costo_id ';
		// $qry .= ' = d.centro_costo_id ';
		$qry .= ' WHERE ';
		$qry .= ' d.docto_compra_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
    }
    public function getImagenes($id){
        $qry = 'SELECT';
		$qry .= ' ra.archivo ';
		$qry .= ' , dra.repositorio_archivo_id ';
		$qry .= ' , ra.nombre_archivo ';
		$qry .= ' , dra.descripcion ';
		$qry .= ' FROM ' ;
		$qry .= ' repositorio_archivos ra ';
		$qry .= ' LEFT JOIN doctos_cpras_archivos dra ';
		$qry .= ' ON ';
		$qry .= 'ra.repositorio_archivo_id = dra.repositorio_archivo_id ';
		$qry .= ' WHERE ';
		$qry .= ' dra.docto_cpra_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
    }
	//editar orden compra
	//crear orden compra
	public function getAlmacenes(){
		$qry = ' SELECT ';
		$qry .= ' almacen_id ';
		$qry .= ', nombre ';
		$qry .= ' FROM almacenes;';
		return (DB::select($qry));
    }
	public function insertOrdenCompraDet($articulod/*, $centrocostod*/, $cantidadd,$precio, $notad, $doctocompraid, $usuario){
		$qry = 'CALL';
		$qry .= ' ORDENCOMPRAADDRENGLON ';
		$qry .= ' ( ';
		$qry .=  '\'' . $articulod . '\'';
		/*$qry .=  ' , \'' . $centrocostod . '\'';*/
		$qry .=  ' , \'' . $cantidadd . '\'';
		$qry .=  ' , \'' . $precio . '\'';
		$qry .=  ' , \'' . $notad . '\'';
		$qry .=  ' , \'' . $doctocompraid . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}
	public function deleteArticuloCompra($doctocompraid, $articuloid, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' ORDENCOMPRADELETEENGLON ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctocompraid . '\'';
		$qry .=  ' , \'' . $articuloid . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		try{
			$data = DB::select($qry,array());
			$data= $data[0]->Proceso;
		}catch(Exception $e){
			$data=$e->getMessage();
		}
		return $data;
	}
	public function getRequisiciones($email){
		$qry = 'CALL';
		$qry .= ' VISTAORDENCOMPRAREQUISICIONES';
		$qry .= ' ( ';
		$qry .=  '\'' . $email . '\'';
		$qry .=  ' , \'A\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}
	public function validateRequisicionid($id){
		$qry = ' SELECT ';
		$qry .= ' docto_compra_id ';
		$qry .= ' FROM doctos_compras ';
		$qry .= ' WHERE ' ;
		$qry .= ' docto_compra_id = ' . $id;
		return (DB::select($qry));
	}
	public function getDoctoCompra($id){
		$qry = 'SELECT';
		$qry .= ' COALESCE(co.folio, \'No\') folio  ';
		$qry .= ', c.nombre ';
		$qry .= ', co.docto_compra_id ';
		$qry .= ' , co.descripcion ';
		$qry .= ' , co.fecha ';
		$qry .= ' , p.nombre as proveedor ';
		$qry .= ' , al.nombre as almacen ';
		$qry .= ' , uw.nombre as creado_por ';
		$qry .= ' , co.usuario_creador as email ';
		$qry .= ' , ( ';
		$qry .= ' CASE co.estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'T\' THEN \'Terminado\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus ';
		$qry .= ' FROM doctos_compras co ';
		$qry .= ' INNER JOIN conceptos_compras c';
		$qry .= ' ON  ';
		$qry .= ' co.concepto_compra_id ';
		$qry .= ' = c.concepto_compra_id ';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  uw.correo=co.usuario_creador  ';
		$qry .= ' INNER JOIN proveedores p ON ';
		$qry .= ' p.proveedor_id = co.proveedor_id ';
		$qry .= ' INNER JOIN almacenes al ON ';
		$qry .= ' al.almacen_id = co.almacen_id ';
		$qry .= ' WHERE ';
		$qry .= ' co.docto_compra_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
	}
	public function getArticulosCompra($id){
		$qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		$qry .= ' , d.docto_compra_det_id ';
		$qry .= ' , ROUND(d.cantidad, 2) AS cantidad ';
		$qry .= ' , a.nombre ';
		$qry .= ' , d.nota_articulo ';
		//$qry .= ' , c.nombre AS centrocosto';
		$qry .= ' , d.precio_unitario ';
		$qry .= ' , d.total ';
		$qry .= ' , d.nota_articulo as nota ';
		$qry .= ' FROM doctos_compras_det d';
		$qry .= ' INNER JOIN articulos a';
		$qry .= ' ON ';
		$qry .= ' d.articulo_id ';
		$qry .= ' = a.articulo_id ';
		/*$qry .= ' LEFT JOIN centros_costos c';
		$qry .= ' ON ';
		$qry .= ' c.centro_costo_id ';
		$qry .= ' = d.centro_costo_id ';*/
		$qry .= ' WHERE ';
		$qry .= ' d.docto_compra_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
	}
	public function getArticulos($id)
	{

		$qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		$qry .= ' , a.nombre ';
		$qry .= ' , a.unidad_compra ';
		$qry .= ' , coalesce((select ac.precio_unitario from articulos_ultimas_compras ac where ac.articulo_id=a.articulo_id order by fecha_ultima_compra desc limit 1),0) as precio';
		$qry .= ' , (case a.pesar_articulo when \'N\' then \'NO\' when \'S\' then \'Si\' end) pesar ';
		$qry .= ' FROM ' ;
		$qry .= ' articulos a';
		$qry .= ' WHERE ';
		$qry .= ' a.estatus = \'R\' ' ;
		// $qry .= ' LEFT JOIN conceptos_requis_articulos cra';
		// $qry .= ' ON ';
		// $qry .= ' cra.articulo_id ';
		// $qry .= ' = a.articulo_id ';
		// $qry .= ' LEFT JOIN doctos_requisiciones dr';
		// $qry .= ' ON ';
		// $qry .= ' cra.concepto_requisicion_id ';
		// $qry .= ' = dr.concepto_requisicion_id ';
		// $qry .= ' WHERE ';
		// $qry .= ' dr.docto_requisicion_id = ' . $id ;

		$data = DB::select($qry,array());
		return $data;
	}
	public function getProvsbyTerm($term){
		$qry = 'SELECT';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM proveedores ';
		$qry .= ' WHERE  ';
		// $qry .= ' estatus = \'A\'  ';
		// $qry .= ' AND  ';
		$qry .= ' nombre LIKE \'%'. $term . '%\'';
		$data = DB::select($qry,array());
		return $data;
	}
	public function updateOrdenCompra($doctocompraid,$descripcion){
		// $qry = 'UPDATE';
		// $qry .= ' doctos_compras ';
		// $qry .= ' SET ';
		// $qry .= ' descripcion  ';
		// $qry .= ' = \'' . $descripcion . '\'';
		// $qry .= ' WHERE ';
		// $qry .= ' docto_compra_id = ' . $doctocompraid;
		$qry="call ORDENCOMPRAUPDATE($doctocompraid,'$descripcion')";
		try{
			$data = DB::select($qry,array());
			$data=$data[0]->Respuesta;
		}catch(Exception $e){
			$data=$e->getMessage();
		}
		return $data;
	}
	public function getArticulosRequisition($requisicion_id){
		$qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		//$qry .= ' , d.docto_requisicion_det_id ';
		$qry .= ' , ROUND(d.cantidad, 2) AS cantidad ';
		$qry .= ' , a.nombre ';
		$qry .= ' , d.nota_articulo ';
		//$qry .= ' , c.nombre AS centrocosto';
		$qry .= ' FROM doctos_requisiciones_det d';
		$qry .= ' INNER JOIN articulos a';
		$qry .= ' ON ';
		$qry .= ' d.articulo_id ';
		$qry .= ' = a.articulo_id ';
		// $qry .= ' LEFT JOIN centros_costos c';
		// $qry .= ' ON ';
		// $qry .= ' c.centro_costo_id ';
		// $qry .= ' = d.centro_costo_id ';
		$qry .= ' WHERE ';
		$qry .= ' d.docto_requisicion_id = ' . $requisicion_id;
		$data = DB::select($qry,array());
		return $data;
	}
	public function insertOrdenCompraDetRequ($articulod/*, $centrocostod*/, $cantidadd, $notad, $doctocompraid, $usuario){
		$qry = 'CALL';
		$qry .= ' ORDENCOMPRARENGLONREQU ';
		$qry .= ' ( ';
		$qry .=  '\'' . $articulod . '\'';
		/*$qry .=  ' , \'' . $centrocostod . '\'';*/
		$qry .=  ' , \'' . $cantidadd . '\'';
		$qry .=  ' , \'' . $notad . '\'';
		$qry .=  ' , \'' . $doctocompraid . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}
	public function aplicarOrdenCompra($ordencompraid,$articulosstr,$usuario){
		//ORDENCOMPRAAPLICA
		$qry = 'CALL';
		$qry .= ' ORDENCOMPRAAPLICA ';
		$qry .= ' ( ';
		$qry .=  '\'' . $ordencompraid . '\'';
		$qry .=  ',\'' . $articulosstr . '\'';
		$qry .=  ', \'' . $usuario . '\'';
		$qry .= ' )  ';
		try{
			$data = DB::select($qry,array());
			$data=$data[0]->Proceso;
		}catch(Exception $e){
			$data=$e->getMessage();
		}
		return $data;
	}
	public function getEmailToAutjOrdenCompra($doctocompraid){
		$qry = 'SELECT';
		$qry .= ' correo_notificacion ';
		$qry .= ' FROM conceptos_compras c ';
		$qry .= ' INNER JOIN doctos_compras dc ';
		$qry .= ' ON ';
		$qry .= ' dc.concepto_compra_id ';
		$qry .= ' = c.concepto_compra_id ';
		$qry .= ' WHERE  ';
		$qry .= ' dc.docto_compra_id = ' . $doctocompraid;
		$data = DB::select($qry,array());
		return $data;
	}
	public function autorizaOrdencompra($doctoordencompraid, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' ORDENCOMPRAAUTORIZA ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoordencompraid . '\'';
		$qry .=  ', \'' . $usuario . '\'';
		$qry .= ' )  ';
		try{
			$data = DB::select($qry,array());
			$data=$data[0]->Proceso;
		}catch(Exception $e){
			$data=$e->getMessage();
		}
		return $data;
	}
	public function cancelaOrdenCompra($doctoordencompraid, $usuario, $motivo)
	{
		$qry = 'CALL';
		$qry .= ' ORDENCOMPRACANCELA ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoordencompraid . '\'';
		$qry .=  ', \'' . $usuario . '\'';
		$qry .=  ', \'' . $motivo . '\'';
		$qry .= ' )  ';
		try{
			$data = DB::select($qry,array());
			$data=$data[0]->Proceso;
		}catch(Exception $e){
			$data=$e->getMessage();
		}
		return $data;
	}
}
