<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\CatalogoModel;
use App\Models\Catalogos\MonedaModel;
use App\Models\Compras\CotizacionModel;
use App\Models\Compras\OrdenCompraModel;
//use App\Models\OrdenCompraModel;
use App\Models\RequisitionModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use PDF;

class OrdenesComprasController extends Controller
{
    protected $OrdenCompraModel;
    protected $RequisitionModel;
    protected $Cotizacion;
    protected $Catalogo;
    public function __construct(){
        $this->OrdenCompraModel=new OrdenCompraModel();
        $this->RequisitionModel=new RequisitionModel();
        $this->Catalogo=new CatalogoModel();
        $this->Cotizacion=new CotizacionModel();
    }
    public function OrdenesCompras(){
        $content=array();
        $usuario= session()->get('email');
        $rol = session()->get('rol');
        try{
            $requisiciones = $this->OrdenCompraModel->getPurchaseOrders($usuario);
            $statuspassword = $this->RequisitionModel->getStatusPassword($usuario);
            $monedas=$this->Catalogo->getMonedasSelect();
            $almacenes=$this->Catalogo->getAlmacenesSelect();
        }catch (\Exception $e) {
            return $e->getMessage();
        }
        $content['requisiciones'] = $requisiciones;
        $content['status_password'] = $statuspassword;
        $content['almacenes']=$almacenes;
        $content['monedas']=$monedas;
        $content['totalrequisiciones'] = count($requisiciones);
        //return $content;
        return view('compras.ordenescompras.ordenescompras',['content'=>$content]);
    }
    public function OrdenesComprasGetCotizaciones(){
        $resp=$this->Cotizacion->CotizacionGetAll('O','','');
        return response($resp);
    }
    public function NewOrder(){
        $content=array();
        try {
            $proveedores = $this->OrdenCompraModel->getProveedores();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        // try {
        //     $conceptos_compras = $this->OrdenCompraModel->getConceptosCompras();
        // }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        try{
            $almacenes=$this->OrdenCompraModel->getAlmacenes();
        }catch(\Exception $e){
            return $e->getMessage();
        }
        try{
            $monedas=MonedaModel::select('nombre')->get();
        }catch(\Exception $e){
            return $e->getMessage();
        }
        $content['almacenes']=$almacenes;
        $content['proveedores']=$proveedores;
        //$content['conceptos_compras']=$conceptos_compras;
        $content['monedas']=$monedas;
        return view('compras.ordenescompras.nuevaordencompra',['content'=>$content]);
    }
    public function SubmitOrdenCompra(Request $request){
        $request->validate([
            'descripcion'=>'required',
            'proveedor'=>'required',
            'almacen'=>'required',
            'moneda'=>'required',
        ]);
        $content=array();
        $response=array("status"=>false,"data"=>array());

        if ($request->getMethod()!='POST'){
            $response['data']="Not Authorized";
            return $response;
        }
        
        $post = $request->request->all();
        $proveedor=$post['proveedor'];
        $almacen=$post['almacen'];
        $descripcion=$post['descripcion'];
        $fecha=date("Y-m-d");
        $moneda=$post['moneda'];
        $usuario=session()->get('email');
        
        $result=$this->OrdenCompraModel->insertOrdenCompra($proveedor,$fecha,$usuario,$almacen,$descripcion,$moneda);
        /*$result = json_decode(json_encode($result), true);
        $id_requisicion = $result[0]['Proceso'];
        $content['id_ordencompra'] = $id_requisicion;*/
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['message']='Orden de compra Guardada';
        $response['status']=true;
        $response['data']=route('ordencompra_editar',$result);
        return $response;
    }
    public function EditOrdenCompra($id){
        $content = array();
        $usuario=session()->get('email');
        $rol=session()->get('rol');
        try {
            if ($rol == 'Administrador') {
              $result = $this->OrdenCompraModel->validateOrdenCompraid($id);
            }
            else {
                $result = $this->OrdenCompraModel->validateOrdenCompraidUsuario($id, $usuario);
            }
        }catch(\Exception $e) {
            return $e->getMessage();
        }
        try{
            $almacenes=$this->OrdenCompraModel->getAlmacenes();
        }catch(\Exception $e){
            return $e->getMessage();
        }
        $content['almacenes']=$almacenes;
        if (count($result) == 0) {
            return back();
        }
        
        $content['id_ordencompra'] = $id;
        //tomar datos de orden de compra
        try {
            $ordencompra = $this->OrdenCompraModel->getDoctoOrdenCompra($id,$usuario);
          }
          catch (\Exception $e) {
            return $e->getMessage();
          }
          $content['ordencompra'] = $ordencompra;
          //Articulo orden de compra
          try {
            $articulos_ordencompra = $this->OrdenCompraModel->getArticulosOrdenCompra($id);
            
          }
          catch (\Exception $e) {
            return $e->getMessage();
          }
      
          $content['articulos_ordencompra'] = $articulos_ordencompra;
          //articulos
        try {
            $articulos = $this->OrdenCompraModel->getArticulos($id);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
  
        $content['articulos'] = $articulos;
        try{
            $requisiciones = $this->OrdenCompraModel->getRequisiciones($usuario);
        }catch (\Exception $e) {
            return $e->getMessage();
        }
        $total=0;
        foreach($articulos_ordencompra as $ao){
            $total+=$ao->total;
        }
        $content['total']=$total;
        $content['Requisitions']=$requisiciones;
        // return $content;
        return view('compras.ordenescompras.editarordencompra', ['content' => $content]);
    }
    public function OCCentrosCostos(Request $request){
        $content = array();
         $post = $request->request->all();
         if (isset($post['term'])) {
           $term = $post['term'];
         } else {
           $term = "";
         }
         //centros de costos
         try {
           $centros_costos = $this->OrdenCompraModel->getProvsbyTerm($term);
         }
         
         catch (\Exception $e) {
           return $e->getMessage();
         }
         $content['results'] = $centros_costos;
         $content['pagination']['more'] = true;
         //return $centros_costos;
         //return $this->getResponse($content);
         return response($content);
    }
    public function NewOrdenCompraDet(Request $request){
        $usuario = session()->get('email');
        $result=array();
        $response = array("status" => false, "data" => array());
        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }

        $post = $request->request->all();
        
        $articles = json_decode($post['jsonArticles'], True);
        foreach ($articles as $article=>$value) {
            
            $cantidadd = (double)$value['cantidad'];
            $precio=0;
            if(isset($value['precio'])){
                $precio=$value['precio'];
            }

            $id_ordencompra = (int)$value['req'];

            $articulod = $value['nombre'] ;
            
            if (isset($value['nota'])) {
                $notad = $value['nota'];
            } else {
                $notad = "";
            }
            if ($cantidadd && $cantidadd>0) {
                try {
                    $result = $this->OrdenCompraModel->insertOrdenCompraDet($articulod/*, $precio*/, $cantidadd,$precio, $notad, $id_ordencompra, $usuario);
                }
                catch (\Exception $e) {
                   $response['data']=$e->getMessage();
                    //return $e->getMessage();
                    return $response;
                }


            } else{
                $response['data']="No se agregaron articulos";
                return $response;
            }



        }
        if(count($result)!=0){
            $result = json_decode(json_encode($result), true);
            if(!is_numeric($result[0]['Proceso'])){
                $response['data']=$result[0]['Proceso'];
            }else{
                $response['status']=true;
                $response['message']='Registro agregado exitosamente';
            }
        }

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


        $articuloid = (int) $post['articulo_id'];
        $compra_id = (int) $post['docto_id'];
        $result = $this->OrdenCompraModel->deleteArticuloCompra($compra_id, $articuloid, $usuario );
        if(!is_numeric($result)){
            $response['data'] = $result;
            return $response;
        }
        $response['status'] = true;
        $response['message'] = "Articulo eliminado";
        $response['data'] = "reload";
        return $response;
      //return response($result);
    }
    public function GetRequisitionCompraByType(Request $request){
        $content = array();
        $post = $request->request->all();
        $id = (int) $post['requisicion_id'];


        //articulos
        try {
          $articulos = $this->RequisitionModel->getArticulos($id);
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }

        $content['articulos'] = $articulos;



        return response($content);
    }
    public function VerCompra($id){
        $usuario = session()->get('email');
        $rol = session()->get('rol');

        try {
            $result = $this->OrdenCompraModel->validateRequisicionid($id);

        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        if (count($result) == 0) {
            return back();
        }

        $content = array();
        $content['id_compra'] = $id;


        //datos de la requisición
        try {
            $compra = $this->OrdenCompraModel->getDoctoOrdenCompra($id,$usuario);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        $content['compra'] = $compra;
        // print_r($content['requisicion'][0]->nombre);
        // die();

        //articulos de la requisición
        try {
            $articulos_compra = $this->OrdenCompraModel->getArticulosOrdenCompra($id);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        $content['articulos_compra'] = $articulos_compra;

        //articulos
        try {
            $articulos = $this->OrdenCompraModel->getArticulos($id);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        $content['articulos'] = $articulos;

        return view('compras.ordenescompras.terminarordencompra', ['content' => $content]);
    }
    public function UpdateCompra(Request $request){
        $request->validate([
            'descripcion'=>'required',
            'ordencompra_id'=>'required'
        ]);
        $response = array("status" => false);

        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }

        $post = $request->request->all();

        $descripciond = $post['descripcion'];
        $id = $post['ordencompra_id'];
        $result = $this->OrdenCompraModel->updateOrdenCompra($id, $descripciond);
        if(!is_numeric($result)){
            $response['data']=$result;
        }
        $response['status']=true;
        $response['message']='Actualizado correctamente';
        return $response;

    }
    public function AgregarRequisition(Request $request){
        $request->validate([
            'doctos_ids'=>'required',
            'proveedor'=>'required',
            'lugar_entrega'=>'required',
            'moneda'=>'required',
            'familia_articulos'=>'required'
        ]);
        $usuario = session()->get('email');
        $response= array("status"=>false,"data"=>array());
        $requisiciones=$request->doctos_ids;
        $proveedor=$request->proveedor;
        $lugar_entrega=$request->lugar_entrega;
        $moneda=$request->moneda;
        $familia=$request->familia_articulos;
        $result=$this->OrdenCompraModel->InsertRequisicionOrdenCompra($requisiciones,$proveedor,$lugar_entrega,$moneda,$familia,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['message']='Orden de compra Guardada';
        $response['status']=true;
        $response['data']=route('ordencompra_editar',$result);
        return $response;
    }
    public function OrdenesComprasDesdeCotizacion(Request $request){
        $request->validate([
            'doctos_ids'=>'required',
            'lugar_entrega'=>'required',
        ]);
        $usuario = session()->get('email');
        $response= array("status"=>false,"data"=>array());
        $idcotizacion=(int) $request->doctos_ids;
        $lugar_entrega=$request->lugar_entrega;
        $result=$this->OrdenCompraModel->InsertCotizacionOrdenCompra($idcotizacion,$lugar_entrega,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['message']='Orden de compra Guardada';
        $response['status']=true;
        $response['data']=route('ordencompra_editar',$result);
        return $response;
    }
    public function AppOrdenCompra(Request $request){
        $request->validate([
            'id'=>'required',
            'jsonArticles'=>'required',
        ]);
        $usuario=session()->get('email');
        $response= array("status"=>false,);
        if($request->getMethod()!='POST'){
            $response['data']="Not Authorized";
            return $response;
        }
        $post=$request->request->all();
        $id=(int) $post['id'];
        $articulos=json_decode($post['jsonArticles'],true);
        $articulosstr='';
        foreach($articulos as $item => $value){
            $prec='0';
            if(isset($value['precio'])){
                $prec=$value['precio'];
            }
            $cant='0';
            if(isset($value['cantidad'])){
                $cant=$value['cantidad'];
            }
            if( $cant != '0' ){
                $articulosstr .= $value['articulo_id'].','.
                    $cant.','.
                    $prec;
                if($item != array_key_last($articulos)){
                    $articulosstr.=',';
                }
            }
        }
        // $response['data']=$articulosstr;
        // return $response;
        $result=$this->OrdenCompraModel->aplicarOrdenCompra($id,$articulosstr,$usuario);

        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['doctoid_mail']=$result;
        $response['data']=route('ordenescompras');
        return $response;
    }
    public function SendEmail(Request $request){
        $response = array("status" => false, "data" => array());

        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
       
        $post = json_decode($request->request->all()['jsonData'],true);
        $id = (int) $post['docto_id'];
        $usuario=session()->get('email');
        $content = array();
        $content = $this->getOrdenCompraData($id,$usuario);
        
        $content['id_ordencompra']=$id;
        $email=$this->OrdenCompraModel->getEmailToAutjOrdenCompra($id);
        $email=$email[0]->correo_notificacion;
        $list_email=explode(",",$email);
        $content['datamail'] = [
            'email'=>$list_email,
            'subject'=>'Nueva Orden de Compra a Autorizar',
            'bodyMessage'=>'prueba',
        ];
        $content['datamail']=array(
            'email'=>$list_email,
            'subject'=>'Nueva Orden de Compra a Autorizar',
            'bodyMessage'=>'prueba',
        );
        //$response['data']=$content['datamail']['subject'];
        //return $content;
        try{
            //return view('ordenescompras.email',['content'=>$content]);
            Mail::send('compras.ordenescompras.email',['content'=>$content],function($message) use ($content){
                $message->from('ordenescompras@megafreshproduce.com.mx','Ordenes Compra Mega Fresh Produce');
                $message->to($content['datamail']['email']);
                $message->subject($content['datamail']['subject']);
                //$message->to($dtmail['email'])->subject($dtmail['subject']);
            });
        }catch(\Exception $e){
            $response['data']=$e->getMessage();
            return $response;
        }
        $response['data']="Correo enviado exitosamente";
        return response($response);
    }
    public function EmailView($id){
        $content = array();
        $content = $this->getOrdenCompraData($id,"email");
        //return $content;
        return view('compras.ordenescompras.email',['content'=>$content]);
    }
    public function getOrdenCompraData($id,$usuario){
        $content=array();
        $content['id_ordencompra']=$id;

        try{
            $ordencompra=$this->OrdenCompraModel->getDoctoOrdenCompra($id,$usuario);
            $articulos_ordencompra=$this->OrdenCompraModel->getArticulosOrdenCompra($id);
        }catch(\Exception $e){
            return $e->getMessage();
        }
        $content['ordencompra']=$ordencompra;
        try{
            
        }catch(\Exception $e){
            return $e->getMessage();
        }
        $content['articulos_ordencompra']=$articulos_ordencompra;
        return $content;
    }
    public function AutorizaOrdenCompra($id){
        $usuario=session()->get('email');
        $rol=session()->get('rol');
        try{
            if($rol=='Administrador'){
                $result=$this->OrdenCompraModel->validateOrdenCompraid($id);
            }else{
                $result=$this->OrdenCompraModel->validateOrdenCompraidUsuario($id,$usuario);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
        if(count($result)==0){
            return back();
        }
        $content=array();
        $content['id_ordencompra']=$id;
        try{
            $ordencompra=$this->OrdenCompraModel->getDoctoOrdenCompra($id,$usuario);
        }catch(\Exception $e){
            return $e->getMessage();
        }
        $content['ordencompra']=$ordencompra;
        try{
            $articulos_ordencompra=$this->OrdenCompraModel->getArticulosOrdenCompra($id);
        }catch(\Exception $e){
            return $e->getMessage();
        }
        $content['articulos_ordencompra']=$articulos_ordencompra;
        try{
            $articulos=$this->OrdenCompraModel->getArticulos($id);
        }catch(\Exception $e){
            return $e->getMessage();
        }
        $content['articulos']=$articulos;
        return view('compras.ordenescompras.autorizaordencompra',['content'=>$content]);
    }
    public function AuthOrdenCompra(Request $request){
        $response=array('status'=>false);
        if($request->getMethod()!='POST'){
            $response['data'] = "Not Authorized";   
            return $response;
        }
        $post=json_decode($request->request->all()['jsonData'],true);
        $id=$post['docto_id'];
        $usuario=session()->get('email');
        $result=$this->OrdenCompraModel->autorizaOrdencompra($id,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('ordenescompras');
        return $response;
    }
    public function CancelOrdenCompra(Request $request){
        $request->validate([
            'descripcion'=>'required',
            'ordencompra_id'=>'required'
        ]);
        $response=array('status'=>false);
        if($request->getMethod()!='POST'){
            $response['data']="Not Authorized";
            return $response;
        }
        
        $result=array();
        $post=$request->request->all();
        //return $post['descripcion'];
        $id=$post['ordencompra_id'];
        $descripcion=$post['descripcion'];
        $usuario=session()->get('email');
        $result = $this->OrdenCompraModel->cancelaOrdenCompra($id, $usuario, $descripcion);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['message']='Orden de compra cancelada';
        $response['status']=true;
        $response['data']=route('ordenescompras');
        return $response;
    }
    public function PDFView($id){
        $usuario=session()->get('email');
        $rol=session()->get('rol');
        $content=array();
        $content=$this->getOrdenCompraData($id,$usuario);
        //return $content;
        //$pdf=PDF::loadView('compras.ordenescompras.pdf',['content'=>$content])->setPaper('a4');
        $pdf=$this->Catalogo->PDFView($content,'compras.ordenescompras.pdf');
        return $pdf->stream();
    }
    public function PDFViewAuth($id){
        $usuario=session()->get('email');
        $rol=session()->get('rol');
        $content=array();
        $content=$this->getOrdenCompraData($id,$usuario);
        //$pdf=PDF::loadView('compras.ordenescompras.emailautorizado',['content'=>$content])->setPaper('a4');
        $pdf=$this->Catalogo->PDFView($content,'compras.ordenescompras.emailautorizado');
        return $pdf->stream();
    }
    public function SendEmailPDFAuth(Request $request){
        $response = array("status" => false, "data" => array());
        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
     
        $post = json_decode($request->request->all()['jsonData'],true);
        $id = (int) $post['docto_id'];
        $usuario=session()->get('email');
        $content = array();
     
        $content = $this->getOrdenCompraData($id,$usuario);
        $content['id_ordencompra'] = (int)$id;
     
        $email = $content['ordencompra'][0]->email;
        $folio = $content['ordencompra'][0]->folio;
        $list_email = explode(",",$email);
        // $pdf = $this->PDFView($id);
        //Datos del email
        $content['datamail'] = [
            //'email'=>'jfsayeg@megafreshproduce.com.mx',
            'email'=>$list_email,
            'subject'=>'Orden de Compra autorizada '. $folio,
            'bodyMessage'=>'Prueba pdf',
            ];
        
        //Enviar el mail
        try {
            $mail = Mail::send('compras.ordenescompras.emailautorizado', ['content' => $content],function($message) use ($content){
                $message->from('ordenenscompras@megafreshproduce.com.mx', 'Ordenens Compras Mega Fresh Produce');
                $message->to($content['datamail']['email']);
                $message->subject($content['datamail']['subject']);
                // $message->attach('http://www.megafreshproduce.com.mx/erp-web/requisicion/pdf/218', array(
                //            'as' => 'requisicion.pdf',
                //            'mime' => 'application/pdf')
                //            );
            });
        }catch (\Exception $e) {
            $response['data']=$e->getMessage();
            //return $e->getMessage();
            return $response;
        }
        //$response['status']=true;
        $response['data'] = "Correo enviado exitosamente";
        return $this->getResponse($response);
    }
    public function getArticulos(){
        try {
            $articulos = $this->OrdenCompraModel->getArticulos("");
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        //return response()->json($articulos);
        return json_encode($articulos);
    }
    public function getRequisicionesparaordenes(){
        try {
            $articulos = $this->OrdenCompraModel->getRequisiciones("");
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        // return response()->json($articulos);
        return json_encode($articulos);
    }
    public function getResponse($data) {
        $response = new Response(json_encode($data), 200, array('Content-Type', 'text/json'));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, *');
        return $response;
    }
}
