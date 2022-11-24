@extends('app')


@section('title', 'Nueva Requisición')

@section('content')
	<form id="formRequisition" method="POST">
	{{ csrf_field() }}
<div class="card">


	<!-- card content para nuevo registro en doctos_requisicion -->
	<div class="card-content">

		<div class="row">

				<div class="col s12">
					<select id="slc-tiporequisicion" name="concepto_requisicion" class="error browser-default">
						<option value="" disabled  selected>Selecciona opción</option>
						@foreach ($content['conceptos_requisiciones'] as $concepto_requisicion)
						<option value="{{ $concepto_requisicion->nombre }}">{{ $concepto_requisicion->nombre }}</option>
						@endforeach
					</select>
					<label>Tipo Requisición</label>
				</div>

				<div class="input-field col s12">
					<textarea id="descripciond" name="descripciond" class="materialize-textarea"></textarea>
					<label for="descripciond">Descripción</label>
					<span class="helper-text">Para ser utilizado en</span>
				</div>

				<div class="col s12">
					<button form="formRequisition" type="submit" id= "save-requisition" class="btn-floating btn-small waves-effect waves-light tooltipped blue right" data-tooltip="Continuar" name="button" >
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

<div class="card">
	<div class="card-content">
		<div class="row">
			<div class="input-field col s12">
				<h6>Subir Archivo</h6>
				<input id="uploadedfile" name="uploadedfile" disabled="disabled" type="file" class="dropify" data-allowed-file-extensions="pdf png jpg jpeg" />
			</div>
			<div class="col s12">
				<a id="btnAddImage" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped disabled" data-position="top" data-tooltip="Añadir imagen">
					<i class="large material-icons">cloud_upload</i>
				</a>
			</div>
		</div>
	</div>
</div>


@endsection

@push('scripts')
<script type="text/javascript">
var path_url_submit = "{{ route('submit') }}";


</script>
@endpush
