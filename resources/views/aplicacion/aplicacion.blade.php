@extends('app')

@section('title', 'Aplicaciones')


@section('content')


<div class="card">
	<div class="card-content">

		<table class="display" id="tableApplications">
			<thead>
				<tr>
					<th data-priority="1">Fecha Aplicación</th>
					<th data-priority="4">Folio</th>
					<th data-priority="3">Estatus</th>
					<th data-priority="2">Lote</th>
					<th data-priority="6">Creado por</th>
					<th data-priority="5"></th>
				</tr>
			</thead>

			<tbody>
				@foreach ($content['producciones'] as $produccion)
				<tr>
					<td>{{ $produccion->fecha_proceso }}</td>
					<td>{{ $produccion->folio }}</td>
					<td>
						@switch($produccion->estatus)
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

						{{ $produccion->estatus }}
					</td>
					<td>{{ $produccion->lote }}</td>
					<td>{{ $produccion->usuario_creacion }}</td>
					<td>

						@switch($produccion->estatus)
						@case('Pendiente')
						<i class="material-icons edit-record-app tooltipped" data-tooltip="Editar" id-record="{{ $produccion->docto_produccion_id }}" >edit</i>
						<i class="material-icons disabled-btn tooltipped"  data-tooltip="La aplicación debe estar terminada" >picture_as_pdf</i>
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La receta debe estar terminada">beenhere</i>
						@break
						@case('Normal')
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La aplicación debe estar pendiente">edit</i>
						<a class="pdf-record" target="_blank" href="{{ route('apppdf',  $produccion->docto_produccion_id) }}">
							<i class="material-icons tooltipped"  data-tooltip="Descargar PDF"  id-record="{{ $produccion->docto_produccion_id }}" >picture_as_pdf</i>
						</a>
							@if($produccion->concepto_produccion_id == 2)
						<a class="pdf-record" href="{{ route('aplicareceta', [ $produccion->docto_produccion_id, $produccion->folio]) }}">
							<i class="material-icons tooltipped"  data-tooltip="Aplicar Receta"  id-record="{{ $produccion->docto_produccion_id }}" >beenhere</i>
						</a>
						@else
							<i class="material-icons tooltipped disabled-btn"  data-tooltip="Solo se pueden aplicar recetas">beenhere</i>
							@endif
						@break

						@case('Cancelado')
						<i  class="material-icons disabled-btn" id-record="{{ $produccion->docto_produccion_id }}" >edit</i>
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La aplicación debe estar terminada" >picture_as_pdf</i>
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La receta debe estar terminada">beenhere</i>
						@break

						@endswitch
						<i class="material-icons tooltipped view-record-app" data-tooltip="Visualizar" id-record="{{ $produccion->docto_produccion_id }}">remove_red_eye</i>
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
	<a class="btn-floating btn-large waves-green waves-effect waves-light tooltipped light-green accent-4" href="aplicacion/nueva" data-position="top" data-tooltip="Nueva aplicación">
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
var path_url_iframe_app = "{{ route('ver-app', 1) }}";
</script>

@endpush
