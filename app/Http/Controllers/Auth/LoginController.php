<?php





namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Html\FormFacade;

use Illuminate\Html\HtmlFacade;

use App\Http\Requests;

use App\Models\LoginModel;
use App\Models\users;

use Illuminate\Support\Facades\DB;

use Session;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;
use Illuminate\Support\Facades\Hash;





class LoginController extends Controller

{

  protected $LoginModel;



  public function __construct() {

    $this->LoginModel = new LoginModel();



  }



  public function Login(Request $Request)

  {
   

    $email = $Request->input('user');

    $password = $Request->input('password');

    //$key = \Config::get('app.key');

    $passwordEncrypted = $this->encryptValue($password);

    //return $passwordEncrypted;

    $checkLogin = $this->LoginModel->getLogin($email, $passwordEncrypted);

    //return $checkLogin;


    
    if ($checkLogin['status']) {

    if (count($checkLogin) > 0) {

      

      //Obtener el nombre de la persona

      $nombre = $this->LoginModel->getNombreUsuario($email, $passwordEncrypted) ;

      $nombre = json_decode(json_encode($nombre), true);

      $nombre = $nombre[0]['nombre'];

      $userdata = $this->LoginModel->getUsername($email) ;

      $userdata = json_decode(json_encode($userdata), true);

      $clave = $userdata[0]['clave'];

      $username = $userdata[0]['nombre_corto'];

      $rol = $userdata[0]['nombre'];
      //return $rol;

      $username = substr($username, 0, strpos($username, '@uriel.hosting-mexico.net'));

      $Request -> session()->regenerate();

      \Session::put('user',$username);

      \Session::put('clave',$clave);

      \Session::put('email',$email);

      \Session::put('password',$password);

      \Session::put('nombre',$nombre);

      \Session::put('rol',$rol);


   //  $conexion = $this->ConnectUserDB($username,$clave);
//return $conexion;


      $previous_url = \Session::get('previous_url');
      
      //return $previous_url;

      if ($previous_url != 'inicio' and $previous_url != null) {



        return redirect($previous_url);

      }else{



        return redirect('inicio');

      }



      //return redirect('/requisicion');

    } else {

       

      

      // ->withInput()

      // ->withErrors(['password' => 'Estas credenciales no coinciden en nuestros registros']);

      return back()

      ->withInput()

      ->withErrors($checkLogin);

    }





  }}



  public function Logout(Request $Request)

  {

    $Request->session()->flush();

    return redirect('/');

  }



  public function ConnectUserDB($username, $password)

  {

    $username = substr($username, 0, strpos($username, '@uriel.hosting-mexico.net'));



    \Config::set('database.connections.mysql2.username', $username);

    \Config::set('database.connections.mysql2.password', $password);

    \DB::disconnect('mysql');

    $conexion = \DB::connection('mysql2');

    return $conexion;

  }



  public function encryptValue($value)

  {

    $key = \Config::get('app.key');

    if (Str::startsWith($key, 'base64:')) {

        $key = base64_decode(substr($key, 7));

         //$key = substr($key, 7);

     }



    /* $contra = hash_hmac('sha256', $value , $key);

     print_r($contra);

     die();*/

    return hash_hmac('sha256', $value , $key);

  }



  public function getResponse($data) {

    $response = new Response(json_encode($data), 200, array('Content-Type', 'text/json'));

    $response->headers->set('Access-Control-Allow-Origin', '*');

    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, *');

    return $response;

  }
//===========================================================================================================
  

  public function CrearUsuario(Request $request){

    
    //Asigno valores del request a variables-------------------------
    $nombreP  = $request->usuario;
    $empresaP = $request->empresa;
    $emailP   = $request->email;
    $proceso = 1;
    $id_user  = 2;
    $password = "123";  

    //Metodo store--------------------------------------------------- Funciona Perron
      $query = "call NUEVAEMPRESA('$nombreP','$empresaP','$emailP','$proceso');";
      try {
      $resultado = DB::select($query,array()); 
      $resultado = $resultado[0]->Respuesta; //Respuesta es lit la respuesta del store xD
      } catch (\Exception $th) {
      $resultado = $th->getMessage();
      }

      $data = [
        'nombre' => $request->usuario,
        'password' => $password,
        'correo' => $request->email,
        'id' => $resultado
      ];
      //return dd($resultado);
    //Mandamos el email al usuario-----------------------------------
   Mail::to($emailP)->queue(new SignUp($data));
    //Regresamos a la vista de confirmar correo------------------------------------------
    return view('registro.activacion',['usuario_id'=>$resultado]); 
  }

  public function ReenviarCorreo($id)
  {
    //return dd($id);
    //Obtenemos la info del usuario recien registrado------------------------------------
    $correo = DB::table('empresas')->where('empresa_id', $id)->value('correo_empresa');
    //return dd($email);
    $nombre = DB::table('empresas')->where('empresa_id', $id)->value('nombre');
    $password = "Planners"; 
    //$correo = "ogue@gmail.com";
    
    $data = [
      'nombre' => $nombre,
      'password' => $password,
      'correo' => $correo,
      'id' => $id
    ];
    $resultado = $id;
    //return dd($correo);
    //Reenviamos el correo---------------------------------------------------------------
    Mail::to($correo)->queue(new SignUp($data));
    //Regresamos a la vista de confirmar correo------------------------------------------
    return view('registro.reenvio',['usuario_id'=>$id]);  //literalmente se reenvia si solo recargamos la pagina, no era necesario todo lo de arriba UnU
    
  }

  public function r(){
    return back();
    //Cambiamos lo del estatus aqui merengues
  }

  public function ConfirmarCorreo($id)
  {
    DB::table('empresas')->where('empresa_id', $id)->update(['estatus_registro' => 2]);
    return view('registro.contrasena', ['id' => $id]) ;
  }

  public function CrearContraseña(Request $request, $id)
  {
    //Hacemos el Update de la contraseña master ============================================
    
    DB::table('empresas')->where('empresa_id', $id)->update(['estatus_registro' => 3]);
    //return dd($request->password);
    //$contrasena = Hash::make($request->password);
    $contrasena = $this->encryptValue($request->password);
    DB::table('empresas')->where('empresa_id', $id)->update(['contrasena' => $contrasena]);
    
    //Asignamos variables para el sp de usuarios web =======================================
    
    $nombreP = DB::table('empresas')->where('empresa_id', $id)->value('nombre');
    $emailP  = DB::table('empresas')->where('empresa_id', $id)->value('correo_empresa');
    $claveP = DB::table('empresas')->where('empresa_id', $id)->value('contrasena');
    $idP = $id;
    $tipo = 1;
    //Llamamos al metodo store==============================================================

    $query = "call NUEVOUSUARIOWEB('$nombreP','$emailP','$claveP','$idP','$tipo');";
      try {
      $resultado = DB::select($query,array()); 
      $resultado = $resultado[0]->Respuesta; //Respuesta es lit la respuesta del store xD
      } catch (\Exception $th) {
      $resultado = $th->getMessage();
      }
      //return dd($resultado);

    return redirect('/inicio');
  }

  public function getcorreoR(){
    return view('registro.reestablecercontrasena');
  }

  public function ResetPost(Request $request){

    $correo = $request->correo;

    $data = [
      'nombre' => $nombre,
      'password' => $password,
      'correo' => $correo,
      'id' => $id
    ];
    
    Mail::to($correo)->queue(new SignUp($data));

  }

  



}

