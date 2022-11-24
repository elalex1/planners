@extends('app')


@section('title', 'Editar Aplicación')

@section('content')

<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['produccion'][0]->fecha_creacion }} </h6>
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
				<div class="input-field col s6">
					<a id="btnAddArticlesApp" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped" href="#mdlArticlesApp" data-position="top" data-delay="50" data-tooltip="Añadir artículos">
						<i class="large material-icons">add</i>
					</a>
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
								<td>
									<i class="material-icons delete-record-app tooltipped" data-delay="50" data-tooltip="Eliminar artículo" id-record="{{ $articulo_produccion->nombre }}" id-asign="{{ Request::route('id') }}">delete_forever</i>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>


			</div>
		</div>
		<div class="fixed-action-btn">
			<a class="btn-floating btn-large green tooltipped modal-trigger"  href="#modalAplica" data-position="left" data-tooltip="Aplicar">
				<i class="large material-icons">check</i>
			</a>
		</div>
	</div>

	<!-- card content para nuevo registro en usos_empleados -->
@if ( $content['produccion'][0]->usa_empleado === 'S')
	<form id="formAplicador" method="POST">
		{{ csrf_field() }}
		<div class="card">

			<div class="card-content">

				<div class="row">

					<div class="col s6">
						<h6>Equipo Aplicación</h6>
					</div>

				<div class="col s12">
					<label>Aplicador</label>
					@if ($content['count_usos_empleados'] > 0)
					<input value="{{ $content['usos_empleados'][0]->aplicador }}" disabled name="aplicador" id="aplicador" type="text" class="validate">
					@else
					<select id="slc-aplicador" name="aplicador" class="error browser-default">
						<option value="" disabled  selected >Selecciona opción</option>
						@foreach ($content['empleados'] as $empleado)
						<option value="{{ $empleado->empleado_id }}">{{ $empleado->nombre, $empleado->apellido_paterno,$empleado->apellido_materno }}</option>
						@endforeach
					</select>
					@endif
				</div>

			 <div class="col s8">
					<label>Vía Aplicación</label>
					@if ($content['count_usos_empleados'] > 0)
					<input value="{{ $content['usos_empleados'][0]->via_aplicacion }}" disabled name="via_aplicacion" id="via_aplicacion" type="text" class="validate">
					@else
					<select id="slc-via_aplicacion" name="via_aplicacion" class="error browser-default">
						<option value="" disabled  selected >Selecciona opción</option>
						@foreach ($content['tipos_usos_empleados'] as $tipo_uso_empleado)
						<option value="{{ $tipo_uso_empleado->nombre }}">{{ $tipo_uso_empleado->nombre }}</option>
						@endforeach
					</select>
					@endif
					<br>
				</div>

				<div class="input-field col s2">
					@if ($content['count_usos_empleados'] > 0)
					<input disabled value="{{ $content['usos_empleados'][0]->horas }}" id="horas" name="horas" type="number" class="validate">
					@else
					<input value="" id="horas" name="horas" type="number" class="validate">
					@endif
					<label for="horas">Horas de aplicación</label>
				</div>

				<div class="input-field col s2">
					@if ($content['count_usos_empleados'] > 0)
					<input disabled value="{{ $content['usos_empleados'][0]->pozo }}" id="pozo" name="pozo" type="number" class="validate">
					@else
					<input value="" id="pozo" name="pozo" type="number" class="validate">
					@endif
					<label for="pozo">Pozo</label>
				</div>


				<div class="col s12">
					@if ($content['count_usos_empleados'] > 0)
					<button  class="btn-floating btn-small waves-effect waves-light tooltipped orange right" disabled>
					@else
					<button form="formAplicador" type="submit" id= "save-aplicador" class="btn-floating btn-small waves-effect waves-light tooltipped orange right" data-tooltip="Guardar" name="button" >
					@endif
						<i class="material-icons right">person</i>
					</button>
				</div>
			</div>
		</div>



	</div>
	</form>
	@endif
