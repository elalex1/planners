<?php



namespace App\Http\Controllers\Catalogos;



use App\Http\Controllers\Controller;

use App\Http\Requests\StoreEmpleado;

use App\Http\Requests\StoreUpdateEmpleado;

use App\Http\Requests\UpdateEmpleado;

use App\Models\CatalogoModel; 

use App\Models\CatalogosFunciones\EmpleadoModel;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use PhpParser\Node\Stmt\Return_;

use App\Http\Controllers\UploadController;

use Rap2hpoutre\FastExcel\FastExcel;



class EmpleadosController extends Controller

{

    protected $EmpleadoModel;

    protected $Catalogos;

    public function __construct()

    {

        $this->EmpleadoModel= new EmpleadoModel();

        $this->Catalogos=new CatalogoModel();

    }

    public function getAll(){

        $data= $this->EmpleadoModel->getEmpleados();

        return response($data);

    }

    public function index()

    {

        $data['empleados']= $this->EmpleadoModel->getEmpleados();

        $data['entidades']=$this->Catalogos->getEntidades();

        return view('catalogos.empleados.empleados',['content'=>$data]); 

        return $data;

        $content=array();

        try{

            $empleados=$this->EmpleadoModel->getEmpleados();

        }catch(\Exception $e){

            return $e->getMessage();

        }

        try{

            $estados=$this->EmpleadoModel->getEstados();

        }catch(\Exception $e){

            return $e->getMessage();

        }

        try{

            $municipios=$this->EmpleadoModel->getMunicipios();

        }catch(\Exception $e){

            return $e->getMessage();

        }

        try{

            $departamentos=$this->EmpleadoModel->getDepartamentos();

        }catch(\Exception $e){

            return $e->getMessage();

        }

        try{

            $puestos=$this->EmpleadoModel->getPuestos();

        }catch(\Exception $e){

            return $e->getMessage();

        }

        /*$empleados =Empleado::select('empleado_id','nombre','paterno','materno')->where('estatus','A')->get();

        $rows=count($empleados,COUNT_RECURSIVE);

        if($rows>0){

            $numero=1;

        }else{

            $numero=0;

        }*/

        $content['empleados']=$empleados;

        $content['estados']=$estados;

        $content['municipios']=$municipios;

        $content['departamentos']=$departamentos;

        $content['puestos']=$puestos;

        return $content;

        return view('catalogos.empleados.empleados',['content'=>$content]);       

    }

    public function empleadoStore(StoreEmpleado $request){

        $response=array('status'=>false);

        //$numeroempleadod, $paternod, $maternod, $nombred, $rfcd, $curpd, $fechanacimientod, $nssd, $fechaaltad, $puestod, $departamentod, $rpd, $usuario

        $data= $request->all();

        $datos=array(

            0

            ,$data['paterno']

            ,$data['materno']

            ,$data['nombre']

            ,$data['rfc']

            ,$data['curp']

            ,$data['fecha_nacimiento']

            ,$data['nss']

            ,$data['fecha_alta']

            ,$data['puesto']

            ,$data['departamento']

            ,''

            ,session()->get('email')

        );

        $result=$this->EmpleadoModel->EmpleadoStore($datos);

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['data']=route('empleados_edit',$result);

        $response['message']='Empleado Agregado con exito';

        return $response;

    }

    public function empleadoEdit($id){

        $data=$this->EmpleadoModel->getEMpleadoData([$id]);

        //return $data;

        $data['entidades']=$this->Catalogos->getEntidades();

        //return $data;

        $data['tipos_contratos']=$this->EmpleadoModel->getTiposContratos();

        $data['registros_patronales']=$this->EmpleadoModel->getRegistrosPatronales();

        /*$data['regimen_fiscales']=$this->EmpleadoModel->getRegimenFiscales();*/

        $data['frecuencias_pago']=$this->EmpleadoModel->getFrecuenciasPago();

        $data['tablas_antiguedades']=$this->EmpleadoModel->getTablasAntiguedades();

        //$data['puestos']=$this->EmpleadoModel->getPuestoa();

        //$data['departamentos']=$this->EmpleadoModel->getDepartamentos();

        return view('catalogos.empleados.edit',['data'=>$data]);

        return view('catalogos.empleados.editarempleado',['data'=>$data]);

        return $data;

    }

