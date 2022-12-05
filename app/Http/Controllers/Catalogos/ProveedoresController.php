<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\ProveedorModel;
use Rap2hpoutre\FastExcel\FastExcel;


class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $proveedores;
    public function __construct(ProveedorModel $proveedores)
    {
        $this->proveedores = $proveedores;
    }


    public function index()
    {
        $proveedores = $this->proveedores->GetProveedores();
        return view('catalogos.proveedores.proveedores',['proveedores' => $proveedores]);
    }

   public function ExportClientes(){
    $clientes = $this->clientes->GetClientes();
    return (new FastExcel($clientes))->download('clientes.xlsx');
   }

   public function ImportClientes(Request $request){
    $users = (new FastExcel)->import($request->clientes, function ($line) {
        return Clientes::create([
            'nombre' => $line['nombre'],
            'correo' => $line['correo'],
            'contacto' => $line['contacto'],
            'clave' => $line['clave'],
            'estatus' => $line['estatus'],
            'clave_cliente' => $line['clave_cliente']
        ]);
    });
    return redirect()->back();
   }
}
