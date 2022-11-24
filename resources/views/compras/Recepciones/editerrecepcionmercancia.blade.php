@extends('app')


@section('title', 'Editar Recepción')

@section('content')
    
        {{ csrf_field() }}
        <div class="card">
            <div class="card-tabs">
                <ul class="tabs trasparent">
                    <li class="tab col l2 m4 s4"><a class="active" href="#vista1">General</a></li>
                    <li class="tab col l2 m4 s4 buttonmonedaextranjera hide"><a href="#vista2">Otros Datos</a></li>
                    <li class="tab col l2 m4 s4"><a href="#vista3">Documentos</a></li>
                </ul>
            </div>
            <!-- card content para nuevo registro en doctos_requisicion -->
            <div class="card-content grey lighten-5">
                <form action="{{ route('recepcionmercancia_update') }}" id="editarRecepcionMercancia" method="PUT">
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
                        <select name="almacen" class="error browser-default white">
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

                        <input hidden type="number" value="{{ $data['recepcion']->docto_compra_id }}" name="recepcion_id">
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
                            <label>Descuentp por</label>
                            
                                <p class="radiohidden">
                                    <label>
                                        <input type="radio" name="tipo_descuento" value="P" 
                                            @if ($data['recepcion']->tipo_descuento == 'P')checked @endif>
                                        <span>Porcentaje</span>
                                    </label>
                                </p>
                                <p class="radiohidden">
                                    <label>
                                        <input type="radio" name="tipo_descuento" value="I"
                                            @if ($data['recepcion']->tipo_descuento == 'I')checked @endif>
                                        <span>Importe</span>
                                    </label>
                                </p>
                                <p class="radiohidden selectnone" @if (!isset($data['recepcion']['tipo_descuento']) )hidden @endif>
                                    <label>
                                        <input type="radio" name="tipo_descuento" value="">
                                        <span>Importe</span>
                                    </label>
                                </p>
                            

                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="col s12">
                                <button form="editarRecepcionMercancia" type="submit"
                                    class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right"
                                    data-tooltip="Guardar" name="button">
                                    <i class="material-icons right">save</i>
                                </button>
                            </div>
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
                    <div class="row">
                        <div class="col s12">
                            <div class="col s12">
                                <button form="editarRecepcionMercancia" type="submit"
                                    class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right"
                                    data-tooltip="Guardar" name="button">
                                    <i class="material-icons right">save</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                </form>
{{-- *********************************************************************************************** --}}
                <div id="vista3" class="row col s12 bloque">
                    <div class="row">
                        <form id ="archivosDocto" action="{{route('recepcionmercancia_doctos')}}" method="post" enctype="multipart/form-data">
                            <input hidden name="id" type="number" value="{{ Request::route('id') }}">
                            <div class="input-field col s12">
                                <!-- Carrusel de imágenes -->
                                @if($data['imagenes'])
                                <h6>Imágenes</h6>
                                <div id="carrusel-img" class="carousel indicadores">
                                    @foreach ($data['imagenes'] as $imagen)
                                    <div class="carousel-item">
                                        <div class="card sticky-action grey lighten-3">
                                            <div class="card-image small">
                                                {{-- <img class="materialboxed" height="220" src="{{Storage::disk('s3')->url($imagen->archivo)}}"> --}}
                                                @if($imagen->tipo != 'pdf' && $imagen->tipo != 'xml')
                                                    <img class="materialboxed" height="220" src="{{Storage::disk('s3')->url($imagen->archivo)}}">
                                                @else
                                                    <img class="materialboxed" height="220" src="{{asset('images/'.$imagen->tipo.'_file.png')}}">
                                                @endif
                                                <span class="card-title">{{ $imagen->nombre_archivo }}</span>
                                                <a  id-record="{{$imagen->repositorio_archivo_id}}" 
                                                    id-asign="{{Request::route('id')}}"
                                                    url-record="{{route('recepcionmercancia_doctos_delete')}}" class="btn-floating halfway-fab waves-effect waves-light red btn-small eliminar_archivo"><i class="material-icons md1"  >delete</i></a>
                                            </div>
                                            <div class="card-content">
                                                <p>{{ $imagen->descripcion }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                <!-- Subir archivos -->
                                <h6>Subir imagen o documento como evidencia (opcional)</h6>
                                <input type="file" accept=".pdf,image/*" name="archivo_docto" class="dropify" data-allowed-file-extensions="pdf png jpg jpeg" data-max-file-size="2.5M"/>

                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="col s6">
                                        <label>Tamaño máximo de archivo: 1.5 MB </label>
                                    </div>
                                    <div class="col s6">
                                        <label class="right" >Formatos permitidos: pdf, png, jpg, jpeg</label>
                                    </div>

                                </div>
                            </div>
                            <div class="input-field col s12">
                                <textarea name="descripcion_documento" id="descripcionimg" class="materialize-textarea"></textarea>
                                <label for="descripcionimg">Descripción Documento</label>
                            </div>
                            <div class=" row col s12">
                                <button form="archivosDocto" class="btn-floating btn-small right light-blue waves-effect waves-light tooltipped validarformularioimg" data-position="top" data-tooltip="Subir imagen">
                                    <i class="large material-icons">cloud_upload</i>
                                </button>
                                <div id="loader_archivos" class="progress">
                                    <div class="indeterminate"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
{{-- *********************************************************************************************** --}}

            </div>
            <!-- Fin card content -->

        </div>
    


    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s6">
                    <h6>Artículos</h6>
                </div>
                <div class="input-field col s6">
                    <a @if ($data['recepcion']->ligada == 0) href="#modalArt" @endif disabled class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped"
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
                        <table id="det_articulos" order="1,asc" update-table="SI" class="compact row-border">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Descripción</th>
                                    <th>Unidad Medida</th>
                                    @if ($data['recepcion']->ligada == 0)
                                    <th>Cantidad</th>
                                    @else
                                    <th>Pedidos</th>
                                    <th>Surtidos</th>
                                    @endif
                                    <th>Precio U.</th>
                                    <th>Importe</th>
                                    @if ($data['recepcion']->ligada == 0)
                                    <th></th>
                                    @endif
                                    <th></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['recepcionDet'] as $articulo)
                                    <tr>
                                        <td>{{ $articulo->clave_articulo }}</td>
                                        <td>{{ $articulo->articulo }}</td>
                                        <td>{{ $articulo->unidad_compra }}</td>
                                        <td>{{ $articulo->cantidad }}</td>
                                        @if ($data['recepcion']->ligada != 0)
                                        <td class="verificar_cantidad">
                                            <input hidden type="number" name="cantidad-{{ $articulo->articulo_id }}" value="{{ $articulo->cantidad }}">
                                            <input type="number" class="center" name="newcantidad-{{ $articulo->articulo_id }}" value="0" min="0" max="{{ $articulo->cantidad }}">
                                            <input hidden type="number" name="doctoid-{{ $articulo->articulo_id }}" value="{{Request::route('id')}}">
                                            <input hidden type="number" name="articuloid-{{ $articulo->articulo_id }}" value="{{ $articulo->articulo_id }}">
                                        </td>
                                        @endif
                                        <td>$ {{ number_format($articulo->precio_unitario,2) }}</td>
                                        <td>$ {{ number_format($articulo->total,2) }}</td>
                                        @if ($data['recepcion']->ligada == 0)
                                        <td>
                                            <i class="material-icons eliminar_renglon puntero tooltipped" data-delay="50"
                                                data-tooltip="Eliminar artículo"
                                                id-record="{{ $articulo->docto_compra_det_id }}"
                                                id-asign="{{ Request::route('id') }}"
                                                url-record="{{ route('recepcionmercancia_DeleteArticle') }}">delete_forever</i>
                                        </td>
                                        @endif
                                        <td>
                                            @if ($articulo->seguimiento_lotes=='S')
                                                <a class="btn waves-effect waves-ligth modallote tooltipped" 
                                                    idarticulo="{{ $articulo->articulo_id }}"
                                                    idcompradet="{{$articulo->docto_compra_det_id}}"
                                                    href="modal-lote-{{ $articulo->articulo_id }}" data-position="left" 
                                                    data-tooltip="Agregar lote">lote
                                                </a>
                                            @endif
                                            <div id="modal-lote-{{ $articulo->articulo_id }}" class="modal_lote modal modal-fixed-footer " >
                                                <div class="modal-content">
                                                        <form id="formulario1-{{ $articulo->articulo_id }}" action="{{route('recepcionmercancia_actualizarlote')}}" method="POST" >
                                                            <div class="row">
                                                                <input hidden type="number" name="articuloid" value="{{ $articulo->articulo_id }}">
                                                                <input hidden type="number" name="compradetid" value="{{$articulo->docto_compra_det_id}}">
                                                                <div class="col s12">
                                                                    <div class="col l3 m3 s6">
                                                                        <label>Tipo</label>
                                                                        <select name="tipo" class="error browser-default">
                                                                            <option disabled selected value="" selected>Selecciona opción {{$articulo->tipo_lote}}</option>
                                                                            <option value="L" @if($articulo->tipo_lote === "L") selected='selected' @endif>Lote</option>
                                                                            <option value="S" @if($articulo->tipo_lote === "S") selected='selected' @endif>Serie</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col l3 m3 s6">
                                                                        <label>Serie/Folio</label>
                                                                        <input type="text" name="serie" value="{{$articulo->seriefolio}}">
                                                                    </div>
                                                                    <div class="col l3 m3 s6">
                                                                        <label>Fecha</label>
                                                                        <input type="date" name="fecha" value="{{$articulo->fecha_lote}}">
                                                                    </div>
                                                                    <div class="col l3 m3 s6">
                                                                        <label>Cantidad</label>
                                                                        <input type="number" name="cantidad" value="{{$articulo->cantidad_lote}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="#!" class="modal-close waves-effect waves-green btn-flat red">Cancelar</a>
                                                    <a form="formulario1-{{ $articulo->articulo_id }}"
                                                        class="waves-effect validarformulario waves-green waves-effect waves-light btn">Aceptar</a>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($data['recepcion']->total > 0)
						<div class="row col s12 pull-s1">
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
                    data-tooltip="Finalizar"><i class="material-icons">check</i></a></li>
            
            <li><a href="#modal_cancelar" class="btn-floating tooltipped red darken-1 modal-trigger" data-position="left"
                    data-tooltip="Cancelar"><i class="material-icons">cancel</i></a></li>
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
            <a href="{{ route('recepcionmercancia_addRenglon') }}"
                class="modal-action guardar_articulos modal-close waves-effect waves-light btn">
                Aceptar
            </a>
        </div>
    </div>
    {{-- Modal Finalizar --}}
    <div id="modalfinalizar" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Finalizar recepción</h4>
            <p>¿Está seguro que desea finalizar esta recepción?</p>
            <form action="{{ route('recepcionmercancia_finalizar') }}" method="PUT" id="finalizar_recepcion">
                <input hidden type="number" name="id_fin" value="{{ $data['recepcion']->docto_compra_id }}">
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a form="finalizar_recepcion"
                class="modal-close waves-effect validarformulario waves-green waves-effect waves-light btn"
                @if ($data['recepcion']->ligada != 0) dataval-recordRM="SI" @endif
                >Finalizar</a>
        </div>
    </div>
    {{-- Modal Finalizar Ligada --}}
    {{-- <div id="modalfinalizarligada" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Finalizar recepción</h4>
            <p>¿Está seguro que desea finalizar esta recepción?</p>
            {{-- <form action="{{ route('recepcionmercancia_finalizarligada') }}" method="PUT" id="finalizar_recepcion_ligada">
                <input type="number" hidden name="id" value="{{ $data['recepcion']->docto_compra_id }}">
            </form> -}}
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a action="{{ route('recepcionmercancia_finalizarligada') }}" method="PUT"
                class="modal-close waves-effect finalizar_oc_ligada waves-green waves-effect waves-light btn">Finalizar</a>
        </div>
    </div> --}}
    {{-- Modal Finalizar incompleta --}}
    <div id="modalFinIncompleta" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>La recepción no esta completa</h4>
            <h5>Existen partidas que no se han recibido completamente.</h5>
            <p>¿Está seguro que desea finalizar esta recepción?</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a form="finalizar_recepcion" 
                class="modal-close waves-effect validarformulario waves-green waves-effect waves-light btn"
                dataval-recordRM="SI"
                fin-anyway="SI">Finalizar</a>
        </div>
    </div>
    {{-- Modal Cancelar --}}
    <div id="modal_cancelar" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Cancelar recepción</h4>
            <p>¿Está seguro que desea cancelar esta recepción?</p>
            <form action="{{ route('recepcionmercancia_cancelar') }}" method="PUT" id="cancelar_recepcion">
                <input type="number" hidden name="recepcion_id" value="{{ $data['recepcion']->docto_compra_id }}">
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

@push('scripts')
    <script type="text/javascript">
    </script>
@endpush
