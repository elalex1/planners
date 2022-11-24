@extends('app')


@section('title', 'Nueva Cotización')

@section('content')
    <form action="{{ route('cotizaciones_store') }}" id="nuevaCotizacion" method="POST">
        {{ csrf_field() }}
        
        <div class="card">
            <!-- card content para nuevo registro en doctos_requisicion -->
            <div class="card-content grey lighten-5">

                <div id="vista1" class="row">
                    <div class="row col s12">
                        <label>proveedor</label>
                        <select class="error selectProveedor browser-default" name="proveedor"
                                url-record="{{route('select_proveedor_by_term')}}">
                            
                        </select>
                    </div>
                    <div class="row">
                            <div class="col s12">
                                <label>Moneda</label>
                                <select name="moneda" class="error browser-default">
                                    <option value="" selected>Seleccione una opción</option>
                                    @foreach ($data['monedas'] as $moneda)
                                        <option value="{{$moneda->nombre}}">{{$moneda->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>

                    
                    <div class="col s12">
                        <button form="nuevaCotizacion" type="submit"
                            class="validarformulario btn-floating btn-small waves-effect waves-light tooltipped blue right"
                            data-tooltip="Continuar" name="button">
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
                    <a disabled class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped"
                        href="#modalArt" data-position="top" data-tooltip="Añadir artículos">
                        <i class="large material-icons">add</i>
                    </a>
                </div>
                    {{-- <div class="row">
                        <div class="col s12">
                            <table class="display compact" >
                                <thead>
                                    <tr>
                                        <th>Clave</th>
                                        <th>Descripción</th>
                                        <th>Unidad Medida</th>
                                        <th>Cantidad</th>
                                        <th>Recibidas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>

        </div> --}}
    </div>
@endsection
