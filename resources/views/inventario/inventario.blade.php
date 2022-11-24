@extends('app')



@section('title', 'Inventario - ' . $content['tipo_inventario'])



@push('css')



<link rel="stylesheet" href="{{ asset('css/inventory.css') }}">



@endpush



@section('content')





<div class="card">

	<div class="card-content">



		<table class="display responsive" id="tableInventory" width="100%">

			<thead>

				<tr>

					<th data-priority="1">Fecha</th>

					<th data-priority="2">Folio</th>

					<th>Almacen</th>

					<th data-priority="6">Concepto</th>

					<th data-priority="4">Descripción</th>

					<th data-priority="3">Estatus</th>

					<th data-priority="7">Creado por</th>

					<th data-priority="5"></th>

				</tr>

			</thead>



			<tbody>

				@foreach ($content['inventarios'] as $inventario)

				<tr>

					<td>{{ $inventario->fecha }}</td>

					<td>{{ $inventario->folio }}</td>

					<td>{{ $inventario->almacen }}</td>

					<td>{{ $inventario->concepto }}</td>

					<td><p class="descripcion tooltipped" data-tooltip="{{ $inventario->descripcion }}">{{ $inventario->descripcion }}</p></td>

					<td>

						@switch($inventario->estatus)

						@case('Pendiente')

						<span class="status text-pending">•</span>

						@break



						@case('Normal')

						<span class="status text-authorized">•</span>

						@break



						@case('Cancelado')

						<span class="status text-cancel">•</span>

						@break

						@endswitch



						{{ $inventario->estatus }}

					</td>

					<td>{{ $inventario->usuario }}</td>

					<td>

						@switch($inventario->estatus)

						@case('Pendiente')

						<a class="pdf-record" href="{{ route('editinv',['tipo_inventario'=>$content['tipo_inventario'],'id'=>$inventario->docto_inventario_id]) }}">

							<i class="material-icons tooltipped" data-tooltip="Editar" >edit</i>

						</a>

						<i class="material-icons disabled-btn tooltipped"  data-tooltip="El documento debe estar en estatus normal" >picture_as_pdf</i>

						@break

						@case('Normal')

						<i class="material-icons tooltipped disabled-btn"  data-tooltip="El documento debe estar pendiente">edit</i>

						<a class="pdf-record" target="_blank" href="{{ route('pdfinv',  $inventario->docto_inventario_id) }}">

							<i class="material-icons tooltipped"  data-tooltip="Descargar PDF"  id-record="{{ $inventario->docto_inventario_id }}" >picture_as_pdf</i>

						</a>



						@break



						@case('Cancelado')

						<i  class="material-icons disabled-btn" id-record="{{ $inventario->docto_inventario_id }}" >edit</i>

						<i class="material-icons tooltipped disabled-btn"  data-tooltip="El documento debe estar en estatus normal" >picture_as_pdf</i>

						@break



						@endswitch

						<i class="material-icons view-record-inv tooltipped" data-tooltip="Visualizar" id-record="{{ $inventario->docto_inventario_id }}">remove_red_eye</i>

					</td>

				</tr>

				@endforeach



			</tbody>

		</table>







	</div>

</div>

</div>

<!-- Botón -->

<div class="fixed-action-btn" >

	<a class="btn-floating btn-large waves-green waves-effect waves-light tooltipped" href="{{ $content['tipo_inventario']}}/nuevo" data-position="top" data-tooltip="Nuevo Movimiento">

		<i class="large material-icons">add</i>

	</a>

</div>





<!-- Modal Structure Visualizar Inventario-->

<div id="modal5" class="modal modal-fixed-footer">

	<div class="modal-content">

		<div id="modal-contenido" class="responsive-video">

			<iframe id="if-inventory" width="100%" height= "calc(100% - 56px)" max-height="100%" src="" frameborder="0" allowfullscreen></iframe>



		</div>

	</div>

	<div class="modal-footer">

		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>

	</div>

</div>

<!-- Fin Visualizar Inventario-->





<a href="#"></a>











@endsection





@push('scripts')

<script type="text/javascript">



</script>

@endpush

