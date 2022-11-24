@extends('app')


@section('title', 'Nueva '. $content['tipo_inventario'])

@section('content')
<form id="formInventario" method="POST">
  {{ csrf_field() }}
  <div class="card">


    <!-- card content para nuevo registro en doctos_inventarios -->
    <div class="card-content">

      <div class="row">

        <div class="col s6">
          <label>Fecha</label>
          <input name="fecha_documento" type="text" class="datepicker">
        </div>

      </div>
      <div class="row">

        <div class="col s6">
          <select id="slc-conceptoinventario" name="concepto_inventario" class="error browser-default">
            <option value="" disabled  selected>Selecciona opción</option>
            @foreach ($content['conceptos_inventarios'] as $concepto_inventario)
            <option value="{{ $concepto_inventario->nombre }}">{{ $concepto_inventario->nombre }}</option>
            @endforeach
          </select>
          <label>Concepto</label>
        </div>

        <div class="col s6">
          <select id="slc-almaceninventario" name="almacend" class="error browser-default">
            <option value="" disabled  selected>Selecciona opción</option>
            @foreach ($content['almacenes'] as $almacen)
            <option value="{{ $almacen->nombre }}">{{ $almacen->nombre }}</option>
            @endforeach
          </select>
          <label>Almacén</label>
        </div>



        <div class="input-field col s12">
          <textarea id="descripciond" name="descripciond" class="materialize-textarea"></textarea>
          <label for="descripciond">Descripción</label>
        </div>
        <div class="col s12">
          <label>Centro de Costo</label>
          <select  disabled class="selectCC js-data-example-ajax browser-default " id="slc-cc" name="centro_costo">
          </select>
        </div>


        <div class="col s12 save-button">
          <button form="formInventario" type="submit" id= "save-inventory" class="btn-floating btn-small waves-effect waves-light tooltipped blue right" data-tooltip="Continuar" name="button" >
            <i class="material-icons right">save</i>
          </button>
        </div>

      </div>

    </div>
    <!-- Fin card content -->

  </div>
</form>


<div class="card">
  <div class="card-content">
    <div class="row">
      <div class="col s6">
        <h6>Selección de Artículos</h6>
      </div>
      <!-- Modal Trigger -->
      <div class="col s6">
        <a id="btnAddArticles" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped disabled" href="#modal1" data-position="top" data-tooltip="Añadir artículos">
          <i class="large material-icons">add</i>
        </a>

      </div>
    </div>
  </div>
</div>



@endsection

@push('scripts')
<script type="text/javascript">
var path_url_submit_inventory = "{{ route('submitinv', $content['tipo_inventario']) }}";
var path_url_requiere_cc = "{{ route('requiereccinv') }}";




</script>
@endpush
