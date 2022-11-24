@extends('app')

@section('title', 'Cotizaciones')

@section('content')

<div class="card z-depth-4">

	<div class="card-content">

		<table class="display responsive" 

			id="tableGeneral" 

			width="100%">

			<thead>

				<tr>

					<th data-priority="1">Folio</th>

					<th data-priority="2">Fecha</th>

					<th data-priority="3">Proveedor</th>

					<th data-priority="7">Tipo Documento</th>

					<th data-priority="4">Partidas</th>

                    <th data-priority="5">Estatus</th>

                    <th data-priority="9">Creado Por</th>

					<th data-priority="6"></th>

				</tr>

			</thead>



			<tbody>

				@foreach ($data['cotizaciones'] as $cotizacion)

				<tr>

					<td>{{ $cotizacion->folio }}</td>

                    <td>{{$cotizacion->fecha}}</td>

                    <td class="proveedor tooltipped" data-tooltip="{{$cotizacion->proveedor}}">{{$cotizacion->proveedor}}</td>

                    <td>{{$cotizacion->tipo_documento}}</td>

                    <td>{{$cotizacion->partidas}}</td>

                    <td>

						@switch($cotizacion->estatus)

						@case('Pendiente')

						<span class="status text-pending">•</span>

						@break

						@case('Terminado')

						@if ($cotizacion->autorizado == 'Si')

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

						{{ $cotizacion->estatus }}

					</td>

					<td>{{ $cotizacion->usuario_creador }}</td>

					<td>

						@switch($cotizacion->estatus)

						@case('Pendiente')

							<i class="material-icons puntero docto-edit tooltipped text-pending" data-tooltip="Editar" href="{{ route('cotizaciones_editar',$cotizacion->docto_compra_id) }}" >edit</i>

							<i class="material-icons disabled-btn tooltipped" data-tooltip="La cotización debe estar terminada">email</i>

							<i class="material-icons disabled-btn">picture_as_pdf</i>

							<i class="material-icons disabled-btn tooltipped" data-tooltip="No se puede cancelar">cancel</i>

						@break

						@case('Terminado')

							<i class="material-icons tooltipped disabled-btn"  data-tooltip="La cotización debe estar pendiente">edit</i>

							<i class="material-icons email-cotizacion puntero tooltipped text-finished" data-tooltip="Enviar e-mail a proveedor" id-record="{{ $cotizacion->docto_compra_id }}" prov-record="{{ $cotizacion->proveedor }}">email</i>

							<i class="ver-pdf puntero" target="_blank"

                                                href="{{route('cotizaciones_pdf',Crypt::encrypt($cotizacion->docto_compra_id))}}">

                                                <i class="material-icons text-surtido tooltipped" data-tooltip="Descargar PDF">picture_as_pdf</i>

                                            </i>

							@if($cotizacion->requisicion == 0 && $cotizacion->ordencompra == 0)

								<i class="material-icons tooltipped puntero cancelar-docto red-text" url-record="{{route('cotizaciones_cancelar')}}" id-record="{{ $cotizacion->docto_compra_id }}" data-tooltip="Cancelar">cancel</i>

							@else

								<i class="material-icons disabled-btn tooltipped" data-tooltip="ligada a documento">cancel</i>

							@endif

						@break

						@case('Cancelado')

							<i  class="material-icons disabled-btn">edit</i>

							<i  class="material-icons disabled-btn">email</i>

							<i class="material-icons disabled-btn">picture_as_pdf</i>

							<i class="material-icons disabled-btn tooltipped" data-tooltip="documento cancelado">cancel</i>

						@break

						@endswitch

						<i class="material-icons visualizardocto tooltipped puntero planner-text" data-tooltip="Visualizar" href="{{route('cotizaciones_ver',Crypt::encrypt($cotizacion->docto_compra_id))}}">remove_red_eye</i>

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

	<a class="btn-floating btn-large waves-green waves-effect waves-light tooltipped " href="{{route('nuevaOrden')}}" data-position="top" data-tooltip="Nueva Orden de Compra">

		<i class="large material-icons">add</i>

	</a>

