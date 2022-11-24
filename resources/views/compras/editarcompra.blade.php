@extends('app')


@section('title', 'Editar Compra')

@section('content')
    
        {{ csrf_field() }}
        <div class="card">
            <div class="card-tabs">
                <ul class="tabs trasparent">
                    <li class="tab col l2 m4 s6"><a class="active" href="#vista1">General</a></li>
                    <li class="tab col l2 m4 s6 buttonmonedaextranjera hide"><a href="#vista2">Otros Datos</a></li>
                    <li class="tab col l2 m4 s6"><a href="#vista3">Documentos</a></li>
                </ul>
            </div>
            <!-- card content para nuevo registro en doctos_requisicion -->
            
            <div class="card-content grey lighten-5">
                <form action="{{ route('compras_update') }}" id="editarCompra" method="PUT">
                    <input hidden name="id" type="text" value="{{ Request::route('id') }}">
                <div id="vista1" class="row">
                    <div class="row col s12">
                        <label>Tipo Documento</label>
                        <select disabled name="concepto_compra" class="error browser-default">
                            <option value="" selected>{{ $data['compra']->concepto_compra }}</option>
                        </select>
                    </div>
                    <div class="row col s12">
                        <label>proveedor</label>
                        <select disabled class="error selectProveedor browser-default" name="proveedor"
                            url-verify="{{ route('recepcionmercancia_verif_prov', $data['compra']->proveedor) }}">
                            <option selected value="{{ $data['compra']->proveedor }}" selected>{{ $data['compra']->proveedor }}</option>
                        </select>
                    </div>
                    <div class="row col s12">
                        <label>Almacen</label>
                        <select disabled name="almacen" class="error browser-default white">
                            <option value="{{ $data['compra']->almacen }}" selected>{{ $data['compra']->almacen }}
                            </option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col s3">
                            <label for="fecha">Fecha</label>
                            <input disabled type="date" value="{{ $data['compra']->fecha }}">
                            <input name="fecha" type="text" hidden value="{{ $data['compra']->fecha }}">

                        </div>
                        @if(!isset($data['compra']['folio']))
                            <div class="col s6">
                                <label for="folio">Folio</label>
                                <input type="text" name="folio" value="{{ $data['compra']->folio }}">
                            </div>
                        @else
                            <div class="col s6">
                                <label for="folio">Folio Factura</label>
                                <input disabled type="text" value="{{ $data['compra']->folio }}">
                            </div>
                        @endif
                            <div class="col s3">
                                <label>Moneda</label>
                                <select @if(isset($data['compra']['moneda'])) disabled @else name="moneda" @endif 
                                    class="error browser-default verify_moneda"
                                    url-record="{{ route('recepcionmercancia_verif_moneda', '000') }}" >
                                    @if(isset($data['compra']['moneda']))
                                        <option value="{{ $data['compra']->moneda }}" selected>
                                            {{ $data['compra']->moneda }}</option>
                                        <input name="moneda" type="text" hidden value="{{ $data['compra']->moneda }}">
                                    @else
                                        <option value="" disabled selected>Selecione opción</option>
                                        @foreach($data['monedas'] as $moneda)
                                            <option value="{{$moneda->nombre}}">{{$moneda->nombre}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                    </div>

                    <div class="col s12">
                        <div class="input-field col s3">
                            <label>Descuento</label></label>
                            <input type="number" class="noarrows" name="importe_descuento" min="0"
                                value="{{ $data['compra']->importe_descuento }}">
                        </div>
                        <div class="col s6">
                            <p><label> Descuentp por</label></p>
                            <p><label><input type="radio" name="tipo_descuento" value="P"
                                        @if ($data['compra']->tipo_descuento == 'P') checked @endif><span>Porcentaje</span></label></p>
                            <p><label><input type="radio" name="tipo_descuento" value="I"
                                @if ($data['compra']->tipo_descuento == 'I') checked @endif><span>Importe</span></label>
                            </p>
                            <p class="selectnone" @if (!isset($data['compra']['tipo_descuento']) || $data['compra']['tipo_descuento'] =="") hidden @endif><label><input type="radio" name="tipo_descuento" value=""
                                @if (!isset($data['compra']['tipo_descuento'])) checked @endif><span>Ninguno</span></label>
                            </p>

                        </div>
                    </div>
                    <div class="col s12">
                        <button form="editarCompra" type="submit"
                            class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right"
                            data-tooltip="Guardar" name="button">
                            <i class="material-icons right">save</i>
                        </button>
                    </div>

                </div>
                <div id="vista2" class=" row col s12 bloque">
                    <div class="input-field col s4">
                        <label>Tipo de Cambio</label>
                        <input type="number" class="noarrows" name="tipo_cambio" min="1"
                            value="{{ $data['compra']->tipo_cambio }}">
                    </div>
                    <div class="input-field col s4">
                        <label>Arancel</label>
                        <input type="number" class="noarrows" name="arancel" min="0"
                            value="{{ $data['compra']->arancel }}" disabled>
                    </div>
                    <div class="input-field col s4">
                        <label>Gastos aduanales</label>
                        <input type="number" class="noarrows" name="gastos_aduanales" min="0"
                            value="{{ $data['compra']->gastos_aduanales }}" disabled>
                    </div>
                    <div class="input-field col s6">
                        <label>Otros Gastos</label>
                        <input type="number" class="noarrows" name="otros_gastos" min="0"
                            value="{{ $data['compra']->otros_gastos }}">
                    </div>
                    <div class="input-field col s6">
                        <label>Fletes</label>
                        <input type="number" class="noarrows" name="fletes" min="0"
                            value="{{ $data['compra']->fletes }}">
                    </div>
                    <div class="col s12">
                        <button form="editarCompra" type="submit"
                            class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right"
                            data-tooltip="Guardar" name="button">
                            <i class="material-icons right">save</i>
                        </button>
                    </div>
                </div>
                </form>
{{-- *********************************************************************************************** --}}
                <div id="vista3" class="row col s12 bloque">
                    <div class="row">
                        <form id ="archivosDocto" action="{{route('compras_archivo_add')}}" method="post" enctype="multipart/form-data">
                            <input hidden name="id" type="text" value="{{ Request::route('id') }}">
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
                                                    url-record="{{route('compras_archivo_delete')}}" class="btn-floating halfway-fab waves-effect waves-light red btn-small eliminar_archivo"><i class="material-icons md1"  >delete</i></a>
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
                                <input name="archivo_docto" type="file" accept=".xml,.pdf,image/*" class="dropify" data-allowed-file-extensions="pdf png jpg jpeg xml" data-max-file-size="2.5M"/>

                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="col s6">
                                        <label>Tamaño máximo de archivo: 1.5 MB </label>
                                    </div>
                                    <div class="col s6">
                                        <label class="right" >Formatos permitidos: xml, pdf, png, jpg, jpeg</label>
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
                    <a class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped"
                    @if($data['compra']->ligada == 0) href="#modalArt" @endif disabled data-position="top" data-tooltip="Añadir artículos">
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
                        <table id="det_articulos" update-table="SI" class="compact row-border">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Descripción</th>
                                    <th>Unidad Medida</th>
                                    <th>Cantidad</th>
                                    <th>Precio U.</th>
                                    <th>Importe</th>
                                    @if($data['compra']->ligada == 0)
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
                                        @if($data['compra']->ligada == 0)
                                        <td>
                                            <i class="material-icons eliminar_renglon puntero tooltipped" data-delay="50"
                                                data-tooltip="Eliminar artículo"
                                                id-record="{{ $articulo->docto_compra_det_id }}"
                                                id-asign="{{ Request::route('id') }}"
                                                url-record="{{ route('compra_delete_articulo') }}">delete_forever</i>
                                        </td>
                                        @endif
                                        {{-- <td>
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
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($data['compra']->total > 0)
						<div class="row col s12 pull-s1">
							<h5 id="total" class="right"><strong>Total: $</strong> {{ number_format($data['compra']->total,2) }} </h5>
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
            <table class="display compact" id="tablaWithUrl" mod-record= "CO" url-record="{{ route('get_articles_oc') }}" id-record="{{ Request::route('id') }}">
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
            <a href="{{route('compra_add_articulo')}}"
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
            <form action="{{ route('compra_finalizar') }}" method="POST" id="finalizar_recepcion">
                <input hidden type="number" name="id_fin" value="{{ Request::route('id') }}">
            </form>modal_cancelar
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a form="finalizar_recepcion"
                class="modal-close waves-effect validarformulario waves-green waves-effect waves-light btn">Finalizar</a>
        </div>
    </div>
    {{-- Modal cancelar --}}
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
                <input hidden type="number" name="compra_id" value="{{Request::route('id')}}">
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a form="formCancelarDocto" class="validarformulario waves-effect waves-green waves-effect waves-light btn">Aceptar</a>
        </div>
    </div>
    {{-- Modal Finalizar Ligada -}}
    <div id="modalfinalizarligada" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Finalizar recepción</h4>
            <p>¿Está seguro que desea finalizar esta recepción?</p>
            {{-- <form action="{{ route('recepcionmercancia_finalizarligada') }}" method="PUT" id="finalizar_recepcion_ligada">
                <input type="number" hidden name="id" value="{{ $data['compra']->docto_compra_id }}">
            </form> -}}
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a action="{{-- route('recepcionmercancia_finalizarligada') -}}" method="PUT"
                class="modal-close waves-effect finalizar_oc_ligada waves-green waves-effect waves-light btn">Finalizar</a>
        </div>
    </div>
    {{-- Modal Cancelar -}}
    <div id="modalcancelar" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Cancelar recepción</h4>
            <p>¿Está seguro que desea cancelar esta recepción?</p>
            <form action="{{-- route('recepcionmercancia_cancelar') -}}" method="PUT" id="cancelar_recepcion">
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

@push('scripts')
    <script type="text/javascript">
    </script>
@endpush
