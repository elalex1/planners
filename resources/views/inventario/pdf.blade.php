<!DOCTYPE html>

<html>

    <head>
      <title>{{ $content['inventario'][0]->folio }}</title>


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
  <p align="right">{{ $content['inventario'][0]->fecha }}</p>
  <img src="{{asset('img/logo.png') }}" width="80" alt="Logo"  />
</header>

    <center >
        <table>
            <tr>
                <td >
                                    <p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>Movimiento Inventario #{{ $content['inventario'][0]->folio }} </strong></p>

                                            <h4>Fecha</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['inventario'][0]->fecha }}
                                            </p>
                                            <h4>Concepto</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['inventario'][0]->nombre }}
                                            </p>

                                            <h4>Almacén</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['inventario'][0]->almacen }}
                                            </p>
                                            <h4>Descripción</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['inventario'][0]->descripcion }}
                                            </p>
                                            <h4>Centro de Costo</h4>
                                            <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                                {{ $content['inventario'][0]->centro_costo }}
                                            </p>

                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Cantidad</th>
                                                        <th>Artículo</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="page">
                                                    @foreach ($content['articulos_inventario'] as $articulo_inventario)
                                                    <tr>
                                                        <td>{{ $articulo_inventario->cantidad }}</td>
                                                        <td>{{ $articulo_inventario->nombre }}</td>
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
      {{ $content['inventario'][0]->usuario }}</p>
    </footer>
</div>
</body>

</html>
