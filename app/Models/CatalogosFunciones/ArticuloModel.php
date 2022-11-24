<?php

namespace App\Models\CatalogosFunciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticuloModel extends Model
{
    public function articulosAll(){
        $qry="SELECT * FROM articulos;";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function KARDEXTOTCANTCOSTO($articulo_id,$almacen_id,$fecha_inicio,$fecha_fin){
        //select @tot_unid_ent entrada_total,@tot_unid_sal salida_total,@tot_costo_ent costo_total_entrada,@tot_costo_sal costo_total_salida;
        $qry="CALL KARDEXTOTCANTCOSTO(?,?,?,?);";
        try{
            $data=DB::select($qry,array($articulo_id,$almacen_id,$fecha_inicio,$fecha_fin));
            $data=$data[0];
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function articulosKardexMov($articulo_id,$almacen_id,$fecha_inicio,$fecha_fin,$costo_inic,$inv_inic){
        //select @tot_unid_ent entrada_total,@tot_unid_sal salida_total,@tot_costo_ent costo_total_entrada,@tot_costo_sal costo_total_salida;
        $qry="CALL VISTAKARDEXARTICULO(?,?,?,?,?,?);";
        try{
            $data=DB::select($qry,array($articulo_id,$almacen_id,$fecha_inicio,$fecha_fin,$costo_inic,$inv_inic));
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function ARTICULOCALCEXISTENCIAALM($articulo_id,$almacen_id,$fecha_fin){
        //select @tot_unid_ent entrada_total,@tot_unid_sal salida_total,@tot_costo_ent costo_total_entrada,@tot_costo_sal costo_total_salida;
        $qry="CALL ARTICULOCALCEXISTENCIAALM(?,?,?);";
        try{
            $data=DB::select($qry,array($articulo_id,$almacen_id,$fecha_fin));
            $data=$data[0];
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function ARTICULOEXISTENCIA($articulo_id,$almacen_id,$fecha_inicio,$fecha_fin){
        //select @tot_unid_ent entrada_total,@tot_unid_sal salida_total,@tot_costo_ent costo_total_entrada,@tot_costo_sal costo_total_salida;
        $qry="CALL ARTICULOEXISTENCIA(?,?,?,?);";
        try{
            $data=DB::select($qry,array($articulo_id,$almacen_id,$fecha_inicio,$fecha_fin));
            $data=$data[0];
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
