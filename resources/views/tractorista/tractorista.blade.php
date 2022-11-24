@extends('app')

@section('title', 'Actividades')


@section('content')


<div class="card">
	<div class="card-content">

		<table class="display" id="tableActivities">
			<thead>
				<tr>
					<th data-priority="1">Fecha Actividades</th>
					<th data-priority="4">Rancho</th>
					<th data-priority="3">Estatus</th>
					<th data-priority="2">Cuadrilla</th>
					<th data-priority="6">Creado por</th>
					<th data-priority="5"></th>
				</tr>
			</thead>

			<tbody>
				@foreach ($content['actividades'] as $actividad)
				<tr>
					<td>{{ $actividad->fecha }}</td>
					<td>{{ $actividad->rancho }}</td>
					<td>
						@switch($actividad->estatus)
						@case('Pendiente')
						<span class="status text-pending">•</span>
						@break

						@case('Normal')
						<span class="status text-authorized">•</span>
						@break

						@case('Cancelado')
						<span class="status text-cancel">•</span>
						@break
						@endswitch

						{{ $actividad->estatus }}
					</td>
					<td>{{ $actividad->nombre_equipo }}</td>
					<td>{{ $actividad->usuario_creacion }}</td>
					<td>

						@switch($actividad->estatus)
						@case('Pendiente')
						<i class="material-icons edit-record-act tooltipped" data-tooltip="Editar" id-record="{{ $actividad->actividad_empleado_produccion_id }}" >edit</i>
						<i class="material-icons disabled-btn tooltipped"  data-tooltip="La actividad debe estar terminada" >picture_as_pdf</i>
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La receta debe estar terminada">beenhere</i>
						@break
						@case('Normal')
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La actividad debe estar pendiente">edit</i>
						<a class="pdf-record" target="_blank" href="{{ route('apppdf',  $actividad->actividad_empleado_produccion_id) }}">
							<i class="material-icons tooltipped"  data-tooltip="Descargar PDF"  id-record="{{ $actividad->actividad_empleado_produccion_id }}" >picture_as_pdf</i>
						</a>
						@break
						@case('Terminado')
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La actividad debe estar pendiente">edit</i>
						<a class="pdf-record" target="_blank" href="{{ route('apppdf',  $actividad->actividad_empleado_produccion_id) }}">
							<i class="material-icons tooltipped"  data-tooltip="Descargar PDF"  id-record="{{ $actividad->actividad_empleado_produccion_id }}" >picture_as_pdf</i>
						</a>
						@break

						@case('Cancelado')
						<i  class="material-icons disabled-btn" id-record="{{ $actividad->actividad_empleado_produccion_id }}" >edit</i>
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La actividad debe estar terminada" >picture_as_pdf</i>
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La receta debe estar terminada">beenhere</i>
						@break

						@endswitch
						<i class="material-icons tooltipped view-record-act" data-tooltip="Visualizar" id-record="{{ $actividad->actividad_empleado_produccion_id }}">remove_red_eye</i>
					</td>
				</tr>
				@endforeach

			</tbody>
		</table>



	</div>
</div>
</div>
<!-- Botón -->
<div class="fixed-action-btn" >
	<a class="btn-floating btn-large waves-green waves-effect waves-light tooltipped light-green accent-4" href="actividad/nueva" data-position="top" data-tooltip="Nueva actividad">
		<i class="large material-icons">add</i>
	</a>
</div>


<!-- Modal Structure Visualizar Produccion-->
<div id="mdl-iframe" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div id="modal-contenido" class="responsive-video">
			<iframe id="if-aplicacion" width="100%" height= "calc(100% - 56px)" max-height="100%" src="" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
	</div>
</div>
<!-- Fin Visualizar produccion-->

</form>

@endsection


@push('scripts')

<script type="text/javascript">
var path_url_iframe_act = "{{ route('ver-act', 1) }}";

</script>

@endpush
