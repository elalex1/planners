@extends('layouts.proceso')
@section('title', 'Perfil')
@section('content')
    <div class="row">
        <div class="espacio-l"></div>
        <div class="col l6 m8 s12 push-l3 push-m2">
            <div class="pink-text">
                <form id="perfilForm" action="{{route('actualizarperfil')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <h4>Agregar tu Logotipo</h4>
                            <div class="divider"></div>
                            <div class="input-field col s6 offset-s3">

                                <input type="file" id="uploadedfile" name="uploadedfile" class="dropify"
                                    data-allowed-file-extensions="png jpg jpeg" data-max-file-size="2.5M" width="300px"
                                    height="200px" />
                            </div>
                            <div class="col s8">
                                <label>Tamaño máximo de archivo: 1.5 MB </label><br>
                                <label>Ancho: 300px y Altura: 100px para conseguir una mejor experiencia en el
                                    sitio</label>
                            </div>
                            <div class="col s4">
                                <label class="right">Formatos permitidos: png, jpg, jpeg</label>
                            </div>

                        </div>
                        <div class="row">
                            <h5>Nombre de la Empresa</h5>
                            <div class="divider"></div>
                            <div class="col l6 m8 s12 push-l3 push-m2">
                                <div class="input-field col s12">
                                    <label class="pink-text">Nombre Oficial de la empresa</label>
                                    <input type="text" name="nombreEmpresa" id="nombreEmpresa"
                                        value="{{ old('nombreEmpresa', $empresa->nombre_comercial) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h5>Contacto</h5>
                            <div class="divider"></div>
                            <div class="input-field col s6">
                                <label class="pink-text">Telefono de Oficina</label>
                                <input type="text" name="telefono_oficina" id="telefono_oficina">
                            </div>
                            <div class="input-field col s6">
                                <label class="pink-text">Celular</label>
                                <input type="text" name="celular" id="celular">
                            </div>
                        </div>
                        <div class="row">
                            <h5>Direccion</h5>
                            <div class="divider"></div>
                            <div class="input-field col s3">
                                <label class="pink-text">Numero Exterior</label>
                                <input type="text" name="numero_exterior" id="numero_exterior" value="">

                            </div>
                            <div class="input-field col s6">
                                <label class="pink-text">Calle</label>
                                <input type="text" name="calle" id="calle">
                            </div>
                            <div class="input-field col s3">
                                <label class="pink-text">Num. int</label>
                                <input type="text" name="numero_interior" id="numero_interior">
                            </div>
                            <div class="input-field col s6">
                                <label class="pink-text">colonia</label>
                                <input type="text" name="colonia" id="colonia">
                            </div>
                            <div class="input-field col s3">

                                <label class="pink-text">Codigo Postal</label>
                                <input type="text" name="cp" id="cp">
                            </div>
                            <div class="input-field col s3">
                                <label class="pink-text"> Municipio </label>
                                <input type="text" name="municipio" id="municipio">
                            </div>
                            <input class="hide" type="text" name="empresa" id="empresa" value="{{ $empresa->empresa_id }}">
                        </div>
                        <div class="row">
                            <div class="col s4 offset-s8">
                                <button form="perfilForm" title="urlimg" class="btn validarForm  waves-effect right" type="submit">Siguiente</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!--form action="" class="form-crearperfil">
                                        <h1 class="form__title">Perfil</h1>
                                        <div class="container--flex"><label>Agregar tu Logotipo</label></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                        <div class="container--frex"><label for="" class="form__label"></label><input type="text" class="form__input"></div>
                                    </form-->
@endsection
