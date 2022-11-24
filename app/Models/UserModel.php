<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class UserModel
{

	public function __construct(){

	}

	public function getUsers()
	{
		$qry = ' SELECT ';
    $qry .= ' uw.usuario_web_id ';
		$qry .= ' , uw.nombre ';
    $qry .= ' , uw.correo ';
		$qry .= ' , uw.usuario_id ';
    $qry .= ' , u.nombre AS rol';
		$qry .= ' FROM usuarios_web uw';
    $qry .= ' INNER JOIN usuarios u ';
    $qry .= ' ON  u.usuario_id = uw.usuario_id';
		return (DB::select($qry));
	}

	public function getRoles()
	{
		$qry = ' SELECT ';
		$qry .= ' usuario_id ';
		$qry .= ' , nombre ';
		$qry .= ' FROM usuarios ';
		return (DB::select($qry));
	}

	public function updateUser($usuario_web_id, $nombreusuario,$correousuario,$rolusuario)
	{
		$qry = 'UPDATE';
		$qry .= ' usuarios_web ';
		$qry .= ' SET ';
		$qry .= ' nombre  ';
		$qry .= ' = \'' . $nombreusuario . '\'';
		$qry .= ' ,correo  ';
		$qry .= ' = \'' . $correousuario . '\'';
		$qry .= ' ,usuario_id  ';
		$qry .= ' = ' . $rolusuario;
		$qry .= ' WHERE ';
		$qry .= ' usuario_web_id = ' . $usuario_web_id;
		$data = DB::select($qry,array());
		return $data;
	}

	public function newUser($nombreusuario,$correousuario,$rolusuario)
	{
		$qry = 'INSERT INTO';
		$qry .= ' usuarios_web ';
		$qry .= ' ( ';
		$qry .= ' nombre  ';
		$qry .= ' ,correo  ';
		$qry .= ' ,usuario_id  ';
		$qry .= ' ) ';
		$qry .= ' VALUES ';
		$qry .= ' ( ';
		$qry .= '\'' . $nombreusuario . '\'';
		$qry .= ',\'' . $correousuario . '\'';
		$qry .= ',' . $rolusuario ;
		$qry .= ' ) ';
		$data = DB::select($qry,array());
		return $data;
	}

}

?>
