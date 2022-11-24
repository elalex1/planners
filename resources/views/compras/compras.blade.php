@extends('app')



@section('title', 'Compras')





@section('content')

    <div class="card">

        

        <div class="card-content">

            <div class="card-title">Documentos</div>



            <table class="display responsive" order="3" id="tableGeneral" width="100%">

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

                                            <span class="status text-finished">•</span>

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

                            <td>pedido</td>

                            <td>



                                @switch($data->estatus)

                                    @case('Pendiente')

                                    <i href="{{route('compras_editar',$data->docto_compra_id)}}"

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

                                                href="{{ route('compras_ver_pdf', Crypt::encrypt($data->docto_compra_id)) }}">

                                                <i class="material-icons text-surtido tooltipped" data-tooltip="Descargar PDF"

                                                    id-record="{{ $data->docto_compra_id }}">picture_as_pdf</i>

                                            </i>

                                    @break



                                    @case('Cancelado')

                                        <i class="material-icons disabled-btn" id-record="{{ $data->docto_compra_id }}">edit</i>

                                        {{-- <i class="material-icons disabled-btn" id-record="{{ $data->docto_compra_id }}">email</i> --}}

                                        <i class="material-icons tooltipped disabled-btn"

                                            data-tooltip="La recepción debe esta cancelada">picture_as_pdf</i>

                                    @break

                                @endswitch

                                @if($data->estatus != 'Pendiente' && $data->estatus != 'Cancelado' && $data->estatus != 'Surtido' && $data->ligadaf == 0)

                                    <i class="puntero material-icons tooltipped red-text cancelar-docto" with-modal="modal_cancelar" data-tooltip="Cancelar" campo_id_name="compra_id" id-record="{{ $data->docto_compra_id }}">cancel</i>

                                @else

                                    <i class="material-icons disabled-btn">cancel</i>

                                @endif

                                <i class="material-icons visualizardocto puntero planner-text tooltipped" data-tooltip="Visualizar"

                                    href="{{ route('compras_visualizar',$data->docto_compra_id) }}">remove_red_eye</i>

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

            data-position="left" data-tooltip="Nueva Compra">

            <i class="large material-icons">add</i>

        </a>

        <ul>

            <li><a href="{{route('compras_nueva')}}" class="btn-floating tooltipped blue" 

                data-position="left" data-tooltip="Nueva"><i class="material-icons">add_circle</i></a></li>

            <li><a disabled href="#verRecepciones" class="btn-floating tooltipped green modal-trigger"

                data-position="left" data-tooltip="Desde Recepcion Mercancia"><i class="material-icons">assignment</i></a></li>

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

{{-------------------------------------------------------------------------------------------------}}

{{----                                     Recepciones terminadas                              ----}}

{{-------------------------------------------------------------------------------------------------}}

<div class="modal modal-fixed-footer" id="verRecepciones">

    <div class="modal-content" >

        {{ csrf_field() }}

		<h4>Recepciones</h4>

        <table class="display tablamodal nowrap table-responsive compact" id="tablaWithUrl" url-record="{{route('compras_recepciones')}}">

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

        <a href="{{route('compra_add_recepcion')}}"

            class="modal-action agregar_tabla_ligada_rec_co modal-close waves-effect waves-light btn">

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

		<form id="formCancelarDocto" action="{{ route('compra_cancelar') }}" method="POST">

			{{ csrf_field() }}

			<h4>Cancelar Compra</h4>

			<p>¿Está seguro que desea cancelar esta Compra?</p>

			<div class="input-field col s12">

				  <textarea name="motivo"  class="materialize-textarea" required></textarea>

				  <label for="motivo">Motivo cancelación</label>

			</div>

			<input hidden type="number" name="compra_id" value="">

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

