<?php

namespace App\Models\CatalogosFunciones;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConceptoNominaModel extends Model
{
    public function getAll(){
        $qry="select * from conceptos_nominas";
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function conceptoNominaStore($datos){
        $qry="CALL catConceptoNomnuevo(?,?,?,?,?	
                                    ,?,?,?,?,?)";
        try{
            $data=DB::select($qry,$datos);
            $data=$data[0]->Respuesta;
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getDataConcepto($id){
        $qry="select * from conceptos_nominas where concepto_nomina_id=?";
        try{
            $data=DB::select($qry,array($id));
            $data=$data[0];
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function conceptoNominaUpdate($datos){
        $qry="CALL catConceptoUpdate(?,?,?	
                                     ,?,?,?)";
        try{
            $data=DB::select($qry,$datos);
            $data=$data[0]->Respuesta;
        }catch(Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
    public function getTiposConceptosSat($tipo,$term){
        if($tipo==='D'){
            $qry="select clave id,descripcion text from cfdis_40.tipos_deducciones where descripcion like '%$term%';";
        }elseif($tipo==='P'){
            $qry="select clave id,descripcion text from cfdis_40.tipos_percepciones where descripcion like '%$term%';";
        }elseif($tipo==='O'){
            $qry="select clave id,descripcion text from cfdis_40.tipos_otros_pagos where descripcion like '%$term%';";
        }elseif($tipo==='R'){
            $data=array('id'=>'','text'=>'');
            return $data;
        }
        try{
            $data=DB::select($qry,array());
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
    }
}
