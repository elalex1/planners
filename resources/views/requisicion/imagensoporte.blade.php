@extends('app')

@section('title', 'Agregar imágenes soporte')

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
					<textarea disabled name="descripciond" id="disabled" class="materialize-textarea">{{ $content['requisicion'][0]->descripcion }}</textarea>
					<label for="disabled">Descripción</label>
					<span class="helper-text" data-error="wrong" data-success="right">Para ser utilizado en</span>
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
			</div>
			<div class="row">
				<div id="contentArticles" class="col s12">
					<table class="responsive-table tblArticles" id ="tblArticlesStatic">
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
</form>

<!-- Card de imágenes -->
<div class="card">
<div class="card-content">
	<div class="row">
		<form id ="formRequisitionImages" method="post" enctype="multipart/form-data">
			<div class="input-field col s12">



				<!-- Carrusel de imágenes -->

				@if($content['imagenes'])
				<h6>Imágenes Soporte</h6>
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

</div>
</div>
</div>
</div>



@endsection
