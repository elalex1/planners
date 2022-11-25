<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Clientes;
use Rap2hpoutre\FastExcel\FastExcel;


class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $clientes;
    public function __construct(Clientes $clientes)
    {
        $this->clientes = $clientes;
    }


    public function index()
    {
        $clientes = $this->clientes->GetClientes();
        return view('catalogos.clientes.clientes',['clientes' => $clientes]);
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
