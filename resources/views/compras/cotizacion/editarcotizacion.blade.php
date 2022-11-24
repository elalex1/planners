@extends('app')

@section('title', 'Editar Cotización')

@section('content')

<div class="row">

    <div class="col s6"><h6><strong>Fecha: </strong> {{ $data['compra']->fecha }}</h6></div>

    <div class="col s6"><h6 class="right"><strong>Estatus: </strong> {{ $data['compra']->estatus }}</h6></div>

</div>

    <form action="{{-- route('cotizaciones_update') --}}" id="editarCompra" method="PUT">

        {{ csrf_field() }}

        

        <div class="card">

            <!-- card content para nuevo registro en doctos_requisicion -->

            <input name="id" type="text" hidden value="{{ $data['compra']->docto_compra_id }}">

            <div class="card-content grey lighten-5">



                <div id="vista1" class="row">

                    <div class="row col s12">

                        <label>Tipo Documento</label>

                        <select disabled name="concepto_compra" class="error browser-default">

                            <option value="" selected>{{ $data['compra']->concepto_compra }}</option>

                        </select>

                    </div>

                    <div class="row col s12">

                        <label>proveedor</label>

                        <select disabled class="error selectProveedor browser-default" name="proveedor">

                            <option selected value="{{ $data['compra']->proveedor }}" selected>{{ $data['compra']->proveedor }}</option>

                        </select>

                    </div>

                    <div class="row">

                        {{-- <div class="col s3">

                            <label for="fecha">Fecha</label>

                            <input disabled type="date" value="{{ $data['compra']->fecha }}">

                            <input name="fecha" type="text" hidden value="{{ $data['compra']->fecha }}">



                        </div>

                            <div class="col s6">

                                <label for="folio">Folio </label>

                                <input disabled type="text" value="{{ $data['compra']->folio }}">

                            </div> --}}

                            <div class="col s12">

                                <label>Moneda</label>

                                <select disabled name="moneda" class="error browser-default">

                                        <option value="{{ $data['compra']->moneda }}" selected>

                                            {{ $data['compra']->moneda }}</option>

                                </select>

                            </div>

                    </div>



                    

                    <div class="col s12">

                        <button disabled form="editarCompra" type="submit"

                            class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right"

                            data-tooltip="Guardar" name="button">

                            <i class="material-icons right">save</i>

                        </button>

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

                    <h6>Artículos</h6>

                </div>

                <div class="input-field col s6">

                    <a {{$data['compra']->autorizado=='Si' || $data['compra']->ligada >= 1 ? '': 'href=#modalArt'}} disabled class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped"

                        data-position="top" 

                        data-tooltip="Añadir artículos">

                        <i class="large material-icons">add</i>

                    </a>

                </div>

            </div>

                <div class="row">

                    <div class="col s12">

                        <!--loader-->

                        <div id="loader_det_articulos" class="preloader-wrapper big active">

                            <div class="spinner-layer spinner-blue-only">

                                <div class="circle-clipper left">

                                    <div class="circle"></div>

                                </div>

                                <div class="gap-patch">

                                    <div class="circle"></div>

                                </div>

                                <div class="circle-clipper right">

                                    <div class="circle"></div>

                                </div>

                            </div>

                        </div>

                        <!--fin loader-->

                        <table id="det_articulos" order="1,asc" update-table="SI" class="compact row-border">

                            <thead>

                                <tr>

                                    <th>Clave</th>

                                    <th>Descripción</th>

                                    <th>Unidad Medida</th>

                                    <th>Cantidad</th>

                                    <th>Precio U.</th>

                                    <th>Importe</th>

                                    @if ($data['compra']->ligada == 0)

                                    <th></th>

                                    @endif

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($data['compraDet'] as $articulo)

                                    <tr>

                                        <td>{{ $articulo->clave_articulo }}</td>

                                        <td>{{ $articulo->articulo }}</td>

                                        <td>{{ $articulo->unidad_compra }}</td>

                                        <td>{{ $articulo->cantidad }}</td>

                                        <td>$ {{ number_format($articulo->precio_unitario,2) }}</td>

                                        <td>$ {{ number_format($articulo->total,2) }}</td>

                                        {{-- <td>

                                            <i class="material-icons editar_renglon puntero tooltipped" data-delay="50"

                                                    data-tooltip="Editar"

                                                    columns-edit="['cantidad','precio_unitario']">edit</i>

                                        </td> --}}

                                        @if ($data['compra']->ligada == 0)

                                        <td>

                                            <i class="material-icons eliminar_renglon puntero tooltipped" data-delay="50"

                                                data-tooltip="Eliminar artículo"

                                                id-record="{{ $articulo->articulo_id }}"

                                                id-asign="{{ Request::route('id') }}"

                                                url-record="{{ route('cotizaciones_DeleteArticle') }}">delete_forever</i>

                                        </td>

                                        @endif

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                        @if($data['compra']->total > 0)

                        <div class="row">

                            <div class="col s12 pull-s1">

                                <h4 class="right"><strong>Total: $</strong>  {{ number_format($data['compra']->total,2) }}</h4>

                            </div>

                        </div>

                        @endif

                    </div>

        </div>

    </div>

    <div class="fixed-action-btn">

        <a href="#modalfinalizar" class="btn-floating btn-large waves-effect waves-light tooltipped green modal-trigger" data-position="left"

            data-tooltip="Finalizar">

            <i class="large material-icons">check</i>

        </a>

        {{-- <ul>

            @if ($data['compra']->ligada == 0)

                <li><a href="#modalfinalizar" class="btn-floating tooltipped green modal-trigger" data-position="left"

                    data-tooltip="Finalizar"><i class="material-icons">check</i></a></li>

            @else

                <li><a class="btn-floating tooltipped green finalizar_oc_ligada_mod" data-position="left"

                    data-tooltip="Finalizar"><i class="material-icons">check</i></a></li>

            @endif

            

            <li><a href="#modalcancelar" class="btn-floating tooltipped red darken-1 modal-trigger" data-position="left"

                    data-tooltip="Cancelar"><i class="material-icons">cancel</i></a></li>

        </ul> --}}

    </div>

    </div>



    {{-- Modales Modal Articulos --}}

    <div id="modalArt" class="modal modal-fixed-footer">

        <div class="modal-content" id="content-datableArticles-oc">

            {{ csrf_field() }}

            <h4>Artículos</h4>

            <table class="display" id="tablaWithUrl" mod-record= "CT" url-record="{{ route('get_articles_oc') }}" id-record="{{ Request::route('id') }}">

                <thead>

                    <tr>

                        <th>Cantidad</th>

                        <th>U. Medida</th>

                        <th>Precio U.</th>

                        <th>Artículo</th>

                    </tr>

                </thead>

                <tbody id="tblArticles" class="tblArticles">

                    {{-- @foreach ($data['articulos'] as $articulo)

				<tr id = "{{ $articulo->articulo_id }}">



					<td id = "cantidad" class = "tblArticles-oc">

						<input class="cantidadnumeric" id="cantidad-{{ $articulo->articulo_id }}" type="number" min="0" name="cantidad-{{ $articulo->articulo_id }}" />

						<input type="hidden" id="req-{{ $articulo->articulo_id }}" name="req-{{ $articulo->articulo_id }}" value="{{ Request::route('id') }}"/>

						<input type="hidden" id="nombre-{{ $articulo->articulo_id }}" name="nombre-{{ $articulo->articulo_id }}" value="{{ $articulo->nombre }}"/>

					</td>



					<td class = "tblArticles-oc">{{ $articulo->unidad_compra }}

					</td>



					<td class = "tblArticles-oc">

                        {{ $articulo->nombre }}

					</td>



					<td class = "tblArticles-oc">

						{{ $articulo->pesar_articulo }}"

					</td>



				</tr>

				@endforeach --}}

                </tbody>

            </table>

        </div>

        <div class="modal-footer">

            <a class="modal-action modal-close waves-effect waves-light">

                Cancelar

            </a>

            <a href="{{route('cotizacion_add_articles')}}"

                class="modal-action guardar_articulos modal-close waves-effect waves-light btn">

                Aceptar

            </a>

        </div>

    </div>

    {{-- Modal Finalizar --}}

   <div id="modalfinalizar" class="modal modal-fixed-footer">

        <div class="modal-content">

            <h4>Finalizar cotización</h4>

            <p>¿Está seguro que desea finalizar esta cotización?</p>

            <form action="{{route('cotizaciones_finalizar')}}" method="post" id="finalizar_docto">

                <input hidden type="number" name="docto_id" value="{{ Request::route('id') }}">

            </form>

        </div>

        <div class="modal-footer">

            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>

            <a form="finalizar_docto"

                class="modal-close waves-effect validarformulario waves-green waves-effect waves-light btn">Finalizar</a>

        </div>

    </div>

    {{-- Modal Finalizar Ligada --}}

