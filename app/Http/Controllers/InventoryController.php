<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use App\Http\Requests;
use App\Models\InventoryModel;
use Illuminate\Http\Exceptions;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Str;


class InventoryController extends Controller
{
  protected $InventoryModel;

  public function __construct() {
    $this->InventoryModel = new InventoryModel();
  }

  public function Inventory($tipo_inventario)
  {
    $content = array();
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');
    $content['tipo_inventario'] = ucfirst($tipo_inventario);

    $tipo_inventario = strtoupper($tipo_inventario[0]);


    //inventarios

      if ($rol == 'Administrador') {

        try {
          $inventarios = $this->InventoryModel->getInventariosAdmin($tipo_inventario, $usuario);
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }
      }else{
        try {
          $inventarios = $this->InventoryModel->getInventarios($tipo_inventario, $usuario);
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }
      }





    $content['inventarios'] = $inventarios;
    $content['totalinventarios'] = count($inventarios);

    return view('inventario.inventario', ['content' => $content]);
  }

  public function getInventoryData($id)
  {
    $content = array();
    $content['id_inventario'] = $id;

    //datos de la requisición
    try {
      $inventario = $this->InventoryModel->getDoctoInventario($id);

    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['inventario'] = $inventario;


    //articulos de la requisición
    try {
      $articulos_inventario = $this->InventoryModel->getArticulosInventario($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_inventario'] = $articulos_inventario;

    return $content;
  }

  public function NewInventory($tipo_inventario)
  {

    $content = array();
    $content['tipo_inventario'] = ucfirst($tipo_inventario);
    $tipo_inventario = $tipo_inventario[0];
    //conceptos inventarios
    try {
      $conceptos_inventarios = $this->InventoryModel->getConceptosInventarios($tipo_inventario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['conceptos_inventarios'] = $conceptos_inventarios;

    //almacenes
    try {
      $almacenes = $this->InventoryModel->getAlmacenes();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['almacenes'] = $almacenes;



    return view('inventario.nuevoinventario', ['content' => $content]);
  }


  public function EditInventory($tipo_inventario,$id)
  {


    $usuario = \Session::get('email');
    $rol = \Session::get('rol');



    try {
      if ($rol == 'Administrador') {
        $result = $this->InventoryModel->validateInventarioid($id);
      }
      else {
        $result = $this->InventoryModel->validateInventarioidUsuario($id, $usuario);
      }
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['id_inventario'] = $id;
    $content['tipo_inventario'] = ucfirst($tipo_inventario);
    


    //datos de la requisición
    try {
      $inventario = $this->InventoryModel->getDoctoInventario($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['inventario'] = $inventario;

    // return $content;
    //articulos de la requisición
    try {
      $articulos_inventario = $this->InventoryModel->getArticulosInventario($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_inventario'] = $articulos_inventario;

    //articulos
    try {
      $articulos = $this->InventoryModel->getArticulos($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos'] = $articulos;


    // return $content;
    return view('inventario.editainventario', ['content' => $content]);

  }

  public function SubmitInventory(Request $request)
  {
    $content = array();
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();


    $concepto_inventario = $post['concepto_inventario'];
    $descripciond = $post['descripciond'];
    $almacend = $post['almacend'];
    $centro_costo = $post['centro_costo'];

    if (isset($post['fecha_documento'])){
      $fechad = $post['fecha_documento'];
    }else {
      $fechad = date("Y-m-d");
    }

    $usuario = \Session::get('email');


    try {
      $result = $this->InventoryModel->insertInventario($concepto_inventario, $fechad, $descripciond, $almacend, $centro_costo, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    //
    $result = json_decode(json_encode($result), true);
    $id_inventario = $result[0];
    $content['id_inventario'] = $id_inventario;


    return $content;

  }

  public function UpdateInventory(Request $request)
  {

    $content = array();
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $descripciond = $post['descripciond'];

    $id = $post['inventario_id'];


    try {
      $result = $this->InventoryModel->updateInventario($id, $descripciond);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    return $this->getResponse($response);

  }



  public function NewInventoryDetail(Request $request)
  {
    $usuario = \Session::get('email');
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();
    $articles = json_decode($post['jsonArticles'], True);

    foreach ($articles as $article=>$value) {

      $cantidadd = (int)$value['cantidad'];

      $id_inventario = (int)$value['inv'];

      if ($value['nombre']) {
        $articulod = $value['nombre'] ;
      } else {
        $articulod = "";
      }


        try {
          $result = $this->InventoryModel->insertInventario_det($id_inventario, $articulod, $cantidadd, $usuario);

        }

        catch (\Exception $e) {
          return $e->getMessage();
        }





    }
    $result = json_decode(json_encode($result), true);
    $id_inventario_det = $result[0];


    return $id_inventario_det;

  }

  public function DeleteArticle(Request $request)
  {
    $usuario = \Session::get('email');
    if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();


    $articulod = $post['articulod'];
    $inventario_id = (int) $post['inventario_id'];



    try {
      $result = $this->InventoryModel->deleteArticuloInventario($inventario_id, $articulod, $usuario );
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    return $result;

  }

  public function GetArticlesInventory(Request $request) {
    $content = array();
    $post = $request->request->all();
    $id = (int) $post['inventario_id'];


    //articulos de la requisición
    try {
      $articulos_inventario = $this->InventoryModel->getArticulosRequisicion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_inventario'] = $articulos_inventario;


    return $this->getResponse($content);
  }

  public function GetArticlesInventoryByType(Request $request) {
    $content = array();
    $post = $request->request->all();
    $id = (int) $post['inventario_id'];


    //articulos
    try {
      $articulos = $this->InventoryModel->getArticulos($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos'] = $articulos;



    return $this->getResponse($content);
  }

  public function GetCostsByType(Request $request) {
    $content = array();
    $post = $request->request->all();

    if (isset($post['term'])) {
      $term = $post['term'];
    } else {
      $term = "";
    }
    //centros de costos
    try {
      $centros_costos = $this->InventoryModel->getCentrosCostosbyTerm($term);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['results'] = $centros_costos;
    $content['pagination']['more'] = true;


    return $this->getResponse($content);
  }

  public function AppInventory(Request $request)
  {
    $usuario = \Session::get('email');
    $response = array("status" => false, "data" => array());
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();
    $id = (int) $post['inventario_id'];

    //Aplicar la requisicón
    try {
      $result = $this->InventoryModel->aplicaInventario($id, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $result = json_decode(json_encode($result), true);

    if (count($result) != 0) {
     $response['data'] = $result[0]['Proceso'];
    }else{
      $response['data'] = "exitoso";
    }

    return $this->getResponse($response);
  }

  public function SendEmail(Request $request)
  {

    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();
    $id = (int) $post['inventario_id'];
    $content = array();
    $content = $this->getInventoryData($id);

    $content['id_inventario'] = $id;
    $email = $this->InventoryModel->getEmailToAuthInventory($id);
    //$list_email = ['julianamoncada4@hotmail.com','kiuboparce@hotmail.com'];
    // print_r($email);

    // die();
    $email = $email[0]->correo_notificacion;
    $list_email = explode(",",$email);

    //Datos del email
    $content['datamail'] = [
      //'email'=>'jfsayeg@megafreshproduce.com.mx',
      'email'=>$list_email,
      'subject'=>'Nueva requisición a autorizar',
      'bodyMessage'=>'Prueba',
    ];


    //Enviar el mail
    try {
      $mail = Mail::send('inventario.email', ['content' => $content],function($message) use ($content){
        $message->from('inventarios@megafreshproduce.com.mx', 'Inventarios Mega Fresh Produce');
        $message->to($content['datamail']['email']);
        $message->subject($content['datamail']['subject']);

      });
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $response['data'] = "Correo enviado exitosamente";
    return $this->getResponse($response);
  }

  public function SendEmailPDFAuth(Request $request)
  {
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();
    $id = (int) $post['inventario_id'];

    $content = array();

    $content = $this->getInventoryData($id);
    $content['id_inventario'] = (int)$id;

    $email = $content['inventario'][0]->email;
    $folio = $content['inventario'][0]->folio;
    $list_email = explode(",",$email);
    // $pdf = $this->PDFView($id);


    //Datos del email
    $content['datamail'] = [
      //'email'=>'jfsayeg@megafreshproduce.com.mx',
      'email'=>$list_email,
      'subject'=>'Requisición autorizada '. $folio,
      'bodyMessage'=>'Prueba',
    ];

    //Enviar el mail
    try {
      $mail = Mail::send('inventario.emailautorizado', ['content' => $content],function($message) use ($content){
        $message->from('inventarios@megafreshproduce.com.mx', 'Inventarios Mega Fresh Produce');
        $message->to($content['datamail']['email']);
        $message->subject($content['datamail']['subject']);
        // $message->attach('http://www.megafreshproduce.com.mx/erp-web/inventario/pdf/218', array(
        //            'as' => 'inventario.pdf',
        //            'mime' => 'application/pdf')
        //            );
      });
    }
    catch (\Exception $e) {
      return $e->getMessage();

    }
    $response['data'] = "Correo enviado exitosamente";
    return $this->getResponse($response);
  }

  ///////////////////////////////////////
  public function PDFView($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    $content = array();
    $content = $this->getInventoryData($id);

    //return view('inventario.pdf', ['content' => $content]);
    $pdf = PDF::loadView('inventario.pdf', ['content' => $content])->setPaper('a4');
    return $pdf->stream();
    //return $pdf->download('hdtuto.pdf');
  }




  ///////////////////////////
  public function EmailView($id)
  {

    $content = array();
    $content = $this->getInventoryData($id);
    return view('inventario.email', ['content' => $content]);
  }

  public function AuthInventory(Request $request)
  {
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $id = $post['inventario_id'];

    $usuario = \Session::get('email');

    //Autorizar la requisición
    try {
      $result = $this->InventoryModel->autorizaRequisicion($id, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $result = json_decode(json_encode($result), true);

    if (count($result) != 0) {
      //$this->SendEmailPDFAuth($id);
      return $result[0]['Proceso'];
    }
  }

  ///------------------------------------------//////////7
  public function CancelInventory(Request $request)
  {
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $id = $post['inventario_id'];
    $descripcion = "prueba";



    $usuario = \Session::get('email');


    //Cancelar la requisición
    try {
      $result = $this->InventoryModel->cancelaRequisicion($id, $usuario, $descripcion);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $result = json_decode(json_encode($result), true);

    if (count($result) != 0) {
      return $result[0]['Proceso'];
    }
  }

  ///------------------------------------------//////////7


  //////////////////////////// Ver _____________________________________-

  public function VerInventory($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      $result = $this->InventoryModel->validateRequisicionid($id);

    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['id_inventario'] = $id;


    //datos de la requisición
    try {
      $inventario = $this->InventoryModel->getDoctoRequisicion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['inventario'] = $inventario;
    // print_r($content['inventario'][0]->nombre);
    // die();

    //articulos de la requisición
    try {
      $articulos_inventario = $this->InventoryModel->getArticulosRequisicion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_inventario'] = $articulos_inventario;

    //articulos
    try {
      $articulos = $this->InventoryModel->getArticulos($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos'] = $articulos;


    //imágenes
    try {
      $imagenes = $this->InventoryModel->getImagenes($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['imagenes'] = $imagenes;

    return view('inventario.terminainventario', ['content' => $content]);

  }

  public function AutorizaInventory($id)
  {

    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      if ($rol == 'Administrador') {
        $result = $this->InventoryModel->validateRequisicionid($id);
      }
      else {
        $result = $this->InventoryModel->validateRequisicionidUsuario($id, $usuario);
      }
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['id_inventario'] = $id;

    //datos de la requisición
    try {
      $inventario = $this->InventoryModel->getDoctoRequisicion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['inventario'] = $inventario;

    //articulos de la requisición
    try {
      $articulos_inventario = $this->InventoryModel->getArticulosRequisicion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_inventario'] = $articulos_inventario;

    //articulos
    try {
      $articulos = $this->InventoryModel->getArticulos($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos'] = $articulos;



    //imágenes
    try {
      $imagenes = $this->InventoryModel->getImagenes($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['imagenes'] = $imagenes;

    return view('inventario.autorizainventario', ['content' => $content]);

  }


  public function ChangePassword(Request $request)
  {
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $usuario = \Session::get('email');
    $newpassword = $post['newpasswordconfirmation'];
    $passwordEncrypted = $this->encryptValue($newpassword);



    //Cancelar la requisición
    try {
      $result = $this->InventoryModel->updatePassword($usuario, $passwordEncrypted);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    return $result;
  }


  public function BitacoraInventario()
  {

    try {
      $bitacorainventario = $this->InventoryModel->getBitacoraInventario();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['bitacorainventarios'] = $bitacorainventario;


    return view('inventario.bitacorainventarios', ['content' => $content]);
  }

  public function RequestCC($concepto)
  {
    try {
      $requiere_cc = $this->InventoryModel->getRequiereCC($concepto);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }


    return $this->getResponse($requiere_cc);

  }

  public function getResponse($data) {

    $response = new Response(json_encode($data), 200, array('Content-Type', 'text/json'));
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, *');
    return $response;
  }

}
