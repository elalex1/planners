@extends('app')


@section('title', 'Editar Requisición')

@section('content')

<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['requisicion'][0]->fecha }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusRequisicion"> Estatus: {{ $content['requisicion'][0]->estatus }} </h6>
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
					<textarea name="descripciond" id="descripciond" class="materialize-textarea">{{ $content['requisicion'][0]->descripcion }}</textarea>
					<label for="descripciond">Descripción</label>
					<span class="helper-text">Para ser utilizado en</span>
					<input type="hidden" id="{{ $content['requisicion'][0]->docto_requisicion_id }}" name="requisicion_id" value="{{ Request::route('id') }}"/>
				</div>


			</div>
			<div class="col s12">
				<button type="submit" id="update-requisition" class="btn-floating btn-small right light-blue waves-effect waves-light tooltipped" data-position="top" data-tooltip="Guardar Cambios">
					<i class="large material-icons">save</i>
				</button>
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
				<div class="input-field col s6">
					<a id="btnAddArticles" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped" href="#modal1" data-position="top" data-delay="50" data-tooltip="Añadir artículos">
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
								<td>{{ $articulo_requisicion->cantidad }}</td>
								<td>{{ $articulo_requisicion->nombre }}</td>
								<td>{{ $articulo_requisicion->centrocosto }}</td>
								<td>{{ $articulo_requisicion->nota_articulo }}</td>
								<td>
									<i class="material-icons delete-record tooltipped" data-delay="50" data-tooltip="Eliminar artículo" id-record="{{ $articulo_requisicion->docto_requisicion_det_id }}" id-asign="{{ Request::route('id') }}">delete_forever</i>
								</td>


							</tr>
							@endforeach

						</tbody>

					</table>
				</div>


			</div>
		</div>
		<div class="fixed-action-btn">
			<a class="btn-floating btn-large green tooltipped modal-trigger"  href="#modal2" data-position="left" data-tooltip="Finalizar">
				<i class="large material-icons">check</i>
			</a>
		</div>
	</div>


<!-- Card de imágenes -->
<div class="card">
	<div class="card-content">
		<div class="row">
			<form id ="formRequisitionImages" method="post" enctype="multipart/form-data">
				<div class="input-field col s12">



					<!-- Carrusel de imágenes -->

					@if($content['imagenes'])
					<h6>Imágenes</h6>
					<div id="carrusel-img" class="carousel">
						@foreach ($content['imagenes'] as $imagen)
						<div class="carousel-item">
							<div class="card sticky-action">
								<div class="card-image small">
									{{-- <img class="materialboxed" height="220" src="data:image/jpg;base64, {{ base64_encode($imagen->archivo) }}"> --}}
									<img class="materialboxed" height="220" 
										src="{{Storage::disk('s3')->temporaryUrl($imagen->archivo, now()->addMinutes(5))}}">
									<span class="card-title">{{ $imagen->nombre_archivo }}</span>
									<a  id="{{ $imagen->repositorio_archivo_id }}" class="btn-floating halfway-fab waves-effect waves-light red delete-img btn-small"><i class="material-icons md1"  >delete</i></a>
								</div>
								<div class="card-content">
									<p>{{ $imagen->descripcion }}</p>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					@endif


					<!--  -->
					<h6>Subir imagen como evidencia (opcional)</h6>
					<input id="uploadedfile" name="uploadedfile" type="file" class="dropify" data-allowed-file-extensions="pdf png jpg jpeg" data-max-file-size="2.5M"/>

				</div>
				<div class="col s6">
					<label>Tamaño máximo de archivo: 1.5 MB </label>
				</div>
				<div class="col s6">
					<label class="right" >Formatos permitidos: pdf, png, jpg, jpeg</label>
				</div>
				<div class="input-field col s12">
					<textarea name="descripcionimg" id="descripcionimg" class="materialize-textarea"></textarea>
					<label for="descripcionimg">Descripción Imagen</label>
				</div>
				<div class="col s12">
					<button type="submit" id="btnAddImage" class="btn-floating btn-small right light-blue waves-effect waves-light tooltipped" data-position="top" data-tooltip="Subir imagen">
						<i class="large material-icons">cloud_upload</i>
					</button>
					<div id="loader-img" class="progress">
						<div class="indeterminate"></div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal Structure FINALIZAR REQUISICIÓN-->

<div id="modal2" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Finalizar Requisición</h4>
		<p>¿Está seguro que desea finalizar esta requisición y enviar correo para autorizar?</p>
		<p>	Nota: Si finaliza la requisición no podrá volver a editarla.</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="#!" id="finaliza-requisicion" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
	</div>
</div>
<!--  -->


<!-- Modal Structure Artículos -->
<div id="modal1" class="modal modal-fixed-footer">

	<div class="modal-content" id="content-datableArticles">
		{{ csrf_field() }}
		<h4>Artículos</h4>


		<table class="display" id="tableArticles">
			<thead>
				<tr>

					<th>Cantidad</th>
					<th>U. Medida</th>
					<th>Centro de Costos</th>
					<th>Artículo</th>
					<th>Nota</th>


				</tr>
			</thead>

			<tbody id="tblArticles" class = "tblArticles">
				@foreach ($content['articulos'] as $articulo)
				<tr id = "{{ $articulo->articulo_id }}">

					<td id = "cantidad" class = "tblArticles">
						<input class="cantidadnumeric" id="cantidad-{{ $articulo->articulo_id }}" type="number" min="0" name="cantidad-{{ $articulo->articulo_id }}" />
						<input type="hidden" id="req-{{ $articulo->articulo_id }}" name="req-{{ $articulo->articulo_id }}" value="{{ Request::route('id') }}"/>
						<input type="hidden" id="nombre-{{ $articulo->articulo_id }}" name="nombre-{{ $articulo->articulo_id }}" value="{{ $articulo->nombre }}"/>
					</td>

					<td class = "tblArticles">{{ $articulo->unidad_compra }}
					</td>

					<td class = "tblArticles">
						<select  class="selectArticles js-data-example-ajax browser-default" id="input-articles-{{ $articulo->articulo_id }}" name="seleccionado-{{ $articulo->articulo_id }}">
						{{--<!--	<option value="" disabled selected>Seleccione una opción</option>
							@foreach ($content['centros_costos'] as $centro_costo)
							<option value="{{$centro_costo->nombre}}">{{$centro_costo->nombre}}</option>
							@endforeach-->--}}
						</select>
					</td>

					<td class = "tblArticles">{{ $articulo->nombre }}

					</td>

					<td class = "tblArticles">
						<input id="nota-{{ $articulo->articulo_id }}" name="nota-{{ $articulo->articulo_id }}">
					</td>

				</tr>
				@endforeach

			</tbody>
		</table>





	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-light">
			Cancelar
		</a>
		<a href="#!" id="save-articles" class="modal-action modal-close waves-effect waves-light btn">
			Aceptar
		</a>
	</div>

</div>
<!-- Modal Structure -->







@endsection
@push('scripts')
<script type="text/javascript">
var path_url_submitarticles = "{{ route('submitarticles') }}";
var path_url_objective = "{{ route('searchobjective') }}";

</script>
@endpush
