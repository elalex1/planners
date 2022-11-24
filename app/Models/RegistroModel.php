<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroModel extends Model
{
    use HasFactory;

    protected $table = "usuarios_web";

    protected $fillable = ['nombre','correo','usuario_id'];

    protected $hidden = ['usuario_web_id'];


    public function ReenviarCorreo($id)
    {

    }
}
