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
            <input type="file" name="clientes" id="clientes" class="dropify">
            
            
          

        </div>
        <div class="col s6">
          <button type="submit"><a class="waves-effect waves-light btn" >Importar</a></button>
          <a class="waves-effect waves-light btn" href=" {{route('ExportClientes')}} ">Exportar</a>
          <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>  {{--Por si sale un error xd--}}
            @endforeach
        </ul>
        </div>
      </form>
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