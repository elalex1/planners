@extends('app')
@section('title', 'Editar Frecuencias Nominas')
@section('content')
    <form id="frm-newTabla" action="{{-- route('empleados_store') --}}" method="POST">
        <div class="card">
            <div class="card-content">

                <h4>Nueva Frecuencia Nomina</h4>

                @csrf
                {{-- <div>
                <label>CODIGO: </label><input type="text" name="codigo" value="{{ old('codigo') }}">
                    <input type="checkbox" name="estatus" value="S">Activo
                </div>
                    <p><label>Datos personales</label></p> --}}
                <div class="row">
                    {{-- <div class="row col s12"> --}}
                        <div class="row">
                            <div class="col l8 m12 s12 input-field">
                                <label for="nombre">NOMBRE</label>
                                <input disabled type="text" name="nombre" id="nombre"
                                    value="{{$content['frecuencia_nomina']->nombre}}">
                            </div>
                            <div class="col l4 m6 s12  input-field">
                                <label for="nombre_corto">NOMBRE CORTO</label>
                                <input disabled type="text" name="nombre_corto" id="nombre_corto"
                                    value="{{$content['frecuencia_nomina']->nombre_corto}}">
                            </div>
                            <div class="col l6 m6 s12  input-field">
                                <label for="clave_fiscal">CLAVE FISCAL</label>
                                <input disabled type="text" name="clave_fiscal" id="clave_fiscal"
                                    value="{{$content['frecuencia_nomina']->clave_fiscal}}">
                            </div>
                            {{-- <div class="col l4 m6 s12  input-field">
                                <label for="clase">CALCULAR SEPTIMO DIA</label>
                                <input type="text" name="clase" id="clase">
                            </div> --}}
                            
                            <div class="col l6 m6 s12  input-field">
                                <label for="dias_periodo">DIAS PERIODO</label>
                                <input type="number" name="dias_periodo" id="dias_periodo"
                                    value="{{$content['frecuencia_nomina']->dias_periodo}}">
                            </div>
                            <div class="col l4 m6 s12  input-field">
                                <label for="dias_trabajador">DIAS TRABAJADOR</label>
                                <input type="number" name="dias_trabajador" id="dias_trabajador"
                                    value="{{$content['frecuencia_nomina']->dias_trabajador}}">
                            </div>
                            <div class="col l4 m6 s12  input-field">
                                <label for="dias_septimo">DIAS SEPTIMO</label>
                                <input type="number" name="dias_septimo" id="dias_septimo"
                                    value="{{$content['frecuencia_nomina']->dias_septimo}}">
                            </div>
                            <div class="col l4 m6 s12 center">
                                <label >CALCULA SEPTIMO DIA</label>
                                <div class="switch">
                                    <label>
                                    
                                    <input {{$content['frecuencia_nomina']->calcular_septimo_dia=='S' ? 'checked':''}} type="checkbox" name="calcula_septimo_dia" value="S">
                                    <span class="lever"></span>
                                    
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="row col l6 m6 s12">
                                    <label>TIPO CALCULO IMPUESTO</label>
                                        <select name="tipo_calculo_impuesto"  class="error browser-default">
                                        <option disabled value="" selected>Selecciona una opción</option>
                                        <option {{$content['frecuencia_nomina']->tipo_calculo_impuesto=='M' ? 'selected':''}} value="M">Monto</option>
                                        <option {{$content['frecuencia_nomina']->tipo_calculo_impuesto=='P' ? 'selected':''}} value="P">Periodo</option>
                                    </select>
                                </div>
                                <div class="row col l6 m6 s12">
                                    <label>TIPO CALCULO NOMINA</label>
                                        <select name="tipo_calculo_nomina"  class="error browser-default">
                                        <option disabled value="" selected>Selecciona una opción</option>
                                        <option {{$content['frecuencia_nomina']->tipo_calculo_nomina=='M' ? 'selected':''}} value="M">Manual</option>
                                        <option {{$content['frecuencia_nomina']->tipo_calculo_nomina=='A' ? 'selected':''}} value="A">Automático</option>
                                    </select>
                                </div>
                            <div class="row col l6 m6 s12">
                                <label>FORMA CALCULO</label>
                                    <select name="forma_calculo"  class="error browser-default">
                                    <option disabled value="" selected>Selecciona una opción</option>
                                    <option {{$content['frecuencia_nomina']->calculo_dia_hora=='D' ? 'selected':''}} value="D">Dia</option>
                                    <option {{$content['frecuencia_nomina']->calculo_dia_hora=='H' ? 'selected':''}} value="H">Hora</option>
                                </select>
                            </div>
                            <div class="row col l4 m6 s12 center">
                                <label >DEVOLVER ISR</label>
                                <div class="switch">
                                    <label>
                                    
                                    <input {{$content['frecuencia_nomina']->devolver_isr=='S' ? 'checked':''}} type="checkbox" name="devolver_isr" value="S">
                                    <span class="lever"></span>
                                    
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </form>
@endsection