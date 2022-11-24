<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDevRecepcion;
use App\Models\CatalogoModel;
use App\Models\Compras\DevRecepcionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DevRecepcionesController extends Controller
{
    protected $DevRecepcion;
    protected $Catalogo;
    public function __construct()
    {
        $this->DevRecepcion=new DevRecepcionModel();
        $this->Catalogo=new CatalogoModel();
    }
    public function DevRecepcionGetAll(){
        $data['doctos']=$this->DevRecepcion->DevRecepcionGetAll("E");
        return view('compras.devolucionrecepcion.devolucionrecepcion',['data'=>$data]);
    }
    public function DevRecepcionNew(){
        $almacenes=$this->Catalogo->getAlmacenesSelect();
        $monedas=$this->Catalogo->getMonedasSelect();
        //$conceptoscompras=$this->Catalogo->getConceptosCompras('RM');
        $data=array('almacenes'=>$almacenes,'monedas'=>$monedas);
        //return $data;
        return view('compras.devolucionrecepcion.nueva',['data'=>$data]);
    }  
    public function DevRecepcionStore(StoreDevRecepcion $request){
        $response=array('status'=>false);
        $proveedor=$request->proveedor;
        $almacen=$request->almacen;
        $fecha=$request->fecha;
        $folio=$request->folio;
        $moneda=$request->moneda;
        $usuario=session()->get('email');
        $resp=$this->Catalogo->validarMoneda($moneda);
        if(!isset($resp['status'])){
            $response['data']=$resp;
            return $response;
        }
        if($request['tipo_cambio'] ==0){
            $response['data']="debe indicar el tipo de cambio";
            return $response;
        }
        $tipoCambio=1.0;
        $arancel=0;
        $gastosAduanales=0;
        $otrosGastos=0;
        $fletes=0;
        $tipoDescuento=$request->tipo_descuento;
        $importeDescuento=0;
        if(!$resp['status']){
            if($request->tipo_cambio){
                $tipoCambio=$request->tipo_cambio;
            }
            if($request->arancel){
                $arancel=$request->arancel;
            }
            if($request->gastos_aduanales){
                $gastosAduanales=$request->gastos_aduanales;
            }
            if($request->otros_gastos){
                $otrosGastos=$request->otros_gastos;
            }
            if($request->fletes){
                $fletes=$request->fletes;
            }
        }
        if($tipoDescuento){
            if($request->importe_descuento){
                $importeDescuento=$request->importe_descuento;
            }
        }
        $descripcion=$request->descripcion;
        $respuesta=$this->DevRecepcion->storenewDevRecepcion($proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion);
        if(is_numeric($respuesta)){
            $response['status']=true;
            $response['message']="Devolución guardada";
            $response['data']=route('dev_recepciones_editar',$respuesta);
        }else{
            $response['data']=$respuesta;
        }
        return $response;
    } 
    public function DevRecepcionUpdate(Request $request){
        $request->validate([
            'moneda'=>'required',
            'tipo_cambio'=>'required',

        ]);
        $response=array('status'=>false);
        $moneda=$request->moneda;
        $usuario=session()->get('email');
        $resp=$this->Catalogo->validarMoneda($moneda);
        if(!isset($resp['status'])){
            $response['data']=$resp;
            return $response;
        }
        if(!isset($request['tipo_cambio']) || $request['tipo_cambio'] == 0){
            $response['data']="debe indicar el tipo de cambio";
            return $response;
        }
        $tipoCambio=1;
        $arancel=0;
        $gastosAduanales=0;
        $otrosGastos=0;
        $fletes=0;
        $tipoDescuento=$request->tipo_descuento;
        $importeDescuento=0;
        if(!$resp['status']){
            if($request->tipo_cambio){
                $tipoCambio=$request->tipo_cambio;
            }
            if($request->arancel){
                $arancel=$request->arancel;
            }
            if($request->gastos_aduanales){
                $gastosAduanales=$request->gastos_aduanales;
            }
            if($request->otros_gastos){
                $otrosGastos=$request->otros_gastos;
            }
            if($request->fletes){
                $fletes=$request->fletes;
            }
        }
        if($tipoDescuento){
            if($request->importe_descuento){
                $importeDescuento=$request->importe_descuento;
            }
        }
        $doctoid=$request->id;
        $descripcion=$request->descripcion;
        $respuesta=$this->DevRecepcion->DevRecepcionUpdate($doctoid,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion);
        if(!is_numeric($respuesta)){
            $response['data']=$respuesta;
            return $response;
        }
        $response['status']=true;
        $response['message']='Devolución Actualizada';
        return $response;
    }
    public function DevRecepcionEdit($id){
        
        $data=$this->DevRecepcion->getDataDevRecepcion($id);
        $data['monedas']=$this->Catalogo->getMonedasSelect();
        $data['almacenes']=$this->Catalogo->getAlmacenesSelect();;
        //return $data;
        return view('compras.devolucionrecepcion.editar',['data'=>$data]);
    }
    public function DevRecepcionVer($id){
        $id=Crypt::decrypt($id);
        $data=$this->DevRecepcion->getDataDevRecepcion($id);
        return view('compras.devolucionrecepcion.verdevrecepcion',['data'=>$data]);
    }
    public function DevRecepcionAddArticles(Request $request){
        $response = array("status" => false,);
        //$response['data']=$request;
        $post = $request->request->all();
        $articles = json_decode($post['jsonArticles'], True);
        $usuario = session()->get('email');
        foreach ($articles as $article=>$value) {
            $cantidad=$value['cantidad'];
            $articulo=$value['nombre'];
            $precio=0;
            $recepcionid=$value['req'];
            if(isset($value['precio'])){
                $precio=$value['precio'];
            }
            $result=$this->DevRecepcion->guardarRenglon($cantidad,$articulo,$precio,$recepcionid,$usuario);
            //$response['data']=array('cantidad'=>$cantidad,'articuloid'=>$articuloid,'precio'=>$precio,'recepcionid'=>$recepcionid);
            if(!is_numeric($result)){
                $response['data']=$result;
                return $response;
            }
        }
        $response['status']=true;
        $response['message']='Articulos agregados';
        $response['data']='reload';
        return $response;
    }
    public function DevRecepcionRemoveArticles(Request $request){
        $response=array('status'=>false);
        $usuario = session()->get('email');
        if ($request->getMethod() != 'DELETE') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $post = $request->request->all();
        $doctoordencompradetid = (int) $post['articulo_id'];
        $compra_id = (int) $post['docto_id'];

        $result=$this->DevRecepcion->eliminarRenglon($compra_id,$doctoordencompradetid,$usuario); 
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']='Articulo eliminado';
        $response['data']='reload';
        return $response;
    }
    public function DevRecepcionDesdeRecepcion(Request $request){
        $response=array('status'=>false);
        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $datos=json_decode($request->request->all()['jsonData'],true);
        $recepcionid=$datos[0]['cantidad'];
        $usuario=session()->get('email');
        $resp=$this->DevRecepcion->agregardesderecepcion($recepcionid,$usuario); 
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('dev_recepciones_editar',$resp);
        return $response;
    }
    public function DevRecepcionFinalizar(Request $request){
        $response=array('status'=>false);
        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $usuario=session()->get('email');
        if($request['jsonArticles']){
            $articles=json_decode($request->request->all()['jsonArticles'],true);
            $tabla='';
            foreach ($articles as $article=>$value) {
                $cantidad=$value['newcantidad'];
                $articuloid=$value['articuloid'];
                $id=$value['doctoid'];
                $tabla .=$id.','.$articuloid.','.$cantidad;
                if($value != end($articles)){
                    $tabla .= ',';
                }
                // if(isset($value['precio'])){
                //     $precio=$value['precio'];
                // }
                // $response['data'] = $articles;
                // return $response;
                // $result=$this->DevRecepcion->guardarRenglon($cantidad,$articulo,$precio,$recepcionid,$usuario);
                // //$response['data']=array('cantidad'=>$cantidad,'articuloid'=>$articuloid,'precio'=>$precio,'recepcionid'=>$recepcionid);
                // if(!is_numeric($result)){
                //     $response['data']=$result;
                //     return $response;
                // }
            }
            //$recepcionid=$datos[0]['cantidad'];
            // $usuario=session()->get('email');
            $resp=$this->DevRecepcion->DevRecepcionFinalizarLigada($tabla,$usuario); 
            if(!is_numeric($resp)){
                $response['data']=$resp;
                return $response;
            }
            $response['status']=true;
            $response['data']=route('devrecepcionmercancia_all');
        }else{
            //$response['status']=true;
            $request->validate([
                'id_fin'=>'required'
            ]);
            $iddocto=$request->id_fin;
            $resp=$this->DevRecepcion->DevRecepcionFinalizar($iddocto,$usuario); 
            if(!is_numeric($resp)){
                $response['data']=$resp;
                return $response;
            }
            $response['status']=true;
            $response['data']=route('devrecepcionmercancia_all');
        }
        return $response;
    }
    public function DevRecepcionCancelar(Request $request){
        $request->validate([
            'devrecepcion_id'=>'required',
            'motivo'=>'required',
        ]);
        $response=array('status'=>false);
        $motivo=$request->motivo;
        $doctoid=$request->devrecepcion_id;
        $usuario=session()->get('email');
        $resp=$this->DevRecepcion->DevRecepcionCancelar($doctoid,$motivo,$usuario);
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['status']=true;
        $response['message']='Devolucion cancelada';
        $response['data']=route('devrecepcionmercancia_all');
        return $response;

    }
}
