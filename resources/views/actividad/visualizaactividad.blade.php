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
										<input disabled value="{{$value2}}" x="{{$loop->index}}" y="{{$loop->parent->index+1}}" class="horas" name="horas" id="{{$loop->index . $loop->parent->index+1}}"  type="number" class="validate">
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

</main>
