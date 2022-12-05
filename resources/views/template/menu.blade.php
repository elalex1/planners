<ul id="slide-out" class="sidenav sidenav-fixed li-ppal-menu">
    <li>
        <div class="user-view">
            <!-- <div class="background">
      <img src="{{ asset('img/logo.png') }}">
    </div> -->
            <img class="responsive-img" src="{{ asset('img/plannersMX1.jpg') }}">
            <span class="black-text name">{{ Session::get('nombre') }}</span>
            <!-- <span class="black-text name">{{ Session::get('email') }}</span> -->
            <span class="pink-text name">{{ Session::get('rol') }}</span>
            <input hidden type="text" name="sessionlifetime" value="{{Config::get('session.lifetime')}}">
            <!-- <span class="black-text email">{{ str_replace('@%', '', Session::get('user')) }}</span> -->
        </div>
    </li>
    <li><a href="#modal6" class="modal-trigger"><i class="material-icons">vpn_key</i>Cambiar Contraseña</a></li>
    <li><a href="{{ asset('/logout') }}"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
    @if (Session::get('rol') == 'Administrador')
    <li><a href="#agregarusuario" class="modal-trigger"><i class="material-icons">accessibility</i>Agregar Usuario</a></li>   
    @endif
    <li>
        <div class="divider"></div>
    </li>
    <li><a class="subheader">Menú</a></li>
    @if (Session::get('rol') == 'Administrador')
        <li class="bold"><a class="waves-effect waves-light" href="{{ asset('/inicio') }}">Inicio</a></li>
    @else
        <li class="bold"><a class="waves-effect waves-light " href="{{ asset('/inicio') }}">Inicio</a></li>
    @endif

    <li class="bold"><a class="waves-effect waves-light " href="{{ asset('/requisicion') }}">Requisiciones</a>
    </li>

    <li class="bold"><a class="waves-effect waves-light" href="{{ asset('/clientes') }}">Clientes</a></li>
    <li class="bold"><a class="waves-effect waves-light" href="{{ asset('/proveedores') }}">Proveedores</a></li>

  <li >

    <ul class="collapsible collapsible-accordion">
      <li class="bold">
        <a class="collapsible-header waves-effect waves-light" tabindex="0">Inventarios<i class="material-icons">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul>
            <li class="limenu"><a class="waves-effect" href="{{asset('/inventario/Entradas')}}">Entradas</a></li>
            <li class="limenu"><a class="waves-effect " href="{{asset('/inventario/Salidas')}}">Salidas</a></li>
            <li class="limenu"><a class="waves-effect " href="{{asset('/articulos')}}">Artículos</a></li>
            <li class="limenu"><a class="waves-effect" href="#">Traspasos</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </li>
    <li>
      <ul class="collapsible collapsible-accordion">
        <li class="blob">
          <a class="collapsible-header waves-effect waves-pink " tabindex="0">
            Compras<i class="material-icons left">arrow_drop_down</i>
          </a>
          <div class="collapsible-body">
            <ul>
                <li class="bold"><a class="waves-effect waves-pink " href="{{ asset('/cotizacion') }}">
                    Cotizaciones</a></li>
                <li class="bold"><a class="waves-effect waves-pink " href="{{ asset('/ordencompra') }}">Ordenes de
                    Compra</a></li>
    
                <li class="bold"><a class="waves-effect waves-pink " href="{{ asset('/recepcionmercancia') }}">Recepción
                    de Mercancía</a></li>
                <li class="bold"><a class="waves-effect waves-pink " href="{{ asset('/devrecepcionmercancia') }}">Devolución de recepción
                    de Mercancía</a></li>

                <li class="bold">
                    <a href="{{ asset('/compra') }}" class="waves-efect waves-pink ">
                        Compra
                    </a>
                </li>
                <li class="bold">
                    <a href="{{ asset('/devcompra') }}" class="waves-efect waves-pink ">
                        Devolucón compra
                    </a>
                </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
    <li>
        <ul class="collapsible collapsible-accordion">
          <li class="blob">
            <a class="collapsible-header waves-effect waves-pink " tabindex="0">
              Nomina<i class="material-icons left">arrow_drop_down</i>
            </a>
            <div class="collapsible-body">
              <ul>
                    <li class="bold"><a class="waves-effect waves-pink " href="#{{-- asset('/cotizacion') --}}">
                        Nomina</a>
                    </li>
                     <li>
                        <ul class="collapsible">
                            <li>
                                <a class="collapsible-header in waves-effect waves-pink " tabindex="1">
                                    Catalogos<i class="material-icons left">arrow_drop_down</i>
                                </a>
                                <div class="collapsible-body in">
                                    <ul>
                                        <li class="blob" >
                                            <a href="{{route('empleados')}}">Empleados</a>
                                        </li>
                                        <li class="blob" >
                                            <a href="{{route('conceptos_nomina')}}">Conceptos</a>
                                        </li>
                                        <li class="blob" >
                                            <a href="{{route('tablas_antiguedades')}}">Tablas antiguedad</a>
                                        </li>
                                        <li class="blob" >
                                            <a href="{{route('registrospatronales')}}">Registros patronales</a>
                                        </li>
                                        <li class="blob" >
                                            <a href="{{route('tiposcontratos')}}">Tipos contratos</a>
                                        </li>
                                        <li class="blob" >
                                            <a href="{{route('frecuenciasnominas')}}">Frecuencias nominas</a>
                                        </li>
                                        <li class="blob" >
                                            <a href="{{route('deperatmentos')}}">Departamentos</a>
                                        </li>
                                        <li class="blob" >
                                            <a href="{{route('puestos')}}">Puestos</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li> 
                  {{-- <li class="bold"><a class="waves-effect waves-pink " href="{{ asset('/ordencompra') }}">Ordenes de
                      Compra</a></li>
      
                  <li class="bold"><a class="waves-effect waves-pink " href="{{ asset('/recepcionmercancia') }}">Recepción
                      de Mercancía</a></li>
                  <li class="bold"><a class="waves-effect waves-pink " href="{{ asset('/devrecepcionmercancia') }}">Devolución de recepción
                      de Mercancía</a></li>
  
                  <li class="bold">
                      <a href="{{ asset('/compra') }}" class="waves-efect waves-pink ">
                          Compra
                      </a>
                  </li>
                  <li class="bold">
                      <a href="{{ asset('/devcompra') }}" class="waves-efect waves-pink text">
                          Devolución compra
                      </a>
                  </li> --}}
              </ul>
            </div>
          </li>
        </ul>
      </li>
      
      
    


    @if (Session::get('rol') == 'Administrador')
        <li>
            <ul class="collapsible collapsible-accordion">
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-pink " tabindex="0">Aplicaciones<i
                            class="material-icons">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li class="limenu"><a class="waves-effect"
                                    href="{{ asset('/aplicacion') }}">Lista Aplicaciones</a></li>
                            <li class="limenu"><a class="waves-effect"
                                    href="{{ asset('/aplicacion/bitacoraplaguicida/consulta') }}">Bitácora
                                    Agroquímicos</a></li>
                            <li class="limenu"><a class="waves-effect"
                                    href="{{ asset('/aplicacion/bitacorafertilizante/consulta') }}">Bitácora
                                    Fertilizantes</a></li>
                            <li class="limenu"><a class="waves-effect"
                                    href="{{ asset('/aplicacion/reporteaplicacion') }}">Reporte Aplicaciones Costos</a>
                            </li>
                            <li class="limenu"><a class="waves-effect"
                                    href="{{ asset('/aplicacion/fertilizantenpk/consulta') }}">Reporte Fertilizantes
                                    NPK</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li>

            <ul class="collapsible collapsible-accordion">
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-pink " tabindex="0">Actividades<i
                            class="material-icons">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li class="limenu"><a class="waves-effect"
                                    href="{{ asset('/actividad/manoobra') }}">Actividades M.O. Cuadrillas</a></li>
                            <li class="limenu"><a class="waves-effect" href="#">Actividades M.O.
                                    Tractoristas</a></li>
                            <li class="limenu"><a class="waves-effect" href="#">Reporte Actividades</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li class="li-ppal-menu"><a class="waves-effect" href="#">Cosecha</a></li>
        <li class="li-ppal-menu"><a class="waves-effect" href="#">Compras/Inventarios</a></li>
        <li class="li-ppal-menu"><a class="waves-effect" href="#">Embarques</a></li>
    @endif
