<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatalogosFunciones\TipoContratoModel;
use Illuminate\Http\Request;

class TiposContratosController extends Controller
{
    protected $TipoContrato;
    public function __construct()
    {
        $this->TipoContrato = new TipoContratoModel();
    }
    public function index(){
        $tiposcontratos=$this->TipoContrato->getAll();
        $content['tipos_contartos']=$tiposcontratos;
        //return $content;
        return view('catalogos.tipos_contratos.index',['content'=>$content]);
    }
    public function TipoContratoStore(Request $request){
        $request->validate([
            'nombre'=>'required',
            'nombre_corto'=>'required',
            'clave_fiscal'=>'required',
        ]);
        $response=array('status'=>false);
        $post=$request->except('_token');
        $nombre=$post['nombre'];
        $nombre_corto=$post['nombre_corto'];
        $clave_fiscal=$post['clave_fiscal'];
        $usuario=session()->get('email');
        $result=$this->TipoContrato->TipoContratoStore($nombre,$nombre_corto,$clave_fiscal,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Registro agregado";
        $response['data']='reload';
        return $response;
    }
    public function TipoContratoUpdate(Request $request){
        $request->validate([
            'id_tipocontrato'=>'required',
        ]);
        $response=array('status'=>false);
        $post=$request->except('_token');
        $id_tipocontrato=$post['id_tipocontrato'];
        $usuario=session()->get('email');
        $result=$this->TipoContrato->TipoContratoEliminar($id_tipocontrato,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Registro actualizado";
        if($result=0){
            $response['message']="Registro elimunado";
        }
        $response['data']='reload';
        return $response;
    }
}
