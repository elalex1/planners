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

   public function ExportProveedores(){
    $proveedores = $this->proveedores->GetProveedores();
    return (new FastExcel($proveedores))->download('Proveedores.xlsx');
   }

   public function ImportProveedores(Request $request){
    $proveedores = (new FastExcel)->import($request->clientes, function ($line) {
        return ProveedoresModel::create([
            'nombre' => $line['nombre'],
            'rfc' => $line['rfc'],
            'tipo_proveedor' => $line['tipo_proveedor'],
            'estatus' => $line['estatus'],
            'cuenta_pagar' => $line['cuenta_pagar'],
            'cuenta_anticipo' => $line['cuenta_anticipo'],
            'extrangero' => $line['extrangero'],
            'condicion_pago_id' => $line['condicion_pago_id']
        ]);
    });
    return redirect()->back();
   }

   
}
