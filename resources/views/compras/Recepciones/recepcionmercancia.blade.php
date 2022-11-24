@extends('app')



@section('title', 'Recepción de Mercancía')





@section('content')

    <div class="card">

        

        <div class="card-content">

            <div class="card-title">Documentos</div>



            <table class="display responsive" id="tableGeneral" order="3" width="100%">

                <thead>

                    <tr>



                        <th data-priority="1">Folio</th>

                        <th data-priority="2">Proveedor</th>

                        <th data-priority="3">Almacen</th>

                        <th data-priority="4">fecha</th>

                        <th data-priority="6">Estatus</th>

                        <th data-priority="7">pedido</th>

                        <th data-priority="5"></th>

                    </tr>

                </thead>



                <tbody>

                    @foreach ($data['data'] as $data)

                        <tr>

                            <td>{{ $data->folio }}</td>

                            <td>{{ $data->proveedor }}</td>

                            <td>{{ $data->almacen }}</td>

                            <td>{{ $data->fecha }}</td>

                            <td>

                                @switch($data->estatus)

                                    @case('Pendiente')

                                        <span class="status text-pending">•</span>

                                    @break



                                    @case('Terminado')

                                        @if ($data->aplicado == 'No')

                                            <span class="status text-authorized">•</span>

                                        @else

                                            <span class="status text-finished">•</span>

                                        @endif

                                    @break



                                    @case('Cancelado')

                                        <span class="status text-cancel">•</span>

                                    @break

                                @endswitch



                                {{ $data->estatus }}

                            </td>

                            <td>{{$data->pedido}}</td>

                            <td>



                                @switch($data->estatus)

                                    @case('Pendiente')

                                    <i href="{{route('recepcionmercancia_editar',$data->docto_compra_id)}}"

                                        class="material-icons editar-documento tooltipped text-pending puntero" data-tooltip="Editar"

                                            id-record="{{ $data->docto_compra_id }}">edit</i>

                                        {{-- <i class="material-icons disabled-btn tooltipped"

                                            data-tooltip="La recepción debe estar terminada">email</i> --}}

                                    <i class="material-icons disabled-btn tooltipped"

                                        data-tooltip="La recepción debe estar autorizada">picture_as_pdf</i>

                                    @break



                                    @case('Terminado')

                                    <i class="material-icons disabled-btn">edit</i>

                                    {{-- <i class="material-icons recepcion-email tooltipped"

                                                data-tooltip="Enviar e-mail"

                                                href="{{ route('recepcionmercancia_pdf', $data->docto_compra_id) }}">email

                                    </i> --}}

                                    <i class="ver-pdf puntero" target="_blank"

                                                href="{{ route('recepcionmercancia_pdf', Crypt::encrypt($data->docto_compra_id)) }}">

                                                <i class="material-icons text-surtido tooltipped" data-tooltip="Descargar PDF">picture_as_pdf</i>

                                            </i>

                                    @break



                                    @case('Cancelado')

                                        <i class="material-icons disabled-btn" id-record="{{ $data->docto_compra_id }}">edit</i>

                                        {{-- <i class="material-icons disabled-btn" id-record="{{ $data->docto_compra_id }}">email</i> --}}

                                        <i class="material-icons tooltipped disabled-btn"

                                            data-tooltip="La recepción debe esta cancelada">picture_as_pdf</i>

                                    @break

                                @endswitch

                                @if($data->estatus != 'Pendiente' && $data->estatus != 'Cancelado' && $data->estatus != 'Surtido' && $data->ligada == 0)

                                    <i class="puntero material-icons tooltipped red-text cancelar-docto" with-modal="modal_cancelar" data-tooltip="Cancelar" campo_id_name="recepcion_id" id-record="{{ $data->docto_compra_id }}">cancel</i>

                                @else

                                    <i class="material-icons disabled-btn">cancel</i>

                                @endif

                                <i class="material-icons visualizardocto puntero teal-text tooltipped" data-tooltip="Visualizar"

                                    href="{{ route('recepcionmercancia_visualizar',$data->docto_compra_id) }}">remove_red_eye</i>

                            </td>

                        </tr>

                    @endforeach



                </tbody>

            </table>







        </div>

    </div>

    </div>

    <!-- Botón -->

    <div class="fixed-action-btn click-to-toggle">

        <a class="btn-floating btn-large waves-green waves-effect waves-light"

            data-position="left" data-tooltip="Nueva Recepción de Mercancia">

            <i class="large material-icons">add</i>

        </a>

        <ul>

            <li><a href="{{route('recepcionmercancia_nueva')}}" class="btn-floating tooltipped blue" 

                data-position="left" data-tooltip="Nueva"><i class="material-icons">add_circle</i></a></li>

            <li><a disabled href="#verOrdenesCompra" class="btn-floating tooltipped green modal-trigger"

                data-position="left" data-tooltip="Desde Orden de Compra"><i class="material-icons">assignment</i></a></li>

        </ul>

    </div>

    </form>

{{-- ---------------------------------------------------------------------------------------- --}}

{{--                                 Modales                                                  --}}

{{-- ---------------------------------------------------------------------------------------- --}}

                               {{--ver Recepcin--}}

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

                        {{--ordenes X recibir--}}

<div class="modal modal-fixed-footer" id="verOrdenesCompra">

    <div class="modal-content" >

        {{ csrf_field() }}

		<h4>Ordenes X Recibir</h4>

        <table class="display tablamodal nowrap compact" id="tablaWithUrl" url-record="{{route('recepcionmercancia_ordenescompra')}}">

            <thead>

                <tr>

                    <th data-priority="1">Fecha</th>

                    <th data-priority="2">Folio</th>

                    <th data-priority="4">Proveedor</th>

                    <th data-priority="5">partidas</th>

                    <th data-priority="6">Lugar de entrega</th>

                    <th data-priority="3"></th>

                </tr>

            </thead>

            <tbody id="tblOrdenesXRecibir" class="tblOrdenesXRecibir"></tbody>

        </table>

    </div>

    <div class="modal-footer">

        <a class="modal-action modal-close waves-effect waves-light">

            Cancelar

        </a>

        <a href="{{ route('recepcionmercancia_ordenescompra_add') }}"

            class="modal-action agregar_tabla_ligada_oc_rec modal-close waves-effect waves-light btn">

            Aceptar

        </a>

	</div>

</div>

{{-- ---------------------------------------------------------------------------------------- --}}

{{--                                 Modales                                                  --}}

{{-- ---------------------------------------------------------------------------------------- --}}

{{-------------------------------------------------------------------------------------------}}

<div id="modal_cancelar" class="modal modal-fixed-footer">

	<div class="modal-content">

		<form id="formCancelarDocto" action="{{ route('recepcionmercancia_cancelar') }}" method="PUT">

			{{ csrf_field() }}

			<h4>Cancelar Recepción de mercancía</h4>

			<p>¿Está seguro que desea cancelar esta Recepción?</p>

			<div class="input-field col s12">

				  <textarea name="motivo"  class="materialize-textarea" required></textarea>

				  <label for="motivo">Motivo cancelación</label>

			</div>

			<input hidden type="number" name="recepcion_id" value="">

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

         

    </script>

@endpush

