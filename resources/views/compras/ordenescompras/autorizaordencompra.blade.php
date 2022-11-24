@extends('app')


@section('title', 'Autorizar OrdenCompra')

@section('content')

<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['ordencompra'][0]->fecha }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusRequisicion"> Estatus: {{ $content['ordencompra'][0]->estatus }} </h6>
	</div>
	<div class="col s12">
		<h6 id="estatusRequisicion"> Autorizado: {{ $content['ordencompra'][0]->folio }} </h6>
	</div>
</div>

<form id ="formRequisitionEdit" method="post">
	{{ csrf_field() }}
	<div class="card">
		<!-- card content para nuevo registro en doctos_requisicion -->
		<div class="card-content">
			<div class="row">
				<div class="input-field col s12">
					<select disabled name="concepto_ordencompra">
						<option value="{{ $content['ordencompra'][0]->concepto_compra }}" selected>{{ $content['ordencompra'][0]->concepto_compra }}</option>
					</select>
					<label>Tipo Orden Compra</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<select disabled name="proveedor">
						<option value="{{ $content['ordencompra'][0]->proveedor }}" selected>{{ $content['ordencompra'][0]->proveedor}}</option>
					</select>
					<label>proveedor</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<select disabled name="almacen">
						<option value="{{ $content['ordencompra'][0]->almacen }}" selected>{{ $content['ordencompra'][0]->almacen }}</option>
					</select>
					<label>Lugar de Entrega</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					
					<textarea disabled name="descripciond" id="descripciond" class="materialize-textarea">{{ $content['ordencompra'][0]->descripcion }}</textarea>
					<label for="descripciond">Descripción</label>
					<span class="helper-text" data-error="wrong" data-success="right">Para ser utilizado en</span>
					<input type="hidden" id="{{ $content['ordencompra'][0]->docto_compra_id }}" name="requisicion_id" value="{{ Request::route('id') }}"/>
				</div>


			</div>

		</div>
		<!-- Fin card content -->

	</div>






<div class="card">

	<div class="card-content">
		<div class="row">
			<div class="col s6">
				<h6>Selección de Artículos</h6>
			</div>

			<!-- Modal Trigger -->

		</div>

		<div class="row">
			<div id="contentArticles" class="col s12">


				<table id ="tblArticlesStatic">
					<thead>
						<tr>
							<th>Cantidad</th>
							<th>Artículo</th>
							<th>Precio Unitario</th>
                            <th>Total</th>
							<th>Nota</th>
							<th></th>
						</tr>
					</thead>


					<tbody>

						@foreach ($content['articulos_ordencompra'] as $articulo_requisicion)
						<tr>
							<td class = "tblArticles">{{ $articulo_requisicion->cantidad }}</td>
							<td class = "tblArticles">{{ $articulo_requisicion->nombre }}</td>
							<td class = "tblArticles">{{ $articulo_requisicion->precio_unitario }}</td>
                            <td class = "tblArticles">{{ $articulo_requisicion->total }}</td>
							<td class = "tblArticles">{{ $articulo_requisicion->nota_articulo }}</td>



						</tr>
						@endforeach
					</tbody>

				</table>
				<div class="col s12">
					<div class="col s6 push-s3 aligtn right">
					<h5 id="total"> Total:  ${{ $content['ordencompra'][0]->total }} </h5>
					</div>
				</div>
			</div>


		</div>
	</div>

</div>

<!-- Card de imágenes -->
</form>



<!-- ********************************************************* -->

    <div class="fixed-action-btn">
  <a class="btn-floating btn-large orange">
    <i class="large material-icons">more_horiz</i>
  </a>
  <ul>

    <li><a class="btn-floating green tooltipped modal-trigger" href="#modal_autorizar" data-position="left" data-tooltip="Autorizar"><i class="material-icons">check</i></a></li>
    <li><a class="btn-floating red darken-1 tooltipped modal-trigger" href="#modal_cancelar" data-position="left" data-tooltip="Cancelar" ><i class="material-icons">cancel</i></a></li>

  </ul>
</div>

<!-- Modal Structure AUTORIZAR REQUISICIÓN-->

<div id="modal_autorizar" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Autorizar Orden Compra</h4>
		<p>¿Está seguro que desea autorizar esta Orden de Compra?</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="{{route('autorizaroc')}}" id="auth-ordencompra" 
			class="modal-close waves-effect waves-green waves-effect waves-light btn"
			id-record="{{ Request::route('id') }}"
			url-record="{{ route('sendpdfordencompra')}}">Aceptar</a>
	</div>
</div>

<!-- ********************************************************* -->

<!-- Modal Structure CANCELAR REQUISICIÓN-->

<div id="modal_cancelar" class="modal modal-fixed-footer">
		<div class="modal-content">
			<form id="formCancelarOC" action="{{ route('cancelarordencompra') }}" method="post">
				{{ csrf_field() }}
				<h4>Cancelar Orden Compra</h4>
				<p>¿Está seguro que desea cancelar esta Orden de Compra?</p>
    			<div class="input-field col s12">
      				<textarea name="descripcion"  class="materialize-textarea" required></textarea>
      				<label for="descripcion">Motivo cancelación</label>
    			</div>
				<div style="display: none">
					<input  type="text" name="ordencompra_id" value="{{ Request::route('id') }}">
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
			<a form="formCancelarOC" class="validarformulario waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
		</div>
</div>
<!-- ********************************************************* -->
@endsection
@push('scripts')
<script type="text/javascript">

</script>
@endpush