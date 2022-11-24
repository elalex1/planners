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
		<h6> Fecha: {{ $content['produccion'][0]->fecha_proceso }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusAplicacion"> Estatus: {{ $content['produccion'][0]->estatus }} </h6>
	</div>
</div>

<form id ="formApplicationEdit" method="post">
	{{ csrf_field() }}
	<div class="card">
		<!-- card content para nuevo registro en doctos_producciones -->
		<div class="card-content">

			<div class="row">

				<div class="input-field col s12">
					<select disabled name="concepto_produccion">
						<option value="{{ $content['produccion'][0]->nombre }}" selected>{{ $content['produccion'][0]->nombre }}</option>
					</select>
					<label>Tipo Producción</label>
				</div>
				@if ( $content['produccion'][0]->fecha_obligatoria === 'S')
				<div class="col s6">
					<label>Fecha Aplicación</label>
					<input disabled name="fecha_proceso" type="text" class="datepicker" value="{{ $content['produccion'][0]->fecha_proceso }}">
				</div>
				@endif
				@if ( $content['produccion'][0]->hora_obligatoria === 'S')
				<div class="col s6">
					<label>Hora Aplicación</label>
					<input disabled name="hora_proceso" type="text" class="timepicker" value="{{ $content['produccion'][0]->hora_proceso }}">
				</div>
				@endif

				<div class="input-field col s12">
					<select disabled name="slclote">
						<option value="{{ $content['produccion'][0]->lote }}" selected>{{ $content['produccion'][0]->lote }}</option>
					</select>
					<label>Lote</label>
				</div>

				<div class="col s4">
					<label>Cosecha</label>
					<input disabled name="cosecha" type="text" value="{{ $content['produccion'][0]->cosecha }}">
				</div>

				<div class="col s4">
					<label>Superficie (HA)</label>
					<input disabled name="superficie" type="text" value="{{ $content['produccion'][0]->superficie }}">
				</div>

				<div class="input-field col s4">
					<input disabled value="{{ $content['produccion'][0]->rancho }}" id="rancho" type="text" class="validate" name="rancho">
					<label id="lblrancho" for="rancho">Rancho</label>
				</div>



			</div>
			<!-- <div class="col s12">
				<button type="submit" id="update-application" class="btn-floating btn-small right light-blue waves-effect waves-light tooltipped" data-position="top" data-tooltip="Guardar Cambios">
					<i class="large material-icons">save</i>
				</button>
			</div> -->
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
		</div>
		<div class="row">
			<div id="contentArticles" class="col s12">
				<!--loader-->
				<div id ="loader-articles" class="preloader-wrapper big active">
					<div class="spinner-layer spinner-blue-only">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div><div class="gap-patch">
							<div class="circle"></div>
						</div><div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>
				</div>
				<!--fin loader-->
				<table id ="tblArticlesStatic">
					<thead>
						<tr>
							<th>Artículo</th>
							<th>Dosis/HA</th>
							<th>U. Medida</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach ($content['articulos_produccion'] as $articulo_produccion)
						<tr>
							<td>{{ $articulo_produccion->nombre }}</td>
							<td>{{ $articulo_produccion->cantidad }}</td>
							<td>{{ $articulo_produccion->unidad_compra }}</td>


						</tr>
						@endforeach

					</tbody>

				</table>
			</div>


		</div>
	</div>
</div>

<!-- card content para nuevo registro en usos_empleados -->
@if ( $content['produccion'][0]->usa_empleado === 'S')
@if ($content['count_usos_empleados'] > 0)
	{{ csrf_field() }}
	<div class="card">

		<div class="card-content">

			<div class="row">

				<div class="col s6">
					<h6>Equipo Aplicación</h6>
				</div>

			<div class="col s12">
				<label>Aplicador</label>

				<input value="{{ $content['usos_empleados'][0]->aplicador }}" disabled name="aplicador" id="aplicador" type="text" class="validate">
			</div>

		 <div class="col s8">
				<label>Vía Aplicación</label>
				<input value="{{ $content['usos_empleados'][0]->via_aplicacion }}" disabled name="via_aplicacion" id="via_aplicacion" type="text" class="validate">
				<br>
			</div>

			<div class="input-field col s2">
				<input disabled value="{{ $content['usos_empleados'][0]->horas }}" id="horas" name="horas" type="number">

				<label for="horas">Horas de aplicación</label>
			</div>

			<div class="input-field col s2">
				@if ($content['count_usos_empleados'] > 0)
				<input disabled value="{{ $content['usos_empleados'][0]->pozo }}" id="pozo" name="pozo" type="number" class="validate">
				@endif
				<label for="pozo">Pozo</label>
			</div>
			@endif
		</div>
	</div>



</div>
@endif
<!-- Fin card content -->


<!--  -->


</main>
