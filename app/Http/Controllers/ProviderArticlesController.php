<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use App\Http\Requests;
use App\Models\ProviderArticleModel;
use Illuminate\Http\Exceptions;
use Mail;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Str;


class ProviderArticlesController extends Controller
{
  protected $ProviderArticleModel;

  public function __construct() {
    $this->ProviderArticleModel = new ProviderArticleModel();
  }


  public function GetProviderArticles($proveedor, $estatus)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    $content = array();

    try {
      $articulos = $this->ProviderArticleModel->getArticulosProveedor($proveedor, $estatus, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos'] = $articulos;
    $content['countarticulos'] = count($articulos);

    return view('articulosproveedores.articulosproveedores', ['content' => $content]);
  }

  public function GetProviderArticleData($articulo_proveedor_id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    $content = array();

    try {
      $articulodata = $this->ProviderArticleModel->getArticuloData($articulo_proveedor_id, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulodata'] = $articulodata;

    try {
      $articulos = $this->ProviderArticleModel->getArticulos();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articulos'] = $articulos;
    $content['countarticulos'] = count($articulos);

    try {
      $articuloseleccionado = $this->ProviderArticleModel->getArticuloSeleccionado($articulo_proveedor_id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }
      $content['articuloseleccionado'] = $articuloseleccionado;

      $content['countarticuloseleccionado'] = count($articuloseleccionado);
    return view('articulosproveedores.editaarticulosproveedores', ['content' => $content]);
  }

  public function GetProviders(Request $request)
  {

    $content = array();
    $post = $request->request->all();

    if (isset($post['term'])) {
      $term = $post['term'];
    } else {
      $term = "";
    }
    //proveedores
    try {
      $proveedores = $this->ProviderArticleModel->getProveedores($term);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['results'] = $proveedores;
    $content['pagination']['more'] = true;

    return $this->getResponse($content);
  }

  public function GetProviderArticleDetail($id)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    $content = array();
    //datos de la actividad
    try {
      $articuloproveedor = $this->ProviderArticleModel->getArticuloProveedorDetalle($id);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    $content['articuloproveedor'] = $articuloproveedor;

  //  return $this->getResponse($content);

    return view('articulosproveedores.articuloproveedor', ['content' => $content]);
  }

  public function updateProviderArticle(Request $request)
  {
    $usuario = \Session::get('email');
    $rol = \Session::get('rol');

    $post = $request->request->all();
    $articulod = $post['articulod'];
    $articuloproveedorid = (int) $post['articulo_proveedor_id'];
    $contenidocompra = (float) $post['contenido_compra'];
    //datos de la actividad
    try {
      $articuloproveedor = $this->ProviderArticleModel->updateArticuloProveedor($articuloproveedorid, $articulod, $contenidocompra, $usuario);
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    //$content['articuloproveedor'] = $articuloproveedor;
    //$result = json_decode(json_encode($articuloproveedor), true);
    //$articuloproveedor = $this->getResponse($articuloproveedor);
    return($articuloproveedor);
    //die();
    //return $this->getResponse($result);

    //return view('articulosproveedores.articuloproveedor', ['content' => $content]);
  }

  public function getResponse($data) {
    $response = new Response(json_encode($data), 200, array('Content-Type', 'text/json'));
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, *');
    return $response;
  }

}
