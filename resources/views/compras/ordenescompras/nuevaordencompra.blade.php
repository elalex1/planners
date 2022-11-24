@extends('app')


@section('title', 'Nueva Orden de Compra')

@section('content')
	<form id="formOrdenCompra" action="{{route('submit.ordencompra')}}" method="POST">
	{{ csrf_field() }}
<div class="card">


	<!-- card content para nuevo registro en doctos_requisicion -->
	<div class="card-content">

		<div class="row">
                <div class=" row col s12">
					<label>proveedor</label>
					<select id="slc-proveedor" name="proveedor" class="error selectProveedor browser-default"
						url-record="{{route('select_proveedor_by_term')}}">
						{{--<!--<option value="" disabled  selected>Selecciona opción</option>
						@foreach ($content['proveedores'] as $proveedor)
						<option value="{{ $proveedor->proveedor_id }}">{{ $proveedor->nombre }}</option>
						@endforeach-->--}}
					</select>
					
				</div>
				<div class="row col s12">
					<label>Lugar de entrega</label>
					<select id="slc-almacen" name="almacen" class="error browser-default">
						<option value="" disabled  selected>Selecciona opción</option>
						@foreach ($content['almacenes'] as $almacen)
						<option value="{{ $almacen->nombre }}">{{ $almacen->nombre }}</option>
						@endforeach
					</select>
				</div>
				<div class="row col s12">
					<label>Moneda</label>
					<select name="moneda" class="error browser-default">
						<option value="" disabled  selected>Selecciona opción</option>
						@foreach ($content['monedas'] as $moneda)
						<option value="{{ $moneda->nombre }}">{{ $moneda->nombre }}</option>
						@endforeach
					</select>
					
				</div>

				<div class="input-field row col s12">
					<textarea id="descripcion" name="descripcion" class="materialize-textarea"></textarea>
					<label for="descripcion">Observaciones</label>
					<span class="helper-text">Para ser utilizado en</span>
				</div>
				

				<div class="col s12">
					<a form="formOrdenCompra" class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right" data-tooltip="Continuar" name="button" >
						<i class="material-icons right">save</i>
					</a>
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

@endsection

@push('scripts')
<script type="text/javascript">
var path_url_submit_new_oc = "{{ route('submit.ordencompra') }}";


</script>
@endpush