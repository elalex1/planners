@extends('app')


@section('title', 'Nueva Aplicación')

@section('content')
<form id="formApplication" method="POST">
	{{ csrf_field() }}
	<div class="card">


		<!-- card content para nuevo registro en doctos_requisicion -->
		<div class="card-content">

			<div class="row">

				<div class="col s12">
					<label>Tipo Producción</label>
					<select id="slc-con-produccion" name="concepto_produccion" class="error browser-default">
						<option value="" disabled  selected >Selecciona opción</option>
						@foreach ($content['conceptos_producciones'] as $concepto_produccion)
						<option value="{{ $concepto_produccion->nombre }}" fechaobli="{{ $concepto_produccion->fecha_obligatoria }}" horaobli="{{ $concepto_produccion->hora_obligatoria }}">{{ $concepto_produccion->nombre }}</option>
						@endforeach
					</select>
					<br>
				</div>

				<div id="fechacontent" class="col s6">
					<label>Fecha Aplicación</label>
					<input name="fecha_proceso" type="text" class="datepicker">
				</div>
				<div id="horacontent" class="col s6">
					<label>Hora Aplicación</label>
					<input name="hora_proceso" type="text" class="timepicker">
				</div>

				<div class=" col s12">
				</br>
				<select id="slclote" class="js-data-example-ajax browser-default" name="slclote">
				</select>
			</div>

			<div class="input-field col s4">
				<input disabled value="" id="cosecha" type="text" class="validate" name="cosecha">
				<label id="lblcosecha"  for="cosecha">Cosecha</label>
			</div>
			<div class="input-field col s4">
				<input disabled value="" id="superficie" type="text" class="validate" name="superficie">
				<label id="lblsuperficie" for="superficie">Superficie(HA)</label>
			</div>
			<div class="input-field col s4">
				<input disabled value="" id="rancho" type="text" class="validate" name="rancho">
				<label id="lblrancho" for="rancho">Rancho</label>
			</div>

			<div class="col s12">
				<button form="formApplication" type="submit" id= "save-application" class="btn-floating btn-small waves-effect waves-light tooltipped blue right" data-tooltip="Continuar" name="button" >
					<i class="material-icons right">save</i>
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
			<div class="col s6">
				<a id="btnAddArticles" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped disabled" href="#modal1" data-position="top" data-tooltip="Añadir artículos">
					<i class="large material-icons">add</i>
				</a>




			</div>
		</div>
	</div>
</div>



@endsection

@push('scripts')
<script type="text/javascript">
var path_url_submit_app = "{{ route('submitapp') }}";
var path_url_applotinfo  = "{{ route('lotinfo') }}";

document.getElementById("fechacontent").style.display = "none";
document.getElementById("horacontent").style.display = "none";

</script>
@endpush
