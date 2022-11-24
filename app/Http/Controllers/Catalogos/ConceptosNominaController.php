<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatalogosFunciones\ConceptoNominaModel;
use Illuminate\Http\Request;

class ConceptosNominaController extends Controller
{
    protected $ConceptoNomina;
    public function __construct()
    {
        $this->ConceptoNomina=new ConceptoNominaModel();
    }
    public function index(){
        $conceptos=$this->ConceptoNomina->getAll();
        $content['conceptos']=$conceptos;
        return view('catalogos.conceptos_nom.conceptos',['content'=>$content]);
        return $conceptos;
    }
    public function conceptoNominaStore(Request $request){
        $request->validate([
            'nombre'=>'required',
            'nombre_corto'=>'required',
            'clave'=>'required',
            'naturaleza'=>'required',
            'clave_fiscal'=>'required',
            'id_interno'=>'required',
            'tipo_calculo'=>'required',
            'tipo_proceso'=>'required',
        ]);
        $response=array('status'=>false);
        //$response['data']=$request->all();
        $datos=array($request->nombre,$request->nombre_corto,$request->clave,$request->naturaleza
                        ,$request->clave_fiscal,$request->id_interno,$request->tipo_calculo
                        ,$request->tipo_proceso,$request->periodico_nuevos_empleados
                        ,session()->get('email'));
        $result=$this->ConceptoNomina->conceptoNominaStore($datos);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('conceptos_nomina_edit',$result);
        $response['message']="Concepto agregado";
        return $response;
    }
    public function conceptoNominaEditar($id){
        $data['concepto_nomina']=$this->ConceptoNomina->getDataConcepto($id);
        // $data=$this->EmpleadoModel->getEMpleadoData([$id]);
        // $data['entidades']=$this->Catalogos->getEntidades();
        // $data['tipos_contratos']=$this->EmpleadoModel->getTiposContratos();
        // $data['registros_patronales']=$this->EmpleadoModel->getRegistrosPatronales();
        // $data['regimen_fiscales']=$this->EmpleadoModel->getRegimenFiscales();
        // $data['frecuencias_pago']=$this->EmpleadoModel->getFrecuenciasPago();
        //$data['puestos']=$this->EmpleadoModel->getPuestoa();
        //$data['departamentos']=$this->EmpleadoModel->getDepartamentos();
        return view('catalogos.conceptos_nom.editar',['content'=>$data]);
        return $data;
    }
    public function conceptoNominaUpdate(Request $request){
        $request->validate([
            'id_concepto'=>'required',
            'tipo_calculo'=>'required',
            'tipo_proceso'=>'required',
        ]);
        $response=array('status'=>false);
        //$response['data']=$request->all();
        $datos=array($request->id_concepto,$request->tipo_calculo
                        ,$request->tipo_proceso,$request->periodico_nuevos_empleados
                        ,$request->funcion,session()->get('email'));
        $result=$this->ConceptoNomina->conceptoNominaUpdate($datos);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['data']=route('conceptos_nomina_edit',$result);
        $response['message']="Concepto actualizado";
        return $response;
    }
    public function getTiposConceptosSat(Request $request){
        $post=$request->all();

        $tipo='P';
        // $result=$this->ConceptoNomina->getTiposConceptosSat($tipo,'');
        $result=$post;
        return response($result);
    }
}
