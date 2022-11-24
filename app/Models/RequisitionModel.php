<?php



namespace App\Models;



use Illuminate\Http\Request;

use App\Http\Requests;

use Exception;

use Illuminate\Support\Facades\DB;



class RequisitionModel

{



	public function __construct(){



	}



	public function validateRequisicionidUsuario($id, $usuario)

	{

		$qry = ' SELECT ';

		$qry .= ' docto_requisicion_id ';

		$qry .= ' FROM doctos_requisiciones ';

		$qry .= ' WHERE ' ;

		$qry .= ' usuario_creacion = \'' . $usuario . ' \' ';

		$qry .= ' AND ' ;

		$qry .= ' docto_requisicion_id = ' . $id;

		return (DB::select($qry));

	}



	public function validateRequisicionid($id)

	{

		$qry = ' SELECT ';

		$qry .= ' docto_requisicion_id ';

		$qry .= ' FROM doctos_requisiciones ';

		$qry .= ' WHERE ' ;

		$qry .= ' docto_requisicion_id = ' . $id;

		return (DB::select($qry));

	}



	public function getRequisiciones($email)

	{

		$qry = 'CALL';

		$qry .= ' VISTAREQUISICION ';

		$qry .= ' ( ';

		$qry .=  '\'' . $email . '\'';

		$qry .=  ' , \'\'';

		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	}



	public function getRequisiciones_old($email)

	{

		$qry = ' SELECT ';

		$qry .= ' COALESCE(dr.folio, \'No\') folio  ';

		$qry .= ', docto_requisicion_id ';

		$qry .= ' , fecha ';

		$qry .= ', descripcion ';

		$qry .= ', uw.nombre as usuario_creacion ';

		$qry .= ' , ( ';

		$qry .= ' CASE autorizado ';

		$qry .= ' WHEN \'S\' THEN \'Si\'';

		$qry .= ' WHEN \'N\' THEN \'No\'';

		$qry .= ' END ';

		$qry .= ' )' ;

		$qry .= 'AS autorizado';

		$qry .= ' , ( ';

		$qry .= ' CASE estatus ';

		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';

		$qry .= ' WHEN \'T\' THEN \'Terminado\'';

		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';

		$qry .= ' END ';

		$qry .= ' ) AS estatus ';

		$qry .= ' FROM doctos_requisiciones dr ';

		$qry .= ' INNER JOIN usuarios_web uw ';

		$qry .= ' ON  dr.usuario_creacion = uw.correo';

		$qry .= ' WHERE ';

		$qry .= ' usuario_creacion = \'' . $email . '\'';

		return (DB::select($qry));

	}



	public function getRequisicionesAdmin()

	{

		$qry = ' SELECT ';

		$qry .= ' COALESCE(dr.folio, \'No\') folio  ';

		$qry .= ', docto_requisicion_id ';

		$qry .= ' , fecha ';

		$qry .= ', descripcion ';

		$qry .= ', uw.nombre as usuario_creacion ';

		$qry .= ' , ( ';

		$qry .= ' CASE autorizado ';

		$qry .= ' WHEN \'S\' THEN \'Si\'';

		$qry .= ' WHEN \'N\' THEN \'No\'';

		$qry .= ' END ';

		$qry .= ' )' ;

		$qry .= 'AS autorizado';

		$qry .= ' , ( ';

		$qry .= ' CASE estatus ';

		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';

		$qry .= ' WHEN \'T\' THEN \'Terminado\'';

		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';

		$qry .= ' END ';

		$qry .= ' ) AS estatus ';

		$qry .= ' FROM doctos_requisiciones dr ';

		$qry .= ' INNER JOIN usuarios_web uw ';

		$qry .= ' ON  dr.usuario_creacion = uw.correo';

		$qry .= ' ORDER BY dr.fecha DESC';

		return (DB::select($qry));

	}



	public function getConceptosRequisiciones()

	{

		$qry = ' SELECT ';

		$qry .= ' * ';

		$qry .= ' FROM ';

		$qry .= ' conceptos_requisiciones';

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

		// $qry .= ' LEFT JOIN doctos_requisiciones dr';

		// $qry .= ' ON ';

		// $qry .= ' cra.concepto_requisicion_id ';

		// $qry .= ' = dr.concepto_requisicion_id ';

		// $qry .= ' WHERE ';

		// $qry .= ' dr.docto_requisicion_id = ' . $id ;



		$data = DB::select($qry,array());

		return $data;

	}



	public function getImagenes($id)

	{

		// $qry = 'SELECT';

		// $qry .= ' ra.archivo ';

		// $qry .= ' , dra.repositorio_archivo_id ';

		// $qry .= ' , ra.nombre_archivo ';

		// $qry .= ' , dra.descripcion ';

		// $qry .= ' FROM ' ;

		// $qry .= ' repositorio_archivos ra ';

		// $qry .= ' LEFT JOIN doctos_requisi_archivos dra ';

		// $qry .= ' ON ';

		// $qry .= 'ra.repositorio_archivo_id = dra.repositorio_archivo_id ';

		// $qry .= ' WHERE ';

		// $qry .= ' dra.docto_requisicion_id = ' . $id;

		$qry="select ra.repositorio_archivo_id,ra.nombre_archivo,ra.tipo,ra.archivo,dra.descripcion,dra.docto_requisi_archivo_id

		from repositorio_archivos ra 

		LEFT JOIN doctos_requisi_archivos dra ON ra.repositorio_archivo_id = dra.repositorio_archivo_id

		where dra.docto_requisicion_id =$id";

		$data = DB::select($qry,array());

		return $data;

	}





