<!DOCTYPE html>
<html >
<head>
    <title>Recepcion de Mercancia</title>
    <style type="text/css">
        body{
            font-size: 16px;
            font-family: "Arial";
        }
        table{
            border-collapse: collapse;
        }
        td{
            padding: 6px 5px;
            font-size: 15px;
        }
        .h1{
            font-size: 21px;
            font-weight: bold;
        }
        .h2{
            font-size: 18px;
            font-weight: bold;
        }
        .tabla1{
            margin-bottom: 20px;
        }
        .tabla2 {
            margin-bottom: 20px;
        }
        .tabla3{
            margin-top: 15px;
        }
        .tabla4{
            margin-top: 15px;
        }
        .tabla3 td{
            border: 1px solid #000;
        }
        .tabla3 .cancelado{
            border-left: 0;
            border-right: 0;
            border-bottom: 0;
            border-top: 1px dotted #000;
            width: 200px;
        }
        .emisor{
            color: red;
        }
        .linea{
            border-bottom: 1px dotted #000;
        }
        .border{
            border: 1px solid #000;
        }
        .fondo{
            background-color: #dfdfdf;
        }
        .fisico{
            color: #fff;
        }
        .fisico td{
            color: #fff;
        }
        .fisico .border{
            border: 1px solid #fff;
        }
        .fisico .tabla3 td{
            border: 1px solid #fff;
        }
        .fisico .linea{
            border-bottom: 1px dotted #fff;
        }
        .fisico .emisor{
            color: #fff;
        }
        .fisico .tabla3 .cancelado{
            border-top: 1px dotted #fff;
        }
        .fisico .text{
            color: #000;
        }
        .fisico .fondo{
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div>
        <table width="100%" class="tabla1">
            <tr>
                <td width="73%" align="center"><img id="logo" src="{{ asset('images/logo.png') }}" alt="" width="255" height="157"></td>
                <td>
                    <table width="100%">
                        <tr>
                            <td height="50" align="center" class="border"><span class="h2">RUC: {{$data['recepcion']['folio']}}</span></td>
                        </tr>
                        <tr>
                            <td height="40" align="center" class="border fondo"><span class="h1">RECEPCIÓN DE MERCANCIA</span></td>
                        </tr>
                        <tr>
                            <td height="50" align="center" class="border">001- Nº <span class="text">{{$data['recepcion']['folio']}}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center">Jr. Santander Nro. 340 Jesus María - Lima</td>
            </tr>
            <tr>
                <td align="center">Telf.: (01) 364-2547 Cel.: 985-748514</td>
            </tr>
        </table>
        <table width="100%" class="tabla2">
            <tr>
                <td width="11%"><strong>Proveedor:</strong></td>
                <td width="37%" class="linea"><span class="text">{{$data['recepcion']->proveedor}}</span></td>
                <td width="5%">&nbsp;</td>
                <td width="13%">&nbsp;</td>
                <td width="4%">&nbsp;</td>
                <td width="7%" align="center" class="border fondo"><strong>DÍA</strong></td>
                <td width="8%" align="center" class="border fondo"><strong>MES</strong></td>
                <td width="7%" align="center" class="border fondo"><strong>AÑO</strong></td>
            </tr>
            <tr>
                <td><strong>Almacen:</strong></td>
                <td class="linea"><span class="text">{{$data['recepcion']->almacen}}</span></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php $fecha=strtotime($data['recepcion']->fecha)?>
                <td align="center" class="border"><span class="text">{{date('d',$fecha)}}</span></td>
                <td align="center" class="border"><span class="text">{{date('m',$fecha)}}</span></td>
                <td align="center" class="border"><span class="text">{{date('Y',$fecha/*$data['recepcion']->fecha*/)}}</span></td>
            </tr>
        </table>
        <table width="100%" class="tabla4">
            <tr>
                <td width="16%"><strong>Tipo descuento:</strong></td>
                <td width="10%" class="linea"><span class="text">{{$data['recepcion']->tipo_descuentp}}</span></td>
                <td width="10%"><strong>Descuento:</strong></td>
                <td width="8%" class="linea"><span class="text">{{$data['recepcion']->importe_descuento}}</span></td>
                <td width="14%"><strong>Tipo cambio:</strong></td>
                <td width="8%" class="linea"><span class="text">{{$data['recepcion']->tipo_cambio}}</span></td>
                <td width="9%"><strong>Moneda:</strong></td>
                <td width="25%" class="linea"><span class="text">{{$data['recepcion']->moneda}}</span></td>
            </tr>
            
        </table>
        <table width="100%" class="tabla5">
            <tr>
                <td width="10%"><strong>Arancel:</strong></td>
                <td class="linea"><span class="text">{{$data['recepcion']->arancel}}</span></td>
                <td width="8%"><strong>Fletes:</strong></td>
                <td class="linea"><span class="text">{{$data['recepcion']->fletes}}</span></td>
                <td width="14%"><strong>Otros gastos:</strong></td>
                <td class="linea"><span class="text">{{$data['recepcion']->otros_gastos}}</span></td>
            </tr>
        </table>
        <table width="100%" class="tabla3">
            <tr>
                <td align="center" class="fondo"><strong>CLAVE</strong></td>
                <td align="center" class="fondo"><strong>DESCRIPCIÓN</strong></td>
                <td align="center" class="fondo"><strong>U. MED</strong></td>
                <td align="center" class="fondo"><strong>CANT.</strong></td>
            </tr>
            @for ($i = 0; $i < count($data['recepcionDet']); $i++)
            @if (isset($data['recepcionDet'][$i]['articulo']))
            <tr>
                <td width="12%" align="center"><span class="text">{{ $data['recepcionDet'][$i]['clave_articulo'] }}</span></td>
                <td width="60%"><span class="text">{{ $data['recepcionDet'][$i]['articulo'] }}</span></td>
                <td width="14%" align="right"><span class="text">{{ $data['recepcionDet'][$i]['unidad_compra'] }}</span></td>
                <td width="14%" align="right"><span class="text">{{ $data['recepcionDet'][$i]['cantidad'] }}</span></td>
            </tr>
            @else
            <tr>
                <td width="12%">&nbsp;</td>
                <td width="60%">&nbsp;</td>
                <td width="14%">&nbsp;</td>
                <td width="14%" align="left">&nbsp;</td>
            </tr>
            @endif
            @endfor
        </table>
    </div>
</body>
</html>