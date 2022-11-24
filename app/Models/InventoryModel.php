<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class InventoryModel
{

	public function __construct(){

	}

	public function validateInventarioidUsuario($id, $usuario)
	{
		$qry = ' SELECT ';
		$qry .= ' docto_inventario_id ';
		$qry .= ' FROM doctos_inventarios ';
		$qry .= ' WHERE ' ;
		$qry .= ' usuario_creador = \'' . $usuario . ' \' ';
		$qry .= ' AND ' ;
		$qry .= ' docto_inventario_id = ' . $id;
		return (DB::select($qry));
	}

	public function validateInventarioid($id)
	{
		$qry = ' SELECT ';
		$qry .= ' docto_inventario_id ';
		$qry .= ' FROM doctos_inventarios ';
		$qry .= ' WHERE ' ;
		$qry .= ' docto_inventario_id = ' . $id;
		return (DB::select($qry));
	}

	public function getInventarios($tipo_inventario,$usuario)
	{
		$qry = ' SELECT ';
		$qry .= ' di.docto_inventario_id ';
		$qry .= ', di.folio ';
		$qry .= ', a.nombre AS almacen ';
		$qry .= ', ci.nombre AS concepto ';
		$qry .= ', di.descripcion ';
		$qry .= ', di.fecha ';
		$qry .= ' , ( ';
		$qry .= ' CASE estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'N\' THEN \'Normal\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus ';
		$qry .= ', uw.nombre as usuario';
		$qry .= ' FROM doctos_inventarios di';
		$qry .= ' INNER JOIN almacenes a ';
		$qry .= ' ON  di.almacen_id = a.almacen_id';
		$qry .= ' INNER JOIN conceptos_inventarios ci ';
		$qry .= ' ON  di.concepto_inventario_id = ci.concepto_inventario_id';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  di.usuario_creador = uw.correo';
		$qry .= ' WHERE ' ;
		$qry .= ' naturaleza_movto = ' . ' \'' . $tipo_inventario . '\' ';
		$qry .= ' AND usuario_creador = ' . ' \'' . $usuario . '\' ';
		$data = DB::select($qry,array());
		return $data;
	}


	public function getInventariosAdmin($tipo_inventario)
	{
		$qry = ' SELECT ';
		$qry .= ' di.docto_inventario_id ';
		$qry .= ', di.folio ';
		$qry .= ', a.nombre AS almacen ';
		$qry .= ', ci.nombre AS concepto ';
		$qry .= ', di.descripcion ';
		$qry .= ', di.fecha ';
		$qry .= ' , ( ';
		$qry .= ' CASE di.estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'N\' THEN \'Normal\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus ';
		$qry .= ', uw.nombre as usuario';
		$qry .= ' FROM doctos_inventarios di';
		$qry .= ' INNER JOIN almacenes a ';
		$qry .= ' ON  di.almacen_id = a.almacen_id';
		$qry .= ' INNER JOIN conceptos_inventarios ci ';
		$qry .= ' ON  di.concepto_inventario_id = ci.concepto_inventario_id';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  di.usuario_creador = uw.correo';
		$qry .= ' WHERE ' ;
		$qry .= ' naturaleza_movto = ' . ' \'' . $tipo_inventario . '\' ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getRequiereCC($concepto)
	{
		$qry = ' SELECT ';
		$qry .= ' requiere_cc ';
		$qry .= ' FROM ';
		$qry .= ' conceptos_inventarios';
		$qry .= ' WHERE ' ;
		$qry .= ' nombre = ' . ' \'' . $concepto . '\' ';
		$data = DB::select($qry,array());
		return $data;
	}
	public function getConceptosInventarios($tipo_inventario)
	{
		$qry = ' SELECT ';
		$qry .= ' * ';
		$qry .= ' FROM ';
		$qry .= ' conceptos_inventarios';
		$qry .= ' WHERE ' ;
		$qry .= ' tipo_movimiento = ' . ' \'' . $tipo_inventario . '\' ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getAlmacenes()
	{
		$qry = ' SELECT ';
		$qry .= ' * ';
		$qry .= ' FROM ';
		$qry .= ' almacenes';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getArticulos($id)
	{

		$qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		$qry .= ' , a.nombre ';
		$qry .= ' , a.unidad_compra ';
		$qry .= ' FROM ' ;
		$qry .= ' articulos a';
		$qry .= ' WHERE ';
		$qry .= ' a.estatus = \'R\' ' ;
		// $qry .= ' LEFT JOIN conceptos_requis_articulos cra';
		// $qry .= ' ON ';
		// $qry .= ' cra.articulo_id ';
		// $qry .= ' = a.articulo_id ';
		// $qry .= ' LEFT JOIN doctos_inventarios dr';
		// $qry .= ' ON ';
		// $qry .= ' cra.concepto_requisicion_id ';
		// $qry .= ' = dr.concepto_requisicion_id ';
		// $qry .= ' WHERE ';
		// $qry .= ' dr.docto_inventario_id = ' . $id ;

		$data = DB::select($qry,array());
		return $data;
	}

	public function getImagenes($id)
	{


		$qry = 'SELECT';
		$qry .= ' ra.archivo ';
		$qry .= ' , dra.repositorio_archivo_id ';
		$qry .= ' , ra.nombre_archivo ';
		$qry .= ' , dra.descripcion ';
		$qry .= ' FROM ' ;
		$qry .= ' repositorio_archivos ra ';
		$qry .= ' LEFT JOIN doctos_requisi_archivos dra ';
		$qry .= ' ON ';
		$qry .= 'ra.repositorio_archivo_id = dra.repositorio_archivo_id ';
		$qry .= ' WHERE ';
		$qry .= ' dra.docto_inventario_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
	}


	public function getArticulosInventario($id)
	{
		$qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		$qry .= ' , d.docto_inventario_det_id ';
		$qry .= ' , ROUND(d.cantidad, 2) AS cantidad ';
		$qry .= ' , a.nombre ';
		$qry .= ' FROM doctos_inventarios_det d';
		$qry .= ' INNER JOIN articulos a';
		$qry .= ' ON ';
		$qry .= ' d.articulo_id ';
		$qry .= ' = a.articulo_id ';
		$qry .= ' WHERE ';
		$qry .= ' d.docto_inventario_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function getDoctoInventario($id)
	{

		$qry = 'SELECT';
		$qry .= ' COALESCE(i.folio, \'No\') folio  ';
		//$qry .= ', REPLACE(REPLACE(REPLACE(i.fecha, \':\', \'\' ), \'-\', \'\'), \' \', \'\') fecha';
		$qry .= ', c.nombre ';
		$qry .= ', i.docto_inventario_id ';
		$qry .= ' , i.descripcion ';
		$qry .= ' , i.fecha ';
		$qry .= ' , a.nombre as almacen';
		$qry .= ' , c.nombre as centro_costo';
		$qry .= ' , uw.nombre as usuario ';
		$qry .= ' , i.usuario_creador as email ';
		$qry .= ' , ( ';
		$qry .= ' CASE i.estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'N\' THEN \'Normal\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus ';
		$qry .= ' FROM doctos_inventarios i ';
		$qry .= ' INNER JOIN conceptos_inventarios c';
		$qry .= ' ON  ';
		$qry .= ' i.concepto_inventario_id ';
		$qry .= ' = c.concepto_inventario_id ';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  i.usuario_creador = uw.correo';
		$qry .= ' INNER JOIN almacenes a ';
		$qry .= ' ON  a.almacen_id = i.almacen_id';
		$qry .= ' LEFT JOIN centros_costos cc ';
		$qry .= ' ON  cc.centro_costo_id = i.centro_costo_id';
		$qry .= ' WHERE ';
		$qry .= ' i.docto_inventario_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function getCentrosCostosbyTerm($term)
	{

		$qry = 'SELECT';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM centros_costos ';
		$qry .= ' WHERE  ';
		$qry .= ' estatus = \'A\'  ';
		$qry .= ' AND  ';
		$qry .= ' nombre LIKE \'%'. $term . '%\'';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getCentrosCostos()
	{
		$qry = 'SELECT';
		$qry .= ' * ';
		$qry .= ' FROM centros_costos ';
		$qry .= ' WHERE  ';
		$qry .= ' estatus = \'A\'  ';
		$data = DB::select($qry,array());
		return $data;
	}


	public function getEmailToAuthRequisition($doctorequisicionid)
	{
		$qry = 'SELECT';
		$qry .= ' correo_notificacion ';
		$qry .= ' FROM conceptos_requisiciones cr ';
		$qry .= ' INNER JOIN doctos_inventarios dr ';
		$qry .= ' ON ';
		$qry .= ' cr.concepto_requisicion_id ';
		$qry .= ' = dr.concepto_requisicion_id ';
		$qry .= ' WHERE  ';
		$qry .= ' dr.docto_inventario_id = ' . $doctorequisicionid;
		$data = DB::select($qry,array());
		return $data;
	}

	public function getBitacoraInventario()
	{

		$qry = 'SELECT * FROM';
		$qry .= ' VISTABITACORAREQUISICION ';
		$data = DB::select($qry,array());
		return $data;
	}


	public function insertInventario($concepto_inventario, $fechad, $descripciond, $almacend, $centro_costo, $usuario)
	{

		$qry = 'CALL';
		$qry .= ' DOCTOINVENTARIONUEVO ';
		$qry .= ' ( ';
		$qry .=  '\'' . $concepto_inventario . '\'';
		$qry .=  ' , \'' . $fechad . '\'';
		$qry .=  ' , \'' . $descripciond . '\'';
		$qry .=  ' , \'' . $almacend . '\'';
		$qry .=  ' , \'' . $centro_costo . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}


	////////////////////////////////////////////////////////

	public function insertInventario_det($doctoinventarioid, $articulod, $cantidadd, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' DOCTOINVENTARIORENGLONNUEVO ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoinventarioid . '\'';
		$qry .=  ' , \'' . $articulod . '\'';
		$qry .=  ' , \'' . $cantidadd . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function deleteArticuloInventario($doctoinventarioid, $articulod, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' DOCTOINVENTARIORENGLONELIMINA ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoinventarioid . '\'';
		$qry .=  ' , \'' . $articulod . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function updateInventario($doctorequisicionid, $descripciond)
	{
		$qry = 'UPDATE';
		$qry .= ' doctos_inventarios ';
		$qry .= ' SET ';
		$qry .= ' descripcion  ';
		$qry .= ' = \'' . $descripciond . '\'';
		$qry .= ' WHERE ';
		$qry .= ' docto_inventario_id = ' . $doctorequisicionid;
		$data = DB::select($qry,array());
		return $data;
	}

	public function updatePassword($email, $newpassword)
	{
		$qry = 'UPDATE';
		$qry .= ' usuarios_web ';
		$qry .= ' SET ';
		$qry .= ' clave  ';
		$qry .= ' = \'' . $newpassword . '\'';
		$qry .= ' ,status_password  ';
		$qry .= ' = 1 ';
		$qry .= ' WHERE ';
		$qry .= ' correo = \'' . $email . '\'';
		$data = DB::select($qry,array());
		return $data;
	}

	public function aplicaInventario($doctoinventarioid, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' DOCTOINVENTARIOAPLICA ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoinventarioid . '\'';
		$qry .=  ', \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}


	public function abortaInventario($doctoinventarioid, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' DOCTOINVENTARIOABORTA ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoinventarioid . '\'';
		$qry .=  ', \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}



}

?>
