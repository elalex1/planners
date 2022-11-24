@extends('app')
@section('title', 'Editar tabla antiguedad')
@section('content')

    <div class="card row">
        <div class="card-title"><div class="row col s12">General</div></div>
        <div class="card-content">
            <div class="row">
                    <div class="row">
                    <div class="col s12 input-field">
                        <label for="nombre">NOMBRE</label>
                        <input disabled type="text" name="nombre" id="nombre" value="{{$content['tabla_antiguedad']->nombre}}">
                    </div>
                    <div class="col s12  input-field">
                        <label for="nombre_corto">NOMBRE CORTO</label>
                        <input disabled type="text" name="nombre_corto" id="nombre_corto" value="{{$content['tabla_antiguedad']->nombre_corto}}">
                    </div>
                    <div class="col s12 center">
                        <label>Activo</label>
                    </div>
                    <div class="col s12 switch center">
                        <label>
                            No
                            <input {{$content['tabla_antiguedad']->estatus=='N' ? 'checked':''}} type="checkbox" value="N">
                            <span class="lever"></span>
                            Si
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card row">
        
        <div class="card-content">
            <div class="row">
                <div class="row input-field col s12">
                    <a  href="#modalArt" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Añadir detalle">
                        <i class="large material-icons">add</i>
                    </a>
                    
                </div>
                {{-- <div class="col s12">
                    <div class="divider"></div>
                </div> --}}
                <table id="tableGeneral" class="display responsive" width="100%" >
                    <thead>
                        <tr>
                            <th data-priority="1">DIAS ANTIGUEDAD</th>
                            <th data-priority="2">AÑOS ANTIGUEDAD</th>
                            <th data-priority="3">AÑOS ANTIGUEDAD IMSS</th>
                            <th data-priority="4">DIAS AGUINALDO</th>
                            <th data-priority="6">DIAS VACACIONES</th>
                            <th data-priority="7">DIAS PRIMA VACACIONAL</th>
                            <th data-priority="5"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($content['tabla_antiguedad_det'] as $tabla_det)
                        <tr>
                            <td>{{$tabla_det->antiguedad_dias}}</td>
                            <td>{{$tabla_det->antiguedad_anio}}</td>
                            <td>{{$tabla_det->antiguedad_anio_imss}}</td>
                            <td>{{$tabla_det->dias_aguinaldo}}</td>
                            <td>{{$tabla_det->dias_vacaciones}}</td>
                            <td>{{$tabla_det->dias_prima_vacacional}}</td>
                            <td><i  class="material-icons cancelar-docto tooltipped text-cancel puntero"
                                with-modal="modalCancelar"
                                campo_id_name="id_tabla_det"
                                id-record="{{$tabla_det->tabla_antiguedad_det_id}}"
                                data-delay="50" data-tooltip="Eliminar registro">delete_forever</i></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{{-- Modales --}}
    <div id="modalArt" class="modal modal-fixed-footer modalform-l grey lighten-2">
        <div class="modal-content">
            <form id="frm-newTablaDet" action="{{ route('tablas_antiguedades_adddet') }}" method="POST">
                <div class="card">
                    <div class="card-content">

                        <h4>Nuevo Detalle Tabla</h4>
                        <input hidden type="number" name="id_tabla" value="{{Request::route('id')}}">

                        @csrf
                        {{-- <div>
                        <label>CODIGO: </label><input type="text" name="codigo" value="{{ old('codigo') }}">
                            <input type="checkbox" name="estatus" value="S">Activo
                        </div>
                            <p><label>Datos personales</label></p> --}}
                        <div class="row">
                            <div class="row col s12">
                                <div class="row">
                                    <div class="col l4 m4 s12 input-field">
                                        <label for="dias_antiguedad">DIAS ANTIGUEDAD</label>
                                        <input type="number" name="dias_antiguedad" id="dias_antiguedad">
                                    </div>
                                    <div class="col l4 m4 s12  input-field">
                                        <label for="anios_antiguedad">AÑOS ANTIGUEDAD</label>
                                        <input type="number" name="anios_antiguedad" id="anios_antiguedad">
                                    </div>
                                    <div class="col l4 m4 s12 input-field">
                                        <label for="anios_antiguedad_imss">AÑOS ANTIGUEDAD IMSS</label>
                                        <input type="number" name="anios_antiguedad_imss" id="anios_antiguedad_imss">
                                    </div>
                                    <div class="col l4 m4 s12  input-field">
                                        <label for="dias_aguinaldo">DIAS AGUINALDO</label>
                                        <input type="number" name="dias_aguinaldo" id="dias_aguinaldo">
                                    </div>
                                    <div class="col l4 m4 s12 input-field">
                                        <label for="dias_vacaciones">DIAS VACACIONES</label>
                                        <input type="number" name="dias_vacaciones" id="dias_vacaciones">
                                    </div>
                                    <div class="col l4 m4 s12  input-field">
                                        <label for="dias_prima_vacacional">DIAS PRIMA VACACIONAL</label>
                                        <input type="number" name="dias_prima_vacacional" id="dias_prima_vacacional">
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <a href="#!" class="btn modal-action modal-close waves-effect waves-light red">
                Cancelar
            </a>
            <button form="frm-newTablaDet" class="btn validarformulario waves-effect waves-light light-green">
                Agregar
            </button>
        </div>
    </div>
    <div id="modalCancelar" class="modal modal-fixed-footer modalform-l grey lighten-2">
        <div class="modal-content">
            <form id="frm-Tabla" action="{{ route('tablas_antiguedades_deletedet') }}" method="POST">
                <div class="card">
                    <div class="card-content">

                        <h4>Eliminar Detalle</h4>

                        @csrf
                        {{-- <div>
                        <label>CODIGO: </label><input type="text" name="codigo" value="{{ old('codigo') }}">
                            <input type="checkbox" name="estatus" value="S">Activo
                        </div>
                            <p><label>Datos personales</label></p> --}}
                        <div class="row">
                            <input hidden type="text" name="id_tabla" id="id_tabla" value="{{Request::route('id')}}">
                            <input hidden type="text" name="id_tabla_det" id="id_tabla_det" value="">
                             <div class="col s12">¿Esta seguro de eliminar este registro?</div>   
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <a href="#!" class="btn modal-action modal-close waves-effect waves-light red">
                Cancelar
            </a>
            <button form="frm-Tabla" class="btn validarformulario waves-effect waves-light light-green">
                Agregar
            </button>
        </div>
    </div>
@endsection