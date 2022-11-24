<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompra;
use App\Mail\EmailConfirmation;
use App\Models\Compras\CompraModel;
use App\Models\Doctos\DoctoCompraModel;
use App\Models\CatalogoModel;
use App\Models\Compras\ValidacionesModel;
use App\Models\RequisitionModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ComprasController extends Controller
{
    protected $Compra;
    protected $Catalogos;
    protected $Verificar;
    protected $RequisitionModel;
        
    public function __construct()
    {
        // $usuario = session()->get('email'); 
        // $rol = session()->get('rol'); 
        $this->Compra=new CompraModel();
        $this->Catalogos=new CatalogoModel();
        $this->Verificar=new ValidacionesModel();
        $this->RequisitionModel=new RequisitionModel();
    }
    public function ComprasGetAll(Request $request){
        //$filtro=$request->filtro;
        $d=$this->Compra->CompraGetAll('C','ALL');
        //return $d;
        $data['data_count']=count($d);
        $data['data']=$d;
        return view('compras.compras',['data'=>$data]);
    }
    public function ComprasNew(){
        $almacenes=$this->Catalogos->getAlmacenesSelect();
        $monedas=$this->Catalogos->getMonedasSelect();
        $conceptos=$this->Compra->getConceptosCompras();
        $data=array('almacenes'=>$almacenes,'monedas'=>$monedas,'conceptos_compras'=>$conceptos);
        return view('compras.nuevacompra',['data'=>$data]);
    }
    public function CompraStore(StoreCompra $request){
        $data=array('status'=>false);
        $proveedor=$request->proveedor;
        $almacen=$request->almacen;
        $fecha=$request->fecha;
        $folio=$request->folio;
        $moneda=$request->moneda;
        $usuario=session()->get('email');
        $resp=$this->Verificar->verificarMonedaNuevaRecepcion($moneda);
        // $response['data']=$resp;
        // return $response;
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
        // $data['data']=$concepto_compra;
        // return $data;
        $respuesta=$this->Compra->NewCompraStrore($proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento);
        if(is_numeric($respuesta)){
            $data['status']=true;
            $data['message']="Compra guardada";
            $data['data']=route('compras_editar',$respuesta);
        }else{
            $data['data']=$respuesta;
        }
        return $data;
    }
    public function EditCompra($id){
        $data=$this->Compra->getDataCompra($id);
        $data['monedas']=$this->Catalogos->getMonedasSelect();
        $imagenes = $this->Compra->getImagenes($id);
        $data['imagenes']=$imagenes;
        //return $data;
        return view('compras.editarcompra',['data'=>$data]);
    }
    public function ComprasUpdate(Request $request){
        $request->validate([
            'importe_descuento'=>'required_with:tipo_descuento',
            'moneda'=>'required',
            'tipo_cambio'=>'required'
        ]);
        $response=array('status'=>false);
        /*$proveedor=$request->proveedor;
        $almacen=$request->almacen;
        $fecha=$request->fecha;
        $folio=$request->folio;*/
        $usuario=session()->get('email');
        $moneda=$request->moneda;
        $resp=$this->Verificar->verificarMonedaNuevaRecepcion($moneda);
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
        $doctoid=$request->id;
        //$usuario=session()->get('email');
        // $response['data']=$usuario;
        // return $response;
        $respuesta=$this->Compra->actualizarCompra($doctoid,$importeDescuento,$tipoDescuento,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$usuario);
        if(!is_numeric($respuesta)){
            $response['data']=$respuesta;
            return $response;
        }
        $response['status']=true;
        // $response['data']=route('recepcionmercancia_editar',$doctoid);
        $response['message']='Datos Actualizados';
        return $response;
    }
    public function ComprasArchivoAdd(Request $request){
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
        $result = $this->Compra->CompraImagenAdd($idrecepcion, $archivo, $extension, $nombre, $descripcion, $usuario);
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
    public function ComprasArchivoDelete(Request $request){
        $response=array('status'=>false);
        $usuario = session()->get('email');
        if ($request->getMethod() != 'DELETE') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $post = $request->request->all();
        $archivo_id = (int) $post['archivo_id'];
        $compra_id = (int) $post['docto_id'];
        $img=$this->Catalogos->getNombreArchivo($archivo_id);
        $result = $this->Compra->CompraImagenDelete($compra_id, $archivo_id, $usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        try{
            Storage::disk('s3')->delete($img);
        }catch(Exception $e){
            $response['message']=$e->getMessage()."archivo: ".$img;
        }
        $response['status']=true;
        $response['data']='reload';
        return $response;
    }
    public function visualizarCompra($id){
        $data=$this->Compra->getDataCompra($id);
        $data['imagenes']=$this->Compra->getImagenes($id);
        //return $data;
        return view('compras.vercompra',['data'=>$data]);
    }
    public function ComprasVerPdf($id){
        try{
            $id=Crypt::decrypt($id);
        }catch(Exception $e){
            return '<h1>Not Authorized</h1>';
        }
        $data=$this->Compra->getDataCompra($id);
        $pdf=$this->Catalogos->PDFView($data,"compras.pdfcompra");
        if(is_string($pdf)){
            return $pdf;
        }
        return $pdf->stream();
    }
    public function GetRecepcionesTerminadas(){
        $data=$this->Compra->GetRecepciones();
        return json_encode($data);
    }
    public function ComprasAddLigada(Request $request){
        $response=array('status'=>false);
        $data=json_decode($request->all()['jsonData'],true);
        $doctos=$data['doctosArray'];
        $usuario = session()->get('email');
        $result=$this->Compra->AddRecepciones($doctos,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        //$response['data']=$doctos." <> ".$usuario;
        $response['message']="Compra creada";
        $response['status']=true;
        $response['data']=route('compras_editar',$result);
        return $response;
    }
    public function ComprasAddRenglon(Request $request){
        $response = array("status" => false,);
        
        $post = $request->request->all();
        $articles = json_decode($post['jsonArticles'], True);
        $usuario = session()->get('email');
        foreach ($articles as $article=>$value) {
            $cantidad=$value['cantidad'];
            $articulo=$value['articulo'];
            $precio=0;
            $doctoid=$value['doctoid'];
            if(isset($value['precio'])){
                $precio=$value['precio'];
            }
            $result=$this->Compra->guardarRenglon($cantidad,$articulo,$precio,$doctoid,$usuario);
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
    public function ComprasDeleteRenglon(Request $request){
        $response=array('status'=>false);
        $usuario = session()->get('email');
        if ($request->getMethod() != 'DELETE') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $post = $request->request->all();
        $doctoordencompradetid = (int) $post['articulo_id'];
        $compra_id = (int) $post['docto_id'];
        $result=$this->Compra->eliminarRenglon($compra_id,$doctoordencompradetid,$usuario); 
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']='Articulo eliminado';
        $response['data']='reload';
        return $response;
    }
    public function ComprasFinalizar(Request $request){
        $request->validate([
            'id_fin'=>'required'
        ]);
        $response=array('status'=>false);
        $usuario = session()->get('email');
        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $post = $request->request->all();
        $compra_id = (int) $post['id_fin'];
        $result=$this->Compra->FinalizarCompra($compra_id,$usuario); 
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('compras_all');
        return $response;
    }
    public function ComprasCancelar(Request $request){
        $request->validate([
            'compra_id'=>'required',
            'motivo'=>'required',
        ]);
        $response=array('status'=>false);
        $motivo=$request->motivo;
        $doctoid=$request->compra_id;
        $usuario=session()->get('email');
        $resp=$this->Compra->CompraCancelar($doctoid,$motivo,$usuario);
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['status']=true;
        $response['message']='Compra cancelada';
        $response['data']=route('compras_all');
        /*try{
            Mail::from('pruebasMegafresh@gmail.com')->to('drh_river@hotmail.com')->send(new EmailConfirmation());
        }catch(Exception $e){
            $response['data']=$e->getMessage();
        }*/
        return $response;
    }
    
}
