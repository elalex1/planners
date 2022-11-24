<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\CatalogoModel;
use App\Models\Compras\CotizacionModel;
use Exception;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PDF;

class CotizacionesController extends Controller
{
    protected $CotizacionModel;
    protected $CatalogoModel;
    public function __construct()
    {
        $this->CotizacionModel=new CotizacionModel();
        $this->CatalogoModel=new CatalogoModel();
    }
    public function CotizacionGetAll(){
        $data['cotizaciones']=$this->CotizacionModel->CotizacionGetAll('T','','');
        if(is_string($data['cotizaciones'])){
            $data['error']=$data['cotizaciones'];
            $data['previous_url']=url()->current();
            return view('error',['data'=>$data]);
        }
        $data['monedas']=$this->CatalogoModel->getMonedasSelect();
        //return $data;
        return view('compras.cotizacion.cotizacion',['data'=>$data]);
    }
    public function CotizacionNew(){
        $data['monedas']=$this->CatalogoModel->getMonedasSelect();
        return view('compras.cotizacion.nuevacotizacion',['data'=>$data]);
    }
    public function CotizacionStore(Request $request){
        $request->validate([
            'proveedor'=>'required',
            'moneda'=>'required',
        ]);
        $post=$request->request->all();
        $response=array('status'=>false);
        if ($request->getMethod()!='POST'){
            $response['data']="Not Authorized";
            return $response;
        }
        $usuario=session()->get('email');
        $proveedor=$post['proveedor'];
        $moneda=$post['moneda'];
        $resp=$this->CotizacionModel->CotizacionStore($proveedor,$moneda,$usuario);
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        //$response['data']=$usuario."<>".$proveedor."<>".$moneda;
        $response['status']=true;
        $response['message']='Cotización guardada';
        $response['data']=route('cotizaciones_editar',$resp);
        return $response;
    }
    public function EditCotizacion($id){
        // Crypt::encrypt($id);
        // $id=Crypt::decrypt($id);
        // $prevurl=redirect()->getUrlGenerator()->previous();
        // $home=route('cotizaciones_all');
        // $newcot=route('cotizaciones_nueva');
        // if($prevurl != $home && $prevurl != $newcot){
        //     return 'no auth';
        // }
        $usuario=session()->get('email');
        $data=$this->CotizacionModel->GetDataDocto($id,$usuario);
        //return $data;
        return view('compras.cotizacion.editarcotizacion',['data'=>$data]);
    }
    public function VerCotizacion($id){
        $id=Crypt::decrypt($id);
        $usuario=session()->get('email');
        $data=$this->CotizacionModel->GetDataDocto($id,$usuario);
        //return $data;
        return view('compras.cotizacion.ver',['data'=>$data]);
    }
    public function CotizacionAddArticles(Request $request){
        $response=array('status'=>false);
        $articulos=$request->all();
        $articulos=json_decode($articulos['jsonArticles'],true);
        $usuario=session()->get('email');
        $error=0;
        $items=0;
        foreach($articulos as $art){
            //$items++;
            $cantidad=$art['cantidad'];
            $cotizacion_id=$art['doctoid'];
            $precio=$art['precio'];
            $articulo=$art['articulo'];
            $articulo=str_replace("\r\n","",$articulo);
            $resp=$this->CotizacionModel->AddRenglon($cotizacion_id,$cantidad,$precio,$articulo,$usuario);
            // $response['data']=$cantidad."<>".$cotizacion_id."<>".$precio."<>".$articulo."<>".$usuario;
            if(!is_numeric($resp)){
                // $data['errors'][$error]=$resp;
                // $error ++;
                $response['data']=$resp;
                return $response;
            }
        }
        $response['status']=true;
        $response['message']='Articulos agregados';
        $response['data']='reload';
        return $response;
    }
    public function CotizacionRemoveArticles(Request $request){
        $response=array('status'=>false);
        if ($request->getMethod()!='DELETE'){
            $response['data']="Not Authorized";
            return $response;
        }
        $request->validate([
            'articulo_id'=>'required',
            'docto_id'=>'required',
        ]);
        $usuario=session()->get('email');
        $articuloid=$request->articulo_id;
        $doctoid=$request->docto_id;
        $resp=$this->CotizacionModel->DeleteRenglon($doctoid,$articuloid,$usuario);
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['data']='reload';
        $response['message']='articulo eliminado';
        $response['status']=true;
        return $response;
    }
    public function CotizacionFinalizar(Request $request){
        $response=array('status'=>false);
        if ($request->getMethod()!='POST'){
            $response['data']="Not Authorized";
            return $response;
        }
        $request->validate([
            'docto_id'=>'required',
        ]);
        $usuario=session()->get('email');
        $doctoid=$request->docto_id;
        $resp=$this->CotizacionModel->FinalizarDocto($doctoid,$usuario);
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['data']=route('cotizaciones_all');
        $response['message']='cotización finalizada';
        $response['status']=true;
        return $response;
    }
    public function CotizacionAddRequs(Request $request){
        $response=array('status'=>false);
        if ($request->getMethod()!='POST'){
            $response['data']="Not Authorized";
            return $response;
        }
        $request->validate([
            'doctos_ids'=>'required',
            'proveedor'=>'required',
            'moneda'=>'required',
            'familia_erticulos'=>'required',
        ]);
        $usuario=session()->get('email');
        $requisiciones=$request->doctos_ids;
        $proveedor=$request->proveedor;
        $moneda=$request->moneda;
        $familia=$request->familia_erticulos;
        //$response['data']=$usuario."<>".$requisiciones."<>".$proveedor."<>".$moneda;
        //$response['data']=$usuario;
        //return $response;
         $resp=$this->CotizacionModel->CotizacionAddRequs($requisiciones,$proveedor,$moneda,$familia,$usuario);
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['data']=route('cotizaciones_editar',$resp);
        $response['message']='cotización creada';
        $response['status']=true;
        return $response;
    }
    public function GetContactosProv(Request $request){
        $proveedor=$request->proveedor;
        if(!isset($request['proveedor'])){
            $proveedor='';
        }
        $resp=$this->CotizacionModel->GetContactosProv($proveedor);
        return response($resp);
    }
    public function SendEmailProv(Request $request){
        $response = array("status" => false);

        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
       
        $post = json_decode($request->request->all()['jsonData'],true);
        foreach($post as $item){
            $id = (int) $item['cotizacion'];
            $correo=$item['correo'];
            $contacto=$item['contacto'];
            $usuario=session()->get('email');
            $content = array();
            $content = $this->CotizacionModel->GetDataDocto($id,$usuario);
            //$content['compraDet']= $this->CotizacionModel->GetDataDocto($id,$usuario)['compraDet'];
            $content['id_cotizacion']=$id;
            $desde='pruebasCompras@megafreshproduce.com.mx';
            $usuarioEnvia='Compras Mega Fresh Produce new';
            $content['datamail']=array(
                'email'=>$correo,
                'subject'=>'Cotización',
                'bodyMessage'=>'prueba',
                'contacto'=>$contacto,
                'desde'=>$desde,
                'usuario_envia'=>$usuarioEnvia,
            );
            $resp=$this->CatalogoModel->SendEmail('compras.cotizacion.email',$content);
            if(!$resp['status']){
                $response['data']=$resp['data'];
                return $response;
            }
        }
        $response['status']=true;
        $response['message']='Correo Enviado con exito';
        return $response;
    }
    public function CotizacionCancelar(Request $request){
        $response = array("status" => false);

        if ($request->getMethod() != 'POST') {
            $response['data'] = "Not Authorized";
            return $response;
        }
        $post=$request->request->all();
        $post = json_decode($post['jsonData'],true);
        $usuario=session()->get('email');
        $cotizacionid=$post['docto_id'];
        //$response['data']=$usuario."<>".$cotizacionid;
        $resp=$this->CotizacionModel->CotizacionCancelar($cotizacionid,$usuario);
        if(!is_numeric($resp)){
            $response['data']=$resp;
            return $response;
        }
        $response['data']='reload';
        $response['message']='cotización Cancelada';
        $response['status']=true;
        return $response;
    }
    public function CotizacionPDF($id){
        try{
            $id=Crypt::decrypt($id);
        }catch(Exception $e){
            return "Not Authorized";
        }
        $data=$this->CotizacionModel->getDataDoctoPDF($id);
        if(is_string($data)){
            return $data;
        }
        $data['titulo_docto']=$data['docto']->folio.'-Cotización';
        $pdf=$this->CatalogoModel->PDFView($data,"compras.cotizacion.pdf");
        if(is_string($pdf)){
            return $pdf;
        }
        return $pdf->stream();
    }
}
