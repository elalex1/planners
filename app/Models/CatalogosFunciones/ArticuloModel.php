<?php

namespace App\Models\CatalogosFunciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticuloModel extends Model
{

    protected $table = "articulos";
    protected $fillable = ['familia_articulo_id','nombre','estatus','almacenable','es_servicio',
    'seguimiento_lotes','caducidad','unidad_venta','unidad_compra','contenido_compra','pesar_articulo',
    'peso_unitario','peso_variante','importado','pctaje_arancel','es_kit','dias_produccion','clave_fiscal',
    'fecha_creacion','fecha_modificacion','usuario_creacion','usuario_modificacion'];

    public $timestamps = false;
    
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
