<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\CatalogoModel;
use App\Models\CatalogosFunciones\ArticuloModel;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ArticulosController extends Controller
{
    protected $Articulo;
    protected $Catalogo;
    public function __construct()
    {
        $this->Articulo=new ArticuloModel();
        $this->Catalogo=new CatalogoModel();
    }
    public function articulosAll(){
        $articulos=$this->Articulo->articulosAll();
        $content['articulos']=$articulos;
        $content['almacenes']=$this->Catalogo->getAlmacenesSelect();
        // return $content;
        return view('catalogos.articulos.index',['content'=>$content]);
    }
    public function articulosKardexExistencias(Request $request){
        $response=array('status'=>false);
        $post=$request->all();
        $articulo_id=$post['articulo_id'];
        $almacen_id=$post['almacen'];
        if(!isset($post['fecha_inicio_f'])){
            $request->validate([
                'fecha_inicio'=>'required',
                'fecha_fin'=>'required',
            ]);
            $fecha_inicio=$post['fecha_inicio'];
            $fecha_fin=$post['fecha_fin'];
            $result=$this->Articulo->KARDEXTOTCANTCOSTO($articulo_id,$almacen_id,$fecha_inicio,$fecha_fin);
            $response['data']=$result;
            if(is_string($result)){
                return $response;
            }
            $response['status']=true;
        }else{
            $totales=$this->Articulo->KARDEXTOTCANTCOSTO($articulo_id,$almacen_id,'1900-01-01',date('Y-m-d', time()));
            $rotacion=$this->Articulo->ARTICULOEXISTENCIA($articulo_id,$almacen_id,date('Y-01-01', time()),date('Y-m-d', time()));
            $existencias=$this->Articulo->ARTICULOCALCEXISTENCIAALM($articulo_id,$almacen_id,date('Y-m-d', time()));
            $content=array('totales'=>$totales,'rotacion'=>$rotacion,'existencias'=>$existencias);
            $response['data']=$content;
            $response['status']=true;
        }
        
        return $response;
    }
    public function articulosKardexMov(Request $request){
        $response=array('status'=>false);
        
        $request->validate([
            'fecha_inicio'=>'required',
            'fecha_fin'=>'required',
        ]);
        $post=$request->all();
        $articulo_id=$post['articulo_id'];
        $almacen_id=$post['almacen'];
        $fecha_inicio=$post['fecha_inicio'];
        $fecha_fin=$post['fecha_fin'];
        $costo_inic=0;
        $inv_inic=0;
        //$datos=array('fecha'=>'fecha');
        $datos=$this->Articulo->articulosKardexMov($articulo_id,$almacen_id,$fecha_inicio,$fecha_fin,$costo_inic,$inv_inic);
        
        return json_encode($datos);
    }

    public function ExportExcel(){
        $articulos=$this->Articulo->articulosAll();
        return(new FastExcel($articulos))->download('Articulos.xlsx');
    }

    public function ImportExcel (Request $request){
        $users = (new FastExcel)->import($request->articulos, function ($line) {
            return ArticuloModel::create([
                'familia_articulo_id' => $line['familia_articulo_id'],
                'nombre' => $line['nombre'],
                'estatus' => $line['estatus'],
                'almacenable' => $line['almacenable'],
                'es_servicio' => $line['es_servicio'],
                'seguimiento_lotes' => $line['seguimiento_lotes'],
                'caducidad' => $line['caducidad'],
                'unidad_venta' => $line['unidad_venta'],
                'unidad_compra' => $line['unidad_compra'],
                'contenido_compra' => $line['contenido_compra'],
                'pesar_articulo' => $line['pesar_articulo'],
                'peso_unitario' => $line['peso_unitario'],
                'peso_variante' => $line['peso_variante'],
                'importado' => $line['importado'],
                'pctaje_arancel' => $line['pctaje_arancel'],
                'es_kit' => $line['es_kit'],
                'dias_produccion' => $line['dias_produccion'],
                'clave_fiscal' => $line['clave_fiscal'],
                'fecha_creacion' => $line['fecha_creacion'],
                'fecha_modificacion' => $line['fecha_modificacion'],
                'usuario_creacion' => $line['usuario_creacion'],
                'usuario_modificacion' => $line['usuario_modificacion']
            ]);
        });
        return redirect()->back();
       }
}
