@extends('app')

@section('title', 'Ordenes Compras')


@section('content')


<div class="card">
	<div class="card-content">

		<table class="display responsive" 
			id="tableGeneral" 
			order="1"
			width="100%">
			<thead>
				<tr>
					<th data-priority="1">Folio</th>
					<th data-priority="2">Fecha</th>
					<th data-priority="3">Proveedor</th>
					<th data-priority="7">Tipo Documento</th>
					<th data-priority="4">Partidas</th>
                    <th data-priority="5">Estatus</th>
                    <th data-priority="8">Autorizado</th>
                    <th data-priority="9">Creado Por</th>
					<th data-priority="6"></th>
				</tr>
			</thead>

			<tbody>
				@foreach ($content['requisiciones'] as $ordencompra)
				<tr>
					<td>{{ $ordencompra->folio }}</td>
                    <td>{{$ordencompra->fecha}}</td>
                    <td class="proveedor tooltipped" data-tooltip="{{$ordencompra->proveedor}}">{{$ordencompra->proveedor}}</td>
                    <td>{{$ordencompra->tipo_documento}}</td>
                    <td>{{$ordencompra->partidas}}</td>
                    <td>
						@switch($ordencompra->estatus)
						@case('Pendiente')
						<span class="status text-pending">•</span>
						@break

						@case('Terminado')
						@if ($ordencompra->autorizado == 'Si')
						<span class="status text-authorized">•</span>
						@else
						<span class="status text-finished">•</span>
						@endif
						@break

						@case('Surtido')
						<span class="status text-surtido">•</span>
						@break
						@case('Cancelado')
						<span class="status text-cancel">•</span>
						@break
						@endswitch

						{{ $ordencompra->estatus }}
					</td>
                    <td>{{ $ordencompra->autorizado}}</td>
					<td>{{ $ordencompra->usuario_creador }}</td>
					<td>

						@switch($ordencompra->estatus)
						@case('Pendiente')
						<i class="material-icons edit-recordOC tooltipped text-pending" data-tooltip="Editar" id-record="{{ $ordencompra->docto_compra_id }}" >edit</i>
						<i class="material-icons disabled-btn tooltipped" data-tooltip="La orden compra debe estar terminada">email</i>
						@if (Session::get('rol') == 'Administrador')
							<i  class="material-icons disabled-btn">check_box_outline_blank</i>
						@endif
						<i  class="material-icons disabled-btn">picture_as_pdf</i>
						@break
						@case('Terminado')
						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La orden compra debe estar pendiente">edit</i>

						@if ($ordencompra->autorizado == 'Si')
							<i class="material-icons disabled-btn tooltipped" data-tooltip="La orden compra debe estar sin autorizar" >email</i>
							@if (Session::get('rol') == 'Administrador')
								<i  class="material-icons puntero tooltipped green-text" data-tooltip="Autorizado">check_box</i>
							@endif
							{{-- <i class="ver-pdf puntero" target="_blank" href="{{ route('pdfordencompra',  $ordencompra->docto_compra_id) }}">
								<i class="material-icons tooltipped"  data-tooltip="Ligada"  id-record="{{ $ordencompra->docto_compra_id }}" >cancel</i>
							</i> --}}
							<i class="ver-pdf puntero" target="_blank"
                                                href="{{route('pdfordencompra',$ordencompra->docto_compra_id)}}">
                                                <i class="material-icons text-surtido tooltipped" data-tooltip="Descargar PDF">picture_as_pdf</i>
                                            </i>
						@else
							<i class="material-icons email-record-oc tooltipped text-finished" data-tooltip="Enviar e-mail autorización" id-record="{{ $ordencompra->docto_compra_id }}" url-record="{{route('sendemailordencompra')}}">email</i>
							@if (Session::get('rol') == 'Administrador')
								<a href="{{route('autorizaordencompra',$ordencompra->docto_compra_id)}}" class="puntero tooltipped text-pending" data-tooltip="Autorizar orden compra"><i class="material-icons">check_box_outline_blank</i></a>
							@endif
							<i  class="material-icons disabled-btn">picture_as_pdf</i>
						@endif
							@break
							@case('Surtido')
							<i  class="material-icons disabled-btn" id-record="{{ $ordencompra->docto_compra_id }}" >edit</i>
							<i  class="material-icons disabled-btn" id-record="{{ $ordencompra->docto_compra_id }}" >email</i>
							@if (Session::get('rol') == 'Administrador')
								<i  class="material-icons disabled-btn">check_box_outline_blank</i>
							@endif
							<i  class="material-icons disabled-btn">picture_as_pdf</i>
							@break

						@case('Cancelado')
						{{--autorizaordencompra--}}
						<i  class="material-icons disabled-btn">edit</i>
						<i  class="material-icons disabled-btn">email</i>
						@if (Session::get('rol') == 'Administrador')
							<i  class="material-icons disabled-btn">check_box_outline_blank</i>
						@endif
						<i  class="material-icons disabled-btn">picture_as_pdf</i>
						@break

						@endswitch
						@if($ordencompra->estatus != 'Pendiente' && $ordencompra->estatus != 'Cancelado' && $ordencompra->estatus != 'Surtido' && $ordencompra->ligada == 0)
							<i class="puntero material-icons tooltipped red-text cancelar-docto" with-modal="modal_cancelar" data-tooltip="Cancelar" campo_id_name="ordencompra_id" id-record="{{ $ordencompra->docto_compra_id }}">cancel</i>
						@else
							<i class="material-icons disabled-btn">cancel</i>
						@endif
						<i class="material-icons view-record-oc tooltipped teal-text" data-tooltip="Visualizar" id-record="{{ $ordencompra->docto_compra_id }}">remove_red_eye</i>
					</td>
				</tr>
				@endforeach

			</tbody>
		</table>



	</div>
