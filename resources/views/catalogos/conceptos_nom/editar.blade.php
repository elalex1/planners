@extends('app')
@section('title', 'Editar Conceptos Nomina')
@section('content')
<form id="updateConcepto" method="post">
    @csrf
    <input hidden type="number" name="id_concepto" value="{{Request::route('id')}}">
    <div class="card">
        <div class="card-tabs">
            <ul class="tabs trasparent">
                <li class="tab col l2 m3 s4"><a class="active" href="#vista1">General</a></li>
                {{-- <li class="tab col l2 m3 s4"><a  href="#vista2">Otros parámetros</a></li> --}}
                <li class="tab col l2 m3 s4"><a href="#vista3">Cálculo</a></li>
            </ul>
        </div>
        <div class="card-content">
            <div id="vista1" class="row">
                <div class="row">
                    <div class="col s12 input-field">
                        <label for="nombre">Nombre</label>
                        <input disabled type="text" name="nombre" id="nombre"
                            value="{{$content['concepto_nomina']->nombre}}">
                    </div>
                    <div class="col l10 m9 s8 input-field">
                        <label for="nombre_corto">Nombre corto</label>
                        <input disabled type="text" name="nombre_corto" id="nombre_corto"
                            value="{{$content['concepto_nomina']->nombre_corto}}">
                    </div>
                    <div class="col l2 m3 s4 input-field">
                        <label for="clave">Clave</label>
                        <input disabled type="text" name="clave" id="clave"
                            value="{{$content['concepto_nomina']->clave}}">
                    </div>
                    <div class="col s12 divider"></div>
                </div>
                <div class="row">
                    <div class="col l6 m6 s6 ">
                        <label>Naturaleza</label>
                        <select disabled class="js-example-basic-single" type="text" name="naturaleza">
                            <option {{$content['concepto_nomina']->naturaleza == 'P' ? 'selected':''}} value="P">Prestación</option>
                            <option {{$content['concepto_nomina']->naturaleza == 'D' ? 'selected':''}} value="D">Deducción</option>
                            <option {{$content['concepto_nomina']->naturaleza == 'O' ? 'selected':''}} value="O">Otros Pagos</option>
                            <option {{$content['concepto_nomina']->naturaleza == 'R' ? 'selected':''}} value="R">Obligaciones</option>
                        </select>
                    </div>
                    <div class="col s6 input-field">
                        <label for="clave_fiscal">Clave fiscal</label>
                        <input disabled type="text" name="clave_fiscal" id="clave_fiscal"
                            value="{{$content['concepto_nomina']->clave_fiscal}}">
                    </div>
                    
                    {{-- <div class="col l6 m6 s6 ">
                        <label>Tipo de concepto</label><select type="text" name="tipo_concepto">
                            <option {{$content['concepto_nomina']->tipo == 'G' ? 'selected':''}} value="G">General</option>
                            <option {{$content['concepto_nomina']->tipo == 'O' ? 'selected':''}} value="O">Otros pagos</option>
                            <option {{$content['concepto_nomina']->tipo == 'I' ? 'selected':''}} value="I">Otros pagos informativos</option>
                        </select>
                    </div> --}}
                </div>
                <div class="row valign-wrapper">
                    <div class="col s6 input-field">
                        <label for="id_interno">Id interno</label>
                        <input disabled type="number" name="id_interno" id="id_interno"
                            value="{{$content['concepto_nomina']->id_interno}}">
                    </div>
                    {{-- <div class="col l6 m6 s6 ">
                        <label>Tipo percepción tipo retención</label><select type="text" name="tipo_naturaleza">
                            <option disabled selected value="">Seleccione opción</option>
                        </select>
                    </div> --}}
                    {{-- <div class="col l6 m6 s6 center">
                        <label>
                            <input type="checkbox" class="filled-in" value="S" name="tipo_prevision_social"/>
                            <span>Percepción de tipo previsión social</span>
                          </label>
                    </div> --}}
                    <div class="col l6 m6 s6 ">
                        <label>Tipo calculo</label><select name="tipo_calculo">
                            <option {{$content['concepto_nomina']->tipo_calculo == 'C' ? 'selected':''}} value="C">Calculo basado en el salario del trabajado</option>
                            <option {{$content['concepto_nomina']->tipo_calculo == 'M' ? 'selected':''}} value="M">Calculo basado en el Salario Minimo</option>
                            <option {{$content['concepto_nomina']->tipo_calculo == 'U' ? 'selected':''}} value="U">Calculo Basado en la UMA</option>
                            <option {{$content['concepto_nomina']->tipo_calculo == 'F' ? 'selected':''}} value="F">F(?)</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col l6 m6 s6 ">
                        <label>Forma de pago</label><select type="text" name="forma_pago">
                            <option selected value="E">Efectivo</option>
                            <option value="S">En especie</option>
                        </select>
                    </div> --}}
                    <div class="col l6 m6 s6 ">
                        <label>Tipo proceso</label>
                        <select type="text" name="tipo_proceso">
                            <option {{$content['concepto_nomina']->tipo_proceso == 'D' ? 'selected':''}} value="D">Dias</option>
                            <option {{$content['concepto_nomina']->tipo_proceso == 'P' ? 'selected':''}} value="P">Periodo</option>
                            <option {{$content['concepto_nomina']->tipo_proceso == 'C' ? 'selected':''}} value="C">Concepto</option>
                        </select>
                    </div>
                    <div class="col s12 divider"></div>
                </div>
                <div class="row valign-wrapper">
                    <div class="col s12">
                        <label>
                            <input {{$content['concepto_nomina']->agregar_automatico == 'S' ? 'checked':''}} type="checkbox" class="filled-in" value="S" name="periodico_nuevos_empleados"/>
                            <span>Agregar a conceptos periódicos de nuevos empleados</span>
                          </label>
                    </div>
                    {{-- <div class="col l6 m6 s6 center">
                        <label>
                            <input type="checkbox" class="filled-in" value="S" name="uso_interno"/>
                            <span>Concepto de uso interno</span>
                          </label>
                    </div> --}}
                </div>
            </div>
            {{-- <div id="vista2" class="row" >
                <div class="row valign-wrapper">
                    <div class="col s12 center">
                        <label>
                            <input type="checkbox" class="filled-in" value="S" name="tipo_prevision_social"/>
                            <span>Percepción con exención I.S.R</span>
                          </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col l10 m9 s8 ">
                        <label>Tipo de exención</label>
                        <select type="text" name="forma_pago_fiscal">
                            <option disabled selected value=""></option>
                            <option value="T">Total, acumulable</option>
                            <option value="t">Total, no acumulable</option>
                            <option value="A">Parte exenta por año</option>
                            <option value="D">Parte exenta por dia</option>
                            <option value="E">Criterio de tiempo extraordinario</option>
                            <option value="I">Criterio de indemnización</option>
                        </select>
                    </div>
                    <div class="col l2 m3 s4 ">
                        <label for="excencion">Exención</label>
                        <input id="excencion" type="number" value="0" name="excencion">
                        <span class="helper'text">UMA</span>
                    </div>
                </div>
                <div class="row valign-wrapper">
                    <div class="col l6 m6 s6">
                        <label>Integrar al ingreso gravable como percepción</label>
                        <select type="text" name="forma_pago_fiscal">
                            <option value="O">Ordinaria</option>
                            <option value="M">Extraordinaria mensual</option>
                            <option value="A">Extraordinaria anual</option>
                        </select>
                    </div>
                    <div class="col l6 m6 s6 center">
                        <label>
                            <input type="checkbox" class="filled-in" value="S" name="tipo_prevision_social"/>
                            <span>Integrar para la participación de los trabajadores en las utilidades</span>
                          </label>
                    </div>
                </div>
                <div class="row valign-wrapper">
                    <div class="col l6 m6 s6 center">
                        <label>
                            <input type="checkbox" class="filled-in" value="S" name="tipo_prevision_social"/>
                            <span>Integrar para el impuesto estatal</span>
                          </label>
                    </div>
                    <div class="col l6 m6 s6 center">
                        <label>
                            <input type="checkbox" class="filled-in" value="S" name="tipo_prevision_social"/>
                            <span>Integrar para el aguinaldo de empleados con salario variable o mixto</span>
                          </label>
                    </div>
                </div>
                <div class="row valign-wrapper">
                    <div class="col s12 center">
                        <label>
                            <input type="checkbox" class="filled-in" value="S" name="tipo_prevision_social"/>
                            <span>Percepción variable para el I.M.S.S</span>
                          </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="col s3">
                            <label class="">
                                <input name="group1" type="radio"/>
                                <span>Todo el monto</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s3">
                            <label class="">
                                <input name="group1" type="radio"/>
                                <span>El excedente del</span>
                            </label>
                        </div>
                        <div class="col s3">
                            <input type="number" value="0">
                        </div>
                        <div class="col s6">
                            <label for="">% de UMA</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s3">
                            <label class="">
                                <input name="group1" type="radio"/>
                                <span>El excedente del</span>
                            </label>
                        </div>
                        <div class="col s3">
                            <input type="number" value="0">
                        </div>
                        <div class="col s6">
                            <label for="">% del salario base de cotización</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s3">
                            <label class="">
                                <input name="group1" type="radio"/>
                                <span>El excedente del</span>
                            </label>
                        </div>
                        <div class="col s3">
                            <input type="number" value="0">
                        </div>
                        <div class="col s6">
                            <label for="">horas por semana</label>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div id="vista3" class="row">
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="funcion" name="funcion" class="materialize-textarea">{{$content['concepto_nomina']->funcion}}</textarea>
                        <label for="funcion">Función</label>
                        <span class="helper-text">crea la función para calcular en concepto</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
    <div class="fixed-action-btn">
        <a class="modal-trigger validarformulario btn-floating btn-large waves-green waves-effect waves-light tooltipped blue"
            form="updateConcepto"  data-position="top" data-tooltip="Guardar">
            <i class="large material-icons">save</i>
        </a>
    </div>
    {{-- modalnuevoconcepto --}}
    <div id="modalnewE" class="modal modal-fixed-footer modalform-l grey lighten-2">
        <div class="modal-content">
            <form id="frm-newConcepto" method="POST">
                <div class="card">
                    <div class="card-content">

                        <h4>Nuevo Concepto</h4>

                        @csrf
                        
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <a href="#!" class="btn modal-action modal-close waves-effect waves-light red">
                Cancelar
            </a>
            <button form="frm-newConcepto" id="nuevo-empleado" class="btn validarformulario waves-effect waves-light light-green">
                Agregar
            </button>
        </div>
    </div>


    {{-- Fin Form Editar EMpleado --}}
@endsection
