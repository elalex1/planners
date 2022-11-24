@extends('app')
@section('title', 'Editar Registro Patronal')
@section('content')

    <div class="card row">
        <div class="card-title"><div class="row col s12">General</div></div>
        <div class="card-content">
            <div class="row">
                    <div class="row">
                    <div class="col l8 m12 s12 input-field">
                        <label for="nombre">NOMBRE</label>
                        <input disabled type="text" name="nombre" id="nombre" value="{{$content['registro_patronal']->nombre}}">
                    </div>
                    <div class="col l4 m6 s12  input-field">
                        <label for="nombre_corto">NOMBRE CORTO</label>
                        <input disabled type="text" name="nombre_corto" id="nombre_corto" value="{{$content['registro_patronal']->nombre_corto}}">
                    </div>
                    <div class="col l4 m6 s12  input-field">
                        <label for="registro_patronal">REGISTRO PATRONAL</label>
                        <input disabled type="text" name="registro_patronal" id="registro_patronal" value="{{$content['registro_patronal']->registro_patronal}}">
                    </div>
                    <div class="col l4 m6 s12  input-field">
                        <label for="clase">CLASE</label>
                        <input disabled type="text" name="clase" id="clase" value="{{$content['registro_patronal']->clase}}">
                    </div>
                    <div class="col l4 m6 s12  input-field">
                        <label for="clasificador_antiguedad">CLASIFICADOR ACTIVIDAD</label>
                        <input disabled type="text" name="clasificador_antiguedad" id="clasificador_antiguedad" value="{{$content['registro_patronal']->clasificador_actividad}}">
                    </div>
                    <div class="col s12 center">
                        <label>Activo</label>
                    </div>
                    <div class="col s12 switch center">
                        <label>
                            No
                            <input {{$content['registro_patronal']->estatus=='N' ? 'checked':''}} type="checkbox" value="N">
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
                            <th data-priority="1">RIESGO</th>
                            <th data-priority="2">FECHA INICIO</th>
                            <th data-priority="3">FECHA FIN</th>
                            <th data-priority="5"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($content['primas_riesgos'] as $prima_riesgo)
                        <tr>
                            <td>{{$prima_riesgo->riesgo}}</td>
                            <td>{{$prima_riesgo->fecha_inicio}}</td>
                            <td>{{$prima_riesgo->fecha_fin}}</td>
                            <td>
                                <i  class="material-icons cancelar-docto tooltipped text-cancel puntero"
                                with-modal="modalCancelar"
                                campo_id_name="prima_riego_id"
                                id-record="{{$prima_riesgo->prima_riesgo_trabajo_rp_id}}"
                                data-delay="50" data-tooltip="Eliminar registro">delete_forever</i>
                            </td>
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
            <form id="frm-newTablaDet" action="{{ route('registrospatronales_addRiesgo') }}" method="POST">
                <div class="card">
                    <div class="card-content">

                        <h4>Nueva Prima Riesgo</h4>
                        <input hidden type="text" name="id_registro_patronal" value="{{Request::route('id')}}">

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
                                        <label for="riesgo">RIESGO</label>
                                        <input type="number" name="riesgo" id="riesgo">
                                    </div>
                                    <div class="col l4 m4 s6">
                                        <label for="fecha_inicio">FECHA INICIO</label>
                                        <input type="date" name="fecha_inicio" id="fecha_inicio">
                                    </div>
                                    <div class="col l4 m4 s6">
                                        <label for="fecha_fin">FECHA FIN</label>
                                        <input type="date" name="fecha_fin" id="fecha_fin">
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
            <form id="frm-Tabla" action="{{ route('registrospatronales_deleteRiesgo') }}" method="POST">
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
                            <input hidden type="text" name="id_registro_patronal" id="id_tabla" value="{{Request::route('id')}}">
                            <input hidden type="text" name="prima_riego_id" id="prima_riego_id" value="">
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