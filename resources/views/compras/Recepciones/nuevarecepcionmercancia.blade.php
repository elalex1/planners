@extends('app')


@section('title', 'Nueva Recepción')

@section('content')
    <form action="{{ route('recepcionmercancia_store') }}" id="nuevaRecepcionMercancia" method="POST">
        {{ csrf_field() }}
        <div class="col s12">
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
                            <div class="row col s12">
                                <label class="requerido">proveedor</label>
                                <select name="proveedor" class="error selectProveedor browser-default" url-record="{{route('select_proveedor_by_term')}}" url-verify="{{route('recepcionmercancia_verif_prov','000')}}">
                                </select>
                            </div>
                            <div class="row col s12">
                                <label>Almacen</label>
                                <select name="almacen" class="error browser-default white">
                                    <option value="" disabled selected>Selecciona opción</option>
                                    @foreach ($data['almacenes'] as $almacen)
                                        <option value="{{ $almacen->nombre }}">{{ $almacen->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row col s12">
                                <div class="col s3">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" id="fecha">

                                </div>
                                <div class="input-field col s6">
                                    <input type="text" id="folio" name="folio">
                                    <label for="folio">Folio Remisión Proveedor</label>
                                </div>
                                <div class="col s3">
                                    <label>Moneda</label>
                                    <select name="moneda" class="error browser-default verify_moneda"
                                        url-record="{{ route('recepcionmercancia_verif_moneda', '000') }}">
                                        <option value="" disabled selected>Selecciona opción</option>
                                        @foreach ($data['monedas'] as $moneda)
                                            <option value="{{ $moneda->nombre }}">{{ $moneda->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col s12">
                                <div class="input-field col s12">
                                    <textarea id="descripcion" name="descripcion" class="materialize-textarea"></textarea>
                                    <label for="descripcion">Descripción</label>
                                    <span class="helper-text"></span>
                                </div>
                            </div> 

                            <div class="col s12">
                                <div class="input-field col s3">
                                    <label for="importe_descuento">Descuento</label></label>
                                    <input type="number" name="importe_descuento" id="importe_descuento" min="0" value="0">
                                </div>
                                <div class="col s6">
                                    <p><label>Descuentp por</label></p>
                                    <p class="radiohidden"><label><input type="radio" name="tipo_descuento"
                                                value="P"><span>Porcentaje</span></label></p>
                                    <p class="radiohidden"><label><input type="radio" name="tipo_descuento"
                                                value="I"><span>Importe</span></label></p>
                                    <p class="radiohidden selectnone" hidden><label><input type="radio" name="tipo_descuento"
                                                    value=""><span>Ninguno</span></label></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="vista2" class="row">
                        <div class="col s12">
                            <div class="input-field col s4">
                                <label for="tipo_cambio">Tipo de Cambio</label>
                                <input id="tipo_cambio" type="number" class="noarrows" name="tipo_cambio" value="1">
                            </div>
                            <div class="input-field col s4">
                                <label for="arancel">Arancel</label>
                                <input id="arancel" type="number" class="noarrows" name="arancel" min="0" value="0" disabled>
                            </div>
                            <div class="input-field col s4">
                                <label for="gastos_aduanales">Gastos aduanales</label>
                                <input id="gastos_aduanales" type="number" class="noarrows" name="gastos_aduanales" min="0" value="0" disabled>
                            </div>
                            <div class="input-field col s6">
                                <label for="otros_gastos">Otros Gastos</label>
                                <input id="otros_gastos" type="number" class="noarrows" name="otros_gastos" min="0" value="0">
                            </div>
                            <div class="input-field col s6">
                                <label for="fletes">Fletes</label>
                                <input id="fletes" type="number" class="noarrows" name="fletes" min="0" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <button form="nuevaRecepcionMercancia" type="submit"
                                    class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right"
                                    data-tooltip="Continuar" name="button">
                                    <i class="material-icons right">save</i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fin card content -->

            </div>
        </div>
    </form>


    <div class="card">
        <div class="card-content">
            <div class="row">
                <div class="col s6">
                    <h6>Artículos</h6>
                </div>
                <div class="col s6">
                    <a id="btnAddArticles"
                        class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped disabled"
                        href="#modal1" data-position="top" data-tooltip="Añadir artículos">
                        <i class="large material-icons">add</i>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
    </script>
@endpush
