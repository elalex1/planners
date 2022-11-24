<!DOCTYPE html>

<html>

    <head>

        <title>{{ $content['produccion'][0]->folio }}</title>
<style type="text/css" media="print">


div.page
{
    page-break-after: always;
    page-break-inside: avoid;
}
* {
	-webkit-font-smoothing: antialiased;
}
body {
	Margin: 0;
	padding: 0;
	min-width: 100%;
	font-family: Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	mso-line-height-rule: exactly;
}
table {
    width: 100%;
    display: table;
    border-collapse: collapse;
    border-spacing: 0;
}


table.striped>tbody>tr>td {
    border-radius: 0;
}

table.highlight>tbody>tr {
    -webkit-transition: background-color .25s ease;
    transition: background-color .25s ease;
}

table.highlight>tbody>tr:hover {
    background-color: rgba(242, 242, 242, 0.5);
}

table.centered thead tr th,
table.centered tbody tr td {
    text-align: center;
}

.renglon tr {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}

.renglon td,
th {
    padding: 1px 2px;
    display: table-cell;
    text-align: left;
    vertical-align: middle;
    border-radius: 2px;
}
.renglon th {
	font-weight: bold;
text-align: -internal-center;
}

img {
	border: 0;
}
.wrapper {
	width: 100%;
	table-layout: fixed;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
}
.webkit {
	max-width: 600px;
}
.outer {
	Margin: 0 auto;
	width: 100%;
	max-width: 600px;
}
.full-width-image img {
	width: 100%;
	max-width: 600px;
	height: auto;
}
.inner {
	padding: 10px;
}
p {
	Margin: 0;
	padding-bottom: 10px;
}
.h1 {
	font-size: 21px;
	font-weight: bold;
	Margin-top: 15px;
	Margin-bottom: 5px;
	font-family: Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
}
.h2 {
	font-size: 18px;
	font-weight: bold;
	Margin-top: 10px;
	Margin-bottom: 5px;
	font-family: Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
}
.one-column .contents {
	text-align: left;
	font-family: Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
}
.one-column p {
	font-size: 14px;
	Margin-bottom: 10px;
	font-family: Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
}
.two-column {
	text-align: center;
	font-size: 0;
}
.two-column .column {
	width: 100%;
	max-width: 300px;
	display: inline-block;
	vertical-align: top;
}
.contents {
	width: 100%;
}
.two-column .contents {
	font-size: 14px;
	text-align: left;
}
.two-column img {
	width: 100%;
	max-width: 280px;
	height: auto;
}
.two-column .text {
	padding-top: 10px;
}
.three-column {
	text-align: center;
	font-size: 0;
	padding-top: 10px;
	padding-bottom: 10px;
}
.three-column .column {
	width: 100%;
	max-width: 200px;
	display: inline-block;
	vertical-align: top;
}
.three-column .contents {
	font-size: 14px;
	text-align: center;
}
.three-column img {
	width: 100%;
	max-width: 180px;
	height: auto;
}
.three-column .text {
	padding-top: 10px;
}
.img-align-vertical img {
	display: inline-block;
	vertical-align: middle;
}
@media only screen and (max-device-width: 480px) {
table[class=hide], img[class=hide], td[class=hide] {
	display: none !important;
}
.contents1 {
	width: 100%;
}
.contents1 {
	width: 100%;
}
</style>
<p align="right">{{ $content['produccion'][0]->fecha }}</p>
    </head>

    <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;">
<img src="{{asset('img/logo.png') }}" width="80" alt="Logo"  />
    <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">

        <table width="100%" cellpadding="0" cellspacing="0" border="0" >

            <tr>
                <td width="100%"><div class="webkit" style="max-width:90%;Margin:0 auto;">


                <p style="color:#262626; font-size:24px; text-align:center; font-family: Verdana, Geneva, sans-serif"><strong>{{ $content['produccion'][0]->nombre }} #{{ $content['produccion'][0]->folio }} </strong></p>

                    </div>
                    <h4>Fecha y Hora Aplicación</h4>

                    <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                        {{ $content['produccion'][0]->fecha_proceso }} {{ $content['produccion'][0]->hora_proceso }}
                    </p>
                    <br>
                    <table class="renglon">
                        <thead>
                            <tr>
                                <th>Lote</th>
                                <th>Cultivo</th>
                                <th>Superficie</th>
                                <th>Rancho</th>
                            </tr>
                        </thead>


                        <tbody>

                            <tr>
                                <td>{{ $content['produccion'][0]->lote }}</td>
                                <td>{{ $content['produccion'][0]->cosecha }}</td>
                                <td>{{ $content['produccion'][0]->superficie }}</td>
                                <td>{{ $content['produccion'][0]->rancho }}</td>

                            </tr>

                        </tbody>

                    </table>

                    <br />
                    <br />
                    <br />
                    <br />

                    <table class="renglon">
                            <thead>
                                <tr>
                                    <th>Artículo</th>
                                    <th>Dosis/HA</th>
                                    <th>U. Medida</th>
                                </tr>
                            </thead>


                            <tbody>

                                @foreach ($content['articulos_produccion'] as $articulo_produccion)
                                <tr>
                                    <td>{{ $articulo_produccion->nombre }}</td>
                                    <td>{{ $articulo_produccion->cantidad }}</td>
                                    <td>{{ $articulo_produccion->unidad_compra }}</td>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>

                <br>
                <br>
                <br>

                @if ( $content['count_usos_empleados'] > 0)
                <table class="renglon">
                    <thead>
                        <tr>
                            <th>Aplicador</th>
                            <th>Vía Aplicación</th>
                            <th>Horas de aplicación</th>
                            <th>Pozo</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>{{ $content['usos_empleados'][0]->aplicador }}</td>
                            <td>{{ $content['usos_empleados'][0]->via_aplicacion }}</td>
                            <td>{{ $content['usos_empleados'][0]->horas }}</td>
                            <td>{{ $content['usos_empleados'][0]->pozo }}</td>

                        </tr>

                    </tbody>

                </table>
                @endif
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />

                <p style="color:#000000; font-size:16px; text-align:left; font-family: Verdana, Geneva, sans-serif; line-height:22px ">
                    {{ $content['produccion'][0]->usuario_creacion }}
                    </p>
                    <h4>Creado por</h4> <br />

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

</body>

</html>
