<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use PDO;

class activityModel
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
		$qry .= ' mostrar_listado = \'C\'';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getActividades($usuario)
	{
		$qry = ' SELECT ';
		$qry .= ' aep.* ';
		$qry .= ' , ( ';
		$qry .= ' CASE aep.estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'N\' THEN \'Normal\'';
		$qry .= ' WHEN \'T\' THEN \'Terminado\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus ';
		$qry .= ' , ( ';
		$qry .= ' CASE aep.autorizado ';
		$qry .= ' WHEN \'S\' THEN \'Si\'';
		$qry .= ' WHEN \'N\' THEN \'No\'';
		$qry .= ' END ';
		$qry .= ' )' ;
		$qry .= 'AS autorizado';
		$qry .= ' ,cc.nombre as rancho ';
		$qry .= ', uw.nombre as usuario_creacion ';
		$qry .= ' FROM ';
		$qry .= ' actividades_empleados_producciones aep';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  aep.usuario_creacion = uw.correo';
		$qry .= ' INNER JOIN centros_costos cc ';
		$qry .= ' ON  aep.centro_costo_id = cc.centro_costo_id';
		$qry .= ' WHERE';
		$qry .= ' aep.usuario_creacion = \''. $usuario . '\'';

		$data = DB::select($qry,array());
		return $data;
	}

	public function getCuadrillasbyTerm($term)
	{

		$qry = 'SELECT';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM equipos_empleados ';
		$qry .= ' WHERE  ';
		$qry .= ' nombre LIKE \'%'. $term . '%\'';
		$qry .= ' AND  ';
		$qry .= ' estatus =  \'N\'';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getProduccionesbyTerm($term, $rancho)
	{

		$qry = 'SELECT';
		$qry .= ' folio AS id';
		$qry .= ' ,folio AS text ';
		$qry .= ' FROM producciones p';
		$qry .= ' INNER JOIN centros_costos cc ';
		$qry .= ' ON  cc.centro_costo_id = p.centro_costo_id';
		$qry .= ' WHERE  ';
		$qry .= ' folio LIKE \'%'. $term . '%\'';
		$qry .= ' AND  ';
		$qry .= ' cc.nombre =  \'' . $rancho . '\'';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getConceptosProduccionesbyTerm($term)
	{
		$qry = 'SELECT';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM conceptos_producciones ';
		$qry .= ' WHERE  ';
		$qry .= ' nombre LIKE \'%'. $term . '%\'';
		$qry .= ' AND  ';
		$qry .= ' mostrar_listado =\'C\'';
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

	public function getPuestos()
	{
		$qry = ' SELECT ';
		$qry .= ' * ';
		$qry .= ' FROM ';
		$qry .= ' puestos';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getDepartamentos()
	{
		$qry = ' SELECT ';
		$qry .= ' * ';
		$qry .= ' FROM ';
		$qry .= ' departamentos';
		$qry .= ' WHERE  ';
		$qry .= ' centro_costo_id IS NULL  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function insertActivity($cuadrilla, $fecha_proceso, $hora_proceso, $rancho, $usuario)
	{

		$qry = 'CALL';
		$qry .= ' LISTAACTIVIDADESNUEVO ';
		$qry .= ' ( ';
		$qry .=  '\'' . $cuadrilla . '\'';
		$qry .=  ' , \'' . $fecha_proceso . '\'' ;
		$qry .=  ' , \'' . $hora_proceso . '\'' ;
		$qry .=  ' , \'' . $rancho . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function insertActividadLote($listaid, $lote, $actividad, $usuario)
	{

		$qry = 'CALL';
		$qry .= ' LISTAACTIVIDADESPROCESO ';
		$qry .= ' ( ';
		$qry .=  $listaid ;
		$qry .=  ' , \'' . $lote . '\'' ;
		$qry .=  ' , \'' . $actividad . '\'' ;
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function insertList($xd, $yd, $listaid, $horas, $usuario)
	{

		$qry = 'CALL';
		$qry .= ' ACTIVIDADEMPLEADONUEVO ';
		$qry .= ' ( ';
		$qry .=  $xd;
		$qry .=  ' , ' . $yd ;
		$qry .=  ' , ' . $listaid ;
		$qry .=  ' , ' . $horas ;
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function insertEmployee($numeroempleadod, $paternod, $maternod, $nombred, $rfcd, $curpd, $fechanacimientod, $nssd, $fechaaltad, $puestod, $departamentod, $rpd, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' NUEVOEMPLEADO ';
		$qry .= ' ( ';
		$qry .=  $numeroempleadod;
		$qry .=  ', \'' . $paternod . '\'';
		$qry .=  ' , \'' . $maternod . '\'' ;
		$qry .=  ' , \'' . $nombred . '\'' ;
		$qry .=  ' , \'' . $rfcd . '\'';
		$qry .=  ' , \'' . $curpd . '\'';
		$qry .=  ' , \'' . $fechanacimientod . '\'';
		$qry .=  ' , \'' . $nssd . '\'';
		$qry .=  ' , \'' . $fechaaltad . '\'';
		$qry .=  ' , \'' . $puestod . '\'';
		$qry .=  ' , \'' . $departamentod . '\'';
		$qry .=  ' , \'' . $rpd . '\'';
		$qry .=  ' , \'' . $usuario . '\'';
		$qry .= ' )  ';

		$data = DB::select($qry,array());
		return $data;
	}

	public function getActividadProduccion($id)
	{
		$qry = 'SELECT';
		$qry .= ' REPLACE(REPLACE(REPLACE(a.fecha_creacion, \':\', \'\' ), \'-\', \'\'), \' \', \'\') fecha_folio';
		$qry .= ', a.hora ';
		$qry .= ', a.fecha ';
		$qry .= ', a.fecha_creacion ';
		$qry .= ', a.actividad_empleado_produccion_id ';
		$qry .= ' , a.equipo_empleado_id ';
		$qry .= ' , a.nombre_equipo ';
		$qry .= ' , cc.nombre as rancho ';
		$qry .= ' , uw.nombre as usuario_creacion ';
		$qry .= ' , ( ';
		$qry .= ' CASE a.estatus ';
		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';
		$qry .= ' WHEN \'N\' THEN \'Normal\'';
		$qry .= ' WHEN \'T\' THEN \'Terminado\'';
		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';
		$qry .= ' END ';
		$qry .= ' ) AS estatus ';
		$qry .= ' FROM actividades_empleados_producciones a ';
		$qry .= ' INNER JOIN usuarios_web uw ';
		$qry .= ' ON  a.usuario_creacion = uw.correo';
		$qry .= ' INNER JOIN centros_costos cc ';
		$qry .= ' ON  cc.centro_costo_id = a.centro_costo_id';
		$qry .= ' WHERE ';
		$qry .= ' a.actividad_empleado_produccion_id = ' . $id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function getLoteActividad($id, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' vistaspasesdelistasactividades ';
		$qry .= ' ( ';
		$qry .=  $id;
		$qry .=  ', \'' . $usuario . '\'';
		$qry .= ' )  ';
		$pdo = DB::connection()->getPdo();
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		$data = DB::select($qry,array());
		return $data;

	}

	public function validateActividadidUsuario($id, $usuario)
	{
		$qry = ' SELECT ';
		$qry .= ' actividad_empleado_produccion_id ';
		$qry .= ' FROM actividades_empleados_producciones ';
		$qry .= ' WHERE ' ;
		$qry .= ' usuario_creacion = \'' . $usuario . ' \' ';
		$qry .= ' AND ' ;
		$qry .= 'actividad_empleado_produccion_id = ' . $id;
		return (DB::select($qry));
	}

	public function validateActividadid($id)
	{
		$qry = ' SELECT ';
		$qry .= ' actividad_empleado_produccion_id ';
		$qry .= ' FROM actividades_empleados_producciones ';
		$qry .= ' WHERE ' ;
		$qry .= ' actividad_empleado_produccion_id = ' . $id;
		return (DB::select($qry));
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

	public function aplicaActividad($doctoactividadid, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' LISTAACTIVIDADESTERMINAR ';
		$qry .= ' ( ';
		$qry .=  $doctoactividadid;
		$qry .=  ', \'' . $usuario . '\'';
		$qry .= ' )  ';
		$pdo = DB::connection()->getPdo();
		$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		$stmt = $pdo->prepare($qry,[\PDO::ATTR_CURSOR=>\PDO::CURSOR_SCROLL]);
    $exec = $stmt->execute();
    if (!$exec) return $pdo->errorInfo();

		$results = [];
	 do {
			 try {
					 $results[] = $stmt->fetchAll(\PDO::FETCH_OBJ);
			 } catch (\Exception $ex) {

			 }
	 } while ($stmt->nextRowset());


	 if (1 === count($results)) return $results[0];
	 return $results;
	}

	public function getEmailToAuthActivity($id)
	{
		$qry = 'SELECT';
		$qry .= ' uw.correo ';
		$qry .= ' FROM usuarios_web uw';
		$qry .= ' INNER JOIN encargados_centros_costos ecc ';
		$qry .= ' ON ';
		$qry .= ' ecc.usuario_web_id ';
		$qry .= ' = uw.usuario_web_id ';
		$qry .= ' INNER JOIN centros_costos cc ';
		$qry .= ' ON ';
		$qry .= ' cc.centro_costo_id ';
		$qry .= ' = ecc.centro_costo_id ';
		$qry .= ' WHERE  ';
		$qry .= ' ecc.centro_costo_id = (';
		$qry .= 'SELECT';
		$qry .= ' centro_costo_id ';
		$qry .= ' FROM actividades_empleados_producciones ';
		$qry .= ' WHERE ';
		$qry .= ' actividad_empleado_produccion_id = '. $id;
		$qry .= ' )';
		$data = DB::select($qry,array());
		return $data;
	}

	public function autorizaActividad($id, $usuario)
	{
		$qry = 'CALL';
		$qry .= ' LISTAACTIVIDADESGUARDAR ';
		$qry .= ' ( ';
		$qry .=  '\'' . $id . '\'';
		$qry .=  ', \'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

}

?>
