<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class AplicationModel
{

	public function __construct(){

	}

		public function getAplicaciones($email)
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

	public function getConceptosProducciones()
	{
		$qry = ' SELECT ';
		$qry .= ' * ';
		$qry .= ' FROM ';
		$qry .= ' conceptos_producciones';
		$data = DB::select($qry,array());
		return $data;
	}

	public function getProducciones()
	{
		$qry = ' SELECT ';
		$qry .= ' * ';
		$qry .= ' FROM ';
		$qry .= ' producciones';
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

	public function getTractoristas()
	{
		$qry = ' SELECT ';
		$qry .= ' * ';
		$qry .= ' FROM ';
		$qry .= ' conceptos_producciones';
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


}

?>
