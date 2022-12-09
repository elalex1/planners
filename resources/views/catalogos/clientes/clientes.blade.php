@extends('app')
@section('title','Clientes')
@section('content')

{{--Tabla clientes--}}
<div class="card">
  <div class="card-content">
      <table id="tableGeneral" class="display responsive" width="100%">
          <thead>
              <tr>
                  <th data-priority="1">NOMBRE</th>
                  <th data-priority="2">CORREO</th>
                  <th data-priority="3">CONTACTO</th>
                  <th data-priority="5">CLAVE</th>
                  <th data-priority="6">ESTATUS</th>
                  <th data-priority="4"></th>
              </tr>
          </thead>
          <tbody>
              @foreach ($clientes as $cliente)
              <tr id-record="{{$cliente->cliente_id}}" modal-record="modalInfo">
                  <td>{{$cliente->nombre}}</td>
                  <td>{{$cliente->correo}}</td>
                  <td>{{$cliente->contacto}}</td>
                  <td>{{$cliente->clave}}</td>
                  <td>{{$cliente->estatus}}</td>
                  <td>
                    <i href="" class="planner-text  material-icons tooltipped puntero editar-documento" data-delay="50" data-tooltip="Editar Cliente">edit</i>

                    <i href="" class="grey-text material-icons tooltipped" data-delay="50" data-tooltip="Eliminar Cliente">delete_forever</i>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
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
