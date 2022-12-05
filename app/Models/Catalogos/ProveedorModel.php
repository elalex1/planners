<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class ProveedorModel extends Model
{
    protected $table="proveedores";
    protected $hidden = ['proveedor_id'];
    protected $fillable = ['nombre','rfc','tipo_proveedor_id','estatus','cuenta_pagar','cuenta_anticipo','extranjero','condicion_pago_id'];

    public function GetProveedores(){
         return ProveedorModel::all();
    }

    

}
