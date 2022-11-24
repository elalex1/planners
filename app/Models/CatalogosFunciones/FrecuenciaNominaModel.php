<?php

namespace App\Models\CatalogosFunciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FrecuenciaNominaModel extends Model
{
    public function getAll(){
        $qry="select * from frecuencias_nominas";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function FrecuenciaNominaStore($nombre,$nombre_corto,$clave_fiscal,$calcula_septimo_dia,$dias_periodo,$dias_trabajador
                                            ,$dias_septimo,$tipo_calculo_impuesto,$devolver_isr,$tipo_calculo_nomina,$forma_calculo,$usuario){
        $qry="call catFrecuenciaNomNueava(?,?,?,?,?,?
                                          ,?,?,?,?,?,?)";
        try{
            $data=DB::select($qry,array($nombre,$nombre_corto,$clave_fiscal,$calcula_septimo_dia,$dias_periodo,$dias_trabajador,$dias_septimo,$tipo_calculo_impuesto,$devolver_isr,$tipo_calculo_nomina,$forma_calculo,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function FrecuenciaNominaStoreGetData($id){
        $qry="select * from frecuencias_nominas where frecuencia_nomina_id=?;";
        try{
            $data=DB::select($qry,array($id));
            $data=$data[0];
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
