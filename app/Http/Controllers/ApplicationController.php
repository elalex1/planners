<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use App\Http\Requests;
use App\Models\ApplicationModel;
use Illuminate\Http\Exceptions;
use Mail;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Str;


class ApplicationController extends Controller
{
  protected $ApplicationModel;

  public function __construct() {
    $this->ApplicationModel = new ApplicationModel();
  }

  public function Application()
  {
    $content = array();
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');
    //aplicaciones

    try {
      $producciones = $this->ApplicationModel->getProducciones($usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }


    $content['producciones'] = $producciones;
    $content['totalproducciones'] = count($producciones);


    return view('aplicacion.aplicacion', ['content' => $content]);
  }

  public function getApplicationData($id)
  {
    $content = array();
    $content['id_docto_produccion'] = $id;

    //datos de la requisición
    try {
      $produccion = $this->ApplicationModel->getDoctoProduccion($id);

    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['produccion'] = $produccion;


    //articulos de la requisición
    try {
      $articulos_produccion = $this->ApplicationModel->getArticulosProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }


    $content['articulos_produccion'] = $articulos_produccion;

    return $content;
  }

  public function NewApplication()
  {

    $content = array();

    try {
      $conceptos_producciones = $this->ApplicationModel->getConceptosProducciones();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['conceptos_producciones'] = $conceptos_producciones;

    try {
      $ranchos = $this->ApplicationModel->getCentroCostosRanchos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['ranchos'] = $ranchos;

    // try {
    //   $tractoristas = $this->ApplicationModel->getTractoristas();
    // }
    // catch (\Exception $e) {
    //   return $e->getMessage();
    // }
    //
    // $content['tractoristas'] = $tractoristas;

    return view('aplicacion.nuevaaplicacion', ['content' => $content]);
  }


  public function GetLots(Request $request) {
    $content = array();
    $post = $request->request->all();

    if (isset($post['term'])) {
      $term = $post['term'];
    } else {
      $term = "";
    }
    //lotes
    try {
      $producciones = $this->ApplicationModel->getProduccionesbyTerm($term);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['results'] = $producciones;
    $content['pagination']['more'] = true;


    return $this->getResponse($content);
  }


  public function EditApplication($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      if ($rol == 'Administrador') {
        $result = $this->ApplicationModel->validateAplicacionid($id);
      }
      else {
        $result = $this->ApplicationModel->validateAplicacionidUsuario($id, $usuario);
      }
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['id_docto_produccion'] = $id;


    //datos de la producción
    try {
      $produccion = $this->ApplicationModel->getDoctoProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['produccion'] = $produccion;
    // print_r($content['requisicion'][0]->nombre);
    // die();

    //articulos de la requisición
    try {
      $articulos_produccion = $this->ApplicationModel->getArticulosProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_produccion'] = $articulos_produccion;

    //articulos
    $superficie = (float)($content['produccion'][0]->superficie);

    //  $superficie = $content['produccion']
    try {
      $articulos = $this->ApplicationModel->getArticulos($id,$superficie);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos'] = $articulos;

    //conceptos aplicaciones
    $id_articulo_aplica = (int)($content['produccion'][0]->cosecha);
    try {
      $conceptos_aplicaciones = $this->ApplicationModel->getConceptosAplicaciones($id_articulo_aplica);
    }

    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['conceptos_aplicaciones'] = $conceptos_aplicaciones;

    //empleados aplicadores
    try {
      $empleados = $this->ApplicationModel->getEmpleados();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['empleados'] = $empleados;

    //usos_empleados - aplicadores
    try {
      $usos_empleados = $this->ApplicationModel->getUsosEmpleados($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['count_usos_empleados'] = count($usos_empleados);
    $content['usos_empleados'] = $usos_empleados;

    //tipos aplicaciones
    try {
      $tipos_usos_empleados = $this->ApplicationModel->getTiposUsosEmpleados();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['tipos_usos_empleados'] = $tipos_usos_empleados;

    //Recetas
    try {
      $recetas = $this->ApplicationModel->getRecetas();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['recetas'] = $recetas;


      return view('aplicacion.editaaplicacion', ['content' => $content]);

  }

  public function GetLotInfo($lote) {

    $content = array();

    //lote Info
    try {
      $producciones = $this->ApplicationModel->getInfoLote($lote);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['results'] = $producciones;

    return $this->getResponse($content);
  }


  public function SubmitApplication(Request $request)
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

    $concepto_produccion = $post['concepto_produccion'];
    $lote = $post['slclote'];
    $superficie = $post['superficie'];
    $usuario = \Session::get('email');
    try {
      $result = $this->ApplicationModel->insertApplication($lote, $concepto_produccion, $fecha_proceso, $hora_proceso, $superficie, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    //
    $result = json_decode(json_encode($result), true);
    $docto_produccion_id = $result[0]['Proceso'];
    $content['docto_produccion_id'] = $docto_produccion_id;


    return $content;

  }

  public function SubmitAplicador(Request $request)
  {
    $usuario = \Session::get('email');
    $content = array();
    $response = array("status" => false, "data" => array());

    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $aplicadorid = $post['aplicador'];
    $viaaplicacion = $post['via_aplicacion'];
    $cantidadd = $post['horas'];
    $pozo = $post['pozo'];
    $doctoproduccionid = $post['docto_produccion_id'];

    if (isset($post['aplicador'])) {
      $aplicadorid = $post['aplicador'];
      try {
        $result = $this->ApplicationModel->insertAplicador($doctoproduccionid, $aplicadorid, $viaaplicacion, $cantidadd, $usuario, $pozo);
      }
      catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    if (isset($post['activo_fijo'])) {
      $activofijo = $post['activo_fijo'];
      try {
        $result = $this->ActivityModel->insertUsoActivoFijo($doctoproduccionid, $activofijo, $operador, $cantidadd, $usuario);
      }
      catch (\Exception $e) {
        return $e->getMessage();
      }

    }



    //
    // $result = json_decode(json_encode($result), true);
    // $docto_produccion_id = $result[0]['Proceso'];
    // $content['docto_produccion_id'] = $docto_produccion_id;


    return $result;

  }

  public function UpdateApplication(Request $request)
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
      $result = $this->ApplicationModel->updateRequisicion($id, $descripciond);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    return $this->getResponse($response);

  }


  public function NewApplicationDetail(Request $request)
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

      if (isset($value['seleccionado'])) {
        $plaga = $value['seleccionado'];
      } else {
        $plaga = "";
      }

      if ($cantidadd ) {

        try {
          $result = $this->ApplicationModel->insertAplicacion_det($doctoproduccionid, $articulod, $cantidadd, $plaga, $usuario);

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

  public function DeleteArticle(Request $request)
  {
    $usuario = \Session::get('email');
    if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();


    $nombrearticulo = $post['articulo_nombre'];
    $docto_produccion_id = (int) $post['docto_produccion_id'];

    try {
      $result = $this->ApplicationModel->deleteArticuloAplicacion($docto_produccion_id, $nombrearticulo, $usuario );
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    return $this->getResponse($result);
  }

  public function GetArticlesApplication(Request $request) {
    $content = array();
    $post = $request->request->all();
    $id = (int) $post['requisicion_id'];


    //articulos de la requisición
    try {
      $articulos_requisicion = $this->ApplicationModel->getArticulosRequisicion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_produccion'] = $articulos_produccion;


    return $this->getResponse($content);
  }

  public function GetArticlesApplicationByType(Request $request) {
    $content = array();
    $post = $request->request->all();
    $id = (int) $post['requisicion_id'];


    //articulos
    $superficie = (float)($content['produccion'][0]->superficie);
    try {
      $articulos = $this->ApplicationModel->getArticulos($id, $superficie);
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
      $centros_costos = $this->ApplicationModel->getCentrosCostosbyTerm($term);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['results'] = $centros_costos;
    $content['pagination']['more'] = true;


    return $this->getResponse($content);
  }

  public function AppApplication(Request $request)
  {
    $usuario = \Session::get('email');
    $response = array("status" => false, "data" => array());
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();
    $id = (int) $post['produccion_id'];

    //Aplicar la requisicón
    try {
      $result = $this->ApplicationModel->aplicaProduccion($id, $usuario);
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

  public function AppReceta(Request $request)
  {
    $usuario = \Session::get('email');


    $post = $request->request->all();
    $fecha_proceso = $post['fecha_proceso'];
    $hora_proceso = $post['hora_proceso'];
    $aplicadorid = $post['aplicador'];
    $viaaplicacion = $post['via_aplicacion'];
    $cantidadd = $post['horas'];
    $concepto_produccion= $post['concepto_produccion'];
    $receta = $post['receta'];
    $pozo = $post['pozo'];


    $result = $this->ApplicationModel->getRecetaId($receta);
    $result = json_decode(json_encode($result), true);

    $receta_id = (int)($result[0]['docto_produccion_id']);
    //Insertar producción
    try {
      $result = $this->ApplicationModel->aplicaReceta($concepto_produccion, $receta_id, $fecha_proceso, $hora_proceso, $aplicadorid, $viaaplicacion, $cantidadd, $pozo, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }


    // if (is_numeric($result[0]->Proceso)) {
    //   $docto_produccion_id = $result[0]->Proceso;
    //
    //   $result = $this->ApplicationModel->aplicaProduccion($docto_produccion_id, $usuario);
    //
    // }

      $result = json_decode(json_encode($result), true);

    return $this->getResponse($result);
  }

  ///////////////////////////////////////


  public function PDFView($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      if ($rol == 'Administrador') {
        $result = $this->ApplicationModel->validateAplicacionid($id);
      }
      else {
        $result = $this->ApplicationModel->validateAplicacionidUsuario($id, $usuario);
      }
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content = $this->getApplicationData($id);

    //usos_empleados - aplicadores
    try {
      $usos_empleados = $this->ApplicationModel->getUsosEmpleados($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['count_usos_empleados'] = count($usos_empleados);
    $content['usos_empleados'] = $usos_empleados;


    //return view('requisicion.pdf', ['content' => $content]);
    $pdf = PDF::loadView('aplicacion.pdf', ['content' => $content]);
    return $pdf->stream();
    //return $pdf->download('hdtuto.pdf');
  }


  ///////////////////////////
  public function EmailView($id)
  {

    $content = array();
    $content = $this->getApplicationData($id);
    return view('requisicion.email', ['content' => $content]);
  }

  public function AuthApplication(Request $request)
  {
    if ($request->getMethod() != 'POST') {
      $response['data'] = "Not Authorized";
    }

    $post = $request->request->all();

    $id = $post['requisicion_id'];

    $usuario = \Session::get('email');

    //Autorizar la requisición
    try {
      $result = $this->ApplicationModel->autorizaRequisicion($id, $usuario);
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
  public function CancelApplication(Request $request)
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
      $result = $this->ApplicationModel->cancelaRequisicion($id, $usuario, $descripcion);
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

  public function ViewApplication($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      $result = $this->ApplicationModel->validateAplicacionid($id);

    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['id_docto_produccion'] = $id;


    //datos de la requisición
    try {
      $produccion = $this->ApplicationModel->getDoctoProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['produccion'] = $produccion;
    // print_r($content['requisicion'][0]->nombre);
    // die();

    //articulos de la requisición
    try {
      $articulos_produccion = $this->ApplicationModel->getArticulosProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_produccion'] = $articulos_produccion;

    //articulos
    $superficie = (float)($content['produccion'][0]->superficie);
    try {
      $articulos = $this->ApplicationModel->getArticulos($id,$superficie);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos'] = $articulos;

    //empleados aplicadores
    try {
      $empleados = $this->ApplicationModel->getEmpleados();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['empleados'] = $empleados;

    //usos_empleados - aplicadores
    try {
      $usos_empleados = $this->ApplicationModel->getUsosEmpleados($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['count_usos_empleados'] = count($usos_empleados);
    $content['usos_empleados'] = $usos_empleados;


    return view('aplicacion.terminaaplicacion', ['content' => $content]);


  }



  public function SearchObjective(Request $request) {
    $content = array();
    $post = $request->request->all();

    if (isset($post['term'])) {
      $term = $post['term'];
    } else {
      $term = "";
    }

    if (isset($post['articulo_id'])) {
      $articulo_id = $post['articulo_id'];
    } else {
      $articulo_id = "";
    }
    //centros de costos
    try {
      $objetivos = $this->ApplicationModel->getPlagaObjetivo($term, $articulo_id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['results'] = $objetivos;
    $content['pagination']['more'] = true;


    return $this->getResponse($content);
  }

  public function ObjectiveInfo(Request $request) {
    $content = array();
    $post = $request->request->all();
    if (isset($post['articulo_id'])) {
      $articulo_id = $post['articulo_id'];
    } else {
      $articulo_id = "";
    }

    if (isset($post['objetivo'])) {
      $objetivo = $post['objetivo'];
    } else {
      $objetivo = "";
    }

    $superficie = (float)($post['superficie']);

    //Dosis Objetivo
    try {
      $objetivoinfo = $this->ApplicationModel->getObjetivoInfo($objetivo, $articulo_id, $superficie);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['objetivoinfo'] = $objetivoinfo;
    $content['articulo_id'] = $articulo_id;


    return $this->getResponse($content);
  }


  public function AplicaReceta($id,$receta)
  {

    $usuario = \Session::get('email');
    $rol = \Session::get('rol');
    try {
      if ($rol == 'Administrador') {
        $result = $this->ApplicationModel->validateAplicacionid($id);
      }
      else {
        $result = $this->ApplicationModel->validateAplicacionidUsuario($id, $usuario);
      }
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    if (count($result) == 0) {
      return back();
    }

    $content = array();
    $content['receta'] = $receta;
    $content['receta_id'] = $id;


    //datos de la producción
    try {
      $produccion = $this->ApplicationModel->getDoctoProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['produccion'] = $produccion;

    $content['produccion'][0]->nombre= "APLICACION DE AGROQUIMICOS";
    $content['produccion'][0]->estatus= "Normal";

    //articulos de la requisición
    try {
      $articulos_produccion = $this->ApplicationModel->getArticulosProduccion($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos_produccion'] = $articulos_produccion;



    //empleados aplicadores
    try {
      $empleados = $this->ApplicationModel->getEmpleados();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['empleados'] = $empleados;

    //usos_empleados - aplicadores
    try {
      $usos_empleados = $this->ApplicationModel->getUsosEmpleados($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['count_usos_empleados'] = count($usos_empleados);
    $content['usos_empleados'] = $usos_empleados;

    //tipos aplicaciones
    try {
      $tipos_usos_empleados = $this->ApplicationModel->getTiposUsosEmpleados();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['tipos_usos_empleados'] = $tipos_usos_empleados;


    return view('aplicacion.aplicacionreceta', ['content' => $content]);

  }


  public function BitacoraPlaguicida($fechas)
  {

    parse_str($fechas, $valores);

    $usuario = \Session::get('email');
    $rol = \Session::get('rol');
    $concepto_produccion = "APLICACION DE AGROQUIMICOS";

    if (isset($valores['fecha_inicial'])) {
      $fecha_inicial = $valores['fecha_inicial'];
      $fecha_final =$valores['fecha_final'];
    } else {
      $fecha_inicial = "2020-01-01";
      $fecha_final = "2030-01-01";
    }


    try {
      $bitacoraplaguicida = $this->ApplicationModel->getBitacoraPlaguicida($concepto_produccion, $fecha_inicial, $fecha_final, '');
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['countplaguicida'] = count($bitacoraplaguicida);

    if (count($bitacoraplaguicida) != 0) {
      $content['bitacoraplaguicida'] = $bitacoraplaguicida;
    }
    $content['bitacoraplaguicida'] = $bitacoraplaguicida;

    return view('aplicacion.bitacoraplaguicida', ['content' => $content]);
  }

  public function BitacoraFertilizante($lote)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');
    $concepto_produccion = 'APLICACION DE FERTILIZANTE';
    //$lote = 'TV1902-38';

    try {
      $bitacorafertilizante = $this->ApplicationModel->getBitacoraFertilizante($lote, $concepto_produccion);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['countfertilizante'] = count($bitacorafertilizante);

    if (count($bitacorafertilizante) != 0) {

      $content['bitacorafertilizante'] = $bitacorafertilizante;


    }
    return view('aplicacion.bitacorafertilizante', ['content' => $content]);


  }

  public function ReporteAplicacion()
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');
    $concepto_produccion = 'APLICACION DE FERTILIZANTE';
    $fecha_inicial = "2020-01-01";
    $fecha_final = "2020-12-31";

    try {
      $reporteaplicacion = $this->ApplicationModel->getReporteAplicacion($concepto_produccion, $fecha_inicial, $fecha_final);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['countaplicacion'] = count($reporteaplicacion);

    if (count($reporteaplicacion) != 0) {

      $content['reporteaplicacion'] = $reporteaplicacion;


    }
    return view('aplicacion.reporteaplicaciones', ['content' => $content]);


  }
  public function FertilizanteNPK($lote)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');
    $concepto_produccion = 'APLICACION DE FERTILIZANTE';
    //$lote='';
    $familia='';
    $articulo='';
    $fecha_inicio = "2020-01-01";
    $fecha_final ="2020-12-31";
    $centrocosto='';
    //$lote = 'TV1902-38';

    try {
      $fertilizantenpk = $this->ApplicationModel->getFertilizanteNPK($centrocosto, $lote, $familia, $concepto_produccion, $articulo, $fecha_inicio, $fecha_final, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
    $content['countfertilizantenpk'] = count($fertilizantenpk);

    if (count($fertilizantenpk) != 0) {

      $content['fertilizantenpk'] = $fertilizantenpk;

    }
    return view('aplicacion.reportefertilizantenpk', ['content' => $content]);
  }

  public function ReporteCostos()
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    try {
      $reportecostos = $this->ApplicationModel->getReporteCostos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['reportecostos'] = $reportecostos;

    return view('aplicacion.reportecostos', ['content' => $content]);
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
