@extends('app')


@section('title', 'Editar Orden Compra')

@section('content')

<div class="row">
	<div class="col s6">
		<h6> Fecha: {{ $content['ordencompra'][0]->fecha }} </h6>
	</div>
	<div class="col s6">
		<h6 id="estatusOrdenCompra"> Estatus: {{ $content['ordencompra'][0]->estatus }} </h6>
	</div>
</div>
<form id ="formOrdenCompraEdit" method="post" action="{{route('ordencompra_update')}}">
	{{ csrf_field() }}
	<div class="card">
		<!-- card content para nuevo registro en doctos_requisicion -->
		<div class="card-content">


			<div class="row">
				<div class="input-field col s12">
					<select disabled name="concepto_ordencompra">
						<option value="{{ $content['ordencompra'][0]->concepto_compra }}" selected>{{ $content['ordencompra'][0]->concepto_compra }}</option>
					</select>
					<label>Tipo Orden Compra</label>
				</div>
				<div class="input-field col s12">
					<select disabled name="proveedor">
						<option value="{{ $content['ordencompra'][0]->proveedor }}" selected>{{ $content['ordencompra'][0]->proveedor }}</option>
					</select>
					<label>Proveedor</label>
				</div>
				<div class="col s12">
					<select disabled id="slc-almacen" name="almacen" class="error browser-default">
						<option  value="{{ $content['ordencompra'][0]->almacen }}" selected>{{ $content['ordencompra'][0]->almacen  }}</option>
						{{-- @foreach ($content['almacenes'] as $almacen)
						<option value="{{ $almacen->almacen_id }}">{{ $almacen->nombre }}</option>
						@endforeach --}}
					</select>
					<label>Lugar de entrega</label>
				</div>
				<div class="col s12">
					<select disabled name="moneda" class="error browser-default">
						<option value="{{ $content['ordencompra'][0]->moneda }}" disabled  selected>{{ $content['ordencompra'][0]->moneda }}</option>
					</select>
					<label>Moneda</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<textarea name="descripcion" class="materialize-textarea">{{ $content['ordencompra'][0]->descripcion }}</textarea>
					<label for="descripciond">Observaciones</label>
					<span class="helper-text">Para ser utilizado en</span>
					<input type="hidden" id="{{ $content['ordencompra'][0]->docto_compra_id }}" name="ordencompra_id" value="{{ Request::route('id') }}"/>
				</div>


			</div>
			<div class="row col s12">
				<a form="formOrdenCompraEdit" class="validarformulario btn-floating btn-small right light-blue waves-effect waves-light tooltipped" data-position="top" data-tooltip="Guardar Cambios">
					<i class="large material-icons">save</i>
				</a>
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
						<a @if ($content['ordencompra'][0]->ligada == 0) id="btnAddArticles-oc" href="#modalArt" @endif disabled class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Añadir artículos">
							<i class="large material-icons">add</i>
						</a>
					</div>
				
			</div>

			<div class="row">
				<div id="contentArticlesOrdenCompra" class="col s12">
					<!--loader-->
					<div id ="loader_det_articulos" class="preloader-wrapper big active">
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

					<table id ="det_articulos" update-table="SI" class="compact row-border">
						<thead>
							<tr>
								<th>Cantidad</th>
								<th>Artículo</th>
								<th>Precio U</th>
								<th>Total</th>
								{{-- @if ($content['ordencompra'][0]->ligada == 0) --}}
									<th></th>
								{{-- @endif --}}
							</tr>
						</thead>


						<tbody>

							@foreach ($content['articulos_ordencompra'] as $articulo_compra)
							<tr>
								<td>{{ $articulo_compra->cantidad }}</td>
								<td>{{ $articulo_compra->nombre }}</td>
								<td><input type="number" name="precio-{{$articulo_compra->articulo_id }}" value="{{ number_format($articulo_compra->precio_unitario,2) }}"></td>
								<td>$ {{ number_format($articulo_compra->total,2) }}</td>
								@if ($content['ordencompra'][0]->ligada == 0)
									<td>
										<i class="material-icons eliminar_renglon puntero tooltipped" data-delay="50" data-tooltip="Eliminar artículo" id-record="{{ $articulo_compra->articulo_id }}" id-asign="{{ Request::route('id') }}" url-record="{{route('ordencompra_DeleteArticle')}}">delete_forever</i>
										<input hidden type="number" name="cantidad-{{$articulo_compra->articulo_id }}" value="{{$articulo_compra->cantidad}}">
										<input hidden type="number" name="articulo_id-{{$articulo_compra->articulo_id }}" value="{{$articulo_compra->articulo_id }}">
									</td>
								@else
									<td>
										<label>
											<input type="checkbox" class="filled-in" checked="checked" name="cantidad-{{$articulo_compra->articulo_id }}" value="{{$articulo_compra->cantidad}}"/>
											<span></span>
										</label>
										<input hidden type="number" name="articulo_id-{{$articulo_compra->articulo_id }}" value="{{$articulo_compra->articulo_id }}">
										{{-- <input hidden type="number" name="id-{{$articulo_compra->articulo_id }}" value="{{ Request::route('id') }}"> --}}
									</td>
									{{-- <td>
										<i class="material-icons eliminar_renglon puntero tooltipped" data-delay="50" data-tooltip="Eliminar artículo" id-record="{{ $articulo_compra->articulo_id }}" id-asign="{{ Request::route('id') }}" url-record="{{route('ordencompra_DeleteArticle')}}">delete_forever</i>
									</td> --}}
								@endif

							</tr>
							@endforeach
							<!--tr>
								<td></td>
								<td></td>
								<td>Total</td>
								<td>{{ $content['ordencompra'][0]->total }}</td>
								<td></td>
							</tr-->
						</tbody>
					</table>
					@if ($content['ordencompra'][0]->total > 0)
						<div class="row col s12 pull-s1">
							<h5 id="total" class="right"><strong>Total: $</strong> {{ number_format($content['ordencompra'][0]->total,2) }} </h5>
						</div>
					@endif
				</div>
				
			</div>
			
		</div>
		
		<div class="fixed-action-btn">
			<a class="btn-floating btn-large green tooltipped modal-trigger"  href="#modalfinalizar" data-position="left" data-tooltip="Finalizar">
				<i class="large material-icons">check</i>
			</a>
		</div>
	</div>