<!-- Fin card content -->

<!-- Modal Structure FINALIZAR APLICACIÓN-->

<div id="modalAplica" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Finalizar Aplicación</h4>
		<p>¿Está seguro que desea finalizar esta aplicación?</p>
		<p>	Nota: Si finaliza la aplicación no podrá volver a editarla.</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="#!" id="finaliza-aplicacion" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
	</div>
</div>
<!--  -->


<!-- Modal Structure Artículos -->

<div id="mdlArticlesApp" class="modal modal-fixed-footer">

	<div class="modal-content" id="content-datableArticles">
		{{ csrf_field() }}
		<h4>Artículos</h4>

		<table class="display" id="tableArticlesApp">
			<thead>
				<tr>
					<th>Artículo</th>
					<th>Objetivo de plaga</th>
					<th>Dosis/HA</th>
					<th>U. Medida</th>
					<th>Horas Reingreso</th>
					<th>Días Cosecha</th>
				</tr>
			</thead>

			<tbody id="tblArticles" class = "tblArticles">
				@foreach ($content['articulos'] as $articulo)

				<tr id = "{{ $articulo->articulo_id }}">
					<td class = "tblArticles">{{ $articulo->nombre }}</td>
					<td class = "tblArticles">
						<select  class="selectArticlesApp js-data-example-ajax browser-default" id="input-articles-app-{{ $articulo->articulo_id }}" name="seleccionado-{{ $articulo->articulo_id }}">
						{{--<!--	<option value="" disabled selected>Seleccione una opción</option>
							@foreach ($content['centros_costos'] as $centro_costo)
							<option value="{{$centro_costo->nombre}}">{{$centro_costo->nombre}}</option>
							@endforeach-->--}}
						</select>
					</td>
					<!-- <td class = "tblArticles">
						<select  class="selectArticlesApp js-data-example-ajax browser-default" id="input-articles-{{ $articulo->articulo_id }}" name="seleccionado-{{ $articulo->articulo_id }}">
							<option value="" disabled selected>Seleccione una opción</option>
							@foreach ($content['conceptos_aplicaciones'] as $concepto_aplicacion)
							<option value="{{$concepto_aplicacion->nombre}}">{{$concepto_aplicacion->nombre}}</option>
							@endforeach
						</select>
					</td> -->
					<td id = "cantidad" class = "tblArticles">
						<input placeholder="" class="cantidadnumeric" id="cantidad-{{ $articulo->articulo_id }}" type="number" min="0" name="cantidad-{{ $articulo->articulo_id }}" />
						<input type="hidden" id="app-{{ $articulo->articulo_id }}" name="app-{{ $articulo->articulo_id }}" value="{{ Request::route('id') }}"/>
						<input type="hidden" id="nombre-{{ $articulo->articulo_id }}" name="nombre-{{ $articulo->articulo_id }}" value="{{ $articulo->nombre }}"/>
					</td>
					<td class = "tblArticles">{{ $articulo->unidad_compra }}</td>
					<td id="carencia-{{ $articulo->articulo_id }}" class = "tiempo_carencia tblArticles"></td>
					<td id="espera-{{ $articulo->articulo_id }}" class = "tiempo_espera tblArticles"></td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-light">
			Cancelar
		</a>
		<a href="#!" id="save-articlesapp" class="modal-action modal-close waves-effect waves-light btn">
			Aceptar
		</a>
	</div>

</div>
<!-- Modal Structure -->

@endsection
@push('scripts')
<script type="text/javascript">
var path_url_submitarticles_app = "{{ route('submitarticlesapp') }}";
var path_url_applotinfo = "{{ route('lotinfo') }}";
var path_url_submit_aplicador = "{{ route('submitaplicador') }}";
var path_url_appapplication = "{{ route('appapplication') }}";
var path_url_appobjinfo = "{{ route('objectiveinfo') }}";
</script>
@endpush
