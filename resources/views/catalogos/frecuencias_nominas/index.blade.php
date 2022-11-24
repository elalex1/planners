@extends('app')

@section('title', 'Catalogo Frecuencias Nominas')

@section('content')



    <div class="card">

        <div class="card-content">



            <table id="tableGeneral" class="display responsive" width="100%" >

                <thead>

                    <tr>

                        <th data-priority="1">NOMBRE</th>

                        <th data-priority="2">CLAVE FISCAL</th>

                        <th data-priority="3">DIAS PERIODO</th>

                        <th data-priority="4">DIAS TRABAJADOS</th>

                        <th data-priority="6">TIPO CALCULO IMPUESTO</th>

                        <th data-priority="7">TIPO CALCULO NOMINA</th>

                        <th data-priority="8">CALCULAR DIA/HORA</th>

                        <th data-priority="5"></th>

                    </tr>

                </thead>





                <tbody>



                    @foreach ($content['frecuencias_nominas'] as $registro)

                        <tr>

                            <td>{{ $registro->nombre }}</td>

                            <td>{{ $registro->clave_fiscal }}</td>

                            <td>{{ $registro->dias_periodo }}</td>

                            <td>{{ $registro->dias_trabajador }}</td>

                            <td>{{ $registro->tipo_calculo_impuesto }}</td>

                            <td>{{ $registro->tipo_calculo_nomina }}</td>

                            <td>{{ $registro->calculo_dia_hora }}</td>

                            

                            <td class="center">

                                    <i href="{{route('frecuenciasnominas_edit',$registro->frecuencia_nomina_id)}}"

                                        class="planner-text  material-icons tooltipped puntero editar-documento" data-delay="50"

                                            data-tooltip="Editar Registro Patronal">edit

                                    </i>

                                    <i href="" 

                                        class="text-finished material-icons tooltipped" data-delay="50"

                                            data-tooltip="Eliminar Empleado">delete_forever

                                    </i>

                            </td>



                        </tr>

                    @endforeach



                </tbody>

            </table>



            {{-- <div class="form_contenido">

                        <div class="input-field">

                            <label class="form_label">CODIGO:

                            </label><input id="text_input" class="form_ input" type="text" name="codigo" readonly>

                        </div>

                        <div class="">

                            <label class="form_label">NOMBRE DEL EMPLEADO: </label><select class="form_input"

                                name="nombre" id="Empresa" onchange="selectempleado(this.value)">



                                <option>SELECCIONE EMPLEADO</option>

                                @foreach ($content['empleados'] as $empleado)

                                    <option value="{{ $empleado->empleado_id }}">{{ $empleado->nombre }}</option>

                                @endforeach



                            </select>

                        </div>

                    </div>

                    <div class="form_botones">

                        <p>

                            <a class="btn" id="Abrir" href="">ABRIR</a>

                            <a class="btn" id="Editar" href="">EDITAR</a>

                            <a class="btn" href="{{ route('catalogoempleado.create') }}">NUEVA</a>

                        </p>

                    </div> --}}



        </div>

    </div>

    <div class="fixed-action-btn">

        <a class="modal-trigger btn-floating btn-large waves-green waves-effect waves-light tooltipped "

            href="#modalnewE" id="NuevoEmpleado" data-position="top" data-tooltip="Nuevo Empleado">

            <i class="large material-icons">add</i>

        </a>

    </div>

    {{-- modalnuevoempleado --}}

    <div id="modalnewE" class="modal modal-fixed-footer modalform-l grey lighten-2">

        <div class="modal-content">

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

                                        <input type="text" name="nombre" id="nombre">

                                    </div>

                                    <div class="col l4 m6 s12  input-field">

                                        <label for="nombre_corto">NOMBRE CORTO</label>

                                        <input type="text" name="nombre_corto" id="nombre_corto">

                                    </div>

                                    <div class="col l6 m6 s12  input-field">

                                        <label for="clave_fiscal">CLAVE FISCAL</label>

                                        <input type="text" name="clave_fiscal" id="clave_fiscal">

                                    </div>

                                    {{-- <div class="col l4 m6 s12  input-field">

                                        <label for="clase">CALCULAR SEPTIMO DIA</label>

                                        <input type="text" name="clase" id="clase">

                                    </div> --}}

                                    

                                    <div class="col l6 m6 s12  input-field">

                                        <label for="dias_periodo">DIAS PERIODO</label>

                                        <input type="number" name="dias_periodo" id="dias_periodo">

                                    </div>

                                    <div class="col l4 m6 s12  input-field">

                                        <label for="dias_trabajador">DIAS TRABAJADOR</label>

                                        <input type="number" name="dias_trabajador" id="dias_trabajador">

                                    </div>

                                    <div class="col l4 m6 s12  input-field">

                                        <label for="dias_septimo">DIAS SEPTIMO</label>

                                        <input type="number" name="dias_septimo" id="dias_septimo">

                                    </div>

                                    <div class="col l4 m6 s12 center">

                                        <label >CALCULA SEPTIMO DIA</label>

                                        <div class="switch">

                                            <label>

                                            

                                              <input type="checkbox" name="calcula_septimo_dia" value="S">

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

                                                <option value="M">Monto</option>

                                                <option value="P">Periodo</option>

                                            </select>

                                        </div>

                                        <div class="row col l6 m6 s12">

                                            <label>TIPO CALCULO NOMINA</label>

                                                <select name="tipo_calculo_nomina"  class="error browser-default">

                                                <option disabled value="" selected>Selecciona una opción</option>

                                                <option value="M">Manual</option>

                                                <option value="A">Automático</option>

                                            </select>

                                        </div>

                                    <div class="row col l6 m6 s12">

                                        <label>FORMA CALCULO</label>

                                            <select name="forma_calculo"  class="error browser-default">

                                            <option disabled value="" selected>Selecciona una opción</option>

                                            <option value="D">Dia</option>

                                            <option value="H">Hora</option>

                                        </select>

                                    </div>

                                    <div class="row col l4 m6 s12 center">

                                        <label >DEVOLVER ISR</label>

                                        <div class="switch">

                                            <label>

                                            

                                              <input type="checkbox" name="devolver_isr" value="S">

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



        </div>

        <div class="modal-footer">

            <a href="#!" class="btn modal-action modal-close waves-effect waves-light red">

                Cancelar

            </a>

            <button form="frm-newTabla" class="btn validarformulario waves-effect waves-light light-green">

                Agregar

            </button>

        </div>

    </div>





    {{-- Fin del Modal Nuevo Empleado --}}

    {{-- Fin Form Editar EMpleado --}}

@endsection