<!-- Modal Structure FINALIZAR REQUISICIÓN-->

{{-- <div id="modal2" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Finalizar Orden de Compra</h4>
		<p>¿Está seguro que desea finalizar esta Orden de Compra y enviar correo para autorizar?</p>
		<p>	Nota: Si finaliza la Orden de Compra no podrá volver a editarla.</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a href="{{route('appordencompra')}}" id="finaliza-ordencompra" 
			class="modal-close waves-effect waves-green waves-effect waves-light btn"
			id-record="{{ Request::route('id') }}"
			url-record="{{route('sendemailordencompra')}}">Aceptar</a>
	</div>
</div> --}}
<div id="modalfinalizar" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>Finalizar Orden de Compra</h4>
		<p>¿Está seguro que desea finalizar esta Orden de Compra y enviar correo para autorizar?</p>
		
		<p>	Nota: Si finaliza la Orden de Compra no podrá volver a editarla.</p>
		<div class="row">
			<div class="col s12">
				<div class="col s2">
					<i class="material-icons amber-text" style="font-size: 70px;">info_outline</i>
				</div>
				<div class="col s10">
					<div style="font-weight: bold; font-size: 24px;"> Favor de verificar el precio unitario ya que una vez finalizado no se podrá editar.</div>
				</div>
			</div>
		</div>
		
		<form id="finOrdenCompra" action="{{route('appordencompra')}}" method="post">
			<input hidden type="number" name="id" value="{{ Request::route('id') }}">
			<input hidden type="text" name="jsonArticles" value="">
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a form="finOrdenCompra"
			second-form="formOrdenCompraEdit"
			dataval-record="S"
			class="btn modal-close waves-effect waves-light validarformulario-urls 2forms"
			url-record="{{route('sendemailordencompra')}}">Aceptar</a>
	</div>
</div>
<!--  -->


<!-- Modal Structure Artículos -->
<div id="modalArt" class="modal modal-fixed-footer">
	<div class="modal-content" id="content-datableArticles-oc">
		{{ csrf_field() }}
		<h4>Artículos</h4>
		<table class="display compact" id-record="{{ Request::route('id') }}"
			id="tablaWithUrl" url-record="{{route('get_articles_oc')}}" mod-record="OC">
			<thead>
				<tr>
					<th>Cantidad</th>
					<th>U. Medida</th>
					<th>Precio</th>
					<th>Artículo</th>
					<th>Nota</th>
				</tr>
			</thead>

			<tbody id="tblArticles-oc" class = "tblArticles-oc">
				
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-light">
			Cancelar
		</a>
		<a class="guardar_articulos modal-action modal-close waves-effect waves-light btn"
				href="{{route('submitarticles_oc')}}">
			Aceptar
		</a>
	</div>
</div>
<!-- Modal Structure -->
<!--Modal2b-->
{{-- <div id="modal2b" class="modal modal-fixed-footer" itemid="{{ $content['ordencompra'][0]->docto_compra_id }}">

	<div class="modal-content" id="content-datableRequisitions-oc" >
		{{ csrf_field() }}
		<h4>Requisiciones</h4>


		<table class="display" id="tableRequisitions-oc" url-record="{{route('get_requisiciones_oc')}}" >
			<thead>
				<tr >
					<th data-priority="1">Folio</th>
					<th data-priority="2">Fecha</th>
					<th data-priority="3">Descripción</th>
                    <th data-priority="4">Estatus</th>
                    <th data-priority="5">Creado Por</th>
					<th data-priority="6"></th>
				</tr>
			</thead>

			<tbody id="tblRequisitions-oc" class = "tblRequisitions-oc">
				
			</tbody>
		</table>





	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-light">
			Cancelar
		</a>
	</div>

</div> --}}
<!--modal2b fin-->
<!-- Modal Structure Visualizar Requisicion-->
<div id="modal5b" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div id="modal-contenido" class="responsive-video">
			<iframe id="if-requisicion2" width="100%" height= "100%" max-height="100%" src="" frameborder="0" allowfullscreen></iframe>

		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
	</div>
</div>
<!-- Fin Visualizar Requisicion-->





@endsection
@push('scripts')
<script type="text/javascript">
var path_url_submitarticles_oc = "{{ route('submitarticles_oc') }}";
//var path_url_objective = "{{ route('searchobjective') }}";

var path_url_costsbytype_oc="{{route('select.centroscostos')}}";
//var path_url_costsbytype_oc="{{ route('costsbytype') }}";
var path_url_iframe_oc = "{{ route('ver-auth', 1) }}";

//var peth_url_get_articulos_oc="{{route('get_articles_oc')}}";
//var peth_url_get_requisitions_oc="{{route('get_requisiciones_oc')}}";
</script>
@endpush