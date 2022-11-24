<?php

namespace App\Models\Compras;

use App\Models\Catalogos\MonedaModel;
use Illuminate\Database\Eloquent\Model;

class ValidacionesModel extends Model
{
    public function verificarMonedaNuevaRecepcion($moneda){
        //return $moneda;
        try{
            $data=MonedaModel::where('nombre','=',$moneda)
                                    ->select("es_local")->first();
        }catch(\Exception $e){
            $data=$e->getMessage();
        }
        return $data;
        //$data=$this->Compra->validarMoneda($moneda);
        $resp=array('status'=>false);
        
        if($data['es_local']=='S' || $data['es_local']==''){
            //return 'eslocal';
            $resp['status']= true;
        }
        return $resp;
    }
}
