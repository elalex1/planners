@extends('app')


@section('title', 'Autorizar Requisición')

@section('content')

<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['actividad'][0]->fecha_creacion }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusRequisicion"> Estatus: {{ $content['actividad'][0]->estatus }} </h6>
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


<!-- ********************************************************* -->

<div class="fixed-action-btn">
  <a class="btn-floating btn-large orange">
    <i class="large material-icons">more_horiz</i>
  </a>
  <ul>

    <li><a class="btn-floating green tooltipped modal-trigger" href="#mdl-autoriza" data-position="left" data-tooltip="Autorizar"><i class="material-icons">check</i></a></li>
    <li><a class="btn-floating red darken-1 tooltipped modal-trigger" href="#mdl-cancela" data-position="left" data-tooltip="Cancelar" ><i class="material-icons">cancel</i></a></li>

  </ul>
</div>

<!-- Modal Structure AUTORIZAR REQUISICIÓN-->

<div id="mdl-autoriza" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Autorizar Requisición</h4>
		<p>¿Está seguro que desea autorizar esta actividad?</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="#!" id="auth-activity" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
	</div>
</div>

<!-- ********************************************************* -->

<!-- Modal Structure CANCELAR Actividad-->

<div id="mdl-cancela" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Cancelar Requisición</h4>
		<p>¿Está seguro que desea cancelar esta actividad?</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="#!" id="cancel-activity" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
	</div>
</div>
<!-- ********************************************************* -->
@endsection
@push('scripts')
<script type="text/javascript">

</script>
@endpush