</ul>

<!-- Modal Structure Cambiar Password-->
<form id="frm-cambiapassword" class="form-horizontal" method="POST" novalidate="novalidate"
    action="{{route('CambiarPassword')}}"> <!--//"/erp-web/cambiapassword"-->
    <div id="modal6" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Cambiar Contraseña</h4>

            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                <div class="input-field col s6">
                    <input id="new-password" type="text" class="" name="newpassword">
                    <label for="new-password" class="col-md-4 control-label">Nueva Contraseña</label>
                    @if ($errors->has('new-password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new-password') }}</strong>
                        </span>
                    @endif
                </div>

            </div>
            <div class="form-group">
                <div class="input-field col s6">
                    <input id="new-password-confirm" type="text" class=""
                        name="newpasswordconfirmation">
                    <label for="new-password-confirm" class="col-md-4 control-label" data-match="#new-password">Confirma
                        la Nueva Contraseña</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-light">
                Cancelar
            </a>
            <button form="frm-cambiapassword" id="cambia-password" type="submit" class="waves-effect waves-light btn">
                Cambiar contraseña
            </button>
        </div>
    </div>
</form>

<div id="agregarusuario" class="modal">
    <form action="{{route('usuarioempresa')}}" method="post">
        @csrf
        <div class="modal-content">
            <h4>Agregar Usuario</h4>
            <div class="row"></div>
            <div class="row">

                <div class="input-field col s12">
                    <input id="nombre" type="text" class="validate" name="nombre">
                    <label for="nombre">Nombre</label>
                </div>

                <div class="input-field col s12">
                    <input id="correo" type="email" class="validate" name="correo">
                    <label for="correo">Correo</label>
                </div>

                <div class="input-field col s12">
                    <input id="password" type="password" class="validate" name="password">
                    <label for="password">Contraseña</label>
                </div>

                <div class="input-field col s12">
                    <input hidden id="empresa" type="email" name="empresa" value="{{ Session::get('email') }}">
                </div>
            </div>  
          </div>

          <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-light">
                Cancelar
            </a>
            <button type="submit" class="waves-effect waves-light btn modal-close">
                Agregar Usuario
            </button>
          </div>
    </form>
</div>

