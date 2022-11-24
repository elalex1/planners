<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNuevaRecepcion;
use App\Models\CatalogoModel;
use App\Models\Compras\RecepcionModel;
use App\Models\RequisitionModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use PDF;

class RecepcionController extends Controller
{
    protected $RecepcionModel;
    protected $Catalogo;
    protected $RequisitionModel;
    public function __construct()
    {
        $this->RecepcionModel= new RecepcionModel();
        $this->Catalogo=new CatalogoModel();
        $this->RequisitionModel= new RequisitionModel();
    }

    public function getVistaRecepciones(){
        $d=$this->RecepcionModel->GetAll('R');
        //return $d;
        if(!is_array($d)){
            return $d;
        }
        $data['data_count']=count($d);
        $data['data']=$d;
        //return $data;
        return view('compras.Recepciones.recepcionmercancia',['data'=>$data]);
    }
    public function vistaNuevaRecepcion(){
        // $almacenes=$this->Recepciones->getAlmacenesSelect();
        $almacenes=$this->Catalogo->getAlmacenesSelect();
        // $monedas=$this->Recepciones->getMonedasSelect();
        $monedas=$this->Catalogo->getMonedasSelect();
        //$conceptoscompras=$this->Recepciones->getConceptos();
        $conceptoscompras=$this->Catalogo->getConceptosCompras('RM');
        $data=array('almacenes'=>$almacenes,'monedas'=>$monedas,'conceptos_compras'=>$conceptoscompras);
        //return $data;
        return view('compras.Recepciones.nuevarecepcionmercancia',['data'=>$data]);
    }
    public function saveNuevaRecepcion(StoreNuevaRecepcion $request){
        $data=array('status'=>false);
        $proveedor=$request->proveedor;
        $almacen=$request->almacen;
        $fecha=$request->fecha;
        $folio=$request->folio;
        $moneda=$request->moneda;
        $usuario=session()->get('email');
        $resp=$this->verificarMonedaNuevaRecepcion($moneda);
        if(!isset($request['tipo_cambio']) || $request['tipo_cambio'] ==0){
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
        /*$data['data']=$tipoCambio;
        return $data;*/
        $respuesta=$this->RecepcionModel->storenewRecepcion($proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion);
        if(is_numeric($respuesta)){
            $data['status']=true;
            $data['message']="Recepción guardada";
            $data['data']=route('recepcionmercancia_editar',$respuesta);
        }else{
            $data['data']=$respuesta;
        }
        return $data;
    }
    public function editarNuevaRecepcion($id){
        $data=$this->RecepcionModel->getDataRecepcion($id);
        $data['monedas']=$this->Catalogo->getMonedasSelect();
        //return $data;
        $imagenes = $this->RecepcionModel->getImagenes($id);
        $data['imagenes']=$imagenes;
        $data['almacenes']=$this->Catalogo->getAlmacenesSelect();
        //return $data;
        return view('compras.Recepciones.editerrecepcionmercancia',['data'=>$data]);
    }
    public function RecepcionImagen(Request $request){
        $request->validate([
            'id'=>'required',
            'archivo_docto'=>'required',
            'descripcion_documento'=>'required',
        ]);
        $response=array('status'=>false);
        $usuario =session()->get('email');
        $post = $request->request->all(); 
        $idrecepcion=$post['id'];
        $descripcion=$post['descripcion_documento'];
        $imagen = file_get_contents($_FILES['archivo_docto']['tmp_name']);
        $extension = pathinfo($_FILES['archivo_docto']['name'], PATHINFO_EXTENSION);
        $nombre = date("Y-m-d") . '-' . date("h-i-sa") . '.' . $extension;
        $carpeta = 'compras/';
        try{
            $ruta = Storage::disk('s3')->put($carpeta.$nombre, $imagen);
        }catch(\Exception $e){
            $response['data']= 'error:'.$e->getMessage();
            return $response;
        }
        $archivo = $carpeta . $nombre;
        $result = $this->RecepcionModel->RecepcionImagenAdd($idrecepcion, $archivo, $extension, $nombre, $descripcion, $usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            Storage::disk('s3')->delete($archivo);
            return $response;
        }
        $response['status']=true;
        $response['message']='Documento agregado con exito';
        // $response['data']=$archivo."<>".$extension."<>".$nombre;
        $response['data']='reload';
        return $response;
    }
    public function RecepcionImagenDelete(Request $request){
        $response=array('status'=>false);
        $usuario = session()->get('email');
        if ($request->getMethod() != 'DELETE') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $post = $request->request->all();
        $archivo_id = (int) $post['archivo_id'];
        $recepcion_id = (int) $post['docto_id'];
        $img=$this->Catalogo->getNombreArchivo($archivo_id);
        $result = $this->RecepcionModel->RecepcionImagenDelete($recepcion_id, $archivo_id, $usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        try{
            Storage::disk('s3')->delete($img);
        }catch(Exception $e){
            $response['message']=$e->getMessage();
        }
        $response['status']=true;
        $response['data']='reload';
        return $response;
    }
    public function verificarMonedaNuevaRecepcion($moneda){
        //return $moneda;
        $data=$this->RecepcionModel->validarMoneda($moneda);
        $resp=array('status'=>false);
        
        if($data['es_local']=='S' || $data['es_local']==''){
            //return 'eslocal';
            $resp['status']= true;
        }
        return $resp;
    }
    public function verificarproveedorRecepcion($proveedor){
        $data=$this->RecepcionModel->verificarProveedor($proveedor);
        $resp=array('status'=>false);
        if($data->extranjero=='S'){
            $resp['status']= true;
        }
        return $resp;
    }
    public function addRenglonNuevaRecepcion(Request $request){
        $response = array("status" => false);
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
            $result=$this->RecepcionModel->guardarRenglon($cantidad,$articulo,$precio,$recepcionid,$usuario);
            //$response['data']=array('cantidad'=>$cantidad,'articuloid'=>$articuloid,'precio'=>$precio,'recepcionid'=>$recepcionid);
            if(!is_numeric($result)){
                $response['data']=$result;
                return $response;
            }
        }
        $response['status']=true;
        $response['message']='artículos agregados';
        $response['data']='reload';
        return $response;
    }
    public function DeleteArticle(Request $request){
        $response=array('status'=>false);
        $usuario = session()->get('email');
        if ($request->getMethod() != 'DELETE') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $post = $request->request->all();
        $doctoordencompradetid = (int) $post['articulo_id'];
        $compra_id = (int) $post['docto_id'];

        $result=$this->RecepcionModel->eliminarRenglon($compra_id,$doctoordencompradetid,$usuario); 
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']='artículo eliminado';
        $response['data']='reload';
        return $response;
      //return response($result);
    }
    public function updateNuevaRecepcion(Request $request){
        $request->validate([
            'almacen'=>'required',
            'moneda'=>'required',
            'tipo_cambio'=>'required',
        ]);
        $response=array('status'=>false);
        // $response['data']=$request->all();
        // return $response;
        $proveedor=$request->proveedor;
        $almacen=$request->almacen;
        $fecha=$request->fecha;
        $folio=$request->folio;
        $moneda=$request->moneda;
        $usuario=session()->get('email');
        $resp=$this->verificarMonedaNuevaRecepcion($moneda);
        if(!isset($request['tipo_cambio']) || $request['tipo_cambio'] ==0){
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
        $doctoid=$request->recepcion_id;
        $descripcion=$request->descripcion;
        $respuesta=$this->RecepcionModel->actualizarRecepcionMercancia($doctoid,$proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion);
        if(!is_numeric($respuesta)){
            $response['data']=$respuesta;
            return $response;
        }
        $response['status']=true;
        $response['message']='Recepción actualizada';
        //$response['data']=route('recepcionmercancia_editar',$doctoid);
        return $response;
    }
    public function finalizarRecepcion(Request $request){
        $response=array('status'=>false,'data'=>array());
        $usuario=session()->get('email');
        $recepcionid=$request->id;
        //$response['data']=$request->id." ".$usuario;
        $respuesta=$this->RecepcionModel->finalizarRececpcion($recepcionid,$usuario);
        if(!is_numeric($respuesta)){
            $response['data']=$respuesta;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('recepcionmercancia');
        return $response;
    }
    public function cancelarRecepcion(Request $request){
        $request->validate([
            'recepcion_id'=>'required',
            'motivo'=>'required',
        ]);
        $response=array('status'=>false,'data'=>array());
        $usuario=session()->get('email');
        $recepcionid=$request->recepcion_id;
        $motivo=$request->motivo;
        //$response['data']=$request->id." ".$usuario;
        $respuesta=$this->RecepcionModel->cancelarRececpcion($recepcionid,$usuario,$motivo);
        if(!is_numeric($respuesta)){
            $response['data']=$respuesta;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('recepcionmercancia');
        return $response;
    }
    public function ordenescompraRecepcion(){
        //$row=array('fecha'=>'2022/04/22','folio'=>'FOLIO00001','proveedor'=>'proveedor1','almacen'=>'lugar de entrega','docto_compra_id'=>1);
        $data=$this->RecepcionModel->getOrdenesCompra();
        //return $this->getResponse($data);
        return json_encode($data);
    }
    public function addOrdenescompraRecepcion(Request $request){
        $response=array('status'=>false,'data'=>array());
        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $datos=json_decode($request->request->all()['jsonData'],true);
        $ordenes=$datos['doctosArray'];
        $usuario=session()->get('email');
        $resp=$this->RecepcionModel->agregarordenesarecepcion($ordenes,$usuario); 
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('recepcionmercancia_editar',$resp);
        return $response;
    }
    public function finalizarRecepcionligada(Request $request){
        $response=array('status'=>false,'data'=>array());
        $data=$request->request->all();
        $usuario=session()->get('email');
        
        foreach($data as $item){
            /*$response['data']=$item['articuloid'];
            return $response;*/
            $articuloid=$item['articuloid'];
            $pedidas=$item['cantidad'];
            $recepcionid=$item['rececpionid'];
            $recibidas=$item['recibidas'];
            $result=0;
            if($pedidas != $recibidas){
                $result=$this->RecepcionModel->finalizardetalleligado($recepcionid,$articuloid,$pedidas,$recibidas,$usuario);
            }
            if(!is_numeric($result)){
                $response['data']=$result;
                return $response;
            }
        }
        $result=$this->RecepcionModel->finalizarrecepcionligado($recepcionid,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['data']=route('recepcionmercancia');
        $response['status']=true;
        return $response;
    }
    public function guardarLote(Request $request){
        $request->validate([
            'tipo'=>'required',
            'serie'=>'required',
            'fecha'=>'required',
            'cantidad'=>'required'
        ]);
        $articuloid=$request->articuloid;
        $compradetid=$request->compradetid;
        $tipo=$request->tipo;
        $serie=$request->serie;
        $fecha=$request->fecha;
        $cantidad=$request->cantidad;
        $response=array('status'=>false);
        $resp=$this->RecepcionModel->ActualizatLote($articuloid,$compradetid,$tipo,$serie,$fecha,$cantidad);
        if(is_numeric($resp)){
            $resp='Actualizado con exito';
        }
        $response['data']=$resp;
        return $response;
    }
    public function visualizarRecepcion($id){
        $data=$this->RecepcionModel->getDataRecepcion($id);
        $data['imagenes']=$this->RecepcionModel->getImagenes($id);
        //return $data;
        return view('compras.Recepciones.verrecepcionmercancia',['data'=>$data]);
    }
    public function PDFView($id){
        $id=Crypt::decrypt($id);
        $data=$this->RecepcionModel->getDataRecepcion($id);
        //$pdf=PDF::loadView('compras.Recepciones.pdf',['data'=>$data])->setPaper('a4');
        $pdf=$this->Catalogo->PDFView($data,'compras.Recepciones.pdf');
        return $pdf->stream();
    }
    public function RecepcionFinalizar(Request $request){
        $response=array('status'=>false);
        if ($request->getMethod() != 'PUT') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $usuario=session()->get('email');
        
        if($request['jsonArticles']){
            $articles=json_decode($request->request->all()['jsonArticles'],true);
            $tabla='';
            foreach ($articles as $article=>$value) {
                if(isset($value['newcantidad']) && is_numeric($value['newcantidad']) && floatval($value['newcantidad']) >= 1){
                    $cantidad=$value['newcantidad'];
                    $articuloid=$value['articuloid'];
                    $id=$value['doctoid'];
                    $tabla .=$id.','.$articuloid.','.$cantidad;
                    if($value != end($articles)){
                        $tabla .= ',';
                    }
                }
            }
            if(!is_numeric(substr($tabla,strlen($tabla)-1))){
                $tabla=str_replace(',delete','',$tabla.'delete');
            }
            $resp=$this->RecepcionModel->finalizarrecepcionligado($tabla,$usuario); 
            if(!is_numeric($resp)){
                $response['data']=$resp;
                return $response;
            }
            $response['status']=true;
            $response['data']=route('recepcionmercancia');
        }else{
            $request->validate([
                'id_fin'=>'required'
            ]);
            $iddocto=$request->id_fin;
            $resp=$this->RecepcionModel->finalizarRececpcion($iddocto,$usuario); 
            if(!is_numeric($resp)){
                $response['data']=$resp;
                return $response;
            }
            $response['status']=true;
            $response['data']=route('recepcionmercancia');
        }
        return $response;
    }
}
