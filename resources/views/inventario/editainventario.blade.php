@extends('app')


@section('title', 'Editar Documento - ' . $content['tipo_inventario'])
@push('css')

<link rel="stylesheet" href="{{ asset('css/inventory.css') }}">

@endpush

@section('content')

<div class="row">
  <div class="col s6">
    <h6> Fecha: {{ $content['inventario'][0]->fecha }} </h6>
  </div>
  <div class="col s6">
    <h6 class="estatusDocto"> Estatus: {{ $content['inventario'][0]->estatus }} </h6>
  </div>
</div>
<form id ="formInventoryEdit" method="post">
  {{ csrf_field() }}
  <div class="card">
    <!-- card content para nuevo registro en doctos_inventario -->
    <div class="card-content">




      <div class="row">
        <div class="input-field col s6">
          <select disabled name="concepto_inventario">
            <option value="{{ $content['inventario'][0]->nombre }}" selected>{{ $content['inventario'][0]->nombre }}</option>
          </select>
          <label>Concepto</label>
        </div>

        <div class="input-field col s6">
          <select disabled name="almacend" >
            <option value="{{ $content['inventario'][0]->almacen }}">{{ $content['inventario'][0]->almacen }}</option>
          </select>
          <label>Almacén</label>
        </div>

      </div>

      <div class="row">

        <div class="input-field col s12">
          <select disabled name="centro_costo" >
            <option value="{{ $content['inventario'][0]->centro_costo }}">{{ $content['inventario'][0]->centro_costo }}</option>
          </select>
          <label>Centro de Costo</label>
        </div>
        <div class="input-field col s12">
          <textarea name="descripciond" id="descripciond" class="materialize-textarea">{{ $content['inventario'][0]->descripcion }}</textarea>
          <label for="descripciond">Descripción</label>
          <input type="hidden" id="{{ $content['inventario'][0]->docto_inventario_id }}" name="inventario_id" value="{{ Request::route('id') }}"/>

        </div>

        <div class="save-button col s12">
          <button type="submit" id="update-inventory" class="btn-floating btn-small right light-blue waves-effect waves-light tooltipped" data-position="top" data-tooltip="Guardar Cambios">
            <i class="large material-icons">save</i>
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
      <div class="input-field col s6">
        <a id="btnAddArticles" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped" href="#modalArticlesInv" data-position="top" data-delay="50" data-tooltip="Añadir artículos">
          <i class="large material-icons">add</i>
        </a>
      </div>
    </div>

    <div class="row">
      <div id="contentArticles" class="col s12">

        <!--loader-->
        <div id ="loader-articles" class="preloader-wrapper big active">
          <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div><div class="gap-patch">
              <div class="circle"></div>
            </div><div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
        </div>
        <!--fin loader-->

        <table id ="tblArticlesStatic">
          <thead>
            <tr>
              <th>Cantidad</th>
              <th>Artículo</th>
              <th></th>
            </tr>
          </thead>


          <tbody>

            @foreach ($content['articulos_inventario'] as $articulo_inventario)
            <tr>
              <td>{{ $articulo_inventario->cantidad }}</td>
              <td>{{ $articulo_inventario->nombre }}</td>
              <td>
                <i class="material-icons delete-record-inv tooltipped" data-delay="50" data-tooltip="Eliminar artículo" id-record="{{ $articulo_inventario->nombre }}" id-asign="{{ Request::route('id') }}">delete_forever</i>
              </td>


            </tr>
            @endforeach

          </tbody>

        </table>
      </div>


    </div>
  </div>
  <div class="fixed-action-btn">

    <a class="btn-floating btn-large green tooltipped modal-trigger"  href="#modalFinalizaDocumento" data-position="left" data-tooltip="Finalizar">
      <i class="large material-icons">check</i>
    </a>
  </div>
</div>




<!-- Modal Structure FINALIZAR INVENTARIO-->

<div id="modalFinalizaDocumento" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4>Finalizar Documento</h4>
    <p>¿Está seguro que desea finalizar este documento?</p>
    <p>	Nota: Si finaliza el documento no podrá volver a editarlo.</p>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
    <a href="#!" id="finaliza-inventario" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
  </div>
</div>
<!--  -->


<!-- Modal Structure Artículos -->
<div id="modalArticlesInv" class="modal modal-fixed-footer">

  <div class="modal-content" id="content-datableArticles">
    {{ csrf_field() }}
    <h4>Artículos</h4>


    <table class="display" id="tableArticlesInv">
      <thead>
        <tr>

          <th>Cantidad</th>
          <th>U. Medida</th>
          <th>Artículo</th>


        </tr>
      </thead>

      <tbody id="tblArticles" class = "tblArticles nowrap">
        @foreach ($content['articulos'] as $articulo)
        <tr id = "{{ $articulo->articulo_id }}">

          <td id = "cantidad" class = "tblArticles">
            <input class="cantidadnumeric" id="cantidad-{{ $articulo->articulo_id }}" type="number" min="0" name="cantidad-{{ $articulo->articulo_id }}" />
            <input type="hidden" id="inv-{{ $articulo->articulo_id }}" name="inv-{{ $articulo->articulo_id }}" value="{{ Request::route('id') }}"/>
            <input type="hidden" id="nombre-{{ $articulo->articulo_id }}" name="nombre-{{ $articulo->articulo_id }}" value="{{ $articulo->nombre }}"/>
          </td>

          <td class = "tblArticles">{{ $articulo->unidad_compra }}
          </td>
            <td class = "tblArticles">{{ $articulo->nombre }}

            </td>

          </tr>
          @endforeach

        </tbody>
      </table>





    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-light">
        Cancelar
      </a>
      <a href="#!" id="save-articles-inv" class="modal-action modal-close waves-effect waves-light btn">
        Aceptar
      </a>
    </div>

  </div>
  <!-- Modal Structure -->







  @endsection
  @push('scripts')
  <script type="text/javascript">
  var path_url_submitarticlesinv = "{{ route('submitarticlesinv', $content['tipo_inventario']) }}";
  var path_url_updateinventory = "{{ route('updateinventory', $content['tipo_inventario']) }}";
  var path_url_appinventory = "{{ route('appinventory', $content['tipo_inventario']) }}";

</script>
@endpush
