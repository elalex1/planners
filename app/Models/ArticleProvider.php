<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ArticleProviderModel
{

	public function __construct(){

	}

	public function getArticles($proveedor, $estatus)
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





}

?>
