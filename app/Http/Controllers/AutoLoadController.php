<?php

namespace App\Http\Controllers;

use App\Models\CatalogoModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AutoLoadController extends Controller
{
    protected $Catalogo;
    
    public function __construct()
    {
        $this->Catalogo=new CatalogoModel();
    }
    public function GetCiudadesByTerm(Request $request) {
        $content = array();
        $post = $request->request->all();

        if (isset($post['entidad'])) {
          $entidad = $post['entidad'];
        } else {
          $entidad = "";
        }
        if (isset($post['term'])) {
            $term = $post['term'];
          } else {
            $term = "";
          }
        //centros de costos
        try {
          $ciudades = $this->Catalogo->GetCiudadesByTerm($term,$entidad);
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }
        $content['results'] = $ciudades;
        $content['pagination']['more'] = true;
        return response($content);
    }
    public function GetProveedoresByTerm(Request $request){
        $response = array();
        $post = $request->request->all();
        if (isset($post['term'])) {
            $term = $post['term'];
        } else {
            $term = "";
        }
        $proveedores = $this->Catalogo->GetProveedoresByTerm($term);
         $response['results'] = $proveedores;
         $response['pagination']['more'] = true;
         return response($response);
    }
    public function GetFamiliasByReqs(Request $request){
        $post = $request->request->all();
        if(isset($post['doctosJson'])) {
            $term = $post['doctosJson'];
        } else {
            $term = "";
        }
        $familias = $this->Catalogo->GetFamiliasByReqs($term);
        $response['results'] = $familias;
        $response['pagination']['more'] = true;
        return response($response);
    }
    public function GetEntidadesByTerm(Request $request) {
        $content = array();
        $post = $request->request->all();

        if (isset($post['pais'])) {
          $pais = $post['pais'];
        } else {
          $pais = "";
        }
        if (isset($post['term'])) {
            $term = $post['term'];
          } else {
            $term = "";
          }
        //centros de costos
        try {
          $ciudades = $this->Catalogo->GetEntidadesByTerm($term,$pais);
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }
        $content['results'] = $ciudades;
        $content['pagination']['more'] = true;
        return response($content);
    }
    public function getPuestos(Request $request){
        $response = array();
        $post = $request->request->all();
        if (isset($post['term'])) {
            $term = $post['term'];
        } else {
            $term = "";
        }
        $proveedores = $this->Catalogo->getPuestos($term);
         $response['results'] = $proveedores;
         $response['pagination']['more'] = true;
         return response($response);
    }
    public function getDepartamentos(Request $request){
        $response = array();
        $post = $request->request->all();
        if (isset($post['term'])) {
            $term = $post['term'];
        } else {
            $term = "";
        }
        $proveedores = $this->Catalogo->getDepartamentos($term);
         $response['results'] = $proveedores;
         $response['pagination']['more'] = true;
         return response($response);
    }
    public function getArticulosTable(){
        try {
            $articulos = $this->Catalogo->getArticulos();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        //return response()->json($articulos);
        return json_encode($articulos);
    }
    public function getConceptosNomTable(){
      try {
          $articulos = $this->Catalogo->getConceptosNomTable();
      }
      catch (\Exception $e) {
          return $e->getMessage();
      }
      //return response()->json($articulos);
      return json_encode($articulos);
  }
  public function getCentrosCostos(Request $request){
    $response = array();
    $post = $request->request->all();
    if (isset($post['term'])) {
        $term = $post['term'];
    } else {
        $term = "";
    }
    $proveedores = $this->Catalogo->getCentrosCostosbyTerm($term);
     $response['results'] = $proveedores;
     $response['pagination']['more'] = true;
     return response($response);
  }
}
