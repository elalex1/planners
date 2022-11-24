	@extends('app')


	@section('title', 'Editar Actividad')

	@section('content')

	<div class="row">
		<div class="col s6">
			<h6> Fecha: {{ $content['actividad'][0]->fecha_creacion }} </h6>
		</div>
		<div class="col s6">
			<h6 id="estatusActivity"> Estatus: {{ $content['actividad'][0]->estatus }} </h6>
		</div>
	</div>

		<div class="card">
			<!-- card content para nuevo registro en doctos_producciones -->
			<div class="card-content">
				<div class="row">

					<div class="col s6">
						<label>Fecha Actividad</label>
						<input disabled name="fecha" type="text" class="datepicker" value="{{ $content['actividad'][0]->fecha }}">
					</div>
					<div class="col s6">
						<label>Hora Actividad</label>
						<input disabled name="hora" type="text" class="timepicker" value="{{ $content['actividad'][0]->hora }}">
					</div>
					<div class="input-field col s6">
						<input disabled value="{{ $content['actividad'][0]->rancho }}" id="rancho" type="text" class="validate" name="rancho">
						<label id="lblrancho" for="rancho">Rancho</label>
					</div>
					<div class="input-field col s6">
						<input disabled value="{{ $content['actividad'][0]->nombre_equipo }}" id="cuadrilla" type="text" class="validate" name="cuadrilla">
						<label for="rancho">Cuadrilla</label>
					</div>


				</div>

			</div>
			<!-- Fin card content -->
		</div>

	<div class="card">

		<div class="card-content">
			<div class="row">
				<div class="col s6">
					<h6>Selección de Actividad/Lote</h6>
				</div>

				<!-- Modal Trigger -->
				<div class="input-field col s6">
					<a id="btnAddActivity" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped" href="#mdlActivity" data-position="top" data-delay="50" data-tooltip="Añadir actividad/lote">
						<i class="large material-icons">add</i>
					</a>
				</div>
			</div>

			<div class="row">
				<div id="contentActivities" class="col s12">
					@if($content['count_actividades'] > 0)

						<table id="tablePaseLista">
							<thead>
								<tr>
									@foreach ($content['actividad_produccion'][0] as $key=>$value)

									<th>{{ htmlspecialchars($key) }}</th>
									@endforeach
								</tr>
							</thead>

							<tbody>
								@foreach ($content['actividad_produccion'] as $key=>$value)
								<tr>
									@foreach ($value as $value2)

									@if($loop->index > 0)
									<td>
										<input value="{{$value2}}" x="{{$loop->index}}" y="{{$loop->parent->index+1}}" class="horas" name="horas" id="{{$loop->index . $loop->parent->index+1}}"  type="number" class="validate">
									</td>
									@else
									<td>{{$value2}}</td>
									@endif
									@endforeach
								</tr>
								@endforeach


							</tbody>
						</table>
						@endif

				</div>


			</div>

		</div>
	</div>

	<form id="formEmpleado" method="POST">
		{{ csrf_field() }}
	<div class="card">
		<!-- card content para nuevo registro en doctos_producciones -->
		<div class="card-content">
			<div class="row">
				<div class="col s12">
					<h6>Nuevo Empleado</h6>
				</div>

				<div class="input-field col s1">
					<input id="numeroempleadod" name="numeroempleadod" type="text"  class="validate">
					<label for="numeroempleadod">No. Empl.</label>
				</div>
				<div class="input-field col s4">
					<input id="paternod" name="paternod" type="text"  class="validate">
					<label for="paternod">Apellido Paterno*</label>
				</div>
				<div class="input-field col s3">
					<input id="maternod" name="maternod" type="text" class="validate">
					<label for="maternod">Apellido Materno</label>
				</div>
				<div class="input-field col s4">
					<input id="nombred" name="nombred" type="text" class="validate">
					<label for="nombred">Nombre*</label>
				</div>
				<div class="input-field col s6">
					<input id="rfcd" name="rfcd" type="text" class="validate">
					<label for="rfcd">RFC(*)</label>
				</div>
				<div class="input-field col s6">
					<input id="curpd" name="curpd" type="text" class="validate">
					<label for="curpd">CURP*</label>
				</div>
				<div class="input-field col s4">
					<input id="fechanacimientod" name="fechanacimientod" type="text" class="datepicker">
					<label for="fechanacimientod">Fecha Nacimiento*</label>
				</div>
				<div class="input-field col s4">
					<input id="nssd" name="nssd" type="text" class="validate">
					<label for="nssd">NSS</label>
				</div>
				<div class="input-field col s4">
					<input id="rpd" name="rpd" type="text" class="validate">
					<label for="rpd">Registro Patronal</label>
				</div>
				<div class="input-field col s6">
					<input id="fechaaltad" name="fechaaltad" type="text" class="datepicker">
					<label for="fechaaltad">Fecha Alta</label>
				</div>
				<div class="col s6">
					<label>Puesto*</label>
					<select id="puestod" name="puestod" class="error browser-default">
						<option value="" disabled  selected >Selecciona opción</option>
						@foreach ($content['puestos'] as $puesto)
						<option value="{{ $puesto->nombre }}">{{ $puesto->nombre }}</option>
						@endforeach
					</select>
					<br>
				</div>

				<div class="col s12">
						<button form="formEmpleado" type="submit" id= "save-empleado" class="btn-floating btn-small waves-effect waves-light tooltipped orange right" data-tooltip="Guardar" name="button" >
						<i class="material-icons right">person</i>
					</button>
				</div>

			</div>

		</div>
		<!-- Fin card content -->
	</div>
		</form>



	<div class="fixed-action-btn">
		<a class="btn-floating btn-large green tooltipped modal-trigger"  href="#modalAplica" data-position="left" data-tooltip="Aplicar">
			<i class="large material-icons">check</i>
		</a>
	</div>

	<!-- Modal Structure FINALIZAR APLICACIÓN-->

	<div id="modalAplica" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h4>Finalizar Actividad</h4>
			<p>¿Está seguro que desea finalizar esta actividad?</p>
			<p>	Nota: Si finaliza la actividad no podrá volver a editarla.</p>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
			<a href="#!" id="finaliza-actividad" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
		</div>
	</div>
	<!--  -->

	<!-- Modal Structure Artículos -->
	<form id ="formActivityLote" method="post">
		{{ csrf_field() }}
	<div id="mdlActivity" class="modal modal-fixed-footer">

		<div class="modal-content">
			{{ csrf_field() }}
			<h4>Lote/Actividad</h4>

			<div class=" col s12">
			</br>
			<select id="slcloteact" class="js-data-example-ajax browser-default" name="slcloteact">
			</select>
		</div>

		<div class="input-field col s12">
			<input disabled value="" id="cosecha" type="text" class="validate" name="cosecha">
			<label id="lblcosecha"  for="cosecha">Cosecha</label>
		</div>
		<div class="input-field col s12">
			<input disabled value="" id="superficie" type="text" class="validate" name="superficie">
			<label id="lblsuperficie" for="superficie">Superficie(HA)</label>
		</div>
		<div class=" col s12">
		<select id="slcactividad" class="js-data-example-ajax browser-default" name="slcactividad">
		</select>
		</div>

		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-light">
				Cancelar
			</a>
			<button form="formActivityLote" type="submit" id="save-activity" class="modal-action waves-effect waves-light btn">
				Aceptar
			</button>
		</div>

	</div>
</form>
	<!-- Modal Structure -->




	@endsection
	@push('scripts')
	<script type="text/javascript">
	var path_url_applotinfo = "{{ route('lotinfo') }}";
	var path_url_appactivity = "{{ route('appactivity') }}";

	var path_url_submit_lot_act = "{{ route('submitlotact') }}";
	var path_url_activity_lista = "{{ route('submitpaselista') }}";
	</script>
	@endpush
