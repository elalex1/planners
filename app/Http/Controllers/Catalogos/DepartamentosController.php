<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatalogosFunciones\DepartamentoModel;
use Illuminate\Http\Request;

class DepartamentosController extends Controller
{
    protected $Departamento;
    public function __construct()
    {
        $this->Departamento=new DepartamentoModel();
    }
    public function index(){
        $datos=$this->Departamento->getAll();
        $content['departamentos']=$datos;
        //return $content;
        return view('catalogos.departamentos.index',['content'=>$content]);
    }
    public function DepartamentosStore(Request $request){
        $request->validate([
            'nombre'=>'required',
            'centro_costo'=>'required',
        ]);
        $post=$request->except('_token');
        $nombre=$post['nombre'];
        $centro_costo=$post['centro_costo'];
        $usuario=session()->get('email');
        $result=$this->Departamento->FrecuenciaNominaStore($nombre,$centro_costo,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Departamento agragado";
        $response['data']='reload';
        return $response;
    }
    public function DepartamentosEdit($id){
        $datos=$this->Departamento->FrecuenciaNominaGetById($id);
        $content['departamento']=$datos;
        return $content;
    }
}
