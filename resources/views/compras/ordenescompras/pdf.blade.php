<!DOCTYPE html>

<html>

    <head>
      <title>{{ $data['ordencompra'][0]->folio }}</title>


      <style type="text/css">
        @page {
            margin-top: 200px;
            margin-bottom: 120px;

        }

        body {
            font-size: 16px;
            font-family: "Arial";
        }

        header {
            /* background: #ccc; */
            position: fixed;
            top: -199px;
            left: 0px;
            right: 0px;
            height: 200px;
            width: 100%;
            text-align: center;
            line-height: 15px;
        }

        table {
            border-collapse: collapse;
        }

        th {
            font-size: 16px;
            background-color: #dfdfdf;
        }

        td {
            font-size: 14px;
            
        }

        td.alinear-top {
            vertical-align: top;
        }
        td.alinear-bottom {
            vertical-align: bottom;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .tablahead{
            position: relative;
            /* left: -10px; */
            top: 0px;
            padding-right: 15px;
            width: 105%;
            
        }
        .tablahead td{
            padding: 1px;
        }
        .tablahead td .title{
            font-size: 30px;
            font-weight: bold;
        }

        .tabla1 {
            position: relative;
            top: 0px;
            left: 15px;
            padding-right: 15px;
            width: 100%;
            /* height: auto; */
        }

        .tabla1 td {
            padding-top: 0px;
            padding-bottom: 0px;
            /* padding-right: 15%; */
            /* min-height: 10px; */
        }
        
        .tabla2 {
            position: relative;
            top: 0px;
            left: 0px;
            padding-left: 0px;
            width: 100%;
            height: auto;
        }
        .tabla2 td {
            padding: 0px;
            padding-left: 5px;
            min-height: 10px;
        }

        .tabla3 {
            margin-top: 15px;
        }
        .tabla3 td {
            border: 1px solid black;
            padding: 5px, 3px, 5px, 3px;
        }
        .tabla3 th {
            border: 1px solid black;
            background-color: #548032;
            color: white;
            padding: 5px, 0px, 5px, 0px;
        }

        .tabla4 {
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .tabla4 tbody td {
            font-size: 11px;
            border: 1px solid black;
        }
        .tabla4 tfoot td {
            font-size: 11px;
        }

        .tabla4 th {
            font-size: 12px;
            border: 1px solid black;
            background-color: #548032;
            color: white;
            padding: 5px, 0px, 5px, 0px;
        } 

        .tabla-total {
            margin-top: 15px;
        }

        .border {
            border: 1px solid var(--tabla-border-principal);
        }

        .fondo {
            background-color: #dfdfdf;
        }
        .fondo_pr {
            background-color: #548032;
            color: aliceblue;
        }
        .fondo_sec{
            background-color: #c5e0b3;
        }

        footer {
            position: fixed;
            bottom: -70px;
            right: 0px;
            height: 30px;
            text-align: left;
        }
        .descripcion-box{
           
            height: 50px;
        }

    </style>
</head>

    <body class="page">
        <header>
            <table class="tablahead">
                <tr>
                    <td  class="alinear-top" width="22%" align="lefth"><img id="logo"
                        src="{{ asset('images/logo.png') }}" alt="" width="130" height="90">
                    </td>
                    <td>
                        <table class="" width="100%" style="right:-5%">
                            <tr>
                                <td class="alinear-top text-right" height="35">
                                    {{ $data['ordencompra'][0]->fecha_autorizacion }}
                                </td>
                                
                            </tr>
                            <tr>
                                <table width=97%>
                                    <tr>
                                        <td style="padding-right: 35px; padding-top:8px; border" class="alinear-center fondo_pr title" width="100%" height="30px" align="right">
                                            Orden de Compra
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                        </table> 
                    </td>
                </tr>
            </table>
            <table class="tabla1" width="100%">
                
                {{-- <tr>
                    <td class="alinear-top" width="25%" align="lefth"><img id="logo"
                            src="{{ asset('images/logo.png') }}" alt="" width="150" height="90">
                    </td> --}}
                    
                    {{-- <td class="alinear-top" width="45%" align="center">
                        <h2>Mega Fresh poduce</h2>
                        <p>Dirección<br> Telefonos</p>
                    </td>
                    <td class="alinear-top" width="30%" align="right">
                        <table width="100%" class="tabla3">
                            <tr>
                                <th>Cotización</th>
                            </tr>
                            <tr>
                                <td align="center">{{ $data['docto']->folio }}</td>
                            </tr>
                        </table>
                        <table width="100%" class="tabla3">
                            <tr>
                                <th align="center">
                                    <strong>DÍA</strong>
                                </th>
                                <th align="center">
                                    <strong>MES</strong>
                                </th>
                                <th align="center">
                                    <strong>AÑO</strong>
                                </th>
                            </tr>
                            <tr>
                                <--?php $fecha = strtotime($data['docto']->fecha); ?-->
                                <td align="center" class="border"><span class="text">{{ date('d', $fecha) }}</span></td>
                                <td align="center" class="border"><span class="text">{{ date('m', $fecha) }}</span></td>
                                <td align="center" class="border"><span class="text">{{ date('Y', $fecha) }}</span></td>
                            </tr>
                        </table>
                    </td> --}}
                {{-- </tr> --}}
                <tr>
                    <td>
                        <table class="tabla2">
                            <tr>
                                <td class="alinear-top text-right" style="padding-right: 10%;" width="70%" align="center">
                                    <h2>Mega Fresh Produce</h2>
                                </td> 
                                <td>
                                    <table class="tabla2">
                                        <tr >
                                            <td width="35%" class="text-right">
                                                Fecha:
                                            </td>
                                            <td class="text-center" style="padding-right: 20%;">
                                                <div  style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->fecha }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                No. OC:
                                            </td>
                                            <td class="text-center" style="padding-right: 20%;">
                                                <div style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->folio }}</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="73%">
                            <tr>
                                <td style="padding-left: 150px;" class="text-center">
                                    <div>Calle Emiliano Zapata #11, El Matorral, Loreto, Zacatecas a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left: 150px;" class="text-center">
                                    <div>megafreshproduce@hotmail.com</div>
                                </td>
                            </tr>
                            <tr >
                                <td style="padding-left: 150px;" class="text-center">
                                    <div> (123) 456-78 90</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </header>

    {{--<center >
        <table style="width: 100%;">
            <tr>
                <td>
                    <p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>Orden de Compra #{{ $data['ordencompra'][0]->folio }} </strong></p>
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
                                        {{ $data['ordencompra'][0]->fecha }}
                                    </p>
                                </td>
                        </tr>
                        <tr>
                                <td>
                                    <div style="color:#262626;"><strong>Tipo Orden Compra: </strong> </div>
                                </td>
                                <td>
                                    <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                        {{ $data['ordencompra'][0]->concepto_compra }}
                                    </p>
                                </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="color:#000000;"><strong>Descripción: </strong></div>
                            </td>
                            <td>
                                <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                                    {{ $data['ordencompra'][0]->descripcion }}
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
                            @foreach ($data['articulos_ordencompra'] as $articulo)
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
                    <p style="text-align: right;"><strong style="background: rgba(255, 250, 117, 0.887);">Total: $ {{ $data['ordencompra'][0]->total }} </strong></p>
                    
                </td>
            </tr>
        </table>


    </center>--}}
    <footer>
      <h4>Solicitado por: <br/>
      {{ $data['ordencompra'][0]->usuario_creacion }}</h4>
    </footer>
    <table class="tabla1">
        <tr>
            <td>
                <table class="tabla2" style="margin-top: 15px;">
                    <tr>
                        <td width="50%" class="text-center"><strong>Proveedor</strong></td>
                        <td class="text-center"><strong>Envio a:</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <table class="tabla2">
                                <tr >
                                    <td width="20%">
                                        Compañía:
                                    </td>
                                    <td class="text-center" >
                                        <div  style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->proveedor }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Contacto:
                                    </td>
                                    <td class="text-center">
                                        <div style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->email }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Domicilio:
                                    </td>
                                    <td class="text-center">
                                        <div style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->email }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Telefono:
                                    </td>
                                    <td class="text-center">
                                        <div style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->email }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="tabla2">
                                <tr >
                                    <td width="20%">
                                        Responsable:
                                    </td>
                                    <td class="text-center">
                                        <div  style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->email }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Departamento:
                                    </td>
                                    <td class="text-center">
                                        <div style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->email }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Dirección:
                                    </td>
                                    <td class="text-center">
                                        <div style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->email }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Telefono:
                                    </td>
                                    <td class="text-center">
                                        <div style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->email }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Correo:
                                    </td>
                                    <td class="text-center">
                                        <div style="border-bottom: 1px solid #ccc;">{{ $data['ordencompra'][0]->email }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="fondo_sec" height="20px"></td>
        </tr>
    </table>
    <table class="tabla1">
        <tr>
            <td>
                <table class="tabla4" width="100%">
                    <thead>
                        <tr>
                            <th width="10%">Cantidad</th>
                            <th width="60%">Producto</th>
                            <th width="17%">Costo unitario</th>
                            <th width="13%">Sub total</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data['articulos_ordencompra'] as $articulo)
                            <tr>
                                <td>{{ $articulo->cantidad }}</td>
                                <td>{{ $articulo->nombre }}</td>
                                <td class="text-right">$ {{ $articulo->precio_unitario }}</td>
                                <td class="text-right">$ {{ $articulo->total }}</td>
                            </tr>
                        @endforeach
                        @for($i=0;$i<32;$i++)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>$0.00</td>
                            </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="border">SUB TOTAL</td>
                            <td class="text-right border">$0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="border">IVA</td>
                            <td class="text-right border">$0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="border">ENVIO</td>
                            <td class="text-right border">$0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="border">OTROS</td>
                            <td class="text-right border">$0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="fondo_pr border">TOTAL</td>
                            <td class="fondo_sec text-right border">{{ $data['ordencompra'][0]->total }}</td>
                        </tr>
                    </tfoot>
                </table>
                
            </td>
        </tr>
    </table>
    <table class="tabla1">
        <tr>
            <td>
                <table class="tabla2" style="margin-top: 15px;">
                    <tr>
                        <td width="70%" >
                            <table class="tabla2">
                                <tr>
                                    <td class="fondo_sec">
                                        Notas/Observaciones
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border descripcion-box alinear-top">
                                        {{ $data['ordencompra'][0]->descripcion }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                           <table class="tabla2">
                                <tr>
                                    <td class="descripcion-box" style="border-bottom: 1px solid #ccc;"><div></div></td>
                                </tr>
                                <tr>
                                    <td class="text-center alinear-top" >Autorización</td>
                                </tr>
                           </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <table class="tabla1" style="margin-top: 15px;">
        <tr>
            <td>
                <strong> Si usted tiene una pregunta sobre esta Orden de Compra favor de ponerce en contacto </strong>
            </td>
        </tr>
        <tr>
            <td>
                <table class="tabla2">
                    <tr>
                        <td width="5%" class="text-lefth">
                            <strong>Con:</strong>
                        </td>
                        <td width="40%" class="text-lefth">
                            Contacto
                        </td>
                        <td width="15%" class="text-right">
                            <strong>Al telefono:</strong>
                        </td>
                        <td width="35%" class="text-lefth">
                            1234567
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<script type="text/php">if ( isset($pdf) ) {
    $pdf->page_script('
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $pdf->text($pdf->get_width()-35, $pdf->get_height() - 20, "$PAGE_NUM de $PAGE_COUNT", $font, 10);
    ');
}</script>
</body>

</html>