{{--    <div id="modalfinalizarligada" class="modal modal-fixed-footer">

        <div class="modal-content">

            <h4>Finalizar recepción</h4>

            <p>¿Está seguro que desea finalizar esta recepción?</p>

        </div>

        <div class="modal-footer">

            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>

            <a action="" method="PUT"

                class="modal-close waves-effect finalizar_oc_ligada waves-green waves-effect waves-light btn">Finalizar</a>

        </div>

    </div>

    {{-- Modal Finalizar incompleta --}}

{{--    <div id="modalfinalizarligadaincompleta" class="modal modal-fixed-footer">

        <div class="modal-content">

            <h4>La recepción no esta completa</h4>

            <h5>Existen partidas que no se han recibido completamente.</h5>

            <p>¿Está seguro que desea finalizar esta recepción?</p>

        </div>

        <div class="modal-footer">

            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>

            <a id="finalizarligada" action="" method="PUT"

                class="modal-close waves-effect finalizar_oc_ligada waves-green waves-effect waves-light btn">Finalizar</a>

        </div>

    </div>

    {{-- Modal Cancelar --}}

{{--    <div id="modalcancelar" class="modal modal-fixed-footer">

        <div class="modal-content">

            <h4>Cancelar recepción</h4>

            <p>¿Está seguro que desea cancelar esta recepción?</p>

            <form action="" method="PUT" id="cancelar_recepcion">

                <input type="number" hidden name="id" value="{{ $data['compra']->docto_compra_id }}">

                <div class="row">

                    <div class="col s12">

                        <div class="input-field col s12">

                            <label>Motivo</label>

                            <input type="text" name="motivo">

                        </div>

                    </div>

                </div>

            </form>

        </div>

        <div class="modal-footer">

            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>

            <a form="cancelar_recepcion"

                class="waves-effect validarformulario waves-green waves-effect waves-light btn">Aceptar</a>

        </div>

    </div>

    {{--------------------------------------LOTE-----------------------------------------------}}

    

    {{-- Fin Modales --}}

    

    

@endsection

