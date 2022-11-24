@extends('app')



@section('title', 'Requisiciones')





@section('content')





<div class="card">

	<div class="card-content">



		<table class="display responsive" id="tableRequisitions" width="100%">

			<thead>

				<tr>

					<th data-priority="1">Fecha</th>

					<th data-priority="4">Descripción</th>

					<th data-priority="3">Estatus</th>

					<th data-priority="2">Autorizado</th>

					<th data-priority="6">Creado por</th>

					<th data-priority="5"></th>

				</tr>

			</thead>



			<tbody>

				@foreach ($content['requisiciones'] as $requisicion)

				<tr>

					<td>{{ $requisicion->fecha }}</td>

					<td><p class="descripcion tooltipped" data-tooltip="{{ $requisicion->descripcion }}">{{ $requisicion->descripcion }}</p></td>

					<td>

						@switch($requisicion->estatus)

						@case('Pendiente')

						<span class="status text-pending">•</span>

						@break



						@case('Terminado')

						@if ($requisicion->autorizado == 'Si')

						<span class="status text-authorized">•</span>

						@else

						<span class="status text-finished">•</span>

						@endif

						@break



						@case('Cancelado')

						<span class="status text-cancel">•</span>

						@break

						@endswitch



						{{ $requisicion->estatus }}

					</td>

					<td>{{ $requisicion->folio }}</td>

					<td>{{ $requisicion->usuario_creacion }}</td>

					<td>



						@switch($requisicion->estatus)

						@case('Pendiente')

						<i class="material-icons edit-record tooltipped" data-tooltip="Editar" id-record="{{ $requisicion->docto_requisicion_id }}" >edit</i>

						<i class="material-icons disabled-btn tooltipped" data-tooltip="La requisición debe estar terminada">email</i>

						<i class="material-icons disabled-btn tooltipped"  data-tooltip="La requisición debe estar autorizada" >picture_as_pdf</i>

						<i class="material-icons disabled-btn tooltipped"  data-tooltip="La requisición debe estar autorizada" >image</i>

							@if (Session::get('rol') == 'Administrador')

								<i class="material-icons disabled-btn tooltipped"  data-tooltip="La requisición debe estar terminada" >check_box</i>

							@endif

						@break

						@case('Terminado')

						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La requisición debe estar pendiente">edit</i>



						@if ($requisicion->autorizado == 'Si')

						<i class="material-icons disabled-btn tooltipped" data-tooltip="La requisición debe estar sin autorizar" >email</i>

						<a class="pdf-record" target="_blank" href="{{ route('pdf',  $requisicion->docto_requisicion_id) }}">

							<i class="material-icons tooltipped"  data-tooltip="Descargar PDF"  id-record="{{ $requisicion->docto_requisicion_id }}" >picture_as_pdf</i>

						</a>

						<a class="img-record" href="{{ route('soporte',  $requisicion->docto_requisicion_id) }}">

							<i class="material-icons tooltipped"  data-tooltip="Subir imágenes"  id-record="{{ $requisicion->docto_requisicion_id }}" >image</i>

						</a>



							@if (Session::get('rol') == 'Administrador')

								<i class="material-icons disabled-btn tooltipped"  data-tooltip="La requisición debe estar sin autorizar" >check_box</i>

							@endif



						@else

						<i class="material-icons email-record tooltipped" data-tooltip="Enviar e-mail autorización" id-record="{{ $requisicion->docto_requisicion_id }}" >email</i>

						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La requisición debe estar autorizada" >picture_as_pdf</i>

						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La requisición debe estar autorizada" >image</i>

								@if (Session::get('rol') == 'Administrador')

								<a class="auth-record" href="{{ route('autoriza',  $requisicion->docto_requisicion_id) }}">

										<i class="material-icons tooltipped"  data-tooltip="Autorizar"  id-record="{{ $requisicion->docto_requisicion_id }}" >check_box</i>

								</a>

								@endif

						@endif

						@break



						@case('Cancelado')

						<i  class="material-icons disabled-btn" id-record="{{ $requisicion->docto_requisicion_id }}" >edit</i>

						<i  class="material-icons disabled-btn" id-record="{{ $requisicion->docto_requisicion_id }}" >email</i>

						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La requisición debe estar autorizada" >picture_as_pdf</i>

						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La requisición debe estar autorizada" >image</i>

						@if (Session::get('rol') == 'Administrador')

						<i class="material-icons tooltipped disabled-btn"  data-tooltip="La requisición debe estar terminada" >check_box</i>

						@endif

						@break



						@endswitch

						<i class="material-icons view-record tooltipped" data-tooltip="Visualizar" id-record="{{ $requisicion->docto_requisicion_id }}">remove_red_eye</i>

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

	<a class="btn-floating btn-large waves-green waves-effect waves-light tooltipped  " href="requisicion/nueva" data-position="top" data-tooltip="Nueva requisición">

		<i class="large material-icons">add</i>

	</a>

</div>





<!-- Modal Structure Visualizar Requisicion-->

<div id="modal5" class="modal modal-fixed-footer">

	<div class="modal-content">

		<div id="modal-contenido" class="responsive-video">

			<iframe id="if-requisicion" width="100%" height= "calc(100% - 56px)" max-height="100%" src="" frameborder="0" allowfullscreen></iframe>



		</div>

	</div>

	<div class="modal-footer">

		<a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>

	</div>

</div>

<!-- Fin Visualizar Requisicion-->









</form>









@endsection





@push('scripts')

<script type="text/javascript">



var path_url_iframe = "{{ route('ver-auth', 1) }}";

//requisiciones

//enviar email pdf autorizado

var path_url_sendemail_auth = "{{ route('sendpdf') }}";

var path_url_sendemail = "{{ route('sendemail') }}";

var path_url_apprequisition = '{{ route('apprequisition') }}';

var path_url_authrequisition = '{{ route('autorizar') }}';

var path_url_cancelrequisition = '{{ route('cancelar') }}';

var path_url_requisitionimages = '{{ route('images') }}';

var path_url_deleteimages = '{{ route('del-images') }}';

var path_url_costsbytype = "{{ route('costsbytype') }}";

var path_url_objective = "{{ route('searchobjective') }}";





@if ($content['status_password'][0]->status_password == 0)

$(window).on('load', function() {

	setTimeout(function() {

		var elem = document.getElementById("modal6");

		var modal = M.Modal.getInstance(elem);

		modal.open();

	}, 1000);

});

@endif



</script>

@endpush

