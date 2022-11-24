<?php

namespace App\Models\CatalogosFunciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DepartamentoModel extends Model
{
    public function getAll(){
        $qry="select d.departamento_id,d.nombre,cc.nombre centro_costo,d.usuario_creacion from departamentos d
                    left join centros_costos cc on cc.centro_costo_id=d.centro_costo_id order by fecha_creacion desc;";
        try {
            $data=DB::select($qry,array());
        } catch (\Exception $e) {
            $data=$e->getMessage();
        }
        return $data;
    }
    public function FrecuenciaNominaStore($nombre,$centro_costo,$usuario){
        $qry="call catDepartamentoNuevo(?,?,?)";
        try {
            $data=DB::select($qry,array($nombre,$centro_costo,$usuario));
            $data=$data[0]->Respuesta;
        } catch (\Exception $e) {
            $data=$e->getMessage();
        }
        return $data;
    }
    public function FrecuenciaNominaGetById($id){
        $qry="select d.departamento_id,d.nombre,cc.nombre centro_costo,d.usuario_creacion from departamentos d
                    left join centros_costos cc on cc.centro_costo_id=d.centro_costo_id where d.departamento_id=?;";
        try {
            $data=DB::select($qry,array($id));
        } catch (\Exception $e) {
            $data=$e->getMessage();
        }
        return $data;
    }
}
