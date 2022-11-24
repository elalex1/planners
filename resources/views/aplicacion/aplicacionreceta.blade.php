@extends('app')


@section('title', 'Aplicación Receta')

@section('content')

<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['produccion'][0]->fecha_creacion }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusAplicacion"> Estatus: {{ $content['produccion'][0]->estatus }} </h6>
	</div>
</div>
<form id ="formReceta" method="post">
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

				<div id="fechacontent" class="col s6">
					<label>Fecha Aplicación</label>
					<input name="fecha_proceso" type="text" class="datepicker">
				</div>
				<div id="horacontent" class="col s6">
					<label>Hora Aplicación</label>
					<input name="hora_proceso" type="text" class="timepicker">
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
<div class="card">
	<div class="card-content">
		<div class="row">
			<div class="input-field col s12">
				<input disabled value="{{ $content['receta'] }}" id="receta" type="text" class="validate" name="receta">
				<label id="lblreceta" for="receta">Receta</label>
			</div>
			<div class="col s6">
				<h6>Artículos Receta # {{ $content['receta'] }}</h6>
			</div>
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
	<div class="fixed-action-btn">
		<button form="formReceta" type="submit" id= "aplica-receta" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Aplicar">
			<i class="large material-icons">check</i>
		</button>
	</div>
</div>


<!-- card content para nuevo registro en usos_empleados -->
	{{ csrf_field() }}
	<div class="card">

		<div class="card-content">

			<div class="row">

				<div class="col s6">
					<h6>Equipo Aplicación</h6>
				</div>

				<div class="col s12">
					<label>Aplicador</label>
					<select id="slc-aplicador" name="aplicador" class="error browser-default">
						<option value="" disabled  selected >Selecciona opción</option>
						@foreach ($content['empleados'] as $empleado)
						<option value="{{ $empleado->empleado_id }}">{{ $empleado->nombre }} {{ $empleado->apellido_paterno}} {{ $empleado->apellido_materno}}</option>
						@endforeach
					</select>
				</div>

				<div class="col s8">
					<label>Vía Aplicación</label>
					<select id="slc-via_aplicacion" name="via_aplicacion" class="error browser-default">
						<option value="" disabled  selected >Selecciona opción</option>
						@foreach ($content['tipos_usos_empleados'] as $tipo_uso_empleado)
						<option value="{{ $tipo_uso_empleado->nombre }}">{{ $tipo_uso_empleado->nombre }}</option>
						@endforeach
					</select>
					<br>
				</div>

				<div class="input-field col s2">
					<input value="" id="horas" name="horas" type="number" class="validate">
					<label for="horas">Horas de aplicación</label>
				</div>
				<div class="input-field col s2">
					<input value="" id="pozo" name="pozo" type="number" class="validate">
					<label for="pozo">Pozo</label>
				</div>



				</div>
			</div>



		</div>
	</form>



@endsection
@push('scripts')
<script type="text/javascript">
var path_url_submitarticles_app = "{{ route('submitarticlesapp') }}";
var path_url_applotinfo = "{{ route('lotinfo') }}";
var path_url_submit_aplicador = "{{ route('submitaplicador') }}";
var path_url_appapplication = "{{ route('appapplication') }}";
var path_url_appreceta = "{{ route('appreceta') }}";
</script>
@endpush
