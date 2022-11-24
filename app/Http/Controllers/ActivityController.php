<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use App\Http\Requests;
use App\Models\ActivityModel;
use Illuminate\Http\Exceptions;
use Mail;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Str;


class ActivityController extends Controller
{
  protected $ActivityModel;

  public function __construct() {
    $this->ActivityModel = new ActivityModel();
  }

  public function Activity()
  {
    $content = array();
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');
    //actividades

    try {
      $actividades = $this->ActivityModel->getActividades($usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }


    $content['actividades'] = $actividades;
    $content['totalactividades'] = count($actividades);

    return view('actividad.actividad', ['content' => $content]);
  }

  public function getActivityData($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    $content = array();
    $content['actividad_empleado_produccion_id'] = $id;

    //datos de la actividad
    try {
      $actividad = $this->ActivityModel->getActividadProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['actividad'] = $actividad;
    $content['count_actividades'] = count($actividad);

    //datos de la produccion: lote/actividad
    try {
      $actividad_produccion = $this->ActivityModel->getLoteActividad($id, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['actividad_produccion'] = $actividad_produccion;

    return $content;
  }

  public function NewActivity()
  {

    $content = array();

    try {
      $ranchos = $this->ActivityModel->getCentroCostosRanchos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['ranchos'] = $ranchos;

    // try {
    //   $tractoristas = $this->ActivityModel->getTractoristas();
    // }
    // catch (\Exception $e) {
    //   return $e->getMessage();
    // }
    //
    // $content['tractoristas'] = $tractoristas;

    return view('actividad.nuevaactividad', ['content' => $content]);
  }

  public function GetLots(Request $request)
  {
    $content = array();
    $post = $request->request->all();

    if (isset($post['term'])) {
      $term = $post['term'];
    } else {
      $term = "";
    }

    if (isset($post['rancho'])) {
      $rancho = $post['rancho'];
    } else {
      $rancho = "";
    }

    //lotes
    try {
      $producciones = $this->ActivityModel->getProduccionesbyTerm($term, $rancho);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['results'] = $producciones;
    $content['pagination']['more'] = true;


    return $this->getResponse($content);
  }

  public function GetActivities(Request $request)
  {
    $content = array();
    $post = $request->request->all();

    if (isset($post['term'])) {
      $term = $post['term'];
    } else {
      $term = "";
    }

    //Actividades-Conceptos Producciones
    try {
      $conceptos_producciones = $this->ActivityModel->getConceptosProduccionesbyTerm($term);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['results'] = $conceptos_producciones;
    $content['pagination']['more'] = true;


    return $this->getResponse($content);
  }

  public function GetGroupsByType(Request $request)
  {
    $content = array();
    $post = $request->request->all();

    if (isset($post['term'])) {
      $term = $post['term'];
    } else {
      $term = "";
    }

    //cuadrillas
    try {
      $grupos = $this->ActivityModel->getCuadrillasbyTerm($term);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['results'] = $grupos;
    $content['pagination']['more'] = true;


    return $this->getResponse($content);
  }


  public function EditActivity($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      if ($rol == 'Administrador') {
        $result = $this->ActivityModel->validateActividadid($id);
      }
      else {
        $result = $this->ActivityModel->validateActividadidUsuario($id, $usuario);
      }
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['actividad_empleado_produccion_id'] = $id;

    //datos de la actividad
    try {
      $actividad = $this->ActivityModel->getActividadProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['actividad'] = $actividad;
    $content['count_actividades'] = count($actividad);

    //datos de la produccion: lote/actividad
    try {
      $actividad_produccion = $this->ActivityModel->getLoteActividad($id, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['actividad_produccion'] = $actividad_produccion;

    //puestos
    try {
      $puestos = $this->ActivityModel->getPuestos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['puestos'] = $puestos;

    //cuadrillas
    try {
      $departamentos = $this->ActivityModel->getDepartamentos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['departamentos'] = $departamentos;


    return view('actividad.editaactividad', ['content' => $content]);

  }

  public function GetLotInfo($lote) {

    $content = array();

    //lote Info
    try {
      $producciones = $this->ActivityModel->getInfoLote($lote);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['results'] = $producciones;

    return $this->getResponse($content);
  }


  public function SubmitActivity(Request $request)
  {
    $content = array();
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    if (isset($post['fecha_proceso'])) {
      $fecha_proceso = $post['fecha_proceso'] ;
    } else {

      $fecha_proceso = date("Y-m-d");
    }

    if (isset($post['hora_proceso'])) {
      $hora_proceso = $post['hora_proceso'] ;
    } else {

      $hora_proceso = date("h:i:s");
    }

    $cuadrilla = $post['slccuadrilla'];
    $rancho = $post['rancho'];
    $usuario = \Session::get('email');
    try {
      $result = $this->ActivityModel->insertActivity($cuadrilla, $fecha_proceso, $hora_proceso, $rancho, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    //
  //  $result = json_decode(json_encode($result), true);
  //  $docto_produccion_id = $result[0]['Proceso'];
    //$content['docto_produccion_id'] = $docto_produccion_id;
    return $this->getResponse($result);


    //return $content;

  }

  public function SubmitList(Request $request)
  {
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    if (isset($post['horas'])) {
      $horas = (int)$post['horas'] ;
    } else {
      $horas = 0;
    }

    $xd = (int) $post['xd'] ;
    $yd = (int) $post['yd'] ;
    $listaid = (int)$post['listaid'] ;
    $usuario = \Session::get('email');

    if ($horas > 0) {
      try {
        $result = $this->ActivityModel->insertList($xd, $yd, $listaid, $horas, $usuario);
      }
      catch (\Exception $e) {
        return $e->getMessage();
      }
    }


    //
  //  $result = json_decode(json_encode($result), true);
  //  $docto_produccion_id = $result[0]['Proceso'];
    //$content['docto_produccion_id'] = $docto_produccion_id;
    return $this->getResponse($result);


    //return $content;

  }

  public function UpdateActivity(Request $request)
  {

    $content = array();
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $descripciond = $post['descripciond'];
    $id = $post['requisicion_id'];


    try {
      $result = $this->ActivityModel->updateRequisicion($id, $descripciond);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    return $this->getResponse($response);

  }


  public function NewActivityDetail(Request $request)
  {
    $usuario = \Session::get('email');
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();
    $articles = json_decode($post['jsonArticles'], True);

    foreach ($articles as $article=>$value) {

      $cantidadd = $value['cantidad'];

      $doctoproduccionid = (int)$value['app'];

      if ($value['nombre']) {
        $articulod = $value['nombre'] ;
      } else {
        $articulod = "";
      }

      if ($cantidadd ) {

        try {
          $result = $this->ActivityModel->insertAplicacion_det($doctoproduccionid, $articulod, $cantidadd, $usuario);

        }
        catch (\Exception $e) {
          return $e->getMessage();
        }


      } else{

      }



    }

    //return $this->getResponse($result);
    $result = json_decode(json_encode($result), true);
    // $id_produccion_det = $result[0]['Respuesta'];
    //
    //
    return $result;

  }

  public function SubmitEmployee(Request $request)
  {
    $content = array();
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    if (isset($post['numeroempleadod'])) {
      $numeroempleadod = $post['numeroempleadod'] ;
    } else {

      $numeroempleadod = 0;
    }

    if (isset($post['maternod'])) {
      $maternod = $post['maternod'] ;
    } else {

      $maternod = "";
    }

    if (isset($post['rfcd'])) {
      $rfcd = $post['rfcd'] ;
    } else {

      $rfcd = "";
    }

    if (isset($post['nssd'])) {
      $nssd = $post['nssd'] ;
    } else {

      $nssd = "";
    }

    if (isset($post['rpd'])) {
      $rpd = $post['rpd'] ;
    } else {

      $rpd = "";
    }

    if (isset($post['fechaaltad'])) {
      $fechaaltad = $post['fechaaltad'] ;
    } else {

      $fechaaltad = date("Y-m-d");
    }

    $paternod = $post['paternod'];
    $nombred = $post['nombred'];
    $curpd = $post['curpd'];
    $fechanacimientod = $post['fechanacimientod'];
    $puestod = $post['puestod'];
    $departamentod = $post['departamentod'];
    $usuario = \Session::get('email');
    try {
      $result = $this->ActivityModel->insertEmployee($numeroempleadod, $paternod, $maternod, $nombred, $rfcd, $curpd, $fechanacimientod, $nssd, $fechaaltad, $puestod, $departamentod, $rpd, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    //
  //  $result = json_decode(json_encode($result), true);
  //  $docto_produccion_id = $result[0]['Proceso'];
    //$content['docto_produccion_id'] = $docto_produccion_id;
    return $this->getResponse($result);


    //return $content;

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
      $centros_costos = $this->ActivityModel->getRanchosbyTerm($term);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['results'] = $centros_costos;
    $content['pagination']['more'] = true;


    return $this->getResponse($content);
  }

  public function AppActivity(Request $request)
  {
    $usuario = \Session::get('email');
    $response = array("status" => false, "data" => array());
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();
    $id = (int) $post['produccion_id'];

    //Aplicar la actividad
    try {
      $result = $this->ActivityModel->aplicaActividad($id, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    //$result = json_decode(json_encode($result), true);
    //
    // if (count($result) != 0) {
    //    return $result[0];
    // }
    // $response['data'] = "exitoso";
    return $this->getResponse($result);
  }


  ///////////////////////////////////////


  public function PDFView($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');


    try {
      if ($rol == 'Administrador') {
        $result = $this->ActivityModel->validateActividadid($id);
      }
      else {
        $result = $this->ActivityModel->validateActividadidUsuario($id, $usuario);
      }
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['actividad_empleado_produccion_id'] = $id;

    //datos de la actividad
    try {
      $actividad = $this->ActivityModel->getActividadProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['actividad'] = $actividad;
    $content['count_actividades'] = count($actividad);

    //datos de la produccion: lote/actividad
    try {
      $actividad_produccion = $this->ActivityModel->getLoteActividad($id, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['actividad_produccion'] = $actividad_produccion;

    //puestos
    try {
      $puestos = $this->ActivityModel->getPuestos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['puestos'] = $puestos;

    //cuadrillas
    try {
      $departamentos = $this->ActivityModel->getDepartamentos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['departamentos'] = $departamentos;


    $pdf = PDF::loadView('actividad.pdf', ['content' => $content]);
    return $pdf->stream();
  }


  ///////////////////////////
  public function EmailView($id)
  {

    $content = array();
    $content = $this->getActivityData($id);
    return view('actividad.email', ['content' => $content]);
  }

  public function AuthActivity(Request $request)
  {
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $id = $post['actividad_id'];

    $usuario = \Session::get('email');

    //Autorizar la actividad
    try {
      $result = $this->ActivityModel->autorizaActividad($id, $usuario);
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
  public function CancelActivity(Request $request)
  {
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $id = $post['requisicion_id'];
    $descripcion = "prueba";



    $usuario = \Session::get('email');


    //Cancelar la requisición
    try {
      $result = $this->ActivityModel->cancelaRequisicion($id, $usuario, $descripcion);
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

  public function ViewActivity($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      if ($rol == 'Administrador') {
        $result = $this->ActivityModel->validateActividadid($id);
      }
      else {
        $result = $this->ActivityModel->validateActividadidUsuario($id, $usuario);
      }
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['actividad_empleado_produccion_id'] = $id;

    //datos de la actividad
    try {
      $actividad = $this->ActivityModel->getActividadProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['actividad'] = $actividad;
    $content['count_actividades'] = count($actividad);

    //datos de la produccion: lote/actividad
    try {
      $actividad_produccion = $this->ActivityModel->getLoteActividad($id, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['actividad_produccion'] = $actividad_produccion;

    //puestos
    try {
      $puestos = $this->ActivityModel->getPuestos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['puestos'] = $puestos;

    //cuadrillas
    try {
      $departamentos = $this->ActivityModel->getDepartamentos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['departamentos'] = $departamentos;



    return view('actividad.visualizaactividad', ['content' => $content]);


  }

  public function SubmitLotActivity(Request $request)
  {
    $usuario = \Session::get('email');
    $content = array();
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $listaid = $post['actividades_empleados_producciones_id'];
    $lote = $post['slcloteact'];
    $actividad = $post['slcactividad'];


      try {
        $result = $this->ActivityModel->insertActividadLote($listaid, $lote, $actividad, $usuario);
      }
      catch (\Exception $e) {
        return $e->getMessage();
      }




    //
    // $result = json_decode(json_encode($result), true);
    // $docto_produccion_id = $result[0]['Proceso'];
    // $content['docto_produccion_id'] = $docto_produccion_id;


    return $result;

  }

  public function SendEmailAct(Request $request)
  {

    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();
     $id = (int) $post['actividad_empleado_produccion_id'];
    $content = array();
    $content = $this->getActivityData($id);

    $content['actividades_empleados_producciones_id'] = $id;
    $emails = $this->ActivityModel->getEmailToAuthActivity($id);
    //$list_email = ['julianamoncada4@hotmail.com','kiuboparce@hotmail.com'];
    //$emails = json_decode($emails, True);
    //$emails = json_decode($emails, true)
    $emails = json_decode(json_encode($emails), true);
    //$email = $result[0]['correo'];
    $lista_emails = '';
    //
    foreach ($emails as $email=>$value) {

        $lista_emails = $lista_emails . $value['correo'] . ','  ;

    }

    //$email = $email[0]->correo_notificacion;
    $lista_emails =substr($lista_emails, 0, -1);
    $list_email = explode(",",$lista_emails);

    //Datos del email
      $content['datamail'] = [
        //'email'=>'julianam@megafreshproduce.com.mx',
        'email'=>$list_email,
        'subject'=>'Nueva aplicación a autorizar',
        'bodyMessage'=>'Prueba',
      ];


      //Enviar el mail
      try {
        $mail = Mail::send('actividad.email', ['content' => $content],function($message) use ($content){
          $message->from('aplicaciones@megafreshproduce.com.mx', 'Aplicaciones Mega Fresh Produce');
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

  public function AutorizaActivity($id)
 {

   $usuario = \Session::get('email');
   $rol = \Session::get('rol');

   try {
     if ($rol == 'Administrador') {
       $result = $this->ActivityModel->validateActividadid($id);
     }
     else {
       $result = $this->ActivityModel->validateActividadidUsuario($id, $usuario);
     }
   }
   catch (\Exception $e) {
     return $e->getMessage();
   }

   if (count($result) == 0) {
     return back();
   }

   $content = array();
   $content['actividad_empleado_produccion_id'] = $id;

   //datos de la actividad
   try {
     $actividad = $this->ActivityModel->getActividadProduccion($id);
   }
   catch (\Exception $e) {
     return $e->getMessage();
   }
   $content['actividad'] = $actividad;
   $content['count_actividades'] = count($actividad);

   //datos de la produccion: lote/actividad
   try {
     $actividad_produccion = $this->ActivityModel->getLoteActividad($id, $usuario);
   }
   catch (\Exception $e) {
     return $e->getMessage();
   }
   $content['actividad_produccion'] = $actividad_produccion;

   //puestos
   try {
     $puestos = $this->ActivityModel->getPuestos();
   }
   catch (\Exception $e) {
     return $e->getMessage();
   }
   $content['puestos'] = $puestos;

   //cuadrillas
   try {
     $departamentos = $this->ActivityModel->getDepartamentos();
   }
   catch (\Exception $e) {
     return $e->getMessage();
   }
   $content['departamentos'] = $departamentos;

   return view('actividad.autorizaactividad', ['content' => $content]);

 }

  public function ReporteCostos()
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      $reportecostos = $this->ActivityModel->getReporteCostos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['reportecostos'] = $reportecostos;

    return view('actividad.reportecostos', ['content' => $content]);
  }

  public function encryptValue($value)
  {
    $key = \Config::get('app.key');
    if (Str::startsWith($key, 'base64:')) {
      $key = base64_decode(substr($key, 7));
    }

    return hash_hmac('sha256', $value , $key);
  }

  public function getResponse($data) {
    $response = new Response(json_encode($data), 200, array('Content-Type', 'text/json'));
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, *');
    return $response;
  }

}
