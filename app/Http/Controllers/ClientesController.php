<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\Clientes;

class ClientesController extends Controller
{

 /*   protected $clientes;
    public function __construct(Clientes $clientes){

        $this->Clientes = $clientes;
    
    }*/


    public function index(){

        //$clientes = $this->Clientes->obtenerClientes();
         return view('catalogos.clientes.clientes');
    }

    public function ImportCliente()
    {
        $clientes = (new UploadController)->Archivo($request);
    
        //=============================================================================================================================================
          // Insert to MySQL database
          foreach($clientes as $importData){

            $insertData = array(
               "nombre"=>$importData[0],
               "correo"=>$importData[1],                  //Esta es la parte Dinamica de la funcion, va a variar dependiendo de que se desee insertar
               "equipo"=>$importData[2]);
              
            Clientes::insertData($insertData);

          }
          //===============================================================================================================================================================

          Session::flash('message','Import Successful.');
    // Redirect to index
    return redirect('inicio');
    }
}
