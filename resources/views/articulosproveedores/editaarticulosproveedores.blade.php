@extends('app')

@section('title', 'Artículos Proveedores')


@section('content')


<div class="card">
	<div class="card-content row">
		<div class="input-field col s6">
			<input disabled value="{{ $content['articulodata'][0]->proveedor }}" type="text" class="validate" name="proveedor">
			<label for="proveedor">Proveedor</label>
		</div>
		<div class="input-field col s6">
			<input disabled value="{{ $content['articulodata'][0]->Articulo }}" id="nombrearticulo" type="text" class="validate" name="nombrearticulo">
			<label for="nombrearticulo">Artículo</label>
		</div>
		<div class="input-field col s6">
			<input disabled value="{{ $content['articulodata'][0]->clave_sat }}" id="clavesat" type="text" class="validate" name="clavesat">
			<label for="clavesat">Clave SAT</label>
		</div>
		<div class="input-field col s6">
			<input disabled value="{{ $content['articulodata'][0]->unidad }}" id="clavesat" type="text" class="validate" name="unidad_medida">
			<label for="unidad_medida">Unidad Medida</label>
		</div>
	</div>
</div>
<br>

<div class="card">
	<div class="card-content row">
		@if($content['countarticuloseleccionado'] > 0)
		<div class=" col s12">
			<blockquote>
				{{ $content['articuloseleccionado'][0]->nombre }}
				({{ $content['articuloseleccionado'][0]->unidad_venta }})
			</blockquote>
		</div>
		@endif
		<div class=" col s12">
			<table class="display nowrap" id="tableArticulosProveedores">
				<thead>
					<tr>
						<th>Artículo</th>
						<th>U. Medida</th>
						<th>Contenido Compra</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($content['articulos'] as $articulo)
					@if( $content['articuloseleccionado'] != null)
						@if( $articulo->articulo_id == $content['articuloseleccionado'][0]->articulo_id)
					<tr class="seleccionado">
						@else
					<tr>
						@endif
					@endif
							<td id="td-articuloproveedor_{{ Request::route('id') }}_{{ $articulo->articulo_id }}">{{ $articulo->nombre }}</td>
							<td>{{ $articulo->unidad_venta }}</td>
							<td><input value="{{ $content['articulodata'][0]->ContenidoCompra }}" id="input-articuloproveedor_{{ Request::route('id') }}_{{ $articulo->articulo_id }}" class="validate" type="number" name="contenido_compra">
							</td>
							@if($content['countarticulos'] > 0)
							<td class="selected">
								<i class="material-icons assign-article tooltipped"  data-tooltip="Asignar" id-record="{{ $articulo->articulo_id }}" id-asign="{{ Request::route('id') }}">library_add</i>
							</td>
							@else
							<td>
								<i class="material-icons assign-article tooltipped"  data-tooltip="Asignar" id-record="{{ $articulo->articulo_id }}" id-asign="{{ Request::route('id') }}">library_add</i>
							</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

</form>


@endsection


@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
@endpush
