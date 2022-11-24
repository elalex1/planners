<?php



namespace App\Models\CatalogosFunciones;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class EmpleadoModel extends Model

{

    protected $table='empleados';

    public function getEmpleados(){

        $qry="select 

            e.empleado_id, 

            coalesce(concat(e.nombre,' ',e.apellido_paterno,' ',e.apellido_materno),

            concat(e.nombre,' ',e.apellido_paterno),concat(e.nombre,' ',e.apellido_materno),e.nombre) nombre,

            (case e.estatus when 'A' then 'Activo' when 'P' then 'Pendiente' when 'B' then 'Baja' end) estatus,

            e.rfc,

            coalesce(e.nss,'No') nss,

            coalesce(p.nombre,'No') puesto,

            coalesce(d.nombre,'No') departamento,

            coalesce(cc.nombre,'No') centro_costo

        from empleados e

        left join puestos p on e.puesto_id=p.puesto_id

        left join departamentos d on e.departamento_id=d.departamento_id

        left join centros_costos cc on d.centro_costo_id=cc.centro_costo_id

        order by e.estatus,e.fecha_creacion desc;";

        try{

            $data=DB::select($qry,array());

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function EmpleadoStore($datos){

        $qry="CALL NUEVOEMPLEADO(?,?,?,?,?,?,?,?,?,?,?,?,?);";

        try{

            $dat=DB::select($qry,$datos);

            if(!isset($dat[0]->Respuesta)){

                $dat=json_encode($dat[0]);

                $dat=str_replace('(','',$dat);

                $dat=str_replace(')','',$dat);

                $dat=json_decode($dat);

                $data=$dat->last_insert_id;

            }else{

                $data=$dat[0]->Respuesta;

            }

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function getEMpleadoData($datos){

        $qryg="SELECT 

                    e.empleado_id,e.apellido_paterno,e.apellido_materno,e.nombre,e.rfc,e.curp,e.nss,e.fecha_nacimiento

                    ,e.fecha_alta,e.estatus_civil

                    ,en.nombre estado_nacimiento,e.estatus,e.fecha_creacion,ce.contrato_empleado_id

                    ,ed.empleado_domicilio_id,ed.calle,ed.numero_exterior,ed.numero_interior

                    ,ed.colonia,ed.codigo_postal,ed.correo,ed.telefono,ced.nombre ciudad

                    ,concat(ced.nombre,', ',eed.nombre_corto,', ',ped.nombre_corto) entidad_direccion

                    ,tc.nombre tipo_contrato,p.nombre puesto,d.nombre departamento,ce.fecha_inicio

                    ,ce.fecha_termino,/*ce.estado_civil*/(select 'nocampo') estado_civil,rp.registro_patronal,ce.estatus estatus_contrato,ce.regimen_fiscal

                    ,fn.nombre frecuencia_pago,ce.salario_diario

                    ,tace.nombre tabla_antiguedad

                FROM empleados e 

                left join estados en on en.estado_id=e.estado_nacimiento_id

                left join puestos p on p.puesto_id=e.puesto_id

                left join departamentos d on d.departamento_id=e.departamento_id

                left join empleados_domicilios ed on ed.empleado_id=e.empleado_id

                    left join ciudades ced on ced.ciudad_id=ed.ciudad_id

                    left join estados eed on eed.estado_id=ced.estado_id

                    left join paises ped on ped.pais_id=eed.pais_id

                left join contratos_empleados ce on ce.empleado_id=e.empleado_id and ce.estatus in ('N','P','S')

                /*left join ciudades c on c.ciudad_id=ce.ciudad_id*/

                /*left join estados ent on ent.estado_id=c.entidad_id*/

                    left join tipos_contratos_empleados tc on tc.tipo_contrato_empleado_id=ce.tipo_contrato_empleado_id

                    left join registros_patronales rp on rp.registro_patronal_id=ce.registro_patronal_id

                left join tablas_antiguedades tace on tace.tabla_antiguedad_id=ce.tabla_antiguedad_id

               /* left join regimen_fiscales rf on rf.regimen_fiscal_id=ce.regimen_fiscal_id*/

                left join frecuencias_nominas fn on fn.frecuencia_nomina_id=ce.frecuencia_nomina_id

                where e.empleado_id=?;";

        $qryc="SELECT ce.contrato_empleado_id,tc.nombre tipo_contrato,p.nombre puesto,d.nombre departamento,ce.fecha_inicio,ce.fecha_termino,e.fecha_alta fecha_alta_empleado

                        ,(case ce.estatus when 'N' then 'Activo' when 'P' then 'Pendiente' when 'T' then 'Terminado' when 'S' then 'Suspendido' end) estatus

                    from contratos_empleados ce

                    inner join empleados e on e.empleado_id=ce.empleado_id

                    inner join puestos p on p.puesto_id=e.puesto_id

                    inner join departamentos d on d.departamento_id=e.departamento_id

                    inner join tipos_contratos_empleados tc on tc.tipo_contrato_empleado_id=ce.tipo_contrato_empleado_id

                    /*inner join puestos p on p.puesto_id=ce.puesto_id*/

                    /*inner join departamentos d on d.departamento_id=ce.departamento_id*/

                    where ce.empleado_id=?;";

        $qrycn="SELECT cn.concepto_nomina_id,cn.nombre,cn.clave,cn.naturaleza,cn.clave_fiscal,cp.estatus from contratos_empleados ce

                        inner join contratos_prestaciones cp on cp.contrato_empleado_id=ce.contrato_empleado_id

                        inner join conceptos_nominas cn on cn.concepto_nomina_id=cp.concepto_nomina_id

                    where ce.estatus in ('P','N','S') and ce.empleado_id=?";

        $qrtTR="select clave id,descripcion text from cfdis_40.tipos_regimenes;";

        try{

            $datos_gen=DB::select($qryg,$datos);

            $data['general']=$datos_gen[0];

            $data['contratos']=DB::select($qryc,$datos);

            $data['conceptos_nominas']=DB::select($qrycn,$datos);

            $data['tipos_regimenes']=DB::select($qrtTR,$datos);

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function getTiposContratos(){

        $qryg="SELECT nombre text FROM tipos_contratos_empleados;";

        try{

            $data=DB::select($qryg,array());

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function getRegistrosPatronales(){

        $qryg="SELECT registro_patronal text FROM registros_patronales;";

        try{

            $data=DB::select($qryg,array());

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function getRegimenFiscales(){

        $qryg="SELECT descripcion text FROM regimenes_fiscales;";

        try{

            $data=DB::select($qryg,array());

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function getFrecuenciasPago(){

        $qryg="SELECT nombre text FROM frecuencias_nominas;";

        try{

            $data=DB::select($qryg,array());

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function getTablasAntiguedades(){

        $qryg="SELECT nombre text FROM tablas_antiguedades;";

        try{

            $data=DB::select($qryg,array());

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function NewContratoEmpleado($datos){

        $qry="CALL catContratoNuevo(?,?,?,?,?,?,?,?,?,?)";

        try{

            $data=DB::select($qry,$datos);

            $data=$data[0]->Respuesta;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function UpdateEmpleado($datos){

        $qryg="CALL EMPLEADOUPDATE(?,?,?,?,?

                                    ,?,?,?,?,?

                                    ,?,?,?,?,?

                                    ,?,?,?,?,?

                                    ,?,?,?,?,?

                                    ,?,?);";

        try{

            $data=DB::select($qryg,$datos);

            $data=$data[0]->Respuesta;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function UpdateEmpleadoSC($datos){

        $qry="CALL catEmpleadoUpdateSC(?,?,?,?,?

                                    ,?,?,?,?,?

                                    ,?,?,?,?,?

                                    ,?,?,?,?);";

        try{

            $data=DB::select($qry,$datos);

            $data=$data[0]->Respuesta;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function aplicarContratoEmpleado($id_empleado,$id_contrato){

        $qry2="update empleados set estatus='A' where empleado_id=?;";

        $qry="UPDATE contratos_empleados set estatus='N' where empleado_id=? and contrato_empleado_id=?;";

        try{

            DB::update($qry2,array($id_empleado));

            $data=DB::select($qry,array($id_empleado,$id_contrato));

            $data=1;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function suspenderContratoEmpleado($datos){

        $qry="UPDATE contratos_empleados set estatus='S' where empleado_id=? and contrato_empleado_id=?;";

        try{

            $data=DB::select($qry,$datos);

            $data=1;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function cancelarContratoEmpleado($datos){

        $qry="UPDATE contratos_empleados set estatus='T' where empleado_id=? and contrato_empleado_id=?;";

        try{

            $data=DB::select($qry,$datos);

            $data=1;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function agregarConceptoContratoEmpleado($id_contrato,$ids_conceptos,$usuario){

        $qry="call catEmpleadoContratoAddConceptos(?,?,?)";

        try{

            $data=DB::select($qry,array($id_contrato,$ids_conceptos,$usuario));

            $data=$data[0]->Respuesta;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function quitarConceptoContratoEmpleado($id_contrato,$id_concepto,$usuario){

        $qry="call catEmpleadoContratoQuitarConceptos(?,?,?)";

        try{

            $data=DB::select($qry,array($id_contrato,$id_concepto,$usuario));

            $data=$data[0]->Respuesta;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

    public function validarTipoContrato($tipo_contrato){

        $qry="select tiene_vigencia from tipos_contratos_empleados where nombre=?;";

        try{

            $data=DB::select($qry,array($tipo_contrato));

            $data=$data[0]->tiene_vigencia;

        }catch(\Exception $e){

            $data=$e->getMessage();

        }

        return $data;

    }

//=============================================================================================
public static function insertData($data){

    $value=DB::table('empleados')->where('nombre', $data['nombre'])->get();
    if($value->count() == 0){ //Va a insertar hasta que el contador llegue a 0
       DB::table('empleados')->insert($data);
    }
 }

}