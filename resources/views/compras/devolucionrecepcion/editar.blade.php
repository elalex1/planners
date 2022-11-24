@extends('app')


@section('title', 'Editar Devolución Recepción')

@section('content')
    <form action="{{ route('dev_recepciones_update') }}" id="editarDocto" method="PUT">
        {{ csrf_field() }}
        <div class="card">
            <div class="card-tabs">
                <ul class="tabs trasparent">
                    <li class="tab col l2 m4 s6"><a class="active" href="#vista1">General</a></li>
                    <li class="tab col l2 m4 s6 buttonmonedaextranjera hide"><a href="#vista2">Otros Datos</a></li>
                </ul>
            </div>
            <!-- card content para nuevo registro en doctos_requisicion -->
            <div class="card-content grey lighten-5">

                <div id="vista1" class="row">
                    <div class="col s12">
                        <label>Tipo Documento</label>
                        <select disabled id="slc-tipocompra" name="concepto_compra" class="error browser-default">
                            <option value="" disabled  selected>{{$data['recepcion']->concepto}}</option>
                            {{-- @foreach ($data['conceptos_compras'] as $concepto)
                            <option value="{{ $concepto->nombre }}">{{ $concepto->nombre }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="col s12">
                        <label>proveedor</label>
                        <select disabled class="error selectProveedor browser-default"
                            url-verify="{{ route('recepcionmercancia_verif_prov', $data['recepcion']->proveedor) }}">
                            <option selected value="" selected>{{ $data['recepcion']->proveedor }}</option>
                        </select>
                    </div>
                    <div class="col s12">
                        <label>Almacen</label>
                        <select @if($data['recepcion']['ligada'] > 0) disabled @endif name="almacen" class="error browser-default white">
                            {{-- <option value="{{ $data['recepcion']->almacen }}" selected>{{ $data['recepcion']->almacen }} --}}
                            </option>
                            @foreach ($data['almacenes'] as $almacen)
                                <option value="{{ $almacen->nombre }}" @if($data['recepcion']->almacen === $almacen->nombre) selected="selected" @endif>{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12">
                        <div class="col s3">
                            <label for="fecha">Fecha</label>
                            <input disabled type="date" value="{{ $data['recepcion']->fecha }}">
                            <input name="fecha" type="text" hidden value="{{ $data['recepcion']->fecha }}">

                        </div>
                        @if(!isset($data['recepcion']['folio_proveedor']))
                            <div class="col s6">
                                <label for="folio">Folio</label>
                                <input type="text" name="folio" value="{{ $data['recepcion']->folio_proveedor }}">
                            </div>
                        @else
                            <div class="col s6">
                                <label for="folio">Folio Remisión Proveedor</label>
                                <input disabled type="text" value="{{ $data['recepcion']->folio_proveedor }}">
                            </div>
                        @endif
                        @if (!isset($data['recepcion']['moneda']))
                            <div class="col s3">
                                <label>Moneda</label>
                                <select class="error browser-default verify_moneda" name="moneda"
                                    url-record="{{ route('recepcionmercancia_verif_moneda', '000') }}">
                                    <option value="" selected disabled>Seleccione una Opción</option>
                                    @foreach ($data['monedas'] as $moneda)
                                        <option value="{{ $moneda->nombre }}">{{ $moneda->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="col s3">
                                <label>Moneda</label>
                                <select disabled class="error browser-default verify_moneda"
                                    url-record="{{ route('recepcionmercancia_verif_moneda', '000') }}">
                                    <option value="{{ $data['recepcion']->moneda }}" selected>
                                        {{ $data['recepcion']->moneda }}</option>
                                    <input name="moneda" type="text" hidden value="{{ $data['recepcion']->moneda }}">
                                </select>
                            </div>
                        @endif

                        <input hidden type="number" value="{{ Request::route('id') }}" name="id">
                    </div>
                    <div class="col s12">
                        <div class="input-field col s12">
                            <textarea id="descripcion" name="descripcion" class="materialize-textarea">{{$data['recepcion']->descripcion}}</textarea>
                            <label for="descripcion">Descripción</label>
                            <span class="helper-text"></span>
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="input-field col s3">
                            <label for="importe_descuento">Descuento</label></label>
                            <input id="importe_descuento" type="number" class="noarrows" name="importe_descuento" min="0"
                                value="{{ $data['recepcion']->importe_descuento }}">
                        </div>
                        <div class="col s6">
                            <p><label> Descuentp por</label></p>
                            <p><label><input type="radio" name="tipo_descuento" value="P"
                                        @if ($data['recepcion']->tipo_descuento == 'P') checked @endif><span>Porcentaje</span></label></p>
                            <p><label><input type="radio" name="tipo_descuento" value="I"
                                @if ($data['recepcion']->tipo_descuento == 'I') checked @endif><span>Importe</span></label>
                            </p>
                            <p class="selectnone" @if (!isset($data['recepcion']['tipo_descuento']) || $data['recepcion']['tipo_descuento'] =="") hidden @endif><label><input type="radio" name="tipo_descuento" value=""
                                @if (!isset($data['recepcion']['tipo_descuento'])) checked @endif><span>Ninguno</span></label>
                            </p>

                        </div>
                    </div>
                </div>
                <div id="vista2" class=" row col s12 bloque">
                    <div class="input-field col s4">
                        <label form="tipo_cambio">Tipo de Cambio</label>
                        <input id="tipo_cambio" type="number" class="noarrows" name="tipo_cambio" min="1"
                            value="{{ $data['recepcion']->tipo_cambio }}">
                    </div>
                    <div class="input-field col s4">
                        <label for="arancel">Arancel</label>
                        <input id="arancel" type="number" class="noarrows" name="arancel" min="0"
                            value="{{ $data['recepcion']->arancel }}" disabled>
                    </div>
                    <div class="input-field col s4">
                        <label for="gastos_aduanales">Gastos aduanales</label>
                        <input id="gastos_aduanales" type="number" class="noarrows" name="gastos_aduanales" min="0"
                            value="{{ $data['recepcion']->gastos_aduanales }}" disabled>
                    </div>
                    <div class="input-field col s6">
                        <label for="otros_gastos">Otros Gastos</label>
                        <input id="otros_gastos" type="number" class="noarrows" name="otros_gastos" min="0"
                            value="{{ $data['recepcion']->otros_gastos }}">
                    </div>
                    <div class="input-field col s6">
                        <label for="fletes">Fletes</label>
                        <input id="fletes" type="number" class="noarrows" name="fletes" min="0"
                            value="{{ $data['recepcion']->fletes }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="col s12">
                            <button form="editarDocto" type="submit"
                                class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right"
                                data-tooltip="Guardar" name="button">
                                <i class="material-icons right">save</i>
                            </button>
                        </div>
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
                    {{-- @if($data['recepcion']['ligada'] > 0)
                        <a disabled class="btn-floating btn-small right light-green waves-effect waves-light"
                            data-position="top">
                            <i class="large material-icons">add</i>
                        </a>
                    @else
                        <a  class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped"
                            href="#modalArt" data-position="top" data-tooltip="Añadir artículos">
                            <i class="large material-icons">add</i>
                        </a>
                    @endif --}}
                    <a @if($data['recepcion']['ligada'] == 0) href="#modalArt" @endif disabled class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped"
                             data-position="top" data-tooltip="Añadir artículos">
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
                        <table id="det_articulos" update-table="OK" class="compact row-border">
                            <thead>
                                <tr>
                                    @if($data['recepcion']['ligada'] > 0)
                                    <th>
                                        <label>
                                            <input id="total_rows" type="checkbox" class="filled-in">
                                            <span>Total</span>
                                        </label>
                                    </th>
                                    @endif
                                    <th>Clave</th>
                                    <th>Descripción</th>
                                    <th>Unidad Medida</th>
                                    <th>Cantidad</th>
                                    <th>Precio U.</th>
                                    <th>Importe</th>
                                    @if($data['recepcion']['ligada'] == 0)
                                    <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['recepcionDet'] as $articulo)
                                    <tr>
                                        @if($data['recepcion']['ligada'] > 0)
                                        <td>
                                            <label>
                                                <input type="checkbox" class="filled-in total_rows"  name="cantidad-{{$articulo->articulo_id}}" value="1">
                                                <span></span>
                                                <input hidden type="number" name="articuloid-{{$articulo->articulo_id}}" value="{{$articulo->articulo_id}}">
                                                <input hidden type="number" name="doctoid-{{$articulo->articulo_id}}" value="{{Request::route('id')}}">
                                                <input hidden type="number" name="oldcantidad-{{$articulo->articulo_id}}" 
                                                    value="{{$articulo->cantidad}}">
                                            </label>
                                        </td>
                                        @endif
                                        <td>{{ $articulo->clave_articulo }}</td>
                                        <td>{{ $articulo->articulo }}</td>
                                        <td>{{ $articulo->unidad_compra }}</td>
                                        @if($data['recepcion']['ligada'] > 0)
                                            <td>
                                                
                                                {{-- <label>{{$articulo->cantidad}}</label> --}}
                                                <input class="verificar_cantidad" type="number" 
                                                    name="newcantidad-{{$articulo->articulo_id}}" 
                                                    value="{{$articulo->cantidad}}"
                                                    min="1"
                                                    max="{{$articulo->cantidad}}">
                                            </td>
                                        @else
                                            <td>{{ $articulo->cantidad }}</td>
                                        @endif
                                        <td>$ {{ number_format($articulo->precio_unitario,2) }}</td>
                                        <td>$ {{ number_format($articulo->total,2) }}</td>
                                        @if($data['recepcion']['ligada'] == 0)
                                        <td>
                                            <i class="material-icons eliminar_renglon puntero tooltipped" data-delay="50"
                                                data-tooltip="Eliminar artículo"
                                                id-record="{{ $articulo->docto_compra_det_id }}"
                                                id-asign="{{ Request::route('id') }}"
                                                url-record="{{ route('dev_recepciones_delete_article') }}">delete_forever</i>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($data['recepcion']->total > 0)
						<div class="row col s12">
							<h5 id="total" class="right"><strong>Total: $</strong> {{ number_format($data['recepcion']->total,2) }} </h5>
						</div>
					    @endif
                    </div>

        </div>
    </div>
    <div class="fixed-action-btn click-to-toggle">
        <a class="btn-floating btn-large waves-green waves-effect waves-light orange accent-4" data-position="left"
            data-tooltip="Mas opciones">
            <i class="large material-icons">more_vert</i>
        </a>
        <ul>
            <li><a href="#modalfinalizar" class="btn-floating tooltipped green modal-trigger" data-position="left"
                    data-tooltip="Finalizar"><i class="material-icons">check</i></a>
            </li>
            <li><a href="#modal_cancelar" class="btn-floating tooltipped red darken-1 modal-trigger" data-position="left"
                    data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
            </li>
        </ul>
    </div>
    </div>

    {{-- Modales Modal Articulos --}}
    <div id="modalArt" class="modal modal-fixed-footer">
        <div class="modal-content" id="content-datableArticles-oc">
            {{ csrf_field() }}
            <h4>Artículos</h4>
            <table class="display" id="tablaWithUrl" 
                mod-record= "RM"
                id-record= "{{ Request::route('id') }}"
                url-record= "{{ route('get_articles_oc') }}">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>U. Medida</th>
                        <th>Precio U.</th>
                        <th>Artículo</th>
                        <th>Pesar</th>
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
            <a href="{{ route('dev_recepciones_add_articles') }}"
                class="modal-action guardar_articulos modal-close waves-effect waves-light btn">
                Aceptar
            </a>
        </div>
    </div>
    {{-- Modal Finalizar --}}
    <div id="modalfinalizar" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Finalizar recepción</h4>
            <p>¿Está seguro que desea finalizar esta devolución de recepción?</p>
            <form action="{{route('dev_recepciones_finalizar')}}" method="POST" id="finalizar_recepcion">
                <input hidden type="number" name="id_fin" value="{{ Request::route('id') }}">
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a form="finalizar_recepcion"
                class="modal-close waves-effect validarformulario waves-green waves-effect waves-light btn"
                @if($data['recepcion']['ligada'] > 0) dataval-record="SI" @endif>Finalizar</a>
        </div>
    </div>
    {{-- Modal Finalizar Ligada 
    <div id="modalfinalizarligada" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Finalizar recepción</h4>
            <p>¿Está seguro que desea finalizar esta devolución de recepción?</p>
            {{-- <form action="{{ route('recepcionmercancia_finalizarligada') }}" method="PUT" id="finalizar_recepcion_ligada">
                <input type="number" hidden name="id" value="{{ Request::route('id') }}">
            </form> }}
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a action="" method="PUT"
                class="modal-close waves-effect finalizar_oc_ligada waves-green waves-effect waves-light btn">Finalizar</a>
        </div>
    </div>
    {{-- Modal Finalizar incompleta }}
    <div id="modalfinalizarligadaincompleta" class="modal modal-fixed-footer">
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
                <input hidden type="number" name="devrecepcion_id" value="{{ Request::route('id') }}">
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a form="formCancelarDocto" class="validarformulario waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
        </div>
    </div>
    {{--------------------------------------LOTE-----------------------------------------------}}
    
    {{-- Fin Modales --}}
    
@endsection

@push('scripts')
    <script type="text/javascript">
    </script>
@endpush
