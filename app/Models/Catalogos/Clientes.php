<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogos\Clientes;

class Clientes extends Model
{
    use HasFactory;

    protected $table = "clientes";

    protected $fillable = ['nombre', 'correo', 'contacto', 'clave','estatus','clave_cliente'];
    protected $hidden = ['cliente_id'];
    public $timestamps = false;

    public function GetClientes(){
        return Clientes::all();
    }
}
