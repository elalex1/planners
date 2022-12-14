@extends('app')


@section('menu')
@stop
@section('header')
@stop

@section('content')
@stop
<main>
        <div class="card">
            <div class="card-tabs">
                <ul class="tabs trasparent">
                    <li class="tab col l2 m4 s4"><a class="active" href="#vista1">General</a></li>
                    <li class="tab col l2 m4 s4 buttonmonedaextranjera hide"><a href="#vista2">Otros Datos</a></li>
                    <li class="tab col l2 m4 s4"><a href="#vista3">Documentos</a></li>
                </ul>
            </div>
            <!-- card content para nuevo registro en doctos_requisicion -->
            <input name="id" type="text" hidden value="{{ $data['compra']->docto_compra_id }}">
            <div class="card-content grey lighten-5">

                <div id="vista1" class="row">
                    <div class="row col s12">
                        <label>proveedor</label>
                        <select disabled class="error selectProveedor browser-default"
						url-verify="{{ route('recepcionmercancia_verif_prov', $data['compra']->proveedor) }}">
                            <option selected value="" selected>{{ $data['compra']->proveedor }}</option>
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

                        </div>
                        @if(!isset($data['compra']['folio']))
                            <div class="col s6">
                                <label for="folio">Folio</label>
                                <input disabled type="text" name="folio" value="{{ $data['compra']->folio }}">
                            </div>
                        @else
                            <div class="col s6">
                                <label for="folio">Folio Factura</label>
                                <input disabled type="text" value="{{ $data['compra']->folio }}">
                            </div>
                        @endif
                            <div class="col s3">
                                <label>Moneda</label>
                                <select disabled class="error browser-default verify_moneda"
                                    url-record="{{ route('recepcionmercancia_verif_moneda', '000') }}">
                                    <option value="{{ $data['compra']->moneda }}" selected>
                                        {{ $data['compra']->moneda }}</option>
                                    <input name="moneda" type="text" hidden value="{{ $data['compra']->moneda }}">
                                </select>
                            </div>

                        <input hidden type="number" value="{{ $data['compra']->docto_compra_id }}" name="id">
                    </div>

                    <div class="col s12">
                        <div class="input-field col s6">
                            <label>Descuento</label></label>
                            <input disabled type="number" class="noarrows" name="importe_descuento" min="0"
                                value="{{ $data['compra']->importe_descuento }}">
                        </div>
                        <div class="col s6">
                            <p><label>Descuentp por</label></p>
                            @if ($data['compra']->tipo_descuento == 'P')
                                <p><label><input disabled type="radio" name="tipo_descuento" value="P"
                                            checked><span>Porcentaje</span></label></p>
                                <p><label><input disabled type="radio" name="tipo_descuento" value="I"><span>Importe</span></label>
                                </p>
                            @elseif($data['compra']->tipo_descuento == 'I')
                                <p><label><input disabled type="radio" name="tipo_descuento"
                                            value="P"><span>Porcentaje</span></label></p>
                                <p><label><input disabled type="radio" name="tipo_descuento" value="I"
                                            checked><span>Importe</span></label></p>
                            @else
                                <p><label><input disabled type="radio" name="tipo_descuento"
                                            value="P"><span>Porcentaje</span></label></p>
                                <p><label><input disabled type="radio" name="tipo_descuento" value="I"><span>Importe</span></label>
                                </p>
                            @endif

                        </div>
                    </div>

                </div>
                <div id="vista2" class=" row col s12 bloque">
                    <div class="input-field col s4">
                        <label>Tipo de Cambio</label>
                        <input disabled type="number" class="noarrows" name="tipo_cambio" min="1"
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
                        <input disabled type="number" class="noarrows" name="otros_gastos" min="0"
                            value="{{ $data['compra']->otros_gastos }}">
                    </div>
                    <div class="input-field col s6">
                        <label>Fletes</label>
                        <input disabled type="number" class="noarrows" name="fletes" min="0"
                            value="{{ $data['compra']->fletes }}">
                    </div>
                </div>
                <div id="vista3" class="row col s12 bloque">
                    <div class="row">
                                <div class="input-field col s12">
                                <!-- Carrusel de im??genes -->
                                @if($data['imagenes'])
                                <h6>Im??genes</h6>
                                <div class="carousel indicadores">
                                    @foreach ($data['imagenes'] as $imagen)
                                    <div class="carousel-item">
                                        <div class="card grey lighten-3">
                                            <div class="card-image small">
                                                @if($imagen->tipo != 'pdf' && $imagen->tipo != 'xml')
                                                    <img class="materialboxed" height="220" src="{{Storage::disk('s3')->url($imagen->archivo)}}">
                                                @else
                                                    <img class="materialboxed" height="220" src="{{asset('images/'.$imagen->tipo.'_file.png')}}">
                                                @endif
                                                <span class="card-title">{{ $imagen->nombre_archivo }}</span>
                                            </div>
                                            <div class="card-content">
                                                <p>{{ $imagen->descripcion }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <!-- Subir archivos -->
                                <h6>Documento sin Imagenes</h6>
                                <input disabled name="archivo_docto" type="file" accept=".xml,.pdf,image/*" class="dropify" data-allowed-file-extensions="pdf png jpg jpeg xml" data-max-file-size="2.5M"/>

                            
                            <div class="row">
                                <div class="col s12">
                                    <div class="col s6">
                                        <label>Tama??o m??ximo de archivo: 1.5 MB </label>
                                    </div>
                                    <div class="col s6">
                                        <label class="right" >Formatos permitidos: xml, pdf, png, jpg, jpeg</label>
                                    </div>

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <!-- Fin card content -->

        </div>


    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s6">
                    <h6>Art??culos</h6>
                </div>
            </div>
                <div class="row">
                    <div class="col s12">
                        <table id="tblArticlesStatic">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Descripci??n</th>
                                    <th>Unidad Medida</th>
                                    <th>Cantidad</th>
                                    <th>Precio U.</th>
                                    <th>Importe</th>

                                    <th></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['compraDet'] as $articulo)
                                    <tr>
                                        <td>{{ $articulo->clave_articulo }}</td>
                                        <td>{{ $articulo->articulo }}</td>
                                        <td>{{ $articulo->unidad_compra }}</td>
                                        <td>{{ $articulo->cantidad }}</td>
                                        <td>${{ number_format($articulo->precio_unitario,2) }}</td>
                                        <td>${{ number_format($articulo->total,2) }}</td>

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
                                                                            <option disabled selected value="" selected>Selecciona opci??n {{$articulo->tipo_lote}}</option>
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
                        @if ($data['compra']->total > 0)
						<div class="row col s12 pull-s1">
							<h5 id="total" class="right"><strong>Total: $</strong> {{ number_format($data['compra']->total,2) }} </h5>
						</div>
					@endif
                    </div>
                

        </div>
    </div>
    </div>

</main>
