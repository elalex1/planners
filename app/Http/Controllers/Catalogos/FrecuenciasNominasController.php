<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatalogosFunciones\FrecuenciaNominaModel;
use Illuminate\Http\Request;

class FrecuenciasNominasController extends Controller
{
    protected $FrecuenciaNomina;
    public function __construct()
    {
        $this->FrecuenciaNomina = new FrecuenciaNominaModel();
    }
    public function index(){
        $frecuencias=$this->FrecuenciaNomina->getAll();
        $content['frecuencias_nominas']=$frecuencias;
        return view('catalogos.frecuencias_nominas.index',['content'=>$content]);;
    }
    public function FrecuenciaNominaStore(Request $request){
        $request->validate([
            'nombre'=>'required',
            'nombre_corto'=>'required',
            'clave_fiscal'=>'required',
            // 'calcula_septimo_dia'=>'required',
            'dias_periodo'=>'required',
            'dias_trabajador'=>'required',
            'dias_septimo'=>'required',
            'tipo_calculo_impuesto'=>'required',
            // 'devolver_isr'=>'required',
            'tipo_calculo_nomina'=>'required',
            'forma_calculo'=>'required',
        ]);
        $response=array('status'=>false);
        $post=$request->except('_token');
        $nombre=$post['nombre'];
        $nombre_corto=$post['nombre_corto'];
        $clave_fiscal=$post['clave_fiscal'];
        if(isset($post['calcula_septimo_dia'])){
            $calcula_septimo_dia=$post['calcula_septimo_dia'];
        }else{
            $calcula_septimo_dia='N';
        }
        $dias_periodo=$post['dias_periodo'];
        $dias_trabajador=$post['dias_trabajador'];
        $dias_septimo=$post['dias_septimo'];
        $tipo_calculo_impuesto=$post['tipo_calculo_impuesto'];
        if(isset($post['devolver_isr'])){
            $devolver_isr=$post['devolver_isr'];
        }else{
            $devolver_isr='N';
        }
        $tipo_calculo_nomina=$post['tipo_calculo_nomina'];
        $forma_calculo=$post['forma_calculo'];
        $usuario=session()->get('email');
        $result=$this->FrecuenciaNomina->FrecuenciaNominaStore($nombre,$nombre_corto,$clave_fiscal,$calcula_septimo_dia,$dias_periodo,$dias_trabajador,$dias_septimo,$tipo_calculo_impuesto,$devolver_isr,$tipo_calculo_nomina,$forma_calculo,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Frecuencia nomina agregada";
        $response['data']=route('frecuenciasnominas_edit',$result);
        return $response;
    }
    public function FrecuenciaNominaStoreGetData($id){
        $datos=$this->FrecuenciaNomina->FrecuenciaNominaStoreGetData($id);
        $content['frecuencia_nomina']=$datos;
        return view('catalogos.frecuencias_nominas.editar',['content'=>$content]);
    }
}
