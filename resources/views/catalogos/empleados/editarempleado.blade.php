@extends('app')
@section('title', 'Editar empleado: '.$data['general']->nombre.' '.$data['general']->apellido_paterno.' '.$data['general']->apellido_materno)
@section('content')

<form id="frm-editEmpleado"  action=""  method="{{isset($data['general']->contrato_empleado_id)? 'POST':'PUT'}}">
    @csrf
    <div class="card">
        <div class="card-tabs">
            <ul class="tabs trasparent">
                <li class="tab col l2 m3 s4"><a {{--class="active"--}} href="#vista1">General</a></li>
                @if(isset($data['general']->contrato_empleado_id))
                    <li class="tab col l2 m3 s4"><a class="active" href="#vista2">Contrato</a></li>
                @endif
                <li class="tab col l2 m3 s4"><a href="#vista3">Historial</a></li>
            </ul>
        </div>
        <div class="card-content">
                        <div id="vista1" class="row">
                            <input hidden type="number" name="empleado_id" value="{{Request::route('id')}}">
                            <div class="row">
                                
                                <div class="col l4 m6 s12 input-field">
                                    <label for="paterno">APELLIDO PATERNO</label>
                                    <input disabled type="text" name="paterno" id="paterno"
                                        value="{{$data['general']->apellido_paterno}}">
                                </div>
                                <div class="col l4 m6 s12  input-field">
                                    <label for="materno">APELLIDO MATERNO</label>
                                    <input disabled type="text" name="materno" id="materno"
                                        value="{{$data['general']->apellido_materno}}">
                                </div>
                                <div class="col l4 m6 s12  input-field">
                                    <label for="nombre">NOMBRE(s)</label>
                                    <input disabled type="text" name="nombre" id="nombre"
                                        value="{{$data['general']->nombre}}">
                                </div>
                                <div class="col l4 m6 s12  input-field">
                                    <label  for="rfc">RFC</label>
                                    <input {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}}  type="text" name="rfc" id="rfc"
                                        value="{{$data['general']->rfc}}">
                                </div>
                                <div class="col l4 m6 s12  input-field">
                                    <label for="curp">CURP</label>
                                    <input {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}}  type="text" name="curp" id="curp"
                                        value="{{$data['general']->curp}}">
                                </div>
                                <div class="col l4 m6 s12  input-field">
                                    <label for="nss">NO. DEL SEGURO SOCIAL</label>
                                    <input {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}}  type="text" name="nss" id="nss"
                                        value="{{$data['general']->nss}}">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col l4 m6 s12 ">
                                    <label for="fecha_nacimiento">FECHA DE NACIMIENTO</label>
                                    <input disabled type="date" name="fecha_nacimiento"
                                        id="fecha_nacimiento"
                                        value="{{$data['general']->fecha_nacimiento}}">
                                </div>
                                <div class="col l4 m6 s12 ">
                                    <label for="fecha_alta">FECHA ALTA</label>
                                    <input {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}}  type="date" name="fecha_alta"
                                        id="fecha_alta" value="{{$data['general']->fecha_alta}}">
                                </div>
                                <div class="col l4 m12 s12">
                                    <label  for="entidad">Estado de nacimiento</label>
                                    <select {{$data['general']->estado_nacimiento ? 'disabled':''}} name="entidad_nacimiento" id="entidad_nacimiento" class="selectd" id-title="modalnewE">
                                        <option disabled selected value="">Seleccione una opción</option>
                                        @foreach ($data['entidades'] as $estado)
                                            <option @if($data['general']->estado_nacimiento == $estado->text) selected @endif value="{{ $estado->text }}">{{ $estado->text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="col l4 m4 s12">
                                        <label>Puesto</label>
                                            <select {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} name="puesto"  class="error browser-default select_search_url2"
                                                url-record="{{route('select_puestos_by_term')}}"
                                                >
                                            <option value="{{$data['general']->puesto}}">{{$data['general']->puesto}}</option>
                                            {{-- <option disabled value="" selected>Selecciona una opción</option>
                                            @foreach ($data['puestos'] as $estado)
                                                <option value="{{$estado->text}}">{{$estado->text}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col l4 m4 s12">
                                        <label>Departamento</label>
                                            <select {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} name="departamento"  class="error browser-default select_search_url3"
                                                    url-record="{{route('select_departamentos_by_term')}}">
                                            <option value="{{$data['general']->departamento}}">{{$data['general']->departamento}}</option>
                                                
                                            {{-- <option disabled value="" selected>Selecciona una opción</option>
                                            @foreach ($data['departamentos'] as $estado)
                                                <option value="{{$estado->text}}">{{$estado->text}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col l4 m4 s12">
                                        <label>Estado civil</label>
                                            <select {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} name="estado_civil"  class="error browser-default">
                                            <option disabled value="" selected>Selecciona una opción</option>
                                            <option @if($data['general']->estatus_civil=="C") selected @endif value="C">Casado</option>
                                            <option @if($data['general']->estatus_civil=="S") selected @endif value="S">Soltero</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($data['general']->contrato_empleado_id))
                        <div id="vista2" class="row">
                            <form id="NewCOntrato">
                                <div>Dirección</div>
                                <div class="divider"></div>
                                <div class="row">

                                    <div class="col l6 m6 s12 input-field">
                                        <label for="calle">Calle</label>
                                        <input {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="text" name="calle" id="calle"
                                            value="{{$data['general']->calle}}">
                                    </div>
                                    <div class="col l3 m3 s6 input-field">
                                        <label for="numero_ext">No. ext</label>
                                        <input {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="text" name="numero_ext" id="numero_ext"
                                            value="{{$data['general']->numero_exterior}}">
                                    </div>
                                    <div class="col l3 m3 s6 input-field">
                                        <label for="numero_int">No. int</label>
                                        <input {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="text" name="numero_int" id="numero_int"
                                            value="{{$data['general']->numero_interior}}">
                                    </div>
                                    <div class="col l4 m4 s12 input-field">
                                        <label for="colonia">Colonia</label>
                                        <input {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="text" name="colonia" id="colonia"
                                            value="{{$data['general']->colonia}}">
                                    </div>
                                    {{-- <div class="col l4 m6 s12">
                                        <label>ENTIDAD</label>
                                            <select {{$data['general']->contrato_empleado_id && $data['general']->estatus_contrato=='N' ? 'disabled':''}} name="estado" select-seg="sel1" class="select_dep select_search_url error browser-default"
                                                    url-record="{{route('select_entidades_by_term')}}"
                                                    @if(isset($data['general']->entidad_direccion)) val-seleccionado="{{$data['general']->entidad_direccion}}" @endif>   
                                                    <option value="{{$data['general']->entidad_direccion}}">{{$data['general']->entidad_direccion}}</option>
                                                {{-- <option disabled value="" selected>Selecciona una opción</option>
                                                @foreach ($data['entidades'] as $estado)
                                                    <option value="{{$estado->text}}">{{$estado->text}}</option>
                                                @endforeach -}}
                                        </select>
                                    </div> --}}
                                    <div class="col l4 m4 s12">
                                        <label>Ciudad</label>
                                            <select {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} name="ciudad" id="ciudad" class="select_search_url error browser-default"
                                                url-record="{{route('select_ciudades_by_term')}}">
                                            <option selected value="{{$data['general']->ciudad}}">{{$data['general']->entidad_direccion}}</option>
                                        </select>
                                    </div>
                                    <div class="col l4 m4 s12 input-field tooltipped" 
                                            data-position="top"
                                            data-tooltip="Código Postal">
                                        <label for="codigo_postal">C.P.</label>
                                        <input {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="text" name="codigo_postal" id="codigo_postal"
                                            value="{{$data['general']->codigo_postal}}">
                                    </div>
                                    <div class="col l6 m6 s12 input-field">
                                        <label for="correo">Correo</label>
                                        <input {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="text" name="correo" id="correo"
                                            value="{{$data['general']->correo}}">
                                    </div>
                                    <div class="col l6 m6 s12 input-field">
                                        <label for="telefono">Telefono</label>
                                        <input {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="text" name="telefono" id="telefono"
                                            value="{{$data['general']->telefono}}">
                                    </div>
                                </div>
                                <div>Contrato</div>
                                @if(isset($data['general']->contrato_empleado_id))
                                <input hidden type="text" name="id_contrato" value="{{$data['general']->contrato_empleado_id}}">
                                
                                @endif
                                <input hidden type="text" name="empleado_direccion_id" value="{{$data['general']->empleado_domicilio_id}}">
                                <div class="divider"></div>
                                <div class="row">
                                    <div class="row">
                                        <div class="col l6 m6 s12">
                                            <label>Registro patronal</label>
                                                <select {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} name="registro_patronal" class="error browser-default">
                                                <option disabled value="" selected>Selecciona una opción</option>
                                                @foreach ($data['registros_patronales'] as $estado)
                                                    <option @if($data['general']->registro_patronal == $estado->text) selected @endif value="{{$estado->text}}">{{$estado->text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col l6 m6 s12">
                                            <label>Regimen Fiscal</label>
                                                <select {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} name="regimen_fiscal"  class="error browser-default">
                                                <option disabled value="" selected>Selecciona una opción</option>
                                                @foreach ($data['tipos_regimenes'] as $regimen)
                                                    <option @if($data['general']->regimen_fiscal == $regimen->id) selected @endif value="{{$regimen->id}}">{{$regimen->text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col l6 m6 s12">
                                            <label>Tipo Contrato</label>
                                                <select {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} name="tipo_contrato" class="error browser-default validate_for_enable"
                                                            url-record="{{route('empleados_validartipocontrato')}}"
                                                            next_node="#fecha_fin">
                                                <option disabled value="" selected>Selecciona una opción</option>
                                                @foreach ($data['tipos_contratos'] as $estado)
                                                    <option @if($data['general']->tipo_contrato == $estado->text) selected @endif value="{{$estado->text}}">{{$estado->text}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col l6 m6 s12">
                                            <label>Tabla antiguedad</label>
                                                <select id="tabla_antiguedad" {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} name="tabla_antiguedad" class="error browser-default">
                                                    <option disabled value="" selected>Selecciona una opción</option>
                                                    @foreach ($data['tablas_antiguedades'] as $estado)
                                                        <option @if($data['general']->tabla_antiguedad == $estado->text) selected @endif value="{{$estado->text}}">{{$estado->text}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col l6 m6 s12">
                                            <label>Frecuencia Pago</label>
                                                <select {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} name="frecuencia_pago" class="error browser-default"
                                                            >
                                                    <option disabled value="" selected>Selecciona una opción</option>
                                                    @foreach ($data['frecuencias_pago'] as $estado)
                                                        <option @if($data['general']->frecuencia_pago == $estado->text) selected @endif value="{{$estado->text}}">{{$estado->text}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col l6 m6 s12 input-field">
                                            <label for="salario_diario">Salario Diario</label>
                                            <input {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} type="number" name="salario_diario" id="salario_diario"
                                                value="{{$data['general']->salario_diario}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col l6 m6 s12">
                                            <label >Fecha Inicio</label>
                                            <input {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} type="date" name="fecha_inicio"
                                                value="{{$data['general']->fecha_inicio}}">
                                        </div>
                                        <div class="col l6 m6 s12">
                                            <label >Fecha Fin</label>
                                            <input id="fecha_fin" disabled {{$data['general']->estatus_contrato=='S' ||$data['general']->estatus_contrato=='N' ? 'disabled':''}} type="date" name="fecha_fin"
                                                value="{{$data['general']->fecha_termino}}">
                                        </div>
                                    </div>
                                    <div class="row col s12">
                                        <div class="col l4 m5 s6">
                                            <a href="#modalnewE" class="btn col s12 blue cancelar_aplicar_contrato modal-trigger">CONCEPTOS <i class="material-icons right">attach_money</i></a>
                                        </div>
                                    </div>
                                        @if($data['general']->estatus_contrato=='P')
                                            <div class="row col s12 center">
                                                <div class="col l3 m4 s4">
                                                    <a modal-record="modal_aplicar" class="btn col s12 green accent-4 cancelar_aplicar_contrato with-modal">APLICAR <i class="material-icons right">check</i></a>
                                                </div>
                                                <div class="col l3 m4 s4">
                                                    <a disabled modal-record="modal_aplicar" class="btn col s12 amber lighten-1 cancelar_aplicar_contrato with-modal">SUSPENDER <i class="material-icons right">do_not_disturb_on</i></a>
                                                </div>
                                                <div class="col l3 m4 s4">
                                                    <a disabled modal-record="modal_aplicar" class="btn col s12 deep-orange darken-4 cancelar_aplicar_contrato with-modal">TERMINAR <i class="material-icons right">clear</i></a>
                                                </div>
                                            </div>
                                            
                                        @elseif($data['general']->estatus_contrato=='N')
                                            {{-- <div class="col s2">
                                                <a modal-record="modal_cancelar" class="btn col s12 red cancelar_aplicar_contrato with-modal">CANCELAR/TERMINAR CONTRATO</a>
                                            </div> --}}
                                            <div class="row col s12 center">
                                                <div class="col l3 m4 s4">
                                                    <a disabled modal-record="modal_aplicar" class="btn col s12 green accent-4 cancelar_aplicar_contrato with-modal">APLICAR <i class="material-icons right">check</i></a>
                                                </div>
                                                <div class="col l3 m4 s4">
                                                    <a modal-record="modal_aplicar" class="btn col s12 amber lighten-1 cancelar_aplicar_contrato with-modal">SUSPENDER <i class="material-icons right">do_not_disturb_on</i></a>
                                                </div>
                                                <div class="col l3 m4 s4">
                                                    <a modal-record="modal_cancelar" class="btn col s12 deep-orange darken-4 cancelar_aplicar_contrato with-modal">TERMINAR <i class="material-icons right">clear</i></a>
                                                </div>
                                            </div> 
                                        @elseif($data['general']->estatus_contrato=='S')  
                                            <div class="row col s12 center">
                                                <div class="col l3 m4 s4">
                                                    <a modal-record="modal_aplicar" class="btn col s12 green accent-4 cancelar_aplicar_contrato with-modal">REANUDAR <i class="material-icons right">check</i></a>
                                                </div>
                                                <div class="col l3 m4 s4">
                                                    <a disabled modal-record="modal_aplicar" class="btn col s12 amber lighten-1 cancelar_aplicar_contrato with-modal">SUSPENDER <i class="material-icons right">do_not_disturb_on</i></a>
                                                </div>
                                                <div class="col l3 m4 s4">
                                                    <a modal-record="modal_cancelar" class="btn col s12 deep-orange darken-4 cancelar_aplicar_contrato with-modal">TERMINAR <i class="material-icons right">clear</i></a>
                                                </div>
                                            </div>   
                                        @endif
                                        
                                        
                                        {{-- <div class="col s12 row center">
                                            <label >Aplicar</label>
                                            <div class="switch">
                                                <label>
                                                
                                                  <input type="checkbox" name="aplicar_contrato" value="S">
                                                  <span class="lever"></span>
                                                  
                                                </label>
                                              </div>
                                        </div> --}}
                                    
                                    {{-- <label>ENTIDAD</label><select name="entidad" id="entidad">
                                        @foreach ($estados as $estado)
                                            <option value="{{$estado->estado_id}}">{{$estado->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <label>Municipio</label><input type="text" name="municipio" value="{{old('municipio')}}">
                                    @error('municipio')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>CORREO ELECTRONICO</label><input type="text" name="correo_electronico" value="{{old('correo_electronico')}}">
                                    @error('correo_electronico')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>TIPO DE SALARIO</label><input type="text" name="tipo_salario" value="{{old('tipo_salario')}}">
                                    @error('tipo_salario')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>REGISTRO PATRONAL</label><input type="text" name="registro_patronal" value="{{old('registro_patronal')}}">
                                    @error('registro_patronal')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>TIPO DE CONTRATO</label><input type="text" name="tipo_contrato" value="{{old('tipo_contrato')}}">
                                    @error('tipo_contrato')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>FECHA DE ALTA</label><input type="date" name="fecha_alta" value="{{old('fecha_alta')}}">
                                    @error('fecha_alta')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>PUESTO</label><input type="text" name="puesto" value="{{old('puesto')}}">
                                    @error('puesto')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>DEPARTAMENTO</label><input type="text" name="departamento" value="{{old('departamento')}}">
                                    @error('departamento')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>SD</label><input type="text" name="sd" value="{{old('sd')}}">
                                    @error('sd')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>SBC</label><input type="text" name="sbc" value="{{old('sbc')}}">
                                    @error('sbc')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>REGIMEN</label><input type="text" name="regimen" value="{{old('regimen')}}">
                                    @error('regimen')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>PERIODO DE PAGO</label><input type="text" name="periodo_pago" value="{{old('periodo_pago')}}">
                                    @error('periodo_pago')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>ESTADO CIVIL</label><input type="text" name="estado_civil" value="{{old('estado_civil')}}">
                                    @error('estado_civil')
                                        <p>*{{$message}}</p>
                                    @enderror
                                    <label>ANTIGUEDAD</label><input type="text" name="antiguedad" value="{{old('antiguedad')}}">
                                    @error('antiguedad')
                                        <p>*{{$message}}</p>
                                    @enderror --}}
                                </div> 
                            </form>
                        </div>
                        @endif
                        <div id="vista3" class="row">
                            vista3
                        </div>
        </div>
    </div>
</form>
<div class="card">
    <div class="card-tabs">
        <ul class="tabs trasparent">
            <li class="tab col l2 m3 s4"><a class="active"href="#vistad1">Contratos</a></li>
        </ul>
    </div>
    <div class="card-content">
        <div id="vistad1" class="row">
            <div class="col s12">
                @if(isset($data['general']->contrato_empleado_id))
                    <a disabled class="btn green waves-effect waves-light">NUEVO CONTRATO <i class="material-icons right">add</i></a>
                @else
                    <a href="#modalnewE" class="btn green waves-effect waves-light modal-trigger">NUEVO CONTRATO <i class="material-icons right">add</i></a>
                @endif
            </div>
            <table id="tabladet">
                <thead>
                    <tr>
                        <th>Tipo Contrato</th>
                        <th>Puesto</th>
                        <th>Departamento</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Fecha alta</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['contratos'] as $contrato)
                    <tr @if($contrato->contrato_empleado_id === $data['general']->contrato_empleado_id )class="selected" @endif>
                        <td>{{$contrato->tipo_contrato}}</td>
                        <td>{{$contrato->puesto}}</td>
                        <td>{{$contrato->departamento}}</td>
                        <td>{{$contrato->fecha_inicio}}</td>
                        <td>{{$contrato->fecha_termino}}</td>
                        <td>{{$contrato->fecha_alta_empleado}}</td>
                        <td>
                            <span class="">{{$contrato->estatus}}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large waves-green waves-effect waves-light tooltipped light-green accent-4 validarformulario"
            form="frm-editEmpleado" data-position="top" data-tooltip="Guardar cambios">
            <i class="large material-icons">save</i>
        </a>
    </div>
    {{-- modales --}}
    @if($data['general']->estatus_contrato=='P')
        <div id="modal_aplicar" class="modal modal-fixed-footer">
            <div class="modal-content">
                <form action="{{route('empleados_aplicar_contrato')}}" method="post" id="aplicar_contrato">
                    {{ csrf_field() }}
                    <h4>Aplicar Contrato</h4>
                    <p>¿Estas seguro de aplicar este contrato?</p>
                    <input hidden type="number" name="id_empleado" value="{{Request::route('id')}}">
                    <input hidden type="number" name="id_contrato" value="{{$data['general']->contrato_empleado_id}}">
                </form>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-light">
                    Cancelar
                </a>
                <a form="aplicar_contrato" 
                    second-form="frm-editEmpleado"
                class="validarformulario-urls  modal-action modal-close waves-effect waves-light btn 2forms">
                    Aceptar
                </a>
            </div>
        </div>
    @elseif($data['general']->estatus_contrato=='N')
        <div id="modal_aplicar" class="modal modal-fixed-footer">
            <div class="modal-content">
                <form action="{{route('empleados_suspender_contrato')}}" method="post" id="aplicar_contrato">
                    {{ csrf_field() }}
                    <h4>Suspender Contrato</h4>
                    <p>¿Estas seguro desea suspender este contrato?</p>
                    <input hidden type="number" name="id_empleado" value="{{Request::route('id')}}">
                    <input hidden type="number" name="id_contrato" value="{{$data['general']->contrato_empleado_id}}">
                </form>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-light">
                    Cancelar
                </a>
                <a form="aplicar_contrato" 
                class="validarformulario  modal-action modal-close waves-effect waves-light btn 2forms">
                    Aceptar
                </a>
            </div>
        </div>
    {{-- ************************************* --}}
        <div id="modal_cancelar" class="modal modal-fixed-footer">
            <div class="modal-content">
                <form action="{{route('empleados_cancelar_contrato')}}" method="post" id="cancelar_contrato">
                    {{ csrf_field() }}
                    <h4>Cancelar Contrato</h4>
                    <p>¿Estas seguro de cancelar este contrato?</p>
                    <input hidden type="number" name="id_empleado" value="{{Request::route('id')}}">
                    <input hidden type="number" name="id_contrato" value="{{$data['general']->contrato_empleado_id}}">
                </form>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-light">
                    Cancelar
                </a>
                <a form="cancelar_contrato" 
                class="validarformulario  modal-action modal-close waves-effect waves-light btn">
                    Aceptar
                </a>
            </div>
        </div>
    @elseif($data['general']->estatus_contrato=='S')
        <div id="modal_aplicar" class="modal modal-fixed-footer">
            <div class="modal-content">
                <form action="{{route('empleados_aplicar_contrato')}}" method="post" id="aplicar_contrato">
                    {{ csrf_field() }}
                    <h4>Reanudar Contrato</h4>
                    <p>¿Estas seguro de reanudar este contrato?</p>
                    <input hidden type="number" name="id_empleado" value="{{Request::route('id')}}">
                    <input hidden type="number" name="id_contrato" value="{{$data['general']->contrato_empleado_id}}">
                </form>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-light">
                    Cancelar
                </a>
                <a form="aplicar_contrato" 
                class="validarformulario modal-action modal-close waves-effect waves-light btn 2forms">
                    Aceptar
                </a>
            </div>
        </div>
    {{-- *************** --}}
        <div id="modal_cancelar" class="modal modal-fixed-footer">
            <div class="modal-content">
                <form action="{{route('empleados_cancelar_contrato')}}" method="post" id="cancelar_contrato">
                    {{ csrf_field() }}
                    <h4>Cancelar Contrato</h4>
                    <p>¿Estas seguro de cancelar este contrato?</p>
                    <input hidden type="number" name="id_empleado" value="{{Request::route('id')}}">
                    <input hidden type="number" name="id_contrato" value="{{$data['general']->contrato_empleado_id}}">
                </form>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-light">
                    Cancelar
                </a>
                <a form="cancelar_contrato" 
                class="validarformulario  modal-action modal-close waves-effect waves-light btn">
                    Aceptar
                </a>
            </div>
        </div>
    @endif
    <div id="modalArt" class="modal modal-fixed-footer">
        <div class="modal-content" id="content-datableArticles-oc">
            {{ csrf_field() }}
            <h4>Artículos</h4>
            <table class="display compact" id="tabla-cat-conceptos_nom" url-record="{{ route('get_conceptosnom_al') }}" id-record="{{$data['general']->contrato_empleado_id}}">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Clave</th>
                        <th>Naturaleza</th>
                        <th>Clave fiscal</th>
                        <th>Tipo Calculo</th>
                        <th>Tipo Proceso</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tblArticles" class="tblArticles">
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-light">
                Cancelar
            </a>
            <a href="{{route('empleados_agrega_concepto_contrato')}}"
                class="modal-action agregar_seleccionados_gen waves-effect waves-light btn">
                Aceptar
            </a>
        </div>
    </div>
    @if(!isset($data['general']->contrato_empleado_id))
        <form id="form_empleadocontrato" action="{{roUte('empleados_nuevocontrato')}}" method="POST">
            <div id="modalnewE" class="modal modal-fixed-footer">
                <div class="modal-content" id="content-datableArticles-oc">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col s12">
                            <h4>Nuevo Contrato</h4>
                        </div>
                        <div class="col s12 row">
                            <div class="divider"></div>
                        </div>
                        <input hidden type="number" name="empleado_id" value="{{Request::route('id')}}">
                        <div class="row">
                            <div class="col l6 m6 s12">
                                <label>Registro patronal</label>
                                    <select {{$data['general']->estatus_contrato=='S' || $data['general']->estatus_contrato=='N' ? 'disabled':''}} name="registro_patronal" class="error browser-default">
                                    <option disabled value="" selected>Selecciona una opción</option>
                                    @foreach ($data['registros_patronales'] as $estado)
                                        <option @if($data['general']->registro_patronal == $estado->text) selected @endif value="{{$estado->text}}">{{$estado->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col l6 m6 s12">
                                <label>Regimen Fiscal</label>
                                    <select {{$data['general']->contrato_empleado_id && $data['general']->estatus_contrato=='N' ? 'disabled':''}} name="regimen_fiscal"  class="error browser-default">
                                    <option disabled value="" selected>Selecciona una opción</option>
                                    @foreach ($data['tipos_regimenes'] as $regimen)
                                        <option @if($data['general']->registro_patronal == $estado->text) selected @endif value="{{$regimen->id}}">{{$regimen->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l6 m6 s12">
                                <label>Tipo Contrato</label>
                                    <select {{$data['general']->contrato_empleado_id && $data['general']->estatus_contrato=='N' ? 'disabled':''}} name="tipo_contrato" class="error browser-default validate_for_enable"
                                                url-record="{{route('empleados_validartipocontrato')}}"
                                                next_node="#fecha_fin">
                                    <option disabled value="" selected>Selecciona una opción</option>
                                    @foreach ($data['tipos_contratos'] as $estado)
                                        <option @if($data['general']->tipo_contrato == $estado->text) selected @endif value="{{$estado->text}}">{{$estado->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col l6 m6 s12">
                                <label>Tabla antiguedad</label>
                                    <select id="tabla_antiguedad" {{$data['general']->contrato_empleado_id && $data['general']->estatus_contrato=='N' ? 'disabled':''}} name="tabla_antiguedad" class="error browser-default">
                                        <option disabled value="" selected>Selecciona una opción</option>
                                        @foreach ($data['tablas_antiguedades'] as $estado)
                                            <option @if($data['general']->tabla_antiguedad == $estado->text) selected @endif value="{{$estado->text}}">{{$estado->text}}</option>
                                        @endforeach
                                </select>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col l6 m6 s12">
                                <label>Frecuencia Pago</label>
                                    <select {{$data['general']->contrato_empleado_id && $data['general']->estatus_contrato=='N' ? 'disabled':''}} name="frecuencia_pago" class="error browser-default"
                                                >
                                        <option disabled value="" selected>Selecciona una opción</option>
                                        @foreach ($data['frecuencias_pago'] as $estado)
                                            <option @if($data['general']->frecuencia_pago == $estado->text) selected @endif value="{{$estado->text}}">{{$estado->text}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col l6 m6 s12 input-field">
                                <label for="salario_diario">Salario Diario</label>
                                <input {{$data['general']->contrato_empleado_id && $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="number" name="salario_diario" id="salario_diario"
                                    value="{{$data['general']->salario_diario}}">
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col l6 m6 s12">
                                <label >Fecha Inicio</label>
                                <input {{$data['general']->contrato_empleado_id && $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="date" name="fecha_inicio"
                                    value="{{$data['general']->fecha_inicio}}">
                            </div>
                            <div class="col l6 m6 s12">
                                <label >Fecha Fin</label>
                                <input id="fecha_fin" disabled {{$data['general']->contrato_empleado_id && $data['general']->estatus_contrato=='N' ? 'disabled':''}} type="date" name="fecha_fin"
                                    value="{{$data['general']->fecha_termino}}">
                            </div>
                        </div>
                </div> 
                </div>
                <div class="modal-footer">
                    <a class="modal-action modal-close waves-effect waves-light">
                        Cancelar
                    </a>
                    <a form="form_empleadocontrato"
                        second-form="frm-editEmpleado"
                        class="modal-action waves-effect waves-light btn validarformulario-urls 2forms">
                        Aceptar
                    </a>
                </div>
            </div>
        </form>
    @else
    <div id="modalnewE" class="modal modal-fixed-footer">
        <div class="modal-content" id="content-datableArticles-oc">
            <div id="vistad2" class="row">
                <div class="col s12"><h4>Conceptos</h4></div>
                <div class="col s12">
                    {{-- @if($data['general']->estatus_contrato == 'P')
                        <a disabled href="#modalArt" class="btn-floating btn-small right light-green waves-effect waves-light modal-trigger tooltipped"
                                data-position="top" 
                                data-tooltip="Añadir conceptos" >
                            <i class="large material-icons">add</i>
                        </a>
                    @else --}}
                        <a disabled class="btn-floating btn-small right light-green waves-effect waves-light"
                                 >
                            <i class="large material-icons">add</i>
                        </a>
                    {{-- @endif --}}
                </div>
                <table {{--id="tableGeneral"--}} id="tabladet" class="compact">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Clave</th>
                            <th>Naturaleza</th>
                            <th>Clave fiscal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['conceptos_nominas'] as $concepto_nom)
                        <tr>
                            <td>{{$concepto_nom->nombre}}</td>
                            <td>{{$concepto_nom->clave}}</td>
                            <td>{{$concepto_nom->naturaleza}}</td>
                            <td>{{$concepto_nom->clave_fiscal}}</td>
                            <td>
                                @if(isset($data['general']->contrato_empleado_id) && $data['general']->estatus_contrato=='P')
                                    <i class="material-icons text-cancel puntero tooltipped eliminar_renglon_gen"
                                            data-tooltip="Quitar concepto"
                                            url-record="{{route('empleados_quitar_concepto_contrato')}}"
                                            id-record="{{$concepto_nom->concepto_nomina_id}}"
                                            id-asign="{{$data['general']->contrato_empleado_id}}"
                                            >delete_forever</i>
                                @elseif(isset($data['general']->contrato_empleado_id) && $data['general']->estatus_contrato=='N')
                                    <label class="eliminar_renglon_gen tooltipped"
                                                data-tooltip="{{$concepto_nom->estatus=='N' ? 'Suspender':'Activar'}}"
                                                url-record="{{route('empleados_quitar_concepto_contrato')}}"
                                                id-record="{{$concepto_nom->concepto_nomina_id}}"
                                                id-asign="{{$data['general']->contrato_empleado_id}}">
                                        <input {{$concepto_nom->estatus=='N' ? 'checked':''}} type="checkbox" name="cantidad-{{$concepto_nom->concepto_nomina_id}}" value="N"  
                                                class="filled-in"/>
                                        <span></span>
                                        
                                    </label>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            {{-- <a class="modal-action modal-close waves-effect waves-light">
                Cancelar
            </a> --}}
            <a
                class="btn modal-action waves-effect waves-light modal-close">
                Aceptar
            </a>
        </div>
    </div>
    @endif
        
@endsection
