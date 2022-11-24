<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    //use HasFactory;
    protected $fillable = [
        'nombre',
        'correo',
        'empresa',
    ];

    protected $hidden = [
        'id_usuario',
        'clave',
        'status_reg',
        'status_password',
    ];

    public $timestamps = false;

}
