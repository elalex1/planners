<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ProviderArticleModel
{

	public function __construct(){

	}

	public function getArticulosProveedor($proveedor, $estatus, $usuario)
	{

		$qry = 'CALL';
		$qry .= ' vistaasociacionarticuloscatalogo ';
		$qry .= ' ( ';
		$qry .=  '\'' . $proveedor . '\'';
		$qry .=  ',\'' . $estatus . '\'';
		$qry .=  ',\'' . $usuario . '\'';
		$qry .= ' )  ';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getProveedores($term)
	{
		$qry = ' SELECT ';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM proveedores ';
		$qry .= ' WHERE nombre LIKE \'%'. $term . '%\'';
		$data = DB::select($qry,array());
		return $data;
	}


		public function getArticuloProveedorDetalle($id)
		{
			$qry = ' SELECT ';
			$qry .= ' proveedor_id AS articulo';
			$qry .= ' ,nombre AS unidad_medida_almacen ';
			$qry .= ' FROM proveedores ';
			$qry .= ' WHERE nombre LIKE \'%'. $term . '%\'';
			$data = DB::select($qry,array());


			return $data;
		}

		public function getArticuloData($id, $usuario)
		{
			$qry = 'CALL';
			$qry .= ' vistaasociacararticulocatalogo ';
			$qry .= ' ( ';
			$qry .=  '\'' . $id. '\'';
			$qry .=  ',\'' . $usuario . '\'';
			$qry .= ' )  ';
			$data = DB::select($qry,array());
			return $data;
		}

		public function getArticuloSeleccionado($id)
		{
			$qry = ' SELECT ';
			$qry .= ' a.articulo_id';
			$qry .= ' ,a.nombre';
			$qry .= ' ,a.unidad_venta ';
			$qry .= ' FROM articulos a ';
			$qry .= ' INNER JOIN articulos_proveedores ap ';
			$qry .= ' ON a.articulo_id = ap.articulo_id ';
			$qry .= ' WHERE ap.articulo_proveedor_id ='. $id;
			$data = DB::select($qry,array());
			return $data;
		}

		public function updateArticuloProveedor($articuloproveedorid, $articulod, $contenidocompra, $usuario)
		{
			$qry = 'CALL';
			$qry .= ' ARTICULOPROVEEDORACTUALIZA ';
			$qry .= ' ( ';
			$qry .=  $articuloproveedorid;
			$qry .=  ',\'' . $articulod . '\'';
			$qry .=  ', ' . $contenidocompra ;
			$qry .=  ',\' ' . $usuario . '\'';
			$qry .= ' )  ';
			$data = DB::select($qry,array());
			return $data;
		}

		public function getArticulos()
		{

			$qry = 'SELECT';
			$qry .= ' a.articulo_id ';
			$qry .= ' , a.nombre ';
			$qry .= ' , a.unidad_venta ';
			$qry .= ' , a.clave_fiscal ';
			$qry .= ' FROM ' ;
			$qry .= ' articulos a';
			$qry .= ' WHERE ';
			$qry .= ' a.almacenable = \'S\'';
			//$qry .= ' AND a.estatus in (\'A\', \'C\') ';

			$data = DB::select($qry,array());

			return $data;
		}


}

?>
