@extends('app')

@section('title', 'Requisiciones')


@section('content')


<div class="card">
	<div class="card-content">

		<table class="display nowrap" id="tableBitacoraRequisiciones">
			<thead>
				<tr>
					<th>Folio</th>
					<th>Nota</th>
					<th>Requisición</th>
					<th>Artículo</th>
					<th>Usuario</th>
					<th>UUID</th>
					<th>Correo usuario</th>
					<th>Fecha autorización</th>
					<th>Cantidad</th>
					<th>Centro de costo</th>
					<th>Tipo Requisición</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($content['bitacorarequisiciones'] as $bitacorarequisicion)
				<tr>
					<td>{{ $bitacorarequisicion->folio }}</td>
					<td>{{ $bitacorarequisicion->nota_articulo }}</td>
					<td>{{ $bitacorarequisicion->descripcion }}</td>
					<td>{{ $bitacorarequisicion->articulo }}</td>
					<td>{{ $bitacorarequisicion->nombre }}</td>
					<td>{{ $bitacorarequisicion->uuid_texto }}</td>
					<td>{{ $bitacorarequisicion->usuario_creacion }}</td>
					<td>{{ $bitacorarequisicion->fecha_autorizacion }}</td>
					<td>{{ $bitacorarequisicion->cantidad }}</td>
					<td>{{ $bitacorarequisicion->centro_de_costo }}</td>
					<td>{{ $bitacorarequisicion->tipo_requisicion }}</td>
				</tr>
				@endforeach

			</tbody>
		</table>



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