	public function getArticulosRequisicion($id)

	{

		$qry = 'SELECT';

		$qry .= ' a.articulo_id ';

		$qry .= ' , d.docto_requisicion_det_id ';

		$qry .= ' , ROUND(d.cantidad, 2) AS cantidad ';

		$qry .= ' , a.nombre ';

		$qry .= ' , d.nota_articulo ';

		$qry .= ' , c.nombre AS centrocosto';

		$qry .= ' FROM doctos_requisiciones_det d';

		$qry .= ' INNER JOIN articulos a';

		$qry .= ' ON ';

		$qry .= ' d.articulo_id ';

		$qry .= ' = a.articulo_id ';

		$qry .= ' LEFT JOIN centros_costos c';

		$qry .= ' ON ';

		$qry .= ' c.centro_costo_id ';

		$qry .= ' = d.centro_costo_id ';

		$qry .= ' WHERE ';

		$qry .= ' d.docto_requisicion_id = ' . $id;

		$data = DB::select($qry,array());

		return $data;

	}



	public function getDoctoRequisicion($id)

	{



		$qry = 'SELECT';

		$qry .= ' COALESCE(r.folio, \'No\') folio  ';

		$qry .= ', REPLACE(REPLACE(REPLACE(r.fecha_autorizacion, \':\', \'\' ), \'-\', \'\'), \' \', \'\') fecha_autorizacion';

		$qry .= ', c.nombre ';

		$qry .= ', r.docto_requisicion_id ';

		$qry .= ' , r.descripcion ';

		$qry .= ' , r.fecha ';

		$qry .= ' , uw.nombre as usuario_creacion ';

		$qry .= ' , r.usuario_creacion as email ';

		$qry .= ' , ( ';

		$qry .= ' CASE r.estatus ';

		$qry .= ' WHEN \'P\' THEN \'Pendiente\'';

		$qry .= ' WHEN \'T\' THEN \'Terminado\'';

		$qry .= ' WHEN \'C\' THEN \'Cancelado\'';

		$qry .= ' END ';

		$qry .= ' ) AS estatus ';

		$qry .= ' FROM doctos_requisiciones r ';

		$qry .= ' INNER JOIN conceptos_requisiciones c';

		$qry .= ' ON  ';

		$qry .= ' r.concepto_requisicion_id ';

		$qry .= ' = c.concepto_requisicion_id ';

		$qry .= ' INNER JOIN usuarios_web uw ';

		$qry .= ' ON  r.usuario_creacion = uw.correo';

		$qry .= ' WHERE ';

		$qry .= ' r.docto_requisicion_id = ' . $id;

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



	public function getCentrosCostosByReq($id)

	{



		$qry = 'SELECT';

		$qry .= ' cc.centro_costo_id ';

		$qry .= ' ,cc.nombre ';

		$qry .= ' FROM centros_costos cc';

		$qry .= ' INNER JOIN conceptos_requisi_centros_costos rcc ';

		$qry .= ' ON ';

		$qry .= ' cc.centro_costo_id ';

		$qry .= ' = rcc.centro_costo_id ';

		$qry .= ' INNER JOIN doctos_requisiciones dr ';

		$qry .= ' ON ';

		$qry .= ' dr.concepto_requisicion_id ';

		$qry .= ' = rcc.concepto_requisicion_id ';

		$qry .= ' WHERE  ';

		$qry .= ' cc.estatus = \'A\'  ';

		$qry .= ' AND  ';

		$qry .= ' dr.docto_requisicion_id = ' . $id;

		$data = DB::select($qry,array());

		return $data;

	}



	public function getEmailToAuthRequisition($doctorequisicionid)

	{

		$qry = 'SELECT';

		$qry .= ' correo_notificacion ';

		$qry .= ' FROM conceptos_requisiciones cr ';

		$qry .= ' INNER JOIN doctos_requisiciones dr ';

		$qry .= ' ON ';

		$qry .= ' cr.concepto_requisicion_id ';

		$qry .= ' = dr.concepto_requisicion_id ';

		$qry .= ' WHERE  ';

		$qry .= ' dr.docto_requisicion_id = ' . $doctorequisicionid;

		$data = DB::select($qry,array());

		return $data;

	}



	public function getStatusPassword($email)

	{

		$qry = 'SELECT';

		$qry .= ' status_password ';

		$qry .= ' FROM usuarios_web ';

		$qry .= ' WHERE  ';

		$qry .= ' correo = \'' . $email . '\'';

		$data = DB::select($qry,array());

		return $data;

	}



	public function getBitacoraRequisicion()

	{



		$qry = 'SELECT * FROM';

		$qry .= ' VISTABITACORAREQUISICION ';

		$data = DB::select($qry,array());

		return $data;

	}





	public function insertRequisicion($concepto_requisicion, $fechad, $descripciond, $usuario)

	{



		$qry = 'CALL';

		$qry .= ' REQUISICIONNUEVO ';

		$qry .= ' ( ';

		$qry .=  '\'' . $concepto_requisicion . '\'';

		$qry .=  ' , \'' . $fechad . '\'';

		$qry .=  ' , \'' . $descripciond . '\'';

		$qry .=  ' , \'' . $usuario . '\'';

		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	}

	////////////////////INSERTAR IMAGEN//////////////////////

		public function RequisitionImagen($doctorequisicionid, $imagen, $extension, $nombrearchivo, $descripcion, $usuario)

	{



		$qry = 'CALL';

		$qry .= ' REQUISICIOIMAGENNUEVA';

		$qry .= ' ( ';

		$qry .=  '\'' . $doctorequisicionid . '\'';

		$qry .=  ' , \'' . $imagen . '\'';

		$qry .=  ' , \'' . $extension . '\'';

		$qry .=  ' , \'' . $nombrearchivo . '\'';

		$qry .=  ' , \'' . $descripcion . '\'';

		$qry .=  ' , \'' . $usuario . '\'';

		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	}



	////////////////////////////////////////////////////////



	public function insertRequisicion_det($articulod, $centrocostod, $cantidadd, $notad, $doctorequisicionid, $usuario)

	{

		$qry = 'CALL';

		$qry .= ' REQUISICIONRENGLON ';

		$qry .= ' ( ';

		$qry .=  '\'' . $articulod . '\'';

		$qry .=  ' , \'' . $centrocostod . '\'';

		$qry .=  ' , \'' . $cantidadd . '\'';

		$qry .=  ' , \'' . $notad . '\'';

		$qry .=  ' , \'' . $doctorequisicionid . '\'';

		$qry .=  ' , \'' . $usuario . '\'';

		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	}



	public function deleteArticuloRequisicion($doctorequisicionid, $doctorequisiciondetid, $usuario)

	{

		$qry = 'CALL';

		$qry .= ' REQUISICIOELIMINARENGLON ';

		$qry .= ' ( ';

		$qry .=  '\'' . $doctorequisicionid . '\'';

		$qry .=  ' , \'' . $doctorequisiciondetid . '\'';

		$qry .=  ' , \'' . $usuario . '\'';

		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	}



	public function updateRequisicion($doctorequisicionid, $descripciond)

	{

		$qry = 'UPDATE';

		$qry .= ' doctos_requisiciones ';

		$qry .= ' SET ';

		$qry .= ' descripcion  ';

		$qry .= ' = \'' . $descripciond . '\'';

		$qry .= ' WHERE ';

		$qry .= ' docto_requisicion_id = ' . $doctorequisicionid;

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

	public function CambiarPassword(){
		$data = "Entrando";
		return $data;
	}



	public function aplicaRequisicion($doctorequisicionid, $usuario)

	{

		$qry = 'CALL';

		$qry .= ' REQUISICIONAPLICA ';

		$qry .= ' ( ';

		$qry .=  '\'' . $doctorequisicionid . '\'';

		$qry .=  ', \'' . $usuario . '\'';

		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	}



	public function autorizaRequisicion($doctorequisicionid, $usuario)

	{

		$qry = 'CALL';

		$qry .= ' REQUISICIONAUTORIZA ';

		$qry .= ' ( ';

		$qry .=  '\'' . $doctorequisicionid . '\'';

		$qry .=  ', \'' . $usuario . '\'';

		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	}



	public function cancelaRequisicion($doctorequisicionid, $usuario, $descripcion)

	{

		$qry = 'CALL';

		$qry .= ' REQUISICIONCANCELA ';

		$qry .= ' ( ';

		$qry .=  '\'' . $doctorequisicionid . '\'';

		$qry .=  ', \'' . $usuario . '\'';

		$qry .=  ', \'' . $descripcion . '\'';

		$qry .= ' )  ';

		try{

			$data = DB::select($qry,array());

			$data=$data[0]->Proceso;

		}catch(Exception $e){

			$data=$e->getMessage();

		}

		return $data;

	}

	public function getImagenRuta($idimagen){

		$qry="select archivo from repositorio_archivos where repositorio_archivo_id=$idimagen;";

		$data=DB::select($qry,array());

		$data = $data[0]->archivo;

		return $data;

	}



	public function deleteImagenRequisicion($doctorequisicionid, $imagen_id, $usuario)

	{

		$qry = 'CALL';

		$qry .= ' REQUISICIOIMAGENELIMINAR ';

		$qry .= ' ( ';

		$qry .=  '\'' . $doctorequisicionid . '\'';

		$qry .=  ' , \'' . $imagen_id . '\'';

		$qry .=  ' , \'' . $usuario . '\'';

		$qry .= ' )  ';

		$data = DB::select($qry,array());

		return $data;

	}

}



?>

