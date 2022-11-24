@extends('layouts.proceso')
@section('title', 'Crear Contraseña')
@section('content')
    <div class="row full">
        <div class="espacio-l"></div>
        <div class="col l6 m8 s12 push-l3 push-m2">
            <div class="center pink-text">
                <h4>CREA TU CONTRASEÑA</h4>
                <h5>Y SELECCIONA UNA PREGUNTA SECRETA</h5>
            </div>
            <div class="divider"></div>

            <form id="formCrearPw" action="{{route('crearcontrasena', $id)}}" method="post">
                @csrf
                <div class="input-field col s12">
                    <label for="password" class="pink-text">Contraseña</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="input-field col s12">
                    <label for="confirmarcontrasena" class="pink-text">Confirmar Contraseña :</label>
                    <input type="password" name="confirmarcontrasena" id="confirmarcontrasena">
                </div>
{{---------------------------------------------------------------------------------------------------------------------------------}}
                    
                    <div class="col s12">
                     <button type="submit" class="btn-large validarForm waves-effect waves-light right pink darknes-2">Crear</button>   
                    </div>
                    <div class="col s12" style="height: 30;"><br></div>
            </form>
        </div>
    </div>

    </div>
    </div>
    <script>

    </script>
@endsection
