@extends('app')

@section('title', 'Particionar Requisición ')

@section('content')


<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['requisicion'][0]->fecha }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusRequisicion"> Estatus: {{ $content['requisicion'][0]->estatus }} </h6>
	</div>
</div>


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
					<table class="tblArticles" id ="tblArticlesStatic">
						<thead>
							<tr>
								<th></th>
								<th>Cantidad</th>
								<th>Artículo</th>
								<th>Centro Costos</th>
								<th>Nota</th>
								<th></th>
							</tr>
						</thead>


						<tbody>

							@foreach ($content['articulos_requisicion'] as $articulo_requisicion)
							<tr >
								<td id="{{ $articulo_requisicion->docto_requisicion_det_id }}" class = "tblArticles">
									<p>
							      <label>
							        <input id="check-{{ $articulo_requisicion->docto_requisicion_det_id }}" type="checkbox" />
							        <span></span>
							      </label>
							    </p>
								</td>
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
	<div class="fixed-action-btn">
		<a class="btn-floating btn-large red tooltipped modal-trigger"  href="#mdl-partition" data-position="left" data-tooltip="Particionar">
			<i class="large material-icons">pie_chart</i>
		</a>
	</div>



</div>
</div>
</div>
</div>


<!-- Modal Structure FINALIZAR REQUISICIÓN-->

<div id="mdl-partition" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Finalizar Partición Requisición</h4>
		<p>¿Está seguro que desea finalizar esta partición?</p>
		<p class="red-text">	Nota: Esta acción no se puede deshacer.</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="#!" id="finaliza-particion" class="modal-close waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
	</div>
</div>
<!--  -->



@endsection

@push('scripts')
<script type="text/javascript">
var path_url_particion = "{{ route('particionar') }}";

</script>
@endpush