    public function empleadoUpdate(UpdateEmpleado $request,$id){

        $response=array('status'=>false,'id'=>$id);

        $post=$request->except('_token');

        // $response['data']=$post;

        // return $response;

        $empleado_id=$post['empleado_id'];

        $curp=$post['curp'];

        $nss=$post['nss'];

        $rfc=$post['rfc'];

        $departamento=$post['departamento'];

        $puesto=$post['puesto'];

        $fecha_alta=$post['fecha_alta'];

        $estado_civil=$post['estado_civil'];

        $empleado_direccion_id=0;

        if(isset($post['empleado_direccion_id'])){

            $empleado_direccion_id=$post['empleado_direccion_id'];

        }

        $calle=$post['calle'];

        $numero_ext=$post['numero_ext'];

        $numero_int='';

        if(isset($post['numero_int'])){

            $numero_int=$post['numero_int'];

        }

        $colonia=$post['colonia'];

        $ciudad=$post['ciudad'];

        $codigo_postal=$post['codigo_postal'];

        $correo='';

        if(isset($post['correo'])){

            $correo=$post['correo'];

        }

        $telefono=$post['telefono'];

        $id_contrato=$post['id_contrato'];

        $registro_patronal=$post['registro_patronal'];

        $regimen_fiscal=$post['regimen_fiscal'];

        $tipo_contrato=$post['tipo_contrato'];

        $fecha_inicio=$post['fecha_inicio'];

        $frecuencia_pago=$post['frecuencia_pago'];

        $salario_diario=$post['salario_diario'];

        $tabla_antiguedad=$post['tabla_antiguedad'];

        $fecha_fin='';

        if(isset($post['fecha_fin'])){

            $fecha_fin=$post['fecha_fin'];

        }

        $usuario=session()->get('email');

        $result=$this->EmpleadoModel->validarTipoContrato($tipo_contrato);

        if($result === "S"){

            $request->validate([

                'fecha_fin'=>'required',

            ]);

        }

        $datos=[$empleado_id,$rfc,$curp,$nss,$puesto

                    ,$departamento,$fecha_alta,$estado_civil

                    ,$empleado_direccion_id,$calle,$numero_ext,$numero_int

                    ,$colonia,$ciudad

                    ,$codigo_postal,$correo,$telefono

                    ,$id_contrato,$registro_patronal,$regimen_fiscal,$tipo_contrato

                    ,$frecuencia_pago,$salario_diario,$tabla_antiguedad

                    ,$fecha_inicio,$fecha_fin,$usuario];

        $response['data']=$datos;

        $result=$this->EmpleadoModel->UpdateEmpleado($datos);

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['message']='Datos Actualizados';

        $response['data']='reload';

        return $response;

    }

    public function empleadoUpdateSC(Request $request,$id){

        $request->validate([

            'empleado_id'=>'required',

            'rfc'=>'required',

            'curp'=>'required',

            'nss'=>'required',

            'fecha_alta'=>'required',

            'entidad_nacimiento'=>'required',

            'puesto'=>'required',

            'departamento'=>'required',

            'estado_civil'=>'required',

            //Dirección

            'calle'=>'required',

            'numero_ext'=>'required',

            // 'numero_int'=>'required',

            'colonia'=>'required',

            'ciudad'=>'required',

            'codigo_postal'=>'required',

            'telefono'=>'required',

            'correo'=>'required',

        ]);

        $response=array('status'=>false,'id'=>$id);

        $post=$request->all();

        

        //variables del Empleado

        $empleado_id=$post['empleado_id'];

        $rfc=$post['rfc'];

        $curp=$post['curp'];

        $nss=$post['nss'];

        $fecha_alta=$post['fecha_alta'];

        $entidad_nacimiento='';

        if(isset($post['entidad_nacimiento'])){

        $entidad_nacimiento=$post['entidad_nacimiento'];

        }

        $puesto=$post['puesto'];

        $departamento=$post['departamento'];

        $estado_civil=$post['estado_civil'];

        //Dirección

        $direccion_id=0;

        if(isset($post['empleado_direccion_id'])){

            $direccion_id=$post['empleado_direccion_id'];

        }

        $calle=$post['calle'];

        $numero_ext=$post['numero_ext'];

        $numero_int='';

        if(isset($post['numero_int'])){

            $numero_int=$post['numero_int'];

        }

        $colonia=$post['colonia'];

        $ciudad=$post['ciudad'];

        $codigo_postal=$post['codigo_postal'];

        $telefono=$post['telefono'];

        $correo=$post['correo'];

        

        $usuario=session()->get('email');

        // $datos=[$empleado_id,$rfc,$curp,$nss,$puesto,$departamento,$fecha_alta

        //             ,$estado_civil,$entidad_nacimiento,'-1','','','','',''

        //             ,'','','','0','','','','','0.0',''

        //             ,'0000-01-01','',$usuario];

        $datos=[$empleado_id,$rfc,$curp,$nss,$puesto,$departamento,$fecha_alta

                    ,$estado_civil,$entidad_nacimiento,$usuario

                    ,$direccion_id,$calle,$numero_ext,$numero_int

                    ,$colonia,$ciudad,$codigo_postal,$correo,$telefono];

        //$response['data']=$datos;

        $result=$this->EmpleadoModel->UpdateEmpleadoSC($datos);

        //$response['data']=$result;

        //return $response;

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['message']='Datos Actualizados';

        $response['data']='reload';

        return $response;

    }

