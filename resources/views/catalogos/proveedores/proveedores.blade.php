@extends('app')
@section('title','Proveedores')
@section('content')

<div class="card">
  <div class="card-content">
      <table id="tableGeneral" class="display responsive" width="100%">
          <thead>
              <tr>
                  <th data-priority="1">NOMBRE</th>
                  <th data-priority="2">RFC</th>
                  <th data-priority="3">CUENTA PAGAR</th>
                  <th data-priority="5">CUENTA ANTICIPO</th>
                  <th data-priority="6">EXTRANGERO</th>
                  <th data-priority="4"></th>
              </tr>
          </thead>
          <tbody>
              @foreach ($proveedores as $proveedor)
              <tr id-record="{{$proveedor->proveedor_id}}" modal-record="modalInfo">
                  <td>{{$proveedor->nombre}}</td>
                  <td>{{$proveedor->rfc}}</td>
                  <td>{{$proveedor->cuenta_pagar}}</td>
                  <td>{{$proveedor->cuenta_anticipo}}</td>
                  <td>{{$proveedor->extrangero}}</td>
                  <td></td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>

{{--IMPORT Y EXPORT EXCEL--}}
<div class="card">
  <div class="card-content">
      <form action=" {{route('ImportProveedores')}} " method="post" enctype="multipart/form-data">
          @csrf
          <input type="file" name="proveedores" id="proveedores" class="dropify">
     
      <div class="row center-align">
        <div class="row"></div>  
        <div class="col s12">
              <button class="waves-effect waves-light btn" type="submit">Importar</button>
              <a class="waves-effect waves-black btn" href=" {{route('ExportProveedores')}} ">Exportar</a> 
        </div>
      </div>
    </form>
  </div>
</div>
  
@endsection