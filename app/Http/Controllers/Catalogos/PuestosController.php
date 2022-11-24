<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatalogosFunciones\PuestoModel;
use Illuminate\Http\Request;

class PuestosController extends Controller
{
    protected $Puesto;
    public function __construct()
    {
        $this->Puesto=new PuestoModel();
    }
    public function index(){
        $datos=$this->Puesto->getAll();
        $content['puestos']=$datos;
        return view('catalogos.puestos.index',['content'=>$content]);
    }
    public function PuestoStore(Request $request){
        $request->validate([
            'nombre'=>'required',
        ]);
        $post=$request->except('_token');
        $nombre=$post['nombre'];
        $usuario=session()->get('email');
        $result=$this->Puesto->PuestoStore($nombre,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Puesto agragado";
        $response['data']='reload';
        return $response;
    }
}
