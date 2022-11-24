@extends('app')


@section('title', 'Autorizar Requisición')

@section('content')

<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['requisicion'][0]->fecha }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusRequisicion"> Estatus: {{ $content['requisicion'][0]->estatus }} </h6>
	</div>
	<div class="col s12">
		<h6 id="estatusRequisicion"> Autorizado: {{ $content['requisicion'][0]->folio }} </h6>
	</div>
</div>

<form id ="formRequisitionEdit" method="post">
	{{ csrf_field() }}
	<div class="card">
		<!-- card content para nuevo registro en doctos_requisicion -->
		<div class="card-content">
			<div class="row">
				<div class="input-field col s12">
					<select disabled name="concepto_requisicion">
						<option value="{{ $content['requisicion'][0]->nombre }}" selected>{{ $content['requisicion'][0]->nombre }}</option>
					</select>
					<label>Tipo Requisición</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<textarea disabled name="descripciond" id="descripciond" class="materialize-textarea">{{ $content['requisicion'][0]->descripcion }}</textarea>
					<label for="descripciond">Descripción</label>
					<span class="helper-text" data-error="wrong" data-success="right">Para ser utilizado en</span>
					<input type="hidden" id="{{ $content['requisicion'][0]->docto_requisicion_id }}" name="requisicion_id" value="{{ Request::route('id') }}"/>
				</div>


			</div>

		</div>
		<!-- Fin card content -->

	</div>






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


				<table id ="tblArticlesStatic">
					<thead>
						<tr>
							<th>Cantidad</th>
							<th>Artículo</th>
							<th>Centro Costos</th>
							<th>Nota</th>
							<th></th>
						</tr>
					</thead>


					<tbody>

						@foreach ($content['articulos_requisicion'] as $articulo_requisicion)
						<tr>
							<td class = "tblArticles">{{ $articulo_requisicion->cantidad }}</td>
							<td class = "tblArticles">{{ $articulo_requisicion->nombre }}</td>
							<td class = "tblArticles">{{ $articulo_requisicion->centrocosto }}</td>
							<td class = "tblArticles">{{ $articulo_requisicion->nota_articulo }}</td>



						</tr>
						@endforeach

					</tbody>

				</table>
			</div>


		</div>
	</div>

</div>

<!-- Card de imágenes -->
</form>

<!-- Carrusel de imágenes -->
@if($content['imagenes'])
<div class="card">
	<div class="card-content">
			<h6>Imágenes soporte</h6>

			<div id="carousel-img" class="carousel">
				@foreach ($content['imagenes'] as $imagen)
				<a class="carousel-item">
					<div class="card sticky-action">
						<div class="card-image small">
							{{-- <img class="materialboxed" height="220" src="data:image/jpg;base64, {{ base64_encode($imagen->archivo) }}"> --}}
							<img class="materialboxed" height="220" 
								src="{{Storage::disk('s3')->temporaryUrl($imagen->archivo, now()->addMinutes(5))}}">
							<span class="card-title">{{ $imagen->nombre_archivo }}</span>

						</div>
						<div class="card-content">
							<span class="card-title activator grey-text text-darken-4">Descripción<i class="material-icons right">more_vert</i></span>
						</div>
						<div class="card-reveal">
							<span class="card-title grey-text text-darken-4">Descripción<i class="material-icons right">close</i></span>
							<p>{{ $imagen->descripcion }}</p>
						</div>
					</div>
				</a>
				@endforeach

			</div>
	</div>
</div>
@endif

<!--  -->




<!-- ********************************************************* -->

    <div class="fixed-action-btn">
  <a class="btn-floating btn-large orange">
    <i class="large material-icons">more_horiz</i>
  </a>
  <ul>

    <li><a class="btn-floating green tooltipped modal-trigger" href="#modal3" data-position="left" data-tooltip="Autorizar"><i class="material-icons">check</i></a></li>
    <li><a class="btn-floating red darken-1 tooltipped modal-trigger" href="#modal4" data-position="left" data-tooltip="Cancelar" ><i class="material-icons">cancel</i></a></li>

  </ul>
</div>

<!-- Modal Structure AUTORIZAR REQUISICIÓN-->

<div id="modal3" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Autorizar Requisición</h4>
		<p>¿Está seguro que desea autorizar esta requisición?</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="#!" id="auth-requisition" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
	</div>
</div>

<!-- ********************************************************* -->

<!-- Modal Structure CANCELAR REQUISICIÓN-->

<div id="modal4" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Cancelar Requisición</h4>
		<p>¿Está seguro que desea cancelar esta requisición?</p>
    <div class="input-field col s12">
      <textarea name="descripcion-cancel" id="descripcion-cancel" class="materialize-textarea"></textarea>
      <label for="descripcion-cancel">Motivo cancelación</label>
    </div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="#!" id="cancel-requisition" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
	</div>
</div>
<!-- ********************************************************* -->
@endsection
@push('scripts')
<script type="text/javascript">

</script>
@endpush
