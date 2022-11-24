<?php

namespace App\Models\CatalogosFunciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PuestoModel extends Model
{
    public function getAll(){
        $qry="select * from puestos order by fecha_creacion desc;";
        try {
            $data=DB::select($qry,array());
        } catch (\Exception $e) {
            $data=$e->getMessage();
        }
        return $data;
    }
    public function PuestoStore($nombre,$usuario){
        $qry='insert into puestos(fecha_modificacion,usuario_modificacion,nombre,usuario_creacion) values((select current_timestamp()),?,?,?)';
        try {
            $data=DB::select($qry,array($usuario,$nombre,$usuario));
            $data=1;
        } catch (\Exception $e) {
            $data=$e->getMessage();
        }
        return $data;
    }
}
