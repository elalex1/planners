<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ArchivoModel extends Model
{
     public function GuardarArchivo($disco,$file,$ruta){
        $result=array('status'=>false,'message'=>'El archivo '.$ruta.' ya existe.');
        if(!Storage::disk($disco)->exists($ruta)){
            try{
                $result['message']=null;
                if(!Storage::disk($disco)->put($ruta,$file)){
                    $result['message']='No se pudo agregar la imagen';
                }else{
                    $result['status']=true;
                }
            }catch(\Exception $e){
                $result['message']=$e->getMessage();
            }
        }
        return $result;
    }
    public function EliminarArchivo($disco,$ruta){
        Storage::disk($disco)->delete($ruta);
    }
}
