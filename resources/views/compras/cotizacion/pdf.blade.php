<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $data['titulo_docto'] }}</title>
    <style type="text/css">
        @page {
            margin-top: 180px;
            margin-bottom: 120px;

        }

        body {
            font-size: 16px;
            font-family: "Arial";
        }

        header {
            position: fixed;
            top: -150px;
            left: 0px;
            right: 0px;
            height: 20px;
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

        .tabla1 {
            position: relative;
            top: 0px;
            left: -30px;
            width: 109%;
            height: auto;
        }

        .tabla1 td {
            padding-top: 2px;
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
            background-color: #dfdfdf;
            padding: 5px, 0px, 5px, 0px;
        }

        .tabla4 {
            margin-top: 25px;
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

        footer {
            position: fixed;
            bottom: -70px;
            right: 0px;
            height: 30px;
            text-align: left;
        }
    </style>

</head>

<body class="page">
    <header>
        <table class="tabla1">
            <tr>
                <td class="alinear-top" width="25%" align="lefth"><img id="logo"
                        src="{{ asset('images/logo.png') }}" alt="" width="150" height="90">
                </td>
                <td class="alinear-top" width="45%" align="center">
                    <h2>Mega Fresh Produce</h2>
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
                            <?php $fecha = strtotime($data['docto']->fecha); ?>
                            <td align="center" class="border"><span class="text">{{ date('d', $fecha) }}</span></td>
                            <td align="center" class="border"><span class="text">{{ date('m', $fecha) }}</span></td>
                            <td align="center" class="border"><span class="text">{{ date('Y', $fecha) }}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>
    <footer>
        {{-- <img src="{{asset('images/favicon2.png') }}"> --}}
        <img src="{{ asset('images/logo3.jpg') }}">
        {{-- <img src="{{asset('images/logo.jpg') }}"> --}}
    </footer>
    <table width="100%" class="tabla3">
        <tr>
            <th>Proveedor</th>
            <th>Solicitado Por</th>
            <th>Moneda</th>
        </tr>
        <tr>
            <td width="40%">{{ $data['docto']->proveedor }}</td>
            <td width="40%">{{ $data['docto']->usuario_creacion }}</td>
            <td width="20%" align="center">{{ $data['docto']->moneda }}</td>
        </tr>

    </table>
    <table class="tabla4" width="100%">
        <thead >
            <tr>
                <th>CANT.</th>
                <th>U. MED</th>
                <th>CLAVE</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO.U</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($data['docto_det']); $i++)
                @if (isset($data['docto_det'][$i]->articulo))
                    <tr>
                        <td width="7%" align="center"><span class="text">{{ $data['docto_det'][$i]->cantidad }}</span></td>
                        <td width="7%" align="center"><span class="text">{{ $data['docto_det'][$i]->unidad_compra }}</span>
                        </td>
                        <td width="10%" align="left"><span class="text">{{ $data['docto_det'][$i]->clave_articulo }}</span>
                        </td>
                        <td width="58%" align="left"><span class="text">{{ $data['docto_det'][$i]->articulo }}</span></td>
                        <td width="9%" align="right"><span
                                class="text">${{ number_format($data['docto_det'][$i]->precio_unitario, 2) }}</span>
                        </td>
                        <td width="9%" align="right"><span
                                class="text">${{ number_format($data['docto_det'][$i]->total, 2) }}</span>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <td >&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="right">$0.00</td>
                    </tr>
                @endif
            @endfor
        </tbody>
        <tfoot>
            <tr>
                <td height="30px"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right" class="border fondo">Subtotal</td>
                <td class="border">$ {{ number_format($data['docto']->total, 2) }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right" class="border fondo">Impuestos</td>
                <td class="border">$ {{ number_format(0, 2) }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right" class="border fondo">Total</td>
                <td class="border">$ {{ number_format($data['docto']->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <script type="text/php">if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text($pdf->get_width()-35, $pdf->get_height() - 20, "$PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }</script>
</body>

</html>
