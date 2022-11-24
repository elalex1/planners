<?php

namespace App\Models;

use App\Models\Catalogos\AlmacenModel;
use App\Models\Catalogos\MonedaModel;
use App\Models\Catalogos\ProveedorModel;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;

class CatalogoModel extends Model

{

    protected $table = "empleados";
    
    public function getArticulos()
	{
        $qry = 'SELECT';
		$qry .= ' a.articulo_id ';
		$qry .= ' , a.nombre ';
		$qry .= ' , a.unidad_compra ';
		$qry .= ' , coalesce((select ac.precio_unitario from articulos_ultimas_compras ac where ac.articulo_id=a.articulo_id order by fecha_ultima_compra desc limit 1),0) as precio';
		$qry .= ' , (case a.pesar_articulo when \'N\' then \'NO\' when \'S\' then \'Si\' end) pesar ';
		$qry .= ' FROM ' ;
		$qry .= ' articulos a';
		$qry .= ' WHERE ';
		$qry .= ' a.estatus in (\'R\',\'V\') ' ;
		// $qry .= ' LEFT JOIN conceptos_requis_articulos cra';
		// $qry .= ' ON ';
		// $qry .= ' cra.articulo_id ';
		// $qry .= ' = a.articulo_id ';
		// $qry .= ' LEFT JOIN doctos_requisiciones dr';
		// $qry .= ' ON ';
		// $qry .= ' cra.concepto_requisicion_id ';
		// $qry .= ' = dr.concepto_requisicion_id ';
		// $qry .= ' WHERE ';
		// $qry .= ' dr.docto_requisicion_id = ' . $id ;

		$data = DB::select($qry,array());
		return $data;
	}
    public function SendEmail($vistaEmail,$content){
        $datos=array('status'=>false);
        try{
            Mail::send($vistaEmail,['content'=>$content],function($message) use ($content){
                $message->from($content['datamail']['desde'],$content['datamail']['usuario_envia']);
                // $message->from('compras@megafreshproduce.com.mx','Compras Mega Fresh Produce');
                $message->to($content['datamail']['email'],$content['datamail']['contacto']);
                $message->subject($content['datamail']['subject']);
                //$message->to($dtmail['email'])->subject($dtmail['subject']);
            });
            $datos['status']=true;
        }catch(Exception $e){
            $datos['data']=$e->getMessage();
        }
        return $datos;
    }
    public function PDFView($data,$vista){
        try{
        $pdf=PDF::loadView($vista,['data'=>$data])
                ->setPaper('a4');
        }catch(Exception $e){
            $pdf=$e->getMessage();
        }
        return $pdf;
    }
    public function getAlmacenesSelect(){
        //return "entro";
        $qry="select almacen_id,nombre id,nombre text from almacenes;";
        //$data=AlmacenModel::select('nombre')->get();
        $data=DB::select($qry,array());
        return $data;
    }
    public function getMonedasSelect(){
        $data=MonedaModel::select('nombre')->get();
        return $data;
    }
    public function GetProveedoresByTerm($term){
        $qry = 'SELECT';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM proveedores ';
		$qry .= ' WHERE  ';
		// $qry .= ' estatus = \'A\'  ';
		// $qry .= ' AND  ';
		$qry .= ' nombre LIKE \'%'. $term . '%\'';
        try{
            // $data=ProveedorModel::where('nombre','like','%'.$term.'%')
            //         ->select('nombre as id','nombre as text')->get();
            $data = DB::select($qry,array());
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function GetCiudadesByTerm($term,$entidad){
        $qry="SELECT c.nombre id,concat(c.nombre,', ',e.nombre_corto,', ',p.nombre_corto) text from ciudades c
                    inner join estados e on e.estado_id=c.estado_id /*and e.nombre='$entidad'*/
                    inner join paises p on p.pais_id=e.pais_id
                    where c.nombre like '%$term%';";
        try{
            $data = DB::select($qry,array());
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getConceptosCompras($modulo){
		$qry="call GETCONCEPTOSCOMPRAS('$modulo')";
        $data=DB::select($qry,array());
        return $data;
    }
    public function validarMoneda($moneda){
        try{
            $data=MonedaModel::where('nombre','=',$moneda)
                                    ->select("es_local")->first();
            if($data['es_local']=='S' || $data['es_local']==''){
                $data['status']= true;
            }else{
                $data['status']= false;
            }
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function GetFamiliasByReqs($reqs){
        $qry="call COTIZACIONFAMILIAS('$reqs')";
        try{
            $data=DB::select($qry,array());
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getNombreArchivo($idarchivoid){
		$qry="select archivo from repositorio_archivos where repositorio_archivo_id=$idarchivoid;";
        try{
            $data=DB::select($qry,array());
            $data = $data[0]->archivo;
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
		return $data;
	}
    public function getEntidades($term=''){
        $qry = 'SELECT';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM estados ';
		$qry .= ' WHERE  ';
		// $qry .= ' estatus = \'A\'  ';
		// $qry .= ' AND  ';
		$qry .= ' nombre LIKE \'%'. $term . '%\'';
        try{
            // $data=ProveedorModel::where('nombre','like','%'.$term.'%')
            //         ->select('nombre as id','nombre as text')->get();
            $data = DB::select($qry,array());
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function GetEntidadesByTerm($term,$pais){
        $qry="SELECT e.nombre id,e.nombre text from estados e
                    inner join paises p on p.pais_id=e.pais_id and p.nombre like'%$pais%'
                    where e.nombre like '%$term%';";
        try{
            $data = DB::select($qry,array());
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getPuestos($term=''){
        $qryg="SELECT nombre id,nombre text FROM puestos
                    where nombre like '%$term%';";
        try{
            $data=DB::select($qryg,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getDepartamentos($term=''){
        $qryg="SELECT nombre id,nombre text FROM departamentos
                    where nombre like '%$term%';";
        try{
            $data=DB::select($qryg,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getConceptosNomTable(){
        $qry="select * from conceptos_nominas";
        $data = DB::select($qry,array());
		return $data;
	}
    public function getCentrosCostosbyTerm($term)
	{

		$qry = 'SELECT';
		$qry .= ' nombre AS id';
		$qry .= ' ,nombre AS text ';
		$qry .= ' FROM centros_costos ';
		$qry .= ' WHERE  ';
		$qry .= ' estatus = \'A\'  ';
		$qry .= ' AND  ';
		$qry .= ' nombre LIKE \'%'. $term . '%\'';
		$data = DB::select($qry,array());
		return $data;
	}
}