</div>
</div>
<!-- Botón -->
{{-- <div class="fixed-action-btn" >
	<a class="btn-floating btn-large waves-green waves-effect waves-light tooltipped light-green accent-4" href="{{route('nuevaOrden')}}" data-position="top" data-tooltip="Nueva Orden de Compra">
		<i class="large material-icons">add</i>
	</a>
</div> --}}
<div class="fixed-action-btn click-to-toggle">
	<a class="btn-floating btn-large waves-green waves-effect waves-light light-green accent-4"
		data-position="left" data-tooltip="Nueva Compra">
		<i class="large material-icons">add</i>
	</a>
	<ul>
		<li>
			<a href="{{route('nuevaOrden')}}" class="btn-floating tooltipped blue" 
				data-position="left" data-tooltip="Nueva"><i class="material-icons">add_circle</i>
			</a>
		</li>
		<li>
			<a disabled href="#verRequisiciones" class="btn-floating tooltipped green modal-trigger"
				data-position="left" data-tooltip="Desde Requisicón"><i class="material-icons">assignment</i>
			</a>
		</li>
		<li>
			<a disabled href="#verCotizaciones" class="btn-floating tooltipped purple modal-trigger"
				data-position="left" data-tooltip="Desde Cotización"><i class="material-icons">class</i>
			</a>
		</li>
	</ul>
</div>


<!-- Modal Structure Visualizar Requisicion-->
<div id="modal5" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div id="modal-contenido" class="responsive-video">
			<iframe id="if-requisicion" width="100%" height= "calc(100% - 56px)" max-height="100%" src="" frameborder="0" allowfullscreen></iframe>

		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
	</div>
</div>
<!-- Fin Visualizar Requisicion-->
<div id="modalVerDocto" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div id="modal-contenido" class="responsive-video">
			<iframe id="if-docto" width="100%" height= "calc(100% - 56px)" max-height="100%" src="" frameborder="0" allowfullscreen></iframe>

		</div>
	</div>
	<div class="modal-footer">
		<a class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
	</div>
</div>



</form>

{{-------------------------------------------------------------------------------------------------}}
{{----                                     Recepciones terminadas                              ----}}
{{-------------------------------------------------------------------------------------------------}}
<div class="modal modal-fixed-footer" id="verRequisiciones">
    <div class="modal-content" >
        {{ csrf_field() }}
		<h4>Requisiciones</h4>
        <table class="display tablamodal nowrap compact" id="tablaWithUrl" url-record="{{route('get_requisiciones_oc')}}">
            <thead>
                <tr>
                    <th data-priority="1">Folio</th>
					<th data-priority="2">Fecha</th>
					<th data-priority="3">Descripción</th>
                    <th data-priority="4">Estatus</th>
                    <th data-priority="5">Creado Por</th>
					<th data-priority="6"></th>
                </tr>
            </thead>
            <tbody id="tblDesdeDocto" class="tblDesdeDocto"></tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a class="modal-action modal-close waves-effect waves-light">
            Cancelar
        </a>
        <a href="NuevaOCRequ"
            class="agregar_tabla_ligada_array_detalle modal-close waves-effect waves-light btn">
            Aceptar
        </a>
	</div>
</div>
<div class="modal modal-fixed-footer" id="verCotizaciones">
    <div class="modal-content" >
        {{ csrf_field() }}
		<h4>Cotizaciones</h4>
        <table class="display tablamodal nowrap compact" id="tablaWithUrl2" url-record="{{route('ordenescompras_get_cotizaciones')}}">
            <thead>
                <tr>
                    <th data-priority="1">Folio</th>
					<th data-priority="2">Fecha</th>
					<th data-priority="3">Proveedor</th>
                    <th data-priority="4">Moneda</th>
                    <th data-priority="5">partidas</th>
                    <th data-priority="6">Estatus</th>
					<th data-priority="7"></th>
                </tr>
            </thead>
            <tbody id="tblDesdeDocto" class="tblDesdeDocto"></tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a class="modal-action modal-close waves-effect waves-light">
            Cancelar
        </a>
        <a href="NuevaOCCotización"
            class="agregar_tabla_ligada_array_detalle modal-close waves-effect waves-light btn"
			tabla-record='tabla2'>
            Aceptar
        </a>
	</div>
