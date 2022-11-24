<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use PDO;

class applicationModel
{

	public function __construct(){

	}


	public function getConceptosProducciones()
	{
		$qry = ' SELECT ';
		$qry .= ' * ';
		$qry .= ' FROM ';
		$qry .= ' conceptos_producciones';
		$qry .= ' WHERE';
		$qry .= ' mostrar_listado = \'A\'';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getConceptosAplicaciones($articulo_aplica_id)
	{
		$qry = ' SELECT ';
		$qry .= ' nombre ';
		$qry .= ' FROM ';
		$qry .= ' conceptos_aplicaciones c';
		$qry .= ' INNER JOIN fichas_tecnicas_articulos f ';
		$qry .= ' ON  f.concepto_aplicacion_id = c.concepto_aplicacion_id';
		$qry .= ' WHERE f.articulo_aplica_id =  '. $articulo_aplica_id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function getProducciones()
	{
		$qry = ' SELECT ';
		$qry .= ' dp.* ';
		$qry .= ' , ( ';
		$qry .= ' CASE dp.estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'N\' THEN \'Normal\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus ';
		$qry .= ' ,p.folio as lote ';
		$qry .= ', uw.nombre as usuario_creacion ';
		$qry .= ' FROM ';
		$qry .= ' doctos_producciones dp';
		$qry .= ' INNER JOIN producciones p ';
		$qry .= ' ON  p.produccion_id = dp.produccion_id';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  dp.usuario_creacion = uw.correo';
		$qry .= ' INNER JOIN conceptos_producciones cp ';
		$qry .= ' ON  cp.concepto_produccion_id = dp.concepto_produccion_id';
		$qry .= ' WHERE';
		$qry .= ' cp.mostrar_listado = \'A\'';
		$data = DB::select($qry,array());
		return $data;

	}

	public function getProduccionesbyTerm($term)
	{

		$qry = 'SELECT';
		$qry .= ' folio AS id';
		$qry .= ' ,folio AS text ';
		$qry .= ' FROM producciones ';
		$qry .= ' WHERE  ';
		$qry .= ' folio LIKE \'%'. $term . '%\'';
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

	public function getProduccionInfo($id)
	{

		$qry = 'SELECT';
		$qry .= ' folio AS id';
		$qry .= ' ,folio AS text ';
		$qry .= ' FROM producciones ';
		$qry .= '
		WHERE  ';
		$qry .= ' folio LIKE \'%'. $term . '%\'';
		$data = DB::select($qry,array());
		return $data;
	}


	public function getCentroCostosRanchos()
	{
			$qry = 'SELECT';
			$qry .= ' * ';
			$qry .= ' FROM centros_costos ';
			$qry .= ' WHERE  ';
			$qry .= ' estatus = \'A\'  ';
			$qry .= ' AND  ';
			$qry .= ' tipo_centro_costo_id = 3  ';
			$data = DB::select($qry,array());
			return $data;

	}

	// public function getActivosFijos()
	// {
	// 		$qry = 'SELECT';
	// 		$qry .= ' * ';
	// 		$qry .= ' FROM activos_fijos ';
	// 		$qry .= ' WHERE  ';
	// 		$qry .= ' estatus = \'A\'  ';
	// 		$qry .= ' AND  ';
	// 		$qry .= ' tipo_activo_fijo_id = 1  ';
	// 		$data = DB::select($qry,array());
	// 		return $data;
	//
	// }

	public function getEmpleados()
	{
			$qry = 'SELECT';
			$qry .= ' * ';
			$qry .= ' FROM empleados ';
			$qry .= ' WHERE  ';
			$qry .= ' estatus = \'A\'  ';
			$data = DB::select($qry,array());
			return $data;

	}

	public function getUsosEmpleados($doctoproduccionid)
	{
			$qry = 'SELECT';
			$qry .= ' CONCAT(e.nombre, \' \', e.apellido_paterno,\' \', e.apellido_materno) AS aplicador';
			$qry .= ', tue.nombre as via_aplicacion';
			$qry .= ', ue.pozo_abastecimiento as pozo';
			$qry .= ', ue.horas';
			$qry .= ' FROM usos_empleados ue';
			$qry .= ' INNER JOIN empleados e ';
			$qry .= ' ON  e.empleado_id = ue.empleado_id';
			$qry .= ' INNER JOIN tipos_usos_empleados tue ';
			$qry .= ' ON  tue.tipo_uso_empleado_id = ue.tipo_uso_empleado_id';
			$qry .= ' WHERE  ';
			$qry .= ' ue.docto_produccion_id =  '. $doctoproduccionid;
			$data = DB::select($qry,array());
			return $data;

	}

	public function getTiposUsosEmpleados()
	{
			$qry = 'SELECT';
			$qry .= ' *';
			$qry .= ' FROM tipos_usos_empleados';
			$data = DB::select($qry,array());
			return $data;

	}

	public function insertApplication($lote, $concepto_produccion, $fecha_proceso, $hora_proceso, $superficie, $usuario)
	{

		$qry = 'CALL';
		$qry .= ' DOCTOPRODUCCIONNUEVO ';
		$qry .= ' ( ';
		$qry .=  '\'' . $lote . '\'';
		$qry .=  ' , \'' . $concepto_produccion . '\'';
		$qry .=  ' , \'' . $fecha_proceso . '\'' ;
		$qry .=  ' , \'' . $hora_proceso . '\'' ;
		$qry .=  ' , \'' . $superficie . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function insertAplicacion_det($doctoproduccionid, $articulod, $cantidadd, $plagad, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' DOCTOPRODUCCIONRENGLONNUEVO ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoproduccionid . '\'';
		$qry .=  ' , \'' . $articulod . '\'';
		$qry .=  ' , \'' . $cantidadd . '\'';
		$qry .=  ' , \'' . $plagad . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}


	public function getDoctoProduccion($id)
	{

		$qry = 'SELECT';
		$qry .= ' COALESCE(p.folio, \'No\') folio  ';
		$qry .= ', REPLACE(REPLACE(REPLACE(p.fecha_creacion, \':\', \'\' ), \'-\', \'\'), \' \', \'\') fecha';
		$qry .= ', p.hora_proceso ';
		$qry .= ', p.fecha_proceso ';
		$qry .= ', p.fecha_creacion ';
		$qry .= ', p.docto_produccion_id ';
		$qry .= ' , p.produccion_id ';
		$qry .= ' , p.tipo_docto ';
		$qry .= ' , cc.nombre as rancho ';
		$qry .= ' , c.nombre ';
		$qry .= ' , c.usa_activo_fijo ';
		$qry .= ' , c.usa_empleado ';
		$qry .= ' , c.fecha_obligatoria ';
		$qry .= ' , c.hora_obligatoria ';
		$qry .= ' , pr.folio as lote ';
		$qry .= ' , a.nombre as cosecha ';
		$qry .= ' , pr.cantidad as superficie ';
		$qry .= ' , uw.nombre as usuario_creacion ';
		$qry .= ' , ( ';
		$qry .= ' CASE p.estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'T\' THEN \'Terminado\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus ';
		$qry .= ' FROM doctos_producciones p ';
		$qry .= ' INNER JOIN conceptos_producciones c';
		$qry .= ' ON  ';
		$qry .= ' p.concepto_produccion_id ';
		$qry .= ' = c.concepto_produccion_id ';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  p.usuario_creacion = uw.correo';
		$qry .= ' INNER JOIN centros_costos cc ';
		$qry .= ' ON  cc.centro_costo_id = p.centro_costo_id';
		$qry .= ' INNER JOIN producciones pr ';
		$qry .= ' ON  pr.produccion_id = p.produccion_id';
		$qry .= ' LEFT JOIN articulos a ';
		$qry .= ' ON  a.articulo_id = pr.articulo_id';
		$qry .= ' WHERE ';
		$qry .= ' p.docto_produccion_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function validateAplicacionidUsuario($id, $usuario)
	{
		$qry = ' SELECT ';
		$qry .= ' docto_produccion_id ';
		$qry .= ' FROM doctos_producciones ';
		$qry .= ' WHERE ' ;
		$qry .= ' usuario_creacion = \'' . $usuario . ' \' ';
		$qry .= ' AND ' ;
		$qry .= ' docto_produccion_id = ' . $id;
		return (DB::select($qry));
	}

	public function validateAplicacionid($id)
	{
		$qry = ' SELECT ';
		$qry .= ' docto_produccion_id ';
		$qry .= ' FROM doctos_producciones ';
		$qry .= ' WHERE ' ;
		$qry .= ' docto_produccion_id = ' . $id;
		return (DB::select($qry));
	}

	public function getArticulos($id, $superficie)
	{

		$qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		$qry .= ' , a.nombre ';
		$qry .= ' , a.unidad_compra ';
		// $qry .= ' , ROUND(f.dosis_maximo * f.base_dosis * ' . $superficie  . ' ,1) AS dosis_maximo ';
		// $qry .= ' , ROUND(f.dosis_minimo * f.base_dosis * ' . $superficie  . ' ,1) AS dosis_minimo ';
		// $qry .= ' , f.tiempo_espera ';
		// $qry .= ' , f.tiempo_carencia ';
		$qry .= ' FROM ' ;
		$qry .= ' articulos a';
		// $qry .= ' LEft JOIN fichas_tecnicas_articulos f ';
		// $qry .= ' ON  a.articulo_id = f.articulo_id';
		$qry .= ' WHERE ';
		$qry .= ' a.familia_articulo_id = 4 ' ;
		$data = DB::select($qry,array());
		return $data;
	}

	public function getArticulosProduccion($id)
	{
		$qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		$qry .= ' , d.docto_produccion_det_id ';
		$qry .= ' , ROUND(d.cantidad, 2) AS cantidad ';
		$qry .= ' , a.nombre ';
		$qry .= ' , a.unidad_compra ';
		$qry .= ' FROM doctos_producciones_det d';
		$qry .= ' INNER JOIN articulos a';
		$qry .= ' ON ';
		$qry .= ' d.artidulo_id ';
		$qry .= ' = a.articulo_id ';
		$qry .= ' WHERE ';
		$qry .= ' d.docto_produccion_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function getInfoLote($folio)
	{

		$qry = 'SELECT';
		$qry .= ' ROUND(p.cantidad, 2) AS superficie ';
		$qry .= ' ,a.nombre AS cosecha ';
		$qry .= ' ,cc.nombre AS rancho ';
		$qry .= ' FROM producciones p';
		$qry .= ' LEFT JOIN articulos a ';
		$qry .= ' ON  a.articulo_id = p.articulo_id';
		$qry .= ' LEFT JOIN centros_costos cc ';
		$qry .= ' ON  cc.centro_costo_id = p.centro_costo_id';
		$qry .= ' WHERE  ';
		$qry .= ' p.folio = \'' .  $folio . '\'';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getPlagaObjetivo($term, $articulo_id)
	{

		$qry = 'SELECT';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM conceptos_aplicaciones ca ';
		$qry .= ' INNER JOIN fichas_tecnicas_articulos ft ';
		$qry .= ' ON  ca.concepto_aplicacion_id = ft.concepto_aplicacion_id';
		$qry .= ' WHERE  ';
		$qry .= ' nombre LIKE \'%'. $term . '%\'';
		$qry .= ' AND ft.articulo_id = ' . $articulo_id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function aplicaProduccion($doctoproduccionid, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' DOCTOPRODUCCIONAPLICA ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoproduccionid . '\'';
		$qry .=  ', \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getBitacoraPlaguicida($concepto_produccion, $fecha_inicial, $fecha_final)
	{
		$qry = 'CALL';
		$qry .= ' vistasagroquimicosproducciones ';
		$qry .= ' ( ';
		$qry .=  '\'' . $concepto_produccion . '\'';
		$qry .=  ', \'' . $fecha_inicial . '\'';
		$qry .=  ', \'' . $fecha_final . '\'';
		$qry .=  ', \'N\' ';
		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	
	}

	public function getBitacoraFertilizante($lote, $concepto_produccion)
	{
		$qry = 'CALL';
		$qry .= ' vistasfertilizantesaplicaciones ';
		$qry .= ' ( ';
		$qry .=  '\'' . $lote . '\'';
		$qry .=  ',\'\'';
		$qry .=  ',\'' . $concepto_produccion . '\'';
		$qry .= ' )  ';
		$pdo = DB::connection()->getPdo();
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		$data = DB::select($qry,array());
		return $data;
	}

	public function getReporteAplicacion($concepto_produccion, $fecha_inicial, $fecha_final)
	{


		$qry = 'SELECT';
		$qry .= ' dp.fecha ';
		$qry .= ' ,cc.nombre Rancho ';
		$qry .= ' ,a.nombre Cultivo ';
		$qry .= ' ,cp.nombre Familia ';
		$qry .= ' ,p.fecha FechaPlantacion ';
		$qry .= ' ,p.cantidad Area';
		$qry .= ' ,p.folio TablaYSector ';
		$qry .= ' ,dp.fecha_proceso ';
		$qry .= ' ,dp.folio ';
		$qry .= ' ,ap.nombre descripcion ';
		$qry .= ' ,ap.unidad_venta UM ';
		$qry .= ' ,dpd.cantidad Dosis';
		$qry .= ' ,dpd.costo_unitario Precio_U';
		$qry .= ' ,dpd.costo_total Importe';
		$qry .= ' ,dpd.costo_total/p.cantidad ImporteXHectarea';
		$qry .= ' FROM doctos_producciones dp';
		$qry .= ' LEFT JOIN producciones p on p.produccion_id = dp.produccion_id';
		$qry .= ' left join centros_costos cc on cc.centro_costo_id = p.centro_costo_id';
		$qry .= ' left join articulos a on a.articulo_id = p.articulo_id';
		$qry .= ' left join conceptos_producciones cp on cp.concepto_produccion_id = dp.concepto_produccion_id';
		$qry .= ' left join doctos_producciones_det dpd on dpd.docto_produccion_id = dp.docto_produccion_id ';
		$qry .= ' left join articulos ap on ap.articulo_id = dpd.artidulo_id';
		$qry .= ' WHERE dp.fecha between \'' . $fecha_inicial . '\' and \'' . $fecha_final . '\'';
		$qry .= ' and dp.tipo_docto = \'E\'';
		$data = DB::select($qry,array());
		return $data;

	}

	public function getFertilizanteNPK($centrocosto, $lote, $familia, $concepto_produccion, $articulo, $fecha_inicio, $fecha_final, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' vistasfertilizantesaplicacionesdetalle ';
		$qry .= ' ( ';
		$qry .=  '\'' . $centrocosto . '\'';
		$qry .=  ',\'' . $lote . '\'';
		$qry .=  ',\'' . $familia . '\'';
		$qry .=  ',\'' . $concepto_produccion . '\'';
		$qry .=  ',\'' . $articulo . '\'';
		$qry .=  ',\'' . $fecha_inicio . '\'';
		$qry .=  ',\'' . $fecha_final . '\'';
		$qry .=  ',\'' . $usuario . '\'';
		$qry .= ' )  ';
		$pdo = DB::connection()->getPdo();
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		$data = DB::select($qry,array());
		return $data;
	}

	public function getReporteCostos()
	{
		$qry = 'CALL';
		$qry .= ' vistasfertilizantesaplicaciones ';
		$qry .= ' ( ';
		$qry .=  '\'' . $lote . '\'';
		$qry .=  ',\'\'';
		$qry .=  ',\'' . $concepto_produccion . '\'';
		$qry .= ' )  ';
		$pdo = DB::connection()->getPdo();
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		$data = DB::select($qry,array());
		return $data;
	}

	public function getRecetas()
	{
		$qry = 'SELECT';
		$qry .= ' * ';
		$qry .= ' FROM doctos_producciones ';
		$qry .= ' WHERE  ';
		$qry .= ' concepto_produccion_id = 2 ';
		$qry .= ' AND estatus = \'N\' ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getObjetivoInfo($objetivo, $articulo_id, $superficie)
	{
		$qry = 'SELECT';
		$qry .= ' ROUND(ft.dosis_minimo * ft.base_dosis * ' . $superficie  . ' ,1) AS dosis_minimo';
		$qry .= ' ,ROUND(ft.dosis_maximo * ft.base_dosis * ' . $superficie  . ' ,1) AS dosis_maximo';
		$qry .= ' ,ft.tiempo_espera ';
		$qry .= ' ,ft.tiempo_carencia ';
		$qry .= ' FROM conceptos_aplicaciones ca ';
		$qry .= ' INNER JOIN fichas_tecnicas_articulos ft ';
		$qry .= ' ON  ca.concepto_aplicacion_id = ft.concepto_aplicacion_id';
		$qry .= ' WHERE  ';
		$qry .= ' ca.nombre LIKE \'%'. $objetivo . '%\'';
		$qry .= ' AND ft.articulo_id = ' . $articulo_id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function deleteArticuloAplicacion($doctoproduccionid, $nombrearticulo, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' DOCTOPRODUCCIONRENGLONELIMINA ';
		$qry .= ' ( ';
		$qry .=  '\'' . $doctoproduccionid . '\'';
		$qry .=  ' , \'' . $nombrearticulo . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}


	  public function insertAplicador($doctoproduccionid, $empleadoid, $viaaplicacion, $cantidadd, $usuario, $pozo)
	  {

	    $qry = 'CALL';
	    $qry .= ' DOCTOPRODUCCIONUSOEMPLEADO ';
	    $qry .= ' ( ';
	    $qry .=  $doctoproduccionid;
	    $qry .=  ' , ' . $empleadoid ;
	    $qry .=  ' , \'' . $viaaplicacion . '\'';
	    $qry .=  ' , ' . $cantidadd ;
	    $qry .=  ' , \'' . $usuario . '\'';
	    $qry .=  ' , \'' . $pozo . '\'';
	    $qry .= ' )  ';
	    $data = DB::select($qry,array());
	    return $data;
	  }

	public function aplicaReceta($conceptodoctod, $idfte, $fechad, $horad, $aplicadord, $tipoaplicaciond, $tiempoaplicaciond, $pozod, $usuariod )
	{
		$qry = 'CALL';
		$qry .= ' DOCTOPRODUCCIONOBTENER ';
		$qry .= ' ( ';
		$qry .=  '\'' . $conceptodoctod . '\'';
		$qry .=  ' , ' . $idfte;
		$qry .=  ' , \'' . $fechad . '\'';
		$qry .=  ' , \'' . $horad . '\'';
		$qry .=  ' , ' . $aplicadord;
		$qry .=  ' , \'' . $tipoaplicaciond . '\'';
		$qry .=  ' , ' . $tiempoaplicaciond;
		$qry .=  ' , \'' . $pozod . '\'';
		$qry .=  ' , \'' . $usuariod . '\'';
		$qry .= ' )  ';

		$data = DB::select(DB::raw($qry));
		return $data;
	}

	public function getRecetaId($receta)
	{
		$qry = 'SELECT';
		$qry .= ' docto_produccion_id ';
		$qry .= ' FROM doctos_producciones ';
		$qry .= ' WHERE  ';
		$qry .= ' folio = ' . '\'' . $receta . '\'' ;
		$data = DB::select($qry,array());
		return $data;
	}
}

?>
