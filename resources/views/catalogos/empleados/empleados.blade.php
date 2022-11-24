@extends('app')

@section('title', 'Catalogo Empleados')

@section('content')

<form method='post' action=' {{route('import.empleados')}} ' enctype='multipart/form-data' >
    {{ csrf_field() }}
    <input type='file' name='file'>
    <input type='submit' name='submit' value='Import'>
  </form>

    <div class="card">

        <div class="card-content">



            <table id="tableGeneral" >

                <thead>

                    <tr>

                        <th data-priority="1">EMPLEADO</th>

                        <th data-priority="1">ESTATUS</th>

                        <th data-priority="3">RFC</th>

                        <th data-priority="4">NSS</th>

                        <th data-priority="6">puesto</th>

                        <th data-priority="7">DEPARTAMENTO</th>

                        <th data-priority="8">CENTRO COSTOS</th>

                        <th data-priority="5"></th>

                    </tr>

                </thead>





                <tbody>



                    @foreach ($content['empleados'] as $empleado)

                        <tr>

                            <td>{{ $empleado->nombre }}</td>

                            <td>

                                @switch($empleado->estatus)

                                    @case('Baja')

                                        <span class="status text-cancel">•</span>

                                    @break



                                    @case('Activo')

                                        <span class="status planner-text">•</span>

                                    @break

                                    @case('Pendiente')

                                        <span class="status displanner-text">•</span>

                                    @break

                                @endswitch

                                {{ $empleado->estatus }}

                            </td>

                            <td>{{ $empleado->rfc }}</td>

                            <td>{{ $empleado->nss }}</td>

                            <td>{{ $empleado->puesto }}</td>

                            <td>{{ $empleado->departamento }}</td>

                            <td>{{ $empleado->centro_costo }}</td>

                            <td>

                                {{-- @if($empleado->estatus == 'Baja')

                                    <i href="{{--route('empleados_edit',$empleado->empleado_id)-}}"

                                        class="disabled-btn  material-icons tooltipped" data-delay="50"

                                            data-tooltip="No se puede editar">edit

                                    </i>

                                    <i href="" 

                                        id-record="{{ $empleado->empleado_id }}"

                                        class="disabled-btn material-icons tooltipped" data-delay="50"

                                            data-tooltip="no se puede dar de baja">delete_forever

                                    </i>

                                @else --}}

                                    <i href="{{route('empleados_edit',$empleado->empleado_id)}}"

                                        class="planner-text  material-icons tooltipped puntero editar-documento" data-delay="50"

                                            data-tooltip="Editar Empleado">edit

                                    </i>

                                    <i href="" 

                                        class="grey-text material-icons tooltipped" data-delay="50"

                                            data-tooltip="Eliminar Empleado">delete_forever

                                    </i>

                                {{-- @endif --}}

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

        <a class="modal-trigger btn-floating btn-large waves-green waves-effect waves-light tooltipped"

            href="#modalnewE" id="NuevoEmpleado" data-position="top" data-tooltip="Nuevo Empleado">

            <i class="large material-icons">add</i>

        </a>

    </div>

    {{-- modalnuevoempleado --}}

    <div id="modalnewE" class="modal modal-fixed-footer modalform-l grey lighten-2">

        <div class="modal-content">

            <form id="frm-newEmpleado" action="{{-- route('empleados_store') --}}" method="POST">

                <div class="card">

                    <div class="card-content">



                        <h4>Nuevo Empleado</h4>



                        @csrf

                        {{-- <div>

                        <label>CODIGO: </label><input type="text" name="codigo" value="{{ old('codigo') }}">

                            <input type="checkbox" name="estatus" value="S">Activo

                        </div>

                            <p><label>Datos personales</label></p> --}}

                        <div class="row">

                            <div class="row col s12">

                                <div class="row">

                                <div class="col l4 m6 s12 input-field">

                                    <label for="paterno">APELLIDO PATERNO</label>

                                    <input type="text" name="paterno" id="paterno">

                                </div>

                                <div class="col l4 m6 s12  input-field">

                                    <label for="materno">APELLIDO MATERNO</label>

                                    <input type="text" name="materno" id="materno">

                                </div>

                                <div class="col l4 m6 s12  input-field">

                                    <label for="nombre">NOMBRE(s)</label><input type="text" name="nombre" id="nombre">

                                </div>

                                <div class="col l4 m6 s12  input-field">

                                    <label for="rfc">RFC</label><input type="text" name="rfc" id="rfc">

                                </div>

                                <div class="col l4 m6 s12  input-field">

                                    <label for="curp">CURP</label><input type="text" name="curp" id="curp">

                                </div>

                                <div class="col l4 m6 s12  input-field">

                                    <label for="nss">NUMERO DEL SEGURO SOCIAL</label>

                                    <input type="text" name="nss" id="nss">

                                </div>

                                

                            </div>

                            <div class="row">

                                <div class="col l6 m6 s12 ">

                                    <label for="fecha_nacimiento">FECHA DE NACIMIENTO</label><input type="date" name="fecha_nacimiento"

                                        id="fecha_nacimiento">

                                </div>

                                <div class="col l6 m6 s12 ">

                                    <label for="fecha_alta">FECHA ALTA</label><input type="date" name="fecha_alta"

                                        id="fecha_alta">

                                </div>

                                {{-- <div class="col l4 m6 s12">

                                    <label for="entidad">Estado de nacimiento</label>

                                    <select name="entidad" id="entidad" class="selectd" id-title="modalnewE">

                                        <option disabled selected value="">Seleccione una opcion</option>

                                        @foreach ($content['entidades'] as $estado)

                                            <option value="{{ $estado->text }}">{{ $estado->text }}</option>

                                        @endforeach

                                    </select>

                                </div> --}}

                            </div>

                            <div class="row">

                                    <div class="col l6 m6 s12">

                                        <label>Puesto</label>

                                            <select name="puesto"  class="error browser-default select_search_url2"

                                                url-record="{{route('select_puestos_by_term')}}"

                                                modal-parent="modalnewE">

                                            {{-- <option disabled value="" selected>Selecciona una opcion</option>

                                            @foreach ($data['puestos'] as $estado)

                                                <option value="{{$estado->text}}">{{$estado->text}}</option>

                                            @endforeach --}}

                                        </select>

                                    </div>

                                    <div class="col l6 m6 s12">

                                        <label>Departamento</label>

                                            <select name="departamento"  class="error browser-default select_search_url3"

                                                    url-record="{{route('select_departamentos_by_term')}}"

                                                    modal-parent="modalnewE">

                                                

                                            {{-- <option disabled value="" selected>Selecciona una opcion</option>

                                            @foreach ($data['departamentos'] as $estado)

                                                <option value="{{$estado->text}}">{{$estado->text}}</option>

                                            @endforeach --}}

                                        </select>

                                    </div>

                            </div>

                            </div>

                            {{-- <div class="divider"></div>

                            <div class="row col s12">

                                <div class="col l6 m6 s6  input-field valrequ">

                                    <label>CALLE</label><input type="text" name="calle" id="calle">

                                </div>

                                <div class="col l3 m2 s2  input-field valrequ">

                                    <label>Numero</label><input type="text" name="numero" id="numero">

                                </div>

                                <div class="col l3 m4 s4  input-field valrequ">

                                    <label>CODIGO POSTAL</label><input type="text" name="cp" id="cp">

                                </div> --}}

                                {{-- <div class="col l6 m6 s6  valrequ">

                                    <label>ENTIDAD</label>

                                    <select name="entidad" id="entidad" class="selectdep" id-title="modalnewE"

                                        id-record="{{ route('getmunicipiosByestado') }}" title="municipio">

                                        <option disabled selected value="">Seleccione una opcion</option>

                                        @foreach ($content['estados'] as $estado)

                                            <option value="{{ $estado->estado_id }}">{{ $estado->nombre }}</option>

                                        @endforeach

                                    </select>

                                </div> --}}

                                {{--<div class="col l6 m6 s6 valrequ">

                                    <label>Municipio</label><select name="municipio" id="municipio"

                                        class="error browser-default">

                                        {{-- <option disabled selected value="">Seleccione una opcion</option>

                                        @foreach ($content['municipios'] as $municipio)

                                            <option value="{{$municipio->municipio_id}}">{{$municipio->nombre}}</option>

                                         @endforeach -}}

                                    </select>

                                </div>--}}

                            {{-- </div>

                            <div class="row col s12">

                                <div class="col l6 m6 s6 valrequ">

                                    <label>FECHA DE ALTA</label>

                                    <input type="date" name="fecha_alta" id="fecha_alta">

                                </div> --}}

                                {{-- <div class="col l6 m6 s6 valrequ">

                                    <label>PUESTO</label><select name="puesto" id="puesto">

                                        <option disabled selected value="">Seleccione una opcion</option>

                                        @foreach ($content['puestos'] as $puesto)

                                            <option value="{{ $puesto->puesto_id }}">{{ $puesto->nombre }}</option>

                                        @endforeach

                                    </select>

                                </div> --}}

                                {{-- <div class="col l6 m6 s6 valrequ">

                                    <label>DEPARTAMENTO</label><select name="departamento" id="departamento">

                                        <option disabled selected value="">Seleccione una opcion</option>

                                        @foreach ($content['departamentos'] as $departamento)

                                            <option value="{{ $departamento->departamento_id }}">

                                                {{ $departamento->nombre }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div> --}}

                                {{-- <div class="col l6 m6 s6 valrequ">

                                    <label>ESTADI CIVIL</label><select type="text" name="estado_civil" id="estado_civil">

                                        <option disabled selected value="">Seleccione una opcion</option>

                                        <option value="soltero">Soltero</option>

                                        <option value="casado">Casado</option>

                                    </select>

                                </div>



                                <div class="col l6 m6 s6 input-field valrequ">

                                    <label>CENTRO DE COSTOS</label><input type="text" name="centro_costos"

                                        value="{{ old('sbc') }}">

                                </div>

                                <div class="col l6 m6 s6 input-field valrequ">

                                    <label>ANTIGUEDAD</label><input type="text" name="antiguedad"

                                        value="{{ old('antiguedad') }}">

                                </div>

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

            <button form="frm-newEmpleado" id="nuevo-empleado" class="btn validarformulario waves-effect waves-light light-green">

                Agregar

            </button>

        </div>

    </div>





    {{-- Fin del Modal Nuevo Empleado --}}

    {{-- Fin Form Editar EMpleado --}}

@endsection

