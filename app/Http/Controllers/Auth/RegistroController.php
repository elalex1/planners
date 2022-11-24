<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use App\Http\Requests;
use App\Models\LoginModel;
use App\Models\users;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;


class registroController extends Controller
{
    protected $registro;

    public function __construct(RegistroModel $registro)
    {
        $this->registro = $registro;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CrearEmpresa()
    {
    //Asigno valores del request a variables-----
    $nombreP  = $request->usuario;                  
    $empresaP = $request->empresa;                  
    $emailP   = $request->email;                    
                                                    
    //=================================================

    //Metodo store---------------------------------------------------
      $query = "call NUEVAEMPRESA('$nombreP','$id_user','$emailP');";
      try {
      $resultado = DB::select($query,array()); 
      $resultado = $resultado[0]->Respuesta; //Respuesta es lit la respuesta del store xD
      } catch (\Exception $th) {
      $resultado = $th->getMessage();
      }

//======================================================

      $data = [
        'nombre' => $request->usuario,
        'password' => $password,
        'correo' => $request->email,
        'id' => $resultado
      ];

//======================================================

//Mandamos el email al usuario-----------------------------------
   Mail::to($emailP)->queue(new SignUp($data));
    //Regresamos a la vista de confirmar correo------------------------------------------
    return view('registro.activacion',['usuario_id'=>$resultado]); 
    }

//=======================================================    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
