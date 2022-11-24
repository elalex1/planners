<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDevCompra;
use App\Models\CatalogoModel;
use App\Models\Compras\DevCompraModel;
use Illuminate\Http\Request;

class DevComprasController extends Controller
{
    protected $DevCompra;
    protected $Catalogo;
    public function __construct()
    {
        $this->DevCompra=new DevCompraModel();
        $this->Catalogo=new CatalogoModel();
    }
    public function DevCompraGetAll(){
        $data['doctos']=$this->DevCompra->DevCompraGetAll('D','ALL');
        //return $data;
        return view('compras.devolucioncompra.devolucioncompra',['data'=>$data]);
    }
    public function DevCompraGetAllT(){
        $data=$this->DevCompra->DevCompraTNL();
        return response($data);
        //return view('compras.devolucioncompra.devolucioncompra',['data'=>$data]);
    }
    public function DevCompraNew(){
        $almacenes=$this->Catalogo->getAlmacenesSelect();
        $monedas=$this->Catalogo->getMonedasSelect();
        //$conceptoscompras=$this->Catalogo->getConceptosCompras('RM');
        $data=array('almacenes'=>$almacenes,'monedas'=>$monedas);
        //return $data;
        return view('compras.devolucioncompra.nueva',['data'=>$data]);
    }  
    public function DevCompraStore(StoreDevCompra $request){
        $response=array('status'=>false);
        $proveedor=$request->proveedor;
        $almacen=$request->almacen;
        $fecha=$request->fecha;
        $folio=$request->folio;
        $moneda=$request->moneda;
        $usuario=session()->get('email');
        //$response['data']=$proveedor."<>".$almacen."<>".$fecha."<>".$folio."<>".$moneda."<>".$usuario;
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
        $respuesta=$this->DevCompra->storenewDevCompra($proveedor,$almacen,$fecha,$folio,$moneda,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion);
        if(is_numeric($respuesta)){
            $response['status']=true;
            $response['message']="Devolución guardada";
            $response['data']=route('dev_compras_editar',$respuesta);
        }else{
            $response['data']=$respuesta;
        }
        return $response;
    } 
    public function DevCompraUpdate(Request $request){
        $request->validate([
            'moneda'=>'required',
            'descripcion'=>'required',
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
        $respuesta=$this->DevCompra->DevCompraUpdate($doctoid,$usuario,$tipoCambio,$arancel,$gastosAduanales,$otrosGastos,$fletes,$tipoDescuento,$importeDescuento,$descripcion);
        if(!is_numeric($respuesta)){
            $response['data']=$respuesta;
            return $response;
        }
        $response['status']=true;
        $response['message']='Documento Actualizado';
        return $response;
    }
    public function DevCompraEdit($id){
        $data=$this->DevCompra->getDataDevCompra($id);
        $data['monedas']=$this->Catalogo->getMonedasSelect();
        $data['almacenes']=$this->Catalogo->getAlmacenesSelect();;
        //return $data;
        return view('compras.devolucioncompra.editar',['data'=>$data]);
    }
    public function DevCompraVer($id){
        $data=$this->DevCompra->getDataDevCompra($id);
        return view('compras.devolucioncompra.verdevcompra',['data'=>$data]);
    }
    public function DevCompraAddArticles(Request $request){
        $response = array("status" => false,);
        //$response['data']=$request;
        $post = $request->request->all();
        $articles = json_decode($post['jsonArticles'], True);
        $usuario = session()->get('email');
        foreach ($articles as $article=>$value) {
            $cantidad=$value['cantidad'];
            $articulo=$value['articulo'];
            $precio=0;
            $recepcionid=$value['doctoid'];
            if(isset($value['precio'])){
                $precio=$value['precio'];
            }
            $result=$this->DevCompra->guardarRenglon($cantidad,$articulo,$precio,$recepcionid,$usuario);
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
    public function DevCompraRemoveArticles(Request $request){
        $response=array('status'=>false);
        $usuario = session()->get('email');
        if ($request->getMethod() != 'DELETE') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $post = $request->request->all();
        $doctoordencompradetid = (int) $post['articulo_id'];
        $compra_id = (int) $post['docto_id'];

        $result=$this->DevCompra->eliminarRenglon($compra_id,$doctoordencompradetid,$usuario); 
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']='Articulo eliminado';
        $response['data']='reload';
        return $response;
    }
    public function DevCompraDesdeCompra(Request $request){
        $response=array('status'=>false);
        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $datos=json_decode($request->request->all()['jsonData'],true);
        $recepcionid=$datos[0]['cantidad'];
        $usuario=session()->get('email');
        $resp=$this->DevCompra->agregardesdecompra($recepcionid,$usuario); 
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('dev_compras_editar',$resp);
        return $response;
    }
    public function DevCompraFinalizar(Request $request){
        $request->validate([
            'id_fin'=>'required'
        ]);
        $response=array('status'=>false);
        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $compraid=$request->id_fin;
        $usuario=session()->get('email');
        // $response['data']=$compraid." <> ".$usuario;
        // return $response;
        $resp=$this->DevCompra->DevCompraFinalizar($compraid,$usuario); 
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('dev_compras_all');
        return $response;

    }
    public function DevCompraCancelar(Request $request){
        $request->validate([
            'compra_id'=>'required',
            'motivo'=>'required',
        ]);
        $response=array('status'=>false);
        $motivo=$request->motivo;
        $doctoid=$request->compra_id;
        $usuario=session()->get('email');
        $resp=$this->DevCompra->DevCompraCancelar($doctoid,$motivo,$usuario);
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['status']=true;
        $response['message']='Devolición cancelada';
        $response['data']=route('dev_compras_all');
        /*try{
            Mail::from('pruebasMegafresh@gmail.com')->to('drh_river@hotmail.com')->send(new EmailConfirmation());
        }catch(Exception $e){
            $response['data']=$e->getMessage();
        }*/
        return $response;
    }
}