</div> --}}

<div class="fixed-action-btn click-to-toggle">

	<a class="btn-floating btn-large waves-green waves-effect waves-light"

		data-position="left" data-tooltip="Nueva Compra">

		<i class="large material-icons">add</i>

	</a>

	<ul>

		<li><a href="{{route('cotizaciones_nueva')}}" class="btn-floating tooltipped blue" 

			data-position="left" data-tooltip="Nueva"><i class="material-icons">add_circle</i></a></li>

		<li><a disabled href="#verRequisiciones" class="btn-floating tooltipped green modal-trigger"

			data-position="left" data-tooltip="Desde Requisiciones"><i class="material-icons">assignment</i></a></li>

	</ul>

</div>

<!-- Modal Structure Visualizar Requisicion-->

{{-- <div id="modal5" class="modal modal-fixed-footer">

	<div class="modal-content">

		<div id="modal-contenido" class="responsive-video">

			<iframe id="if-requisicion" width="100%" height= "calc(100% - 56px)" max-height="100%" src="" frameborder="0" allowfullscreen></iframe>



		</div>

	</div>

	<div class="modal-footer">

		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>

	</div>

</div> --}}

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

        <a href="NuevaCotizacion"

            class="agregar_tabla_ligada_array_detalle modal-close waves-effect waves-light btn">

            Aceptar

        </a>

	</div>

</div>

{{-------------------------------------------------------------------------------------------------}}

{{----                                     Contactos para enviar Email                         ----}}

{{-------------------------------------------------------------------------------------------------}}

<div class="modal modal-fixed-footer" id="SendEmailContactos">

    <div class="modal-content" >

        {{ csrf_field() }}

		<h4>Contactos</h4>

		<h5>Selecciona el correo al que deseas enviar la cotización</h5>

        <table class="display table-responsive" id="tablaContactos" url-record="{{route('cotizaciones_contactos_prov')}}">

            <thead>

                <tr>

                    <th data-priority="1">Nombre</th>

					<th data-priority="2">Contacto</th>

					<th data-priority="3">Telefono</th>

                    <th data-priority="4">Movil</th>

                    <th data-priority="6">correo</th>

                    <th data-priority="7">Localización</th>

					<th data-priority="5"></th>

                </tr>

            </thead>

            <tbody id="tblDesdeDocto" class="tblDesdeDocto"></tbody>

        </table>

    </div>

    <div class="modal-footer">

        <a class="modal-action modal-close waves-effect waves-light">

            Cancelar

        </a>

        <a href="tablaContactos" url-record="{{route('cotizaciones_sendemail_prov')}}"

            class="enviar_email_cot modal-close waves-effect waves-light btn">

            Aceptar

        </a>

	</div>

</div>

<div id="NuevaCotizacion" class="modal modal-fixed-footer">

	<div class="modal-content">

		<div class="modal-title center"><h4>Datos generales</h4></div>

		<form id="NuecoDocumento" action="{{ route('cotizaciones_agregar_requs') }}" method="POST">

			<div class="row">

				<input type="text" name="doctos_ids" value="" url-record="fdsfds" hidden>

				<div class="row col s12">

					<select modal-parent="NuevaCotizacion" name="proveedor" 

						url-record="{{route('select_proveedor_by_term')}}"

						class="error selectProveedor_modal browser-default">

					</select>

					<label>Seleccione proveedor</label>

				</div>

				<div class="row col s12">

					<select name="moneda" class="error browser-default">

						<option value="" disabled  selected>Selecciona opción</option>

						@foreach ($data['monedas'] as $moneda)

						<option value="{{ $moneda->nombre }}">{{ $moneda->nombre }}</option>

						@endforeach

					</select>

					<label>seleccione una moneda</label>

				</div>

				<div class="row col s12">

					<select name="familia_erticulos"

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

        <a form="NuecoDocumento"

            class="validarformulario waves-effect waves-light btn">

            Aceptar

        </a>

	</div>

</div>

@endsection