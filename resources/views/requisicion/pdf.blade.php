<!DOCTYPE html>

<html>

    <head>
      <title>{{ $content['requisicion'][0]->folio }}</title>


<style type="text/css">
	div.page
{
    page-break-after: always;
    page-break-inside: avoid;
}

</style>
</head>

    <body >
            <div class="page">
<header>
  <p align="right">{{ $content['requisicion'][0]->fecha_autorizacion }}</p>
  <img src="{{asset('img/logo.png') }}" width="80" alt="Logo"  />
</header>

    <center >
        <table>
            <tr>
                <td >
                                    <p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>Requisición de compra #{{ $content['requisicion'][0]->folio }} </strong></p>

                                            <h4>Fecha</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['requisicion'][0]->fecha }}
                                            </p>
                                            <h4>Tipo Requisición</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['requisicion'][0]->nombre }}
                                            </p>

                                            <h4>Descripción</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['requisicion'][0]->descripcion }}
                                            </p>

                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Cantidad</th>
                                                        <th>Artículo</th>
                                                        <th>Centro Costos</th>
                                                        <th>Nota</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="page">
                                                    @foreach ($content['articulos_requisicion'] as $articulo_requisicion)
                                                    <tr>
                                                        <td>{{ $articulo_requisicion->cantidad }}</td>
                                                        <td>{{ $articulo_requisicion->nombre }}</td>
                                                        <td>{{ $articulo_requisicion->centrocosto }}</td>
                                                        <td>{{ $articulo_requisicion->nota_articulo }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                    <br>
                                    <br>
                                    <br>



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
      Solicitado por <br />
      {{ $content['requisicion'][0]->usuario_creacion }}</p>
    </footer>
</div>
</body>

</html>
