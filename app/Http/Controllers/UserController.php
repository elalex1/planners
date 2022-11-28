<?php



namespace App\Http\Controllers;



use App\Models\UserModel;

use Illuminate\Http\Request;

use Illuminate\Http\Response;



class UserController extends Controller

{

  protected $UserModel;



  public function __construct() {

    $this->UserModel = new UserModel();

  }



  public function User()

  {

    $content = array();

    $usuario = \Session::get('email');

    //usuarios web

    try {

      $usuarios = $this->UserModel->getUsers();

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    $content['usuarios'] = $usuarios;



    //usuarios (roles)

    try {

      $roles = $this->UserModel->getRoles();

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    $content['roles'] = $roles;





      return view('user.user', ['content' => $content]);

  }



  public function EditUser(Request $request)

  {

    $content = array();

    $response = array("status" => false, "data" => array());



    if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";

    }



    $post = $request->request->all();

    $usuario_web_id = $post['edit_item_id'];

    $nombreusuario = $post['nombreusuario'];

    $correousuario = $post['correousuario'];

    $rolusuario = $post['rolusuario'];





    try {

      $response = $this->UserModel->updateUser($usuario_web_id,$nombreusuario,$correousuario,$rolusuario);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }





    return $this->getResponse($response);

  }



  public function NewUser(Request $request)

  {

    $content = array();

    $response = array("status" => false, "data" => array());



    if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";

    }



    $post = $request->request->all();

    $nombreusuario = $post['nuevonombreusuario'];

    $correousuario = $post['nuevocorreousuario'];

    $rolusuario = $post['nuevorolusuario'];





    try {

      $response = $this->UserModel->newUser($nombreusuario,$correousuario,$rolusuario);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }





    return $this->getResponse($response);

  }





   public function getResponse($data) {

     $response = new Response(json_encode($data), 200, array('Content-Type', 'text/json'));

     $response->headers->set('Access-Control-Allow-Origin', '*');

     $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, *');

     return $response;

   }

   public function index(){
    return "Hola";
   }



}

