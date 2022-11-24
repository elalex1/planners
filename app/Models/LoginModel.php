<?php



namespace App\Models;



use Illuminate\Http\Request;

use App\Http\Requests;

use Exception;

use Illuminate\Support\Facades\DB;



class LoginModel

{



	public function __construct(){



	}



	public function getLogin($username, $password)

	{ 

		$data=array('status'=>false);

		$qry ="SELECT count(*) as dato from usuarios_web where correo='$username'";

		if(DB::select($qry,array())[0]->dato == 0){

			$data['nombre_corto']="Usuario $username no registrado";

			return $data;

		}

		$qry ="SELECT count(*) as dato from usuarios_web where correo='$username' and clave='$password'";

		if(DB::select($qry,array())[0]->dato == 0){

			$data['password']="Contraseña incorrecta";

			return $data;

		}

		$qry = ' SELECT ';

		//$qry .= ' COUNT ';

		$qry .= ' ( ';

		$qry .= ' usuario_id ';

		$qry .= ' ) ';

		$qry .= ' FROM usuarios_web ';

		$qry .= ' WHERE ';

		$qry .= ' correo = \'' . $username . '\'';

		$qry .= ' AND ' ;

		$qry .= ' clave = \'' . $password . '\'';

		$data = DB::select($qry,array());

		$data['status']=true;

		return $data;

	}



	public function getNombreUsuario($username, $password)

	{

	$qry = ' SELECT ';

		$qry .= ' ( ';

		$qry .= ' nombre ';

		$qry .= ' ) ';

		$qry .= ' FROM usuarios_web ';

		$qry .= ' WHERE ';

		$qry .= ' correo = \'' . $username . '\'';

		$qry .= ' AND ' ;

		$qry .= ' clave = \'' . $password . '\'';

		$data = DB::select($qry);

		return $data;



	}



	public function getUsername($email)

	{

	$qry = ' SELECT ';

		$qry .= ' u.nombre_corto ';

		$qry .= ', u.clave ';

		$qry .= ', u.nombre ';

		$qry .= ' FROM usuarios u';

		$qry .= ' JOIN usuarios_web uw ';

		$qry .= ' ON u.usuario_id';

		$qry .= ' = uw.usuario_id';

		$qry .= ' WHERE ';

		$qry .= ' uw.correo = \'' . $email . '\'';

		$data = DB::select($qry);

		return $data;



	}

	public function DatosCorreo($id)
	{
	$correo = DB::table('usuarios_web')
                ->select('email')
                ->where('id_usuario', '=', $id)
                ->get();
    
    $nombre = DB::table('usuarios_web')
                ->select('nombre')
                ->where('id_usuario', '=', $id)
                ->get();
    
	$password = "123";
	
	$data = [
		'nombre' => $nombre,
		'password' => $password,
		'correo' => $correo
	  ];
    
	}







}



?>

