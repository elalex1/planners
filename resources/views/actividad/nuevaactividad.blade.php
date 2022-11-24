@extends('app')


@section('title', 'Nueva Actividad')

@section('content')
<form id="formActivity" method="POST">
	{{ csrf_field() }}
	<div class="card">


		<!-- card content para nuevo registro en doctos_requisicion -->
		<div class="card-content">

			<div class="row">

				<div class="col s6">
					<label>Fecha Actividad</label>
					<input name="fecha_proceso" type="text" class="datepicker">
				</div>
				<div class="col s6">
					<label>Hora Actividad</label>
					<input name="hora_proceso" type="text" class="timepicker">
				</div>

				<div class="col s6">
					<label>Rancho</label>
					<select id="slcrancho" name="rancho" class="error browser-default">
						<option value="" disabled  selected >Selecciona opción</option>
						@foreach ($content['ranchos'] as $rancho)
						<option value="{{ $rancho->nombre }}">{{ $rancho->nombre }}</option>
						@endforeach
					</select>
				</div>

				<div class="input-field col s6">
					<br>
					<select id="slccuadrilla" class="js-data-example-ajax browser-default" name="slccuadrilla">
					</select>
				</div>

				<div class="col s12">
					<button form="formActivity" type="submit" id= "save-activity" class="btn-floating btn-small waves-effect waves-light tooltipped blue right" data-tooltip="Continuar" name="button" >
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
				<h6>Selección de Actividades</h6>
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
var path_url_submit_act = "{{ route('submitact') }}";
var path_url_applotinfo  = "{{ route('lotinfo') }}";


</script>
@endpush
