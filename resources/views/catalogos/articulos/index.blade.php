@extends('app')

@section('title', 'Catalogo Articulos')

@section('content')

<div class="card">

    <div class="card-content">

        <table id="tableGeneral" class="display responsive" width="100%">

            <thead>

                <tr>

                    <th data-priority="1">ARTICULO</th>

                    <th data-priority="2">UNIDAD VENTA</th>

                    <th data-priority="3">UNIDAD COMPRA</th>

                    <th data-priority="5">ALMACENABLE</th>

                    <th data-priority="6">SERVICIO</th>

                    <th data-priority="7">SEGUIMIENTO LOTE</th>

                    <th data-priority="8">CADUCIDAD</th>

                    <th data-priority="4"></th>

                </tr>

            </thead>

            <tbody>

                @foreach ($content['articulos'] as $articulo)

                <tr id-record="{{$articulo->articulo_id}}" modal-record="modalInfo">

                    <td>{{$articulo->nombre}}</td>

                    <td>{{$articulo->unidad_venta}}</td>

                    <td>{{$articulo->unidad_compra}}</td>

                    <td>{{$articulo->almacenable}}</td>

                    <td>{{$articulo->es_servicio}}</td>

                    <td>{{$articulo->seguimiento_lotes}}</td>

                    <td>{{$articulo->caducidad}}</td>

                    <td></td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>
</div>

    <div class="card">
        <div class="card-content">
            <form action=" {{route('ImportArticulos')}} " method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="articulos" id="articulos" class="dropify">
           
            <div class="row center-align">
                <div class="col s12">
                    <button class="waves-effect waves-light btn" type="submit">Importar</button>
                    <a class="waves-effect waves-light btn" href=" {{route('ExportArticulos')}} ">Exportar</a> 
                  </div>
            </div>
          </form>
          <div class="row"></div>
        </div>
    </div>



