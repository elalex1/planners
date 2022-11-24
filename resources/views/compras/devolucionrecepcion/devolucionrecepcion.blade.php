@extends('app')

@section('title', 'Devoluciones de Recepciones')

@section('content')

<div class="card">

	<div class="card-content">

		<table class="display responsive" order="3" id="tableGeneral" width="100%">

			<thead>

				<tr>

					<th data-priority="1">Folio</th>

                    <th data-priority="2">Proveedor</th>

                    <th data-priority="3">Almacen</th>

                    <th data-priority="4">fecha</th>

                    <th data-priority="6">Estatus</th>

                    <th data-priority="5"></th>

				</tr>

			</thead>



			<tbody>

				@foreach ($data['doctos'] as $docto)

				<tr>

					<td>{{ $docto->folio }}</td>

                    <td class="proveedor tooltipped" data-tooltip="{{$docto->proveedor}}">{{$docto->proveedor}}</td>

                    <td>{{$docto->almacen}}</td>

                    <td>{{$docto->fecha}}</td>

                    <td>

						@switch($docto->estatus)

						@case('Pendiente')

						<span class="status text-pending">•</span>

						@break

						@case('Terminado')

						@if ($docto->autorizado == 'Si')

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

						{{ $docto->estatus }}

					</td>

					<td>

						@switch($docto->estatus)

						@case('Pendiente')

							<i class="material-icons puntero docto-edit text-pending tooltipped" data-tooltip="Editar" href="{{ route('dev_recepciones_editar',$docto->docto_compra_id) }}" >edit</i>

							<i class="material-icons disabled-btn tooltipped" data-tooltip="La cotización debe estar terminada">email</i>

						@break

						@case('Terminado')

							<i class="material-icons tooltipped disabled-btn"  data-tooltip="La cotización debe estar pendiente">edit</i>

							<i class="material-icons email-docto puntero text-finished tooltipped" data-tooltip="Enviar e-mail" id-record="{{ $docto->docto_compra_id }}" prov-record="{{ $docto->proveedor }}">email</i>

						@break

						@case('Surtido')

							<i  class="material-icons disabled-btn" id-record="{{ $docto->docto_compra_id }}" >edit</i>

							<i  class="material-icons disabled-btn" id-record="{{ $docto->docto_compra_id }}" >email</i>

						@break

						@case('Cancelado')

							<i  class="material-icons disabled-btn" id-record="{{ $docto->docto_compra_id }}" >edit</i>

							<i  class="material-icons disabled-btn" id-record="{{ $docto->docto_compra_id }}" >email</i>

						@break

						@endswitch

						@if($docto->estatus != 'Pendiente' && $docto->estatus != 'Cancelado' && $docto->estatus != 'Surtido' && $docto->ligada == 0)

                                    <i class="puntero material-icons tooltipped red-text cancelar-docto" with-modal="modal_cancelar" data-tooltip="Cancelar" campo_id_name="devrecepcion_id" id-record="{{ $docto->docto_compra_id }}">cancel</i>

                                @else

                                    <i class="material-icons disabled-btn">cancel</i>

                                @endif

						<i class="material-icons visualizardocto tooltipped planner-text puntero" data-tooltip="Visualizar" href="{{route('dev_recepciones_visualizar',Crypt::encrypt($docto->docto_compra_id))}}">remove_red_eye</i>

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

	<a class="btn-floating btn-large waves-green waves-effect waves-light "

		data-position="left" data-tooltip="Nueva Compra">

		<i class="large material-icons">add</i>

	</a>

	<ul>

		<li><a href="{{route('dev_recepciones_nueva')}}" class="btn-floating tooltipped blue" 

			data-position="left" data-tooltip="Nueva"><i class="material-icons">add_circle</i></a></li>

		<li><a disabled href="#verRecepciones" class="btn-floating tooltipped green modal-trigger"

			data-position="left" data-tooltip="Desde recepciones"><i class="material-icons">assignment</i></a></li>

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

<div class="modal modal-fixed-footer" id="verRecepciones">

    <div class="modal-content" >

        {{ csrf_field() }}

		<h4>Recepciones</h4>

        <table class="display tablamodal nowrap table-responsive compact" radio-record="1" id="tablaWithUrl" url-record="{{route('compras_recepciones')}}">

            <thead>

                <tr>    

                    <th data-priority="1">Fecha</th>

                    <th data-priority="2">Folio</th>

                    <th data-priority="3">Proveedor</th>

                    <th data-priority="5">Almacen</th>

                    <th data-priority="4"></th>

                </tr>

            </thead>

            <tbody id="tblDesdeDocto" class="tblDesdeDocto"></tbody>

        </table>

    </div>

    <div class="modal-footer">

        <a class="modal-action modal-close waves-effect waves-light">

            Cancelar

        </a>

        <a href="{{ route('dev_recepciones_desde_recepcion') }}"

            class="agregar_tabla_ligada modal-close waves-effect waves-light btn">

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

		<h5>Selcciona el correo al que deceas enviar la cotización</h5>

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

{{-- <div id="NuevaCotizacion" class="modal modal-fixed-footer">

	<div class="modal-content">

		<div class="modal-title center"><h4>Datos generales</h4></div>

		<form id="NuevaOrdendeCompra" action="{{ route('cotizaciones_agregar_requs') }}" method="POST">

			<div class="row">

				<input type="text" name="requisiciones" value="" hidden>

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

</div> --}}

{{--------------------------------Modal cancelacion-----------------------------------------------------------}}

<div id="modal_cancelar" class="modal modal-fixed-footer">

	<div class="modal-content">

		<form id="formCancelarDocto" action="{{ route('dev_recepciones_cancelar') }}" method="POST">

			{{ csrf_field() }}

			<h4>Cancelar Devolución de Recepción de mercancía</h4>

			<p>¿Está seguro que desea cancelar esta Devolución?</p>

			<div class="input-field col s12">

				  <textarea name="motivo"  class="materialize-textarea" required></textarea>

				  <label for="motivo">Motivo cancelación</label>

			</div>

			<input hidden type="number" name="devrecepcion_id" value="">

		</form>

	</div>

	<div class="modal-footer">

		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>

		<a form="formCancelarDocto" class="validarformulario waves-effect waves-green waves-effect waves-light btn">Aceptar</a>

	</div>

</div>

@endsection