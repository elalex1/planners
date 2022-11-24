<?php

namespace App\Models\CatalogosFunciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoContratoModel extends Model
{
    public function getAll(){
        $qry="select tipo_contrato_empleado_id,nombre,nombre_corto,clave_fiscal,
                    estatus 
                from tipos_contratos_empleados";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function TipoContratoStore($nombre,$nombre_corto,$clave_fiscal,$usuario){
        $qry="call catTipoContratoNuevo(?,?,?,?)";
        try{
            $data=DB::select($qry,array($nombre,$nombre_corto,$clave_fiscal,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function TipoContratoEliminar($id_tipocontrato,$usuario){
        $qry="call catTipoContratoEliminar(?,?)";
        try{
            $data=DB::select($qry,array($id_tipocontrato,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
