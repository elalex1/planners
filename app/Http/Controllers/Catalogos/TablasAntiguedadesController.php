<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTablaAntigDet;
use App\Models\CatalogosFunciones\TablaAntiguedadModel;
use Illuminate\Http\Request;

class TablasAntiguedadesController extends Controller
{
    protected $TablaAntiguedad;
    public function __construct()
    {
        $this->TablaAntiguedad= new TablaAntiguedadModel();
    }
    public function index(){
        $tablas=$this->TablaAntiguedad->getAll();
        $content['tablas_antiguedades']=$tablas;
        //return $tablas;
        return view('catalogos.tablas_antiguedad.index',['content'=>$content]);
    }
    public function TablaAntiguedadStore(Request $request){
        $request->validate([
            'nombre'=>'required',
            'nombre_corto'=>'required',
        ]);
        $response=array('status'=>false);
        $post=$request->all();
        $nombre=$post['nombre'];
        $nombre_corto=$post['nombre_corto'];
        $usuario=session()->get('email');
        $result=$this->TablaAntiguedad->StoreTablaAnt($nombre,$nombre_corto,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Tabla agregada";
        $response['data']=route('tablas_antiguedades_edit',$result);
        return $response;
    }
    public function TablaAntiguedadEditar($id){
        $tabla=$this->TablaAntiguedad->getData($id);
        //return $tabla;
        return view('catalogos.tablas_antiguedad.editar',['content'=>$tabla]);
    }
    public function TablaAntiguedadAddRow(StoreTablaAntigDet $request){
        $response=array('status'=>false);
        $post=$request->all();
        $dias_antiguedad=$post['dias_antiguedad'];
        $anios_antiguedad=$post['anios_antiguedad'];
        $anios_antiguedad_imss=$post['anios_antiguedad_imss'];
        $dias_aguinaldo=$post['dias_aguinaldo'];
        $dias_vacaciones=$post['dias_vacaciones'];
        $dias_prima_vacacional=$post['dias_prima_vacacional'];
        $id_tabla=$post['id_tabla'];
        $usuario=session()->get('email');
        $result=$this->TablaAntiguedad->TablaAntAddRenglon($id_tabla,$dias_antiguedad,$anios_antiguedad,$anios_antiguedad_imss,$dias_aguinaldo,$dias_vacaciones,$dias_prima_vacacional,$usuario);
        if(!is_numeric($result)){
            $response['data']=$result;
            return $response;
        }
        $response['status']=true;
        $response['message']="Renglon agregado";
        $response['data']='reload';
        return $response;
    }
    public function TablaAntiguedadDeleteRow(Request $request){
        $request->validate([
            'id_tabla'=>'required',
            'id_tabla_det'=>'required',
        ]);
        $response=array('status'=>false);
        $post=$request->all();
        $id_tabla=$post['id_tabla'];
        $id_tabla_det=$post['id_tabla_det'];
        $usuario=session()->get('email');
        $result=$this->TablaAntiguedad->TablaAntDeleteRenglon($id_tabla,$id_tabla_det,$usuario);
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
