@extends('app')

@section('title', 'Aplicaciones')


@section('content')


<div class="card">
	<div class="row card-content">
<form id ="formDateBitaAgro" method="post">
		<div class="col s6">
			<input id="fechaibitacora" name="fechaibitacora" type="text" class="datepicker">
			<label for="fechaibitacora">Fecha Inicial</label>
		</div>
		<div class=" col s6">
			<input id="fechafbitacora" name="fechafbitacora" type="text" class="datepicker">
			<label for="fechafbitacora">Fecha Final</label>
		</div>
		<div class="col s12">
			<button form="formDateBitaAgro" type="submit" id= "save-application" class="btn-floating btn-medium waves-effect waves-light tooltipped red right"  data-tooltip="Búsqueda" name="button" >
				<i class="material-icons right">search</i>
			</button>
		</div>
	</form>
</div>
</div>

		<div class="card">
			<div class="card-content">
				@if($content['countplaguicida'] > 0)
		<table class="display nowrap" id="tableBitacora">
			<thead>
				<tr>
					<th>Folio</th>
					<th>Lote</th>
					<th>Fecha</th>
					<th>Hora Término</th>
					<th>Plaguicida</th>
					<th>Ingrediente Activo</th>
					<th>Dosis</th>
					<th>Tipo Plaguicida</th>
					<th>Plaga a Controlar</th>
					<th>Re-entrada al campo (h)</th>
					<th>Intervalo Seguridad</th>
					<th>Equipo Usado</th>
					<th>Via Aplicación</th>
					<th>Pozo Abastecimiento</th>
					<th>Aplicador</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($content['bitacoraplaguicida'] as $bitacoraplaguicida)
				<tr>
					<td>{{ $bitacoraplaguicida->folio }}</td>
					<td>{{ $bitacoraplaguicida->Lote }}</td>
					<td>{{ $bitacoraplaguicida->fecha_proceso }}</td>
					<td>{{ $bitacoraplaguicida->hora_proceso }}</td>
					<td>{{ $bitacoraplaguicida->nombre }}</td>
					<td>{{ $bitacoraplaguicida->ingrediente_activo }}</td>
					<td>{{ $bitacoraplaguicida->Dosis }}</td>
					<td>{{ $bitacoraplaguicida->TipoPlaguicida }}</td>
					<td>{{ $bitacoraplaguicida->PlagaAControla }}</td>
					<td>{{ $bitacoraplaguicida->ReEntradaalCampoHoras }}</td>
					<td>{{ $bitacoraplaguicida->IntervaloDeSeguridad }}</td>
					<td>{{ $bitacoraplaguicida->IntervaloDeSeguridad }}</td>
					<td>{{ $bitacoraplaguicida->ViaAplicacion }}</td>
					<td>{{ $bitacoraplaguicida->pozo_abastecimiento }}</td>
					<td>{{ $bitacoraplaguicida->Aplicador }}</td>
				</tr>
				@endforeach

			</tbody>
		</table>
@endif


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