<div id="modalInfo" class="modal modal-fixed-footer xl">

        {{-- <div class="valign-wrapper modal-title ">

                <h4 class="col s12">Información</h4>

        </div> --}}

        <div class="card-tabs">

            <ul class="tabs trasparent">

                <li class="tab col l2 m3 s4"><a class="active" href="#vista1">Existencia</a></li>

                <li class="tab col l2 m3 s4"><a href="#vista2">Kardex</a></li>

            </ul>

        </div>

        <div class="modal-content">

            <div id="vista1">

                <div class="row">

                    <div class="col s12">

                        <div class="divider"></div>

                        <form id="artexistencias" action="{{route('cat_articulos_kardex_existencias')}}" method="POST">

                            <input  hidden type="number" name="articulo_id" value="">

                            <input hidden type="date" name="fecha_inicio_f" value="{{date('Y-01-01', time())}}">

                            <input hidden type="date" name="fecha_fin_f" value="{{date('Y-m-d', time())}}">    

                            <div class="row col s12">

                                <label for="">Filtro</label>

                            </div>

                            {{-- <div class="row">

                                <div class="col s6 center">

                                    <label>

                                        <input type="radio" name="tipo_busqueda" value="U" checked>

                                        <span>Almacén</span>

                                    </label>

                                </div>

                                <div class="col s6">

                                    <div class="col s6 center">

                                        <label>

                                            <input type="radio" name="tipo_busqueda" value="C">

                                            <span>Consolidado</span>

                                        </label>

                                    </div>

                                </div>

                            </div> --}}

                            <div class="row">

                                <div class="col s8">

                                    <label>Almacen</label><select name="almacen">

                                        <option value="0">Todos</option>

                                        @foreach($content['almacenes'] as $almacen)

                                            <option value="{{$almacen->almacen_id}}">{{$almacen->text}}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="col s4 center">

                                    <a form="artexistencias" class="btn waves-effect waves-light actualizar-info">Actualizar</a>

                                </div>

                            </div>

                        </form>

                        {{-- <div class="row"> --}}

                            {{-- <div class="col s4">

                                <a href="#" class="btn waves-effect waves-light">Actualizar</a>

                            </div> --}}

                        {{-- </div> --}}

                        <div class="divider"></div>

                        <div class="row col s12">

                            <label for="">Disponibilidad</label>

                        </div>

                        <div class="row">

                            <div class="col s3">

                                <label for="existencia_actual">Existencia actual</label>

                                <input disabled type="text" name="existencia_actual" id="existencia_actual" value="0" class="center">

                            </div>

                        </div>

                        <div class="divider"></div>

                        <div class="row col s12">

                            <label for="">Costo</label>

                        </div>

                        <div class="row">

                            {{-- <div class="col s2">

                            </div> --}}

                            <div class="col s4">

                                <div class="col s6 push-s6">

                                    <label>Costo promedio</label>

                                </div>

                            </div>

                            <div class="col s4">

                                <div class="col s6 push-s6">

                                    <label>Ultimo costo</label>

                                </div>

                            </div>

                            <div class="col s4">

                                <div class="col s6 push-s3">

                                    <label>Ultima compra</label>

                                </div>

                            </div>

                            <div class="col s12 valign-wrapper">

                                <div class="col s2">

                                    <label class="right">Costo unitario:</label>

                                </div>

                                <div class="col s2">

                                    <input disabled type="text" name="costo_unitario_promedio" value="0" class="center">

                                </div>

                                {{-- <div class="col s2">

                                    <label>Costo unitario:</label>

                                </div> --}}

                                <div class="col s4">

                                    <input disabled type="text" name="costo_unitario" value="0" class="center">

                                </div>

                                <div class="col s4 center" >

                                    <div class="col s6 push-s3">

                                        <input disabled type="date" name="fecha_ultima_compra" value="" class="center" >

                                    </div>

                                </div>

                            </div>

                            <div class="col s12 valign-wrapper">

                                <div class="col s2">

                                    <label class="right">Valor total:</label>

                                </div>

                                <div class="col s2">

                                    <input disabled type="text" name="valor_total_promedio" value="0" class="center">

                                </div>

                                {{-- <div class="col s2">

                                    <label>Valor total:</label>

                                </div> --}}

                                <div class="col s8">

                                    <div class="col s6">

                                        <input disabled type="text" name="valor_total" value="0" class="center">

                                    </div>

                                    

                                </div>

                            </div>

                        </div>

                        

                        <div class="divider"></div>

                        <div class="row col s12">

                            <label for="">Rotación por año</label>

                        </div>

                        <div class="row">

                            <div class="col s4 input-field">

                                <label for="salidas">Salidas</label>

                                <input disabled type="number" id="salidas" name="salidas" value="0" class="center">

                            </div>

                            <div class="col s4 input-field">

                                <label for="inv_promedio">Inv. promedio</label>

                                <input disabled type="number" id="inv_promedio" name="inv_promedio" value="0" class="center">

                            </div>

                            <div class="col s4 input-field">

                                <label for="rotacion">Rotación</label>

                                <input disabled type="number" id="rotacion" name="rotacion" value="0" class="center">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div id="vista2">

                <div class="row">

                    <div class="col s12 ">

                        <div class="divider"></div>

                        <div class="col s12">

                            <label for="">Opciones</label>

                        </div>

                        <form id="kardex" action="{{route('cat_articulos_kardex_existencias')}}" method="POST">

                            <input hidden type="number" name="articulo_id" value="">

                            <div class="row col s6">

                                <div class="col s12 center">

                                    <label for="periodo">Período</label>

                                </div>

                                <div class="col s12 valign-wrapper">

                                    <div class="col s2 center">

                                        <label for="">De</label>

                                    </div>

                                    <div class="col s4">

                                        <input type="date" name="fecha_inicio" value="{{date('Y-01-01', time())}}">

                                    </div>

                                    <div class="col s2 center">

                                        <label for="">al</label>

                                    </div>

                                    <div class="col s4">

                                        <input type="date" name="fecha_fin" value="{{date('Y-m-d', time())}}">

                                    </div>

                                </div>

                            </div>

                            <div class="col s4">

                                <label >Almacen</label>

                                <select name="almacen" id="almacen">

                                    <option value="0">Todos</option>

                                    @foreach($content['almacenes'] as $almacen)

                                    <option value="{{$almacen->almacen_id}}">{{$almacen->text}}</option>

                                    @endforeach



                                    {{-- <option value="1">selecciona1</option>

                                    <option value="2">selecciona2</option> --}}

                                </select>

                            </div>

                            <div class="row col s2">

                                <a form="kardex" class="btn waves-effect waves-light actualizar-info kardex">Actualizar</a>

                            </div>

                        </form>

                       

                           

                        <div class="divider col s12"></div>

                        <div class="col s12">

                            <label for="">Movimientos</label>

                        </div>

                        <div class="col s12">

                            <table id="tablaKardex" class="cell-border" style="width:100%" url-record="{{route('cat_articulos_kardex_vista')}}">

                                <thead>

                                    <tr class="" style="width:100%">

                                        <th data-priority="1">Fecha</th>

                                        <th data-priority="2">Concepto</th>

                                        <th data-priority="3">Entrada</th>

                                        <th data-priority="4">Salida</th>

                                        <th data-priority="5">Unidades</th>

                                        <th data-priority="6">Costo_fin</th>

                                        <th data-priority="7">unidades_fin</th>

                                    </tr>

                                </thead>

                            </table>

                        </div>

                        <div class="divider col s12"></div>

                        <div class="col s12">

                            <label for="">Existencia</label>

                        </div>

                        <div class="col s12 pull-s2">

                            <div class="col s6">

                                <div class="col s4 push-s8">

                                    <label for="">Inventario inicial</label>

                                </div>

                                

                            </div>

                            <div class="col s2">

                                <label for="">Entradas</label>

                            </div>

                            <div class="col s2">

                                <label for="">Salidas</label>

                            </div>

                            <div class="col s2">

                                <label for="">Inventario final</label>

                            </div>

                            <div class="col s12 valign-wrapper">

                                <div class="col s4">

                                    <div class="col s11">

                                        <label class="right" for="">Unidades:</label>

                                    </div>

                                </div>

                                <div class="col s2">

                                    <input class="center" disabled type="number" name="unidades_inicial" value="0">

                                </div>

                                <div class="col s2">

                                    <input class="center" disabled type="number" name="unidades_entradas">

                                </div>

                                <div class="col s2">

                                    <input class="center" disabled type="number" name="unidades_salidas">

                                </div>

                                <div class="col s2">

                                    <input class="center" disabled type="number" name="unidades_total">

                                </div>

                            

                            </div>

                            <div class="col s12 valign-wrapper">

                                <div class="col s4">

                                    <div class="col s11">

                                        <label class="right" for="">Costo:</label>

                                    </div>

                                </div>

                                <div class="col s2">

                                    <input class="center" disabled type="text" name="costo_inicial" value="0">

                                </div>

                                <div class="col s2">

                                    <input class="center" disabled type="text" name="costo_entradas">

                                </div>

                                <div class="col s2">

                                    <input class="center" disabled type="text" name="costo_salidas">

                                </div>

                                <div class="col s2">

                                    <input class="center" disabled type="text" name="costo_total">

                                </div>

                            </div>

                        </div>

                        

                    </div>

                    

                </div>

            </div>

		{{-- <form id="NuecoDocumento" action="{{ route('cotizaciones_agregar_requs') }}" method="POST">

			<div class="row">

				<input type="text" name="doctos_ids" value="" url-record="fdsfds" hidden>

				<div class="row col s12">

					<select modal-parent="NuevaCotizacion" name="proveedor" 

						url-record="{{route('select_proveedor_by_term')}}"

						class="error selectProveedor_modal browser-default">

					</select>

					<label>Seleccione proveedor</label>

				</div>

				<div class="row col s12">

					<select name="moneda" class="error browser-default">

						<option value="" disabled  selected>Selecciona opción</option>

						@foreach ($data['monedas'] as $moneda)

						<option value="{{ $moneda->nombre }}">{{ $moneda->nombre }}</option>

						@endforeach

					</select>

					<label>seleccione una moneda</label>

				</div>

				<div class="row col s12">

					<select name="familia_erticulos"

						url-record="{{route('select_fam_by_reqs')}}"

						data-record=""

						class="error selectFamilia browser-default">

					</select>

					<label>Seleccione familia de artículos</label>

				</div>

			</div>

		</form> --}}

	</div>

	<div class="modal-footer">

		<a class="btn modal-action modal-close waves-effect waves-light">

            Aceptar

        </a>

        {{-- <a form="NuecoDocumento"

            class="validarformulario waves-effect waves-light btn">

            Aceptar

        </a> --}}

	</div>

</div>



@endsection

@push('scripts')

<script src="{{asset('js/catalogos.js')}}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

@endpush

