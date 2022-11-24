@extends('app')

@section('title', 'Catalogo Tipos Contratos')

@section('content')



    <div class="card">

        <div class="card-content">



            <table id="tableGeneral" class="display responsive" width="100%" >

                <thead>

                    <tr>

                        <th data-priority="1">NOMBRE</th>

                        <th data-priority="2">NOMBRE CORTO</th>

                        {{-- <th data-priority="3">ESTATUS</th> --}}

                        <th data-priority="3">CLAVE FISCAL</th>

                        <th data-priority="4"></th>

                    </tr>

                </thead>





                <tbody>



                    @foreach ($content['tipos_contartos'] as $registro)

                        <tr>

                            <td>{{ $registro->nombre }}</td>

                            <td>{{ $registro->nombre_corto }}</td>

                            {{-- <td>{{ $registro->estatus }}</td> --}}

                            <td>{{ $registro->clave_fiscal }}</td>

                            

                            @if($registro->estatus=='N')

                                <td>

                                    <i with-modal="modalDesElim" 

                                        campo_id_name="id_tipocontrato"

                                        id-record="{{$registro->tipo_contrato_empleado_id}}"

                                        class="text-cancel material-icons tooltipped center puntero cancelar-docto" data-delay="50"

                                            data-tooltip="Desactivar/Eliminar">clear

                                    </i>

                                </td>   

                            @elseif($registro->estatus=='C')

                                <td>

                                    <i with-modal="modalAct" 

                                        campo_id_name="id_tipocontrato"

                                        id-record="{{$registro->tipo_contrato_empleado_id}}"

                                        class="text-authorized material-icons tooltipped center puntero cancelar-docto" data-delay="50"

                                        data-tooltip="Activar">checkbox

                                    </i>

                                </td>      

                            @endif

                                {{-- @endif --}}

                            





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



                        <h4>Nueva Tipo Contrato</h4>



                        @csrf

                        {{-- <div>

                        <label>CODIGO: </label><input type="text" name="codigo" value="{{ old('codigo') }}">

                            <input type="checkbox" name="estatus" value="S">Activo

                        </div>

                            <p><label>Datos personales</label></p> --}}

                        <div class="row">

                            <div class="row col s12">

                                <div class="row">

                                    <div class="col s12 input-field">

                                        <label for="nombre">NOMBRE</label>

                                        <input type="text" name="nombre" id="nombre">

                                    </div>

                                    <div class="col l8 m8 s12  input-field">

                                        <label for="nombre_corto">NOMBRE CORTO</label>

                                        <input type="text" name="nombre_corto" id="nombre_corto">

                                    </div>

                                    <div class="col l4 m4 s12  input-field">

                                        <label for="clave_fiscal">CLAVE FISCAL</label>

                                        <input type="text" name="clave_fiscal" id="clave_fiscal">

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

            <button form="frm-newTabla" class="btn validarformulario waves-effect waves-light light-green">

                Agregar

            </button>

        </div>

    </div>

   <div id="modalDesElim" class="modal modal-fixed-footer modalform-l grey lighten-2">

        <div class="modal-content">

            <form id="frm-deleteDesactivar" action="{{route('tiposcontratos_update')}}" method="POST">

                <div class="card">

                    <div class="card-content">

                        <div class="row">

                            <div class="col s12">

                                <h3>Desactivar/Eliminar</h3>

                                <p>¿Esta seguro de desactivar el topo de contrato</p>

                                <p>Si el tipo de contrato no se ha utilizado se eliminara del catalogo.</p>

                            </div>

                            <input hidden type="number" name="id_tipocontrato" value="">

                        </div>

                    </div>

                </div>

            </form>



        </div>

        <div class="modal-footer">

            <a href="#!" class="btn modal-action modal-close waves-effect waves-light red">

                Cancelar

            </a>

            <button form="frm-deleteDesactivar" class="btn validarformulario waves-effect waves-light light-green">

                Aceptar

            </button>

        </div>

    </div>

    <div id="modalAct" class="modal modal-fixed-footer modalform-l grey lighten-2">

        <div class="modal-content">

            <form id="frm-activar" action="{{route('tiposcontratos_update')}}" method="POST">

                <div class="card">

                    <div class="card-content">

                        <div class="row">

                            <div class="col s12">

                                <h3>Activar</h3>

                                <p>¿Esta seguro de activar el topo de contrato</p>

                            </div>

                            <input hidden type="number" name="id_tipocontrato" value="">

                        </div>

                    </div>

                </div>

            </form>



        </div>

        <div class="modal-footer">

            <a href="#!" class="btn modal-action modal-close waves-effect waves-light red">

                Cancelar

            </a>

            <button form="frm-activar" class="btn validarformulario waves-effect waves-light light-green">

                Aceptar

            </button>

        </div>

    </div>



    {{-- Fin del Modal Nuevo Empleado --}}

    {{-- Fin Form Editar EMpleado --}}

@endsection