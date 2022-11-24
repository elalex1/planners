@extends('app')

@section('title', 'Catalogo Departamentos')

@section('content')



    <div class="card">

        <div class="card-content">



            <table id="tableGeneral" class="display responsive" width="100%" >

                <thead>

                    <tr>

                        <th data-priority="1">NOMBRE</th>

                        <th data-priority="2">CENTRO COSTO</th>

                        <th data-priority="4">USUARIO CREACIÓN</th>

                        <th data-priority="3"></th>

                    </tr>

                </thead>





                <tbody>



                    @foreach ($content['departamentos'] as $registro)

                        <tr>

                            <td>{{ $registro->nombre }}</td>

                            <td>{{ $registro->centro_costo }}</td>

                            <td>{{ $registro->usuario_creacion }}</td>

                            

                            <td class="center">

                                    {{-- <i href="{{route('deperatmentos_editar',$registro->departamento_id)}}"

                                        class="amber-text  material-icons tooltipped puntero editar-documento" data-delay="50"

                                            data-tooltip="Editar Registro Patronal">edit

                                    </i> --}}

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

        <a class="modal-trigger btn-floating btn-large waves-green waves-effect waves-light tooltipped"

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



                        <h4>Nueva Departamento</h4>



                        @csrf

                        {{-- <div>

                        <label>CODIGO: </label><input type="text" name="codigo" value="{{ old('codigo') }}">

                            <input type="checkbox" name="estatus" value="S">Activo

                        </div>

                            <p><label>Datos personales</label></p> --}}

                        <div class="row">

                            {{-- <div class="row col s12"> --}}

                                <div class="row">

                                    <div class="col s12 input-field">

                                        <label for="nombre">NOMBRE</label>

                                        <input type="text" name="nombre" id="nombre">

                                    </div>

                                    <div class="col s12">

                                        <label>CENTRO COSTO</label>

                                            <select  name="centro_costo"  class="error browser-default selectProveedor"

                                                    modal-parent="modalnewE"

                                                    url-record="{{route('select_centros_costos_by_term')}}">

                                                

                                            {{-- <option disabled value="" selected>Selecciona una opción</option>

                                            @foreach ($data['departamentos'] as $estado)

                                                <option value="{{$estado->text}}">{{$estado->text}}</option>

                                            @endforeach --}}

                                        </select>

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