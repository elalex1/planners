@extends('layouts.proceso')
@section('title', 'fiscal')
@section('content')
    <div class="row">
        <div class="espacio-l"></div>
        <div class="col l6 m9 s12 push-l3 push-m2">
            <div class="row">
                <div class="card-content">
                    <form id="formFiscal" action="{{--route('actualizarfiscal')--}}"  method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col l6 m6 s12">
                                <label> Agregar CSD </label>
                                <label for="csd">Seleccionar Archivo</label>
                                <input class="dropify" type="file" name="csd" accept=".cer">
                            </div>
                            <div class="col l6 m6 s12">
                                <label> Agregar KEY </label>
                                <label for="key">Seleccionar Archivo</-label>
                                    <input class="dropify" id="key" type="file" name="key" accept=".key">
                            </div>
                            <div class="input-field col l12 m12 s12">
                                <label>Contraseña </label><input type="password" name="contrasena_csd"
                                    value="{{ old('contrasena_csd') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l6 m6 s12">
                                <label>Pais</label>
                                <select name="pais" id="pais" class="error browser-default">
                                    <option disabled value="" selected>Selecciona una opcion</option>
                                    {{--@foreach ($paises as $pais)
                                        <option value="{{ $pais->pais_id }}"
                                            {{ old('pais') == $pais->nombre ? 'selected' : '' }}>
                                            {{ $pais->nombre }}</option>
                                    @endforeach--}}
                                </select>
                            </div>
                            <div class="col l6 m6 s12">
                                <label> Estado/Provincia </label>
                                <select name="estado" id="estado" class="error browser-default">
                                    <option disabled value="" selected>Selecciona una opcion</option>
                                    {{--@foreach ($estados as $estado)
                                        <option value="{{ $estado->estado_id }}"
                                            {{ old('estado') == $estado->nombre ? 'selected' : '' }}>
                                            {{ $estado->nombre }}
                                        </option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col l6 m6 s12">
                                <label>Zona Horaria</label>
                                <select name="zonah" id="zonah" class="error browser-default">
                                    <option disabled value="" selected>Selecciona una opcion</option>
                                    {{--@foreach ($zonas as $zonah)
                                        <option value="{{ $zonah->zona_horaria_id }}"
                                            {{ old('zonah') == $zonah->nombre ? 'selected' : '' }}>{{ $zonah->nombre }}
                                        </option>
                                    @endforeach--}}
                                </select>
                            </div>
                            <div class="col l6 m6 s12">
                                <label>Moneda</label><select name="moneda" id="moneda" class="error browser-default">
                                    <option disabled value="" selected>Selecciona una opcion</option>
                                    {{--@foreach ($monedas as $moneda)
                                        <option value="{{ $moneda->moneda_id }}"
                                            {{ old('zonah') == $moneda->nombre ? 'selected' : '' }}>
                                            {{ $moneda->nombre }}
                                        </option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l6 m6 s12">
                                <label>RFC Empresa</label>
                                <input type="text" name="rfc" value="{{ old('rfc') }}">
                            </div>
                            <div class="input-field col l6 m6 s12">
                                <label>Número de Factura</label>
                                <input type="text" name="numero_factura" id="numero_factura" value="{{ old('numero_factura') }}">
                                @error('numero_factura')
                                    <p>*{{-- $message --}}</p>
                                @enderror
                            </div>
                        </div>
                        <input type="number" class="hide" name="empresaid" id="empresaid" value="{{--$empresaid--}}">
                        <div class="row">
                            <div>
                                <button form="formFiscal" title="urlimg" class="btn validarForm hoverable right" type="submit" >Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
