



<!DOCTYPE html>

<html>

    <head>
      <title>{{ $content['actividad'][0]->fecha }}</title>

</head>

    <body >
<header>
  <p align="right">{{ $content['actividad'][0]->fecha }}</p>
  <img src="{{asset('img/logo.png') }}" width="80" alt="Logo"  />
</header>
    <center >
        <table>
            <tr>
                <td >
                                    <p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>Actividad #{{ $content['actividad'][0]->nombre_equipo }} </strong></p>

                                            <h4>Fecha</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['actividad'][0]->fecha }}
                                            </p>
                                            <h4>Hora</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['actividad'][0]->hora }}
                                            </p>

                                            <h4>Rancho</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['actividad'][0]->rancho }}
                                            </p>

                                            <table class="renglon">
                                              <thead>
                                                <tr>
                                                  @foreach ($content['actividad_produccion'][0] as $key=>$value)

                                                  <th>{{ htmlspecialchars($key) }}</th>
                                                  @endforeach
                                                </tr>
                                              </thead>

                                                <tbody>
                                                      @foreach ($content['actividad_produccion'] as $key=>$value)
                                                    <tr>
                                                      @foreach ($value as $value2)
                                                        <td>{{$value2}}</td>
                                                        @endforeach
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                </table>
                                    <br>
                                    <br>
                                    <br>

                                    <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px "><br />


                        <!-- ======= end hero article ======= -->


                        <!-- ======= end footer ======= --></td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                                      </td>
                              </tr>
                      </table>
                      <![endif]-->


    </center>
    <footer>
      Creador por <br />
      {{ $content['actividad'][0]->usuario_creacion }}</p>
    </footer>

</body>

</html>
