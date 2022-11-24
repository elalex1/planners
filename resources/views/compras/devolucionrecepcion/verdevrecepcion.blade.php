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
		<h6> Fecha: {{ $data['recepcion']->fecha }} </h6>
	</div>
	<div class="col s6">
		<h6 > Estatus:
			{{-- @switch($data['recepcion']->estatus)
                                    @case('Pendiente')
                                        <span class="status text-pending">•{{ $data['recepcion']->estatus }}</span>
                                    @break

                                    @case('Terminado')
                                        @if ($data->aplicado == 'No')
                                            <span class="status text-authorized">•{{ $data['recepcion']->estatus }}</span>
                                        @else
                                            <span class="status text-finished">•</span>
                                        @endif
                                    @break

                                    @case('Cancelado')
                                        <span class="status text-cancel">•{{ $data['recepcion']->estatus }}</span>
                                    @break
                                @endswitch --}}
			 {{ $data['recepcion']->estatus }} 
			</h6>
	</div>
</div>

<form>
	{{ csrf_field() }}
	<div class="card">
		<div class="card-tabs">
			<ul class="tabs trasparent">
				<li class="tab col l2 m4 s6"><a class="active" href="#vista1">General</a></li>
				<li class="tab col l2 m4 s6 buttonmonedaextranjera hide"><a href="#vista2">Otros Datos</a></li>
			</ul>
		</div>
		<!-- card content para nuevo registro en doctos_requisicion -->
		<input name="id" type="text" hidden value="{{ $data['recepcion']->docto_compra_id }}">
		<div class="card-content grey lighten-5">

			<div id="vista1" class="row">
				<div class="row col s12">
					<label>proveedor</label>
					<select disabled class="error selectProveedor browser-default"
						url-verify="{{ route('recepcionmercancia_verif_prov', $data['recepcion']->proveedor) }}">
						<option selected value="" selected>{{ $data['recepcion']->proveedor }}</option>
						<input name="proveedor" type="text" hidden value="{{ $data['recepcion']->proveedor }}">
					</select>
				</div>
				<div class="row col s12">
					<label>Almacen</label>
					<select disabled name="almacen" class="error browser-default white">
						<option value="{{ $data['recepcion']->almacen }}" selected>{{ $data['recepcion']->almacen }}
						</option>
					</select>
				</div>
				<div class="row">
					<div class="col s3">
						<label for="fecha">Fecha</label>
						<input disabled type="date" value="{{ $data['recepcion']->fecha }}">
						<input name="fecha" type="text" hidden value="{{ $data['recepcion']->fecha }}">

					</div>
					<div class="col s6">
						<label for="folio">Folio Remisión Proveedor</label>
						<input disabled type="text" value="{{ $data['recepcion']->folio }}">
						<input name="folio" type="text" hidden value="{{ $data['recepcion']->folio }}">
					</div>
						<div class="col s3">
							<label>Moneda</label>
							<select disabled class="error browser-default verify_moneda"
								url-record="{{ route('recepcionmercancia_verif_moneda', '000') }}">
								<option value="{{ $data['recepcion']->moneda }}" selected>
									{{ $data['recepcion']->moneda }}</option>
								<input name="moneda" type="text" hidden value="{{ $data['recepcion']->moneda }}">
							</select>
						</div>
				</div>

				<div class="col s12">
					<div class="input-field col s6">
						<label>Descuento</label></label>
						<input disabled type="number" class="noarrows" name="importe_descuento" min="0"
							value="{{ $data['recepcion']->importe_descuento }}">
					</div>
					<div class="col s6">
						<p><label>Descuentp por</label></p>
						@if ($data['recepcion']->tipo_descuento == 'P')
							<p><label><input disabled type="radio" name="tipo_descuento" value="P"
										checked><span>Porcentaje</span></label></p>
							<p><label><input disabled type="radio" name="tipo_descuento" value="I"><span>Importe</span></label>
							</p>
						@elseif($data['recepcion']->tipo_descuento == 'I')
							<p><label><input disabled type="radio" name="tipo_descuento"
										value="P"><span>Porcentaje</span></label></p>
							<p><label><input disabled type="radio" name="tipo_descuento" value="I"
										checked><span>Importe</span></label></p>
						@else
							<p><label><input disabled type="radio" name="tipo_descuento"
										value="P"><span>Porcentaje</span></label></p>
							<p><label><input disabled type="radio" name="tipo_descuento" value="I"><span>Importe</span></label>
							</p>
						@endif

					</div>
				</div>

			</div>
			<div id="vista2" class=" row col s12 bloque">
				<div class="input-field col s4">
					<label>Tipo de Cambio</label>
					<input disabled type="number" class="noarrows" name="tipo_cambio" min="1"
						value="{{ $data['recepcion']->tipo_cambio }}">
				</div>
				<div class="input-field col s4">
					<label>Arancel</label>
					<input disabled type="number" class="noarrows"  min="0"
						value="{{ $data['recepcion']->arancel }}" disabled>
				</div>
				<div class="input-field col s4">
					<label>Gastos aduanales</label>
					<input disabled type="number" class="noarrows"  min="0"
						value="{{ $data['recepcion']->gastos_aduanales }}" disabled>
				</div>
				<div class="input-field col s6">
					<label>Otros Gastos</label>
					<input disabled type="number" class="noarrows" name="otros_gastos" min="0"
						value="{{ $data['recepcion']->otros_gastos }}">
				</div>
				<div class="input-field col s6">
					<label>Fletes</label>
					<input disabled type="number" class="noarrows" name="fletes" min="0"
						value="{{ $data['recepcion']->fletes }}">
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
				<h6>Artículos</h6>
			</div>
		</div>
			<div class="row">
				<div class="col s12">
					<table id="tblArticlesStatic">
						<thead>
							<tr>
								<th>Clave</th>
								<th>Descripción</th>
								<th>Unidad Medida</th>
								<th>Cantidad</th>
								<th>Precio U.</th>
								<th>Importe</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data['recepcionDet'] as $articulo)
								<tr>
									<td>{{ $articulo->clave_articulo }}</td>
									<td>{{ $articulo->articulo }}</td>
									<td>{{ $articulo->unidad_compra }}</td>
									<td>{{ $articulo->cantidad }}</td>
									<td>{{  number_format($articulo->precio_unitario,2) }}</td>
									<td>{{   number_format($articulo->total,2) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					@if ($data['recepcion']->total > 0)
						<div class="row col s12 pull-s1">
							<h5 id="total" class="right"><strong>Total: $</strong> {{ number_format($data['recepcion']->total,2) }} </h5>
						</div>
					@endif

				</div>
	</div>
</div>
</div>


</div>
</div>
</div>
</div>


</main>