</div>
<div id="NuevaOCRequ" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="modal-title center"><h4>Información general</h4></div>
		<form id="NuevaOrdendeCompra" action="{{ route('agregar_requ_ordencompra') }}" method="POST">
			<div class="row">
				<input type="text" name="doctos_ids" hidden>
				<div class="row col s12">
					<select id="slc-proveedor" modal-parent="NuevaOCRequ" name="proveedor" 
						url-record="{{route('select_proveedor_by_term')}}"
						class="error selectProveedor_modal browser-default">
						{{--<!--<option value="" disabled  selected>Selecciona opción</option>
						@foreach ($content['proveedores'] as $proveedor)
						<option value="{{ $proveedor->proveedor_id }}">{{ $proveedor->nombre }}</option>
						@endforeach-->--}}
					</select>
					<label>selecciona proveedor</label>
				</div>
				<div class="row col s12">
					<select name="lugar_entrega" class="error browser-default">
						<option value="" disabled  selected>Selecciona opción</option>
						@foreach ($content['almacenes'] as $almacen)
						<option value="{{ $almacen->nombre }}">{{ $almacen->nombre }}</option>
						@endforeach
					</select>
					<label>seleciona Lugar de entrega</label>
				</div>
				<div class="row col s12">
					<select name="moneda" class="error browser-default">
						<option value="" disabled  selected>Selecciona opción</option>
						@foreach ($content['monedas'] as $moneda)
						<option value="{{ $moneda->nombre }}">{{ $moneda->nombre }}</option>
						@endforeach
					</select>
					<label>selecciona Moneda</label>
				</div>
				<div class="row col s12">
					<select name="familia_articulos"
						url-record="{{route('select_fam_by_reqs')}}"
						data-record=""
						class="error selectFamilia browser-default">
					</select>
					<label>Seleccione familia de artículos</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close waves-effect waves-light">
            Cancelar
        </a>
        <a form="NuevaOrdendeCompra"
            class="validarformulario waves-effect waves-light btn">
            Aceptar
        </a>
	</div>
</div>
<div id="NuevaOCCotización" class="modal modal-fixed-footer">
	<div class="modal-content">
		<div class="modal-title center"><h4>Información general</h4></div>
		<form id="NuevaOrdendeCompraCot" action="{{route('ordenescompras_desde_cotizacion')}}" method="POST">
			<div class="row">
				<input type="text" name="doctos_ids" hidden>
				<div class="row col s12">
					<select name="lugar_entrega" class="error browser-default">
						<option value="" disabled  selected>Selecciona opción</option>
						@foreach ($content['almacenes'] as $almacen)
						<option value="{{ $almacen->nombre }}">{{ $almacen->nombre }}</option>
						@endforeach
					</select>
					<label>selecciona Lugar de entrega</label>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a class="modal-action modal-close waves-effect waves-light">
            Cancelar
        </a>
        <a form="NuevaOrdendeCompraCot"
            class="validarformulario waves-effect waves-light btn">
            Aceptar
        </a>
	</div>
</div>
{{----------------------------------Modal cancelar---------------------------------------------------------}}
<div id="modal_cancelar" class="modal modal-fixed-footer">
	<div class="modal-content">
		<form id="formCancelarDocto" action="{{ route('cancelarordencompra') }}" method="post">
			{{ csrf_field() }}
			<h4>Cancelar Orden Compra</h4>
			<p>¿Está seguro que desea cancelar esta Orden de Compra?</p>
			<div class="input-field col s12">
				  <textarea name="descripcion"  class="materialize-textarea" required></textarea>
				  <label for="descripcion">Motivo cancelación</label>
			</div>
			<input hidden type="number" name="ordencompra_id" value="">
		</form>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		<a form="formCancelarDocto" class="validarformulario waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
	</div>
</div>





@endsection


@push('scripts')
<script type="text/javascript">

var path_url_iframe_oc = "{{ route('ver-auth-oc', 1) }}";
//requisiciones
//enviar email pdf autorizado
// var path_url_sendemail_auth = "{{ route('sendpdf') }}";
// var path_url_sendemail = "{{ route('sendemail') }}";
// var path_url_apprequisition = '{{ route('apprequisition') }}';
// var path_url_authrequisition = '{{ route('autorizar') }}';
// var path_url_cancelrequisition = '{{ route('cancelar') }}';
// var path_url_requisitionimages = '{{ route('images') }}';
// var path_url_deleteimages = '{{ route('del-images') }}';
// var path_url_costsbytype = "{{ route('costsbytype') }}";
// var path_url_objective = "{{ route('searchobjective') }}";

//agregadas

// var path_url_costsbytype_oc="{{route('select.centroscostos')}}";
//var path_url_costsbytype_oc="{{ route('costsbytype') }}";


@if ($content['status_password'][0]->status_password == 0)
$(window).on('load', function() {
	setTimeout(function() {
		var elem = document.getElementById("modal6");
		var modal = M.Modal.getInstance(elem);
		modal.open();
	}, 1000);
});
@endif

</script>
@endpush