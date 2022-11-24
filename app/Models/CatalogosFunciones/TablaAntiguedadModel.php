<?php

namespace App\Models\CatalogosFunciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TablaAntiguedadModel extends Model
{
    public function getAll(){
        $qry="select ta.tabla_antiguedad_id,ta.nombre,ta.nombre_corto,(case ta.estatus when 'N' then 'Activo' when 'C' then 'Cancelado' end) estatus from tablas_antiguedades ta;";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function StoreTablaAnt($nombre,$nombre_corto,$usuario){
        // $qry="insert into tablas_antiguedades(nombre,nombre_corto,estatus)values(?,?,'N');";
        $qry="call catTablaAntNueva(?,?,?);";
        try{
            $data=DB::select($qry,array($nombre,$nombre_corto,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getData($id){
        $qry="select ta.tabla_antiguedad_id,ta.nombre,ta.nombre_corto,ta.estatus from tablas_antiguedades ta
                    where ta.tabla_antiguedad_id=?;";
        $qry2="select tabla_antiguedad_det_id,antiguedad_dias,antiguedad_anio,antiguedad_anio_imss,dias_aguinaldo,dias_vacaciones,dias_prima_vacacional from tablas_antiguedades_det where tabla_antiguedad_id=?";
        try{
            $datos=DB::select($qry,array($id));
            $data['tabla_antiguedad']=$datos[0];
            $data['tabla_antiguedad_det']=DB::select($qry2,array($id));
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function TablaAntAddRenglon($id_tabla,$dias_antiguedad,$anios_antiguedad,$anios_antiguedad_imss,$dias_aguinaldo,$dias_vacaciones,$dias_prima_vacacional,$usuario){
        $qry="call catTablaAntAddRow(?,?,?,?,?,?,?,?)";
        try{
            $data=DB::select($qry,array($id_tabla,$dias_antiguedad,$anios_antiguedad,$anios_antiguedad_imss,$dias_aguinaldo,$dias_vacaciones,$dias_prima_vacacional,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function TablaAntDeleteRenglon($id_taba,$id_tabla_det,$usuario){
        $qry="call catTablaAntDeleteRow(?,?,?)";
        try{
            $data=DB::select($qry,array($id_taba,$id_tabla_det,$usuario));
            $data=$data[0]->Respuesta;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
