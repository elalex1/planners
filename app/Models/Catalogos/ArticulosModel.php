<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class ArticulosModel extends Model
{
    protected $table="articulos";
    protected $fillable = ['nombre', 'estatus', 'almacenable', 'es_servicio'];
    protected $hidden = ['id'];

    public function GetArticulos(){
        return ArticulosModel::all();
    }
}