    public function empleadoNewContract(Request $request){

        $request->validate([

            'empleado_id'=>'required',

            'registro_patronal'=>'required',

            'regimen_fiscal'=>'required',

            'tipo_contrato'=>'required',

            'tabla_antiguedad'=>'required',

            'frecuencia_pago'=>'required',

            'salario_diario'=>'required',

            'fecha_inicio'=>'required',

            

        ]);

        $response=array('status'=>false);

        $post=$request->all();

        

        //variables del Empleado

        $empleado_id=$post['empleado_id'];

        $registro_patronal=$post['registro_patronal'];

        $regimen_fiscal=$post['regimen_fiscal'];

        $tipo_contrato=$post['tipo_contrato'];

        $tabla_antiguedad=$post['tabla_antiguedad'];

        $frecuencia_pago=$post['frecuencia_pago'];

        $salario_diario=$post['salario_diario'];

        $fecha_inicio=$post['fecha_inicio'];

        $fecha_fin='';

        if(isset($post['fecha_fin'])){

            $fecha_fin=$post['fecha_fin'];

        }

        $usuario=session()->get('email');

        $result=$this->EmpleadoModel->validarTipoContrato($tipo_contrato);

        if($result === "S"){

            $request->validate([

                'fecha_fin'=>'required',

            ]);

        }

        $datos=[$empleado_id,$registro_patronal,$regimen_fiscal,$tipo_contrato

                    ,$tabla_antiguedad,$frecuencia_pago,$salario_diario,$fecha_inicio

                    ,$fecha_fin,$usuario];

        //$response['data']=$datos;

        $result=$this->EmpleadoModel->NewContratoEmpleado($datos);

        //$response['data']=$result;

        //return $response;

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['message']='Contrato creado';

        $response['data']='reload';

        return $response;

    }

    public function aplicarContratoEmpleado(Request $request){

        $response=array('status'=>false);

        $datos=$request->all();

        $result=$this->EmpleadoModel->aplicarContratoEmpleado($datos['id_empleado'],$datos['id_contrato']);

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['message']='contrato aplicado';

        $response['data']='reload';

        return $response;

    }

    public function suspenderContratoEmpleado(Request $request){

        $response=array('status'=>false);

        $datos=$request->all();

        $result=$this->EmpleadoModel->suspenderContratoEmpleado(array($datos['id_empleado'],$datos['id_contrato']));

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['message']='contrato aplicado';

        $response['data']='reload';

        return $response;

    }

    public function cancelarContratoEmpleado(Request $request){

        $response=array('status'=>false);

        $datos=$request->all();

        $result=$this->EmpleadoModel->cancelarContratoEmpleado(array($datos['id_empleado'],$datos['id_contrato']));

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['message']='contrato cancelado';

        $response['data']='reload';

        return $response;

    }

    public function agregarConceptosContratoEmpleado(Request $request){

        $response=array('status'=>false);

        $post=json_decode($request->jsonData);

        $ids_conceptos=$post->idsArrays;

        $id_contrato=$post->idgeneral;

        $usuario=session()->get('email');

        // $response['data']=$usuario;

        // return $response;

        $result=$this->EmpleadoModel->agregarConceptoContratoEmpleado($id_contrato,$ids_conceptos,$usuario);

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['message']='conceptos agregados';

        $response['data']='reload';

        return $response;

    }

    public function quitarConceptoContratoEmpleado(Request $request){

        $response=array('status'=>false);

        $post=$request->all();

        $id_concepto=$post['iddet'];

        $id_contrato=$post['idencabezado'];

        $usuario=session()->get('email');

        // $response['data']=$id_concepto."<>".$id_contrato."<>".$usuario;

        // return $response;

        $result=$this->EmpleadoModel->quitarConceptoContratoEmpleado($id_contrato,$id_concepto,$usuario);

        

        if(!is_numeric($result)){

            $response['data']=$result;

            return $response;

        }

        $response['status']=true;

        $response['message']='conceptos actualizados';

        $response['data']='reload';

        return $response;

    }

    public function validarTipocontrato(Request $request){

        //return $request;

        $response=array('status'=>false);

        $tipocontrato='';

        if(isset($request->term)){

            $tipocontrato=$request->term;

        }

        //return $response;

        $result=$this->EmpleadoModel->validarTipoContrato($tipocontrato);

        if(strlen($result)>1){

            $response['data']=$result;

        }

        if($result === "S"){

            $response['status']=true;

        }

        return $response;

    }
//===============================================================================================================================================================================

public function ImportEmpleados(Request $request){

    $users = (new FastExcel)->import('file.xlsx', function ($line) {
        return User::create([
            'name' => $line['Name'],
            'email' => $line['Email']  //Pendiente por aqui xd
        ]);
    });

    }

    public function ExportEmpleados(){
        $users = CatalogoModel::all();
        return (new FastExcel(CatalogoModel::all()))->download('file.xlsx');
        
    }
}