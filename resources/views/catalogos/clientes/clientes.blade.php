@extends('app')
@section('title','Clientes')
@section('content')
{{--Importar Y exportar Clientes--}}
<div class="row">
  <div class="col s12 m12">
    <div class="card White">
      <div class="card-content">
        <div class="row">
        <div class="col s6">
          
          <form action=" {{route('ImportClientes')}} " method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="clientes" id="clientes">
            <a class="waves-effect waves-light btn" ><button type="submit"></button>Importar</a>
            
          </form>

        </div>
        <div class="col s6">
          <a class="waves-effect waves-light btn" href=" {{route('ExportClientes')}} ">Exportar</a> 
        </div>
      </div>
      </div>
    </div>
  </div>
</div>

{{--Tabla clientes--}}
<div class="row">
    <div class="col s12 m12">
      <div class="card White">
        <div class="card-content">
          <span class="card-title center-align">Clientes</span>
          
          <table>
            <thead>
              <tr>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Contacto</th>
              </tr>
            </thead>
    
            <tbody>
              @foreach ($clientes as $cliente)
                <tr>
                  <td>{{$cliente->nombre}}</td>
                  <td>{{$cliente->correo}}</td>
                  <td>{{$cliente->contacto}}</td>
                </tr>
                <tr>  
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection