@extends('app')

@section('title', 'Catalogo Conceptos Nomina')

@section('content')



    <div class="card">

        <div class="card-content">



            <table id="tableGeneral" class="display responsive" width="100%" >

                <thead>

                    <tr>

                        <th data-priority="1">Nombre</th>

                        <th data-priority="2">Nombre corto</th>

                        <th data-priority="3">Clave</th>

                        <th data-priority="4">Naturaleza</th>

                        <th data-priority="5">Id interno</th>

                        <th data-priority="7">Clave fiscal</th>

                        <th data-priority="8">Tipo calculo</th>

                        <th data-priority="9">Tipo proceso</th>

                        <th data-priority="6"></th>

                    </tr>

                </thead>





                <tbody>



                    @foreach ($content['conceptos'] as $concepto)

                        <tr>

                            <td>{{ $concepto->nombre }}</td>

                            <td>{{ $concepto->nombre_corto }}</td>

                            <td>{{ $concepto->clave }}</td>

                            <td>

                                {{ $concepto->naturaleza }}

                            </td>

                            <td>{{ $concepto->id_interno }}</td>

                            <td>{{ $concepto->clave_fiscal }}</td>

                            <td>{{ $concepto->tipo_calculo }}</td>

                            <td>{{ $concepto->tipo_proceso }}</td>

                            <td>

                                {{-- @if($concepto->estatus != 'Activo')

                                    <i href="{{route('conceptos_nomina_edit',$concepto->empleado_id)}}"

                                        class="disabled-btn  material-icons tooltipped" data-delay="50"

                                            data-tooltip="No se puede editar">edit

                                    </i>

                                    {{-- <i href="" 

                                        id-record="{{ $concepto->empleado_id }}"

                                        class="disabled-btn material-icons tooltipped" data-delay="50"

                                            data-tooltip="no se puede dar de baja">delete_forever

                                    </i> --}}

                                {{-- @else--}}

                                    <i href="{{route('conceptos_nomina_edit',$concepto->concepto_nomina_id)}}"

                                        class="text-pending  material-icons tooltipped puntero editar-documento" data-delay="50"

                                            data-tooltip="Editar Concepto">edit

                                    </i>

                                    <i href="" 

                                        class="text-finished material-icons tooltipped" data-delay="50"

                                            data-tooltip="Eliminar Concepto">delete_forever

                                    </i>

                                {{--@endif --}}

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

                                    <option value="{{ $concepto->empleado_id }}">{{ $concepto->nombre }}</option>

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

        <a class="modal-trigger btn-floating btn-large waves-green waves-effect waves-light tooltipped"

            href="#modalnewE" id="NuevoEmpleado" data-position="top" data-tooltip="Nuevo Empleado">

            <i class="large material-icons">add</i>

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

                        <div class="row">

                                <div class="col s12 input-field">

                                    <label for="nombre">Nombre</label>

                                    <input type="text" name="nombre" id="nombre">

                                </div>

                                <div class="col l10 m9 s8 input-field">

                                    <label for="nombre_corto">Nombre corto</label>

                                    <input type="text" name="nombre_corto" id="nombre_corto">

                                </div>

                                <div class="col l2 m3 s4 input-field">

                                    <label for="clave">Clave</label>

                                    <input type="text" name="clave" id="clave">

                                </div>

                                <div class="col s12 divider"></div>

                            </div>

                            <div class="row">

                                <div class="col l6 m6 s6 ">

                                    <label>Naturaleza</label><select name="naturaleza"

                                            url-record="{{route('conceptos_nomina_getTipos')}}">

                                        <option selected value="P">Prestación</option>

                                        <option value="D">Deducción</option>

                                        <option value="O">Otros Pagos</option>

                                        <option value="R">Obligaciones</option>

                                    </select>

                                </div>

                                {{-- <div class="col s6 input-field">

                                    <label for="clave_fiscal">Clave fiscal</label>

                                    <input type="text" name="clave_fiscal" id="clave_fiscal">

                                </div> --}}

                                <div class="col l6 m6 s6 ">

                                    <label>Naturaleza</label><select name="clave_fiscal">

                                    </select>

                                </div>



                                {{-- <div class="col l6 m6 s6 ">

                                    <label>Tipo de concepto</label><select type="text" name="tipo_concepto">

                                        <option selected value="G">General</option>

                                        <option value="O">Otros pagos</option>

                                        <option value="I">Otros pagos informativos</option>

                                    </select>

                                </div> --}}

                            </div>

                            <div class="row valign-wrapper">

                                <div class="col s6 input-field">

                                    <label for="id_interno">Id interno</label>

                                    <input type="number" name="id_interno" id="id_interno">

                                </div>

                                {{-- <div class="col l6 m6 s6 ">

                                    <label>Tipo percepción tipo retención</label><select type="text" name="tipo_naturaleza">

                                        <option disabled selected value="">Seleccione opción</option>

                                    </select>

                                </div> --}}

                                {{-- <div class="col l6 m6 s6 center">

                                    <label>

                                        <input type="checkbox" class="filled-in " value="S" name="tipo_prevision_social"/>

                                        <span>Percepción de tipo previsión social</span>

                                      </label>

                                </div> --}}

                                <div class="col l6 m6 s6 ">

                                    <label>Tipo calculo</label><select name="tipo_calculo">

                                        <option selected value="C">Calculo basado en el salario del trabajado</option>

                                        <option value="M">Calculo basado en el Salario Minimo</option>

                                        <option value="U">Calculo Basado en la UMA</option>

                                        <option value="F">F(?)</option>

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

                                        <option selected value="D">Dias</option>

                                        <option value="P">Periodo</option>

                                        <option value="C">Concepto</option>

                                    </select>

                                </div>

                                <div class="col s12 divider"></div>

                            </div>

                            <div class="row valign-wrapper">

                                <div class="col s12">

                                    <label>

                                        <input type="checkbox" class="filled-in" value="S" name="periodico_nuevos_empleados"/>

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

