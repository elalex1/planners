@extends('app')
@section('title','Clientes')
@section('content')

{{--Tabla clientes--}}
<div class="row">
    <div class="col s12 m12">
      <div class="card White">
        <div class="card-content">
          <span class="card-title center-align">Clientes</span>
          
          <table id="myTable" name="myTable" class="display" style="width:100%">
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
{{--IMPORT Y EXPORT EXCEL--}}
  <div class="card">
    <div class="card-content">
        <form action=" {{route('ImportClientes')}} " method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="articulos" id="articulos" class="dropify">
       
        <div class="row center-align">
          <div class="row"></div>  
          <div class="col s12">
                <button class="waves-effect waves-light btn" type="submit">Importar</button>
                <a class="waves-effect waves-light btn" href=" {{route('ExportClientes')}} ">Exportar</a> 
          </div>
        </div>
      </form>
    </div>
</div>

@endsection
