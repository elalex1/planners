@extends('app')


@section('menu')
@stop
@section('header')
@stop

@section('content')
@stop


<main>
<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['compra'][0]->fecha }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusRequisicion"> Estatus: {{ $content['compra'][0]->estatus }} </h6>
	</div>
</div>

<form id ="formRequisitionEdit" method="post">
	{{ csrf_field() }}
	<div class="card">
		<!-- card content para nuevo registro en doctos_requisicion -->
		<div class="card-content">
			<div class="row">
				<div class="input-field col s12">
					<select disabled name="concepto_requisicion">
						<option value="{{ $content['compra'][0]->concepto_compra }}" selected>{{ $content['compra'][0]->concepto_compra }}</option>
					</select>
					<label>Tipo Orden Compra</label>
				</div>
                <div class="input-field col s12">
					<select disabled name="proveedor">
						<option value="{{ $content['compra'][0]->proveedor }}" selected>{{ $content['compra'][0]->proveedor }}</option>
					</select>
					<label>Proveedor</label>
				</div>
				<div class="col s12">
					<select disabled id="slc-almacen" name="almacen" class="error browser-default">
						<option disabled value="{{ $content['compra'][0]->almacen }}" selected>{{ $content['compra'][0]->almacen  }}</option>
					</select>
					<label>Lugar de entrega</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<textarea disabled name="descripciond" id="disabled" class="materialize-textarea">{{ $content['compra'][0]->descripcion }}</textarea>
					<label for="disabled">Descripción</label>
					<span class="helper-text" data-error="wrong" data-success="right">Para ser utilizado en</span>
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
			</div>
			<div class="row">
				<div id="contentArticles" class="col s12">
					<table class="tblArticles" id ="tblArticlesStatic">
						<thead>
							<tr>
								<th>Cantidad</th>
								<th>Artículo</th>
								<th>Precio Unitario</th>
								<th>Precio Total</th>
								<th>Nota</th>
							</tr>
						</thead>


						<tbody>

							@foreach ($content['articulos_compra'] as $articulo_requisicion)
							<tr>
								<td class = "tblArticles">{{ $articulo_requisicion->cantidad }}</td>
								<td class = "tblArticles">{{ $articulo_requisicion->nombre }}</td>
								<td class = "tblArticles">{{ $articulo_requisicion->precio_unitario }}</td>
								<td class = "tblArticles">{{ $articulo_requisicion->total }}</td>
                                <td class="tblArticles">{{$articulo_requisicion->nota_articulo}}</td>
							</tr>
							@endforeach

						</tbody>

					</table>
					@if ($content['compra'][0]->total > 0)
						<div class="col s12">
							<div class="col s4 right">
							<h5 id="total"> Total:  ${{ $content['compra'][0]->total }} </h5>
							</div>
						</div>
					@endif
				</div>


			</div>
		</div>

	</div>
</form>

</div>
</div>
</div>
</div>


</main>
