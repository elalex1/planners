<!DOCTYPE html>

<html>

    <head>
      <title>{{ $data['compra']->folio }}</title>


<style type="text/css">
body{
    height: 100px;
}
	div.page
{
    page-break-after: always;
    page-break-inside: avoid;
},
.tabla_articulos{
    width: 100%;
}
.tabla_articulos tr{
    background: rgba(245, 245, 245, 0.841);
}
.tabla_articulos tbody{
    text-align: center;
}

</style>
</head>

    <body>
            <div class="page">
<header>
  <p align="right">{{ $data['compra']->fecha_autorizacion }}</p>
  <img src="{{asset('img/logo.png') }}" width="80" alt="Logo"  />
</header>

    <center >
        <table style="width: 100%;">
            <tr>
                <td>
                    <p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>Orden de Compra #{{ $data['compra']->folio }} </strong></p>
                </td>
            </tr>
            <tr>
                <td >
                    <table>
                        <tr>
                                <td>
                                    <div style="color:#262626;"><strong>Fecha: </strong></div>
                                </td>
                                <td>
                                    <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                        {{ $data['compra']->fecha }}
                                    </p>
                                </td>
                        </tr>
                        <tr>
                                <td>
                                    <div style="color:#262626;"><strong>Tipo Orden Compra: </strong> </div>
                                </td>
                                <td>
                                    <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                        {{ $data['compra']->concepto_compra }}
                                    </p>
                                </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="color:#000000;"><strong>Descripción: </strong></div>
                            </td>
                            <td>
                                <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                    {{ $data['compra']->descripcion }}
                                </p>
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td>
                    <table class="tabla_articulos">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Artículo</th>
                                <th>PrecioU</th>
                                <th>Total</th>
                                <th>Nota</th>
                            </tr>
                        </thead>

                        <tbody class="page">
                            @foreach ($data['compraDet'] as $articulo)
                            <tr>
                                <td>{{ $articulo->cantidad }}</td>
                                <td>{{ $articulo->nombre }}</td>
                                <td>$ {{ $articulo->precio_unitario }}</td>
                                <td>$ {{ $articulo->total }}</td>
                                <td>{{ $articulo->nota_articulo }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="text-align: right;"><strong style="background: rgba(255, 250, 117, 0.887);">Total: $ {{ $data['compra']->total }} </strong></p>
                    
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                                      </td>
                              </tr>
                      </table>
                      <![endif]-->


    </center>
    <footer>
      <h4>Solicitado por: <br/>
      {{ $data['compra']->usuario_creacion }}</h4>
    </footer>
</div>
</body>

</html>
