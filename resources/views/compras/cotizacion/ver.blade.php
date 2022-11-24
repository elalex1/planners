@extends('app')


@section('menu')
@stop
@section('header')
@stop

@section('content')
@stop
<main>
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
                            <div class="col s12">
                                <label>Moneda</label>
                                <select disabled name="moneda" class="error browser-default">
                                        <option value="{{ $data['compra']->moneda }}" selected>
                                            {{ $data['compra']->moneda }}</option>
                                </select>
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
            </div>
                <div class="row">
                    <div class="col s12">
                        <table id ="tblArticlesStatic">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Descripción</th>
                                    <th>Unidad Medida</th>
                                    <th>Cantidad</th>
                                    <th>Precio U.</th>
                                    <th>Importe</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['compraDet'] as $articulo)
                                    <tr>
                                        <td>{{ $articulo->clave_articulo }}</td>
                                        <td>{{ $articulo->articulo }}</td>
                                        <td>{{ $articulo->unidad_compra }}</td>
                                        <td>{{ $articulo->cantidad }}</td>
                                        <td>{{ $articulo->precio_unitario }}</td>
                                        <td>{{ $articulo->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col s12 pull-s1">
                                <h4 class="right"><strong>Total: </strong>  {{ $data['compra']->total }}</h4>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
    </div>
</main>
