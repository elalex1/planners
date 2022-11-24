<?php

namespace App\Models\CatalogosFunciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegistroPatronalModel extends Model
{
    public function getAll(){
        $qry="select * from registros_patronales;";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function RegistroPatronalNew($nombre,$nombre_corto,$registro_patronal,$clase,$clasificador_antiguedad,$usuario){
        $qry="call catRegistroPatronalNuevo(?,?,?
                                            ,?,?,?);";
        try{
            $data=DB::select($qry,array($nombre,$nombre_corto,$registro_patronal,$clase,$clasificador_antiguedad,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function RegistroPatronalEdit($id){
        $qry="select * from registros_patronales where registro_patronal_id=?;";
        $qry2="select * from primas_riesgos_trabajos_rp;";
        try{
            $datos=DB::select($qry,array($id));
            $datos=$datos[0];
            $data['registro_patronal']=$datos;
            $datos=DB::select($qry2,array($id));
            $data['primas_riesgos']=$datos;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function RegistroPatronalAddRiesgo($id_registro_patronal,$riesgo,$fecha_inicio,$fecha_fin,$usuario){
        $qry="call catRegistroPatronalAddRiesgo(?,?,?
                                            ,?,?);";
        try{
            $data=DB::select($qry,array($id_registro_patronal,$riesgo,$fecha_inicio,$fecha_fin,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function RegistroPatronalDeleteRiesgo($id_registro_patronal,$prima_riego_id,$usuario){
        $qry="call catRegistroPatronalDeleteRiesgo(?,?,?);";
        try{
            $data=DB::select($qry,array($id_registro_patronal,$prima_riego_id,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
