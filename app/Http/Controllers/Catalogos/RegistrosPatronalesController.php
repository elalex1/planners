<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatalogosFunciones\RegistroPatronalModel;
use Illuminate\Http\Request;

class RegistrosPatronalesController extends Controller
{
    protected $RegistroPatronal;
    public function __construct()
    {
        $this->RegistroPatronal = new RegistroPatronalModel();
    }
    public function index(){
        $registrospatronales=$this->RegistroPatronal->getAll();
        $content['registros_patronales']=$registrospatronales;
        return view('catalogos.registros_patronales.index',['content'=>$content]);
        return $registrospatronales;
    }
    public function RegistroPatronalStore(Request $request){
        $request->validate([
            'nombre'=>'required',
            'nombre_corto'=>'required',
            'registro_patronal'=>'required',
            'clase'=>'required',
            'clasificador_antiguedad'=>'required',
        ]);
        $response=array('status'=>false);
        $post=$request->all();
        $nombre=$post['nombre'];
        $nombre_corto=$post['nombre_corto'];
        $registro_patronal=$post['registro_patronal'];
        $clase=$post['clase'];
        $clasificador_antiguedad=$post['clasificador_antiguedad'];
        $usuario=session()->get('email');
        //$response['data']= $nombre."<>".$nombre_corto."<>".$registro_patronal."<>".$clase."<>".$clasificador_antiguedad."<>".$usuario;
        $result=$this->RegistroPatronal->RegistroPatronalNew($nombre,$nombre_corto,$registro_patronal,$clase,$clasificador_antiguedad,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Renglon agregado";
        $response['data']=route('registrospatronales_edit',$result);
        return $response;
    }
    public function RegistroPatronalEdit($id){
        $datos=$this->RegistroPatronal->RegistroPatronalEdit($id);
        //$content['registro_patronal']=$datos;
        return view('catalogos.registros_patronales.editar',['content'=>$datos]);
    }
    public function RegistroPatronalAddRiesgo(Request $request){
        $request->validate([
            'id_registro_patronal'=>'required',
            'riesgo'=>'required',
            'fecha_inicio'=>'required',
            'fecha_fin'=>'required',
        ]);
        $response=array('status'=>false);
        $post=$request->all();
        $id_registro_patronal=$post['id_registro_patronal'];
        $riesgo=$post['riesgo'];
        $fecha_inicio=$post['fecha_inicio'];
        $fecha_fin=$post['fecha_fin'];
        $usuario=session()->get('email');
        $result=$this->RegistroPatronal->RegistroPatronalAddRiesgo($id_registro_patronal,$riesgo,$fecha_inicio,$fecha_fin,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Renglon agregado";
        $response['data']='reload';
        return $response;
    }
    public function RegistroPatronalDeleteRiesgo(Request $request){
        $request->validate([
            'id_registro_patronal'=>'required',
            'prima_riego_id'=>'required',
        ]);
        $response=array('status'=>false);
        $post=$request->all();
        $id_registro_patronal=$post['id_registro_patronal'];
        $prima_riego_id=$post['prima_riego_id'];
        $usuario=session()->get('email');
        $result=$this->RegistroPatronal->RegistroPatronalDeleteRiesgo($id_registro_patronal,$prima_riego_id,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Renglon eliminado";
        $response['data']='reload';
        return $response;
    }
}
