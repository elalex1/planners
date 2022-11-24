@extends('app')

@section('title', 'Artículos Proveedores')


@section('content')


<div class="card">
	<div class="card-content row">
		<form id ="formSearchProvider" method="post" enctype="multipart/form-data">
			<div class=" col s8">
				<label>Proveedor</label>
				<select id="slcproveedor" class="js-data-example-ajax browser-default" name="slcproveedor">
				</select>
			</div>
			<div class=" col s4">
				<label>Estatus Artículos</label>
				<select id="slcestatus" name="slcestatusartic" class="browser-default">
					<option value="" disabled  selected>Selecciona opción</option>
					<option value="Asignados">Asignados</option>
					<option value="No Asignados">No Asignados</option>
				</select>
			</div>
			<br>
			<div class="col s12">
				<button type="submit" id="search-articles" class="btn-floating btn-small right light-blue waves-effect waves-light tooltipped" data-position="top" data-tooltip="Buscar">
					<i class="large material-icons">search</i>
				</button>
			</div>
		</form>
	</div>
</div>
<br>
@if($content['countarticulos'] > 0)
<div class="card">
	<div class="card-content row">
		<div class=" col s12">
			<table class="display nowrap" id="tableArticulosProveedores">
				<thead>
					<tr>
						<th>Artículo Proveedor</th>
						<th>Artículo Catálogo</th>
						<th></th>
					</tr>
				</thead>

				<tbody>



					@foreach ($content['articulos'] as $articulo_proveedor)
					<tr>
						<td>{{ $articulo_proveedor->ArticuloProveedor }}</td>
						<td>{{ $articulo_proveedor->ArticulosCatalogo }}</td>
						<td>
							<a class="edit-record-art" href="{{ route('articulosproveedores',  $articulo_proveedor->articulo_proveedor_id) }}">
								<i class="material-icons tooltipped" data-tooltip="Editar" id-record="{{ $articulo_proveedor->articulo_proveedor_id }}" >edit</i>
							</a>

						</td>
					</tr>

					@endforeach

				</tbody>
			</table>
			@endif

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
