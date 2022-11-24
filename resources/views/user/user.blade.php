@extends('app')

@section('title', 'Usuarios')


@section('content')

<!-- Modal Structure Editar Usuario-->
<form id ="frm-edituser" method="post" enctype="multipart/form-data" novalidate="novalidate" action="/editarusuario">
	<div id="mdl-edituser" class="modal modal-fixed-footer">

		<div class="modal-content">

			<h4>Editar Usuario</h4>
			<input id="edit_item_id" type="hidden" name="edit_item_id">
			<div class="row">
				<div class="input-field col s12">
					<input id="nombreusuario" name="nombreusuario" type="text" class="validate" activerequired>
					<label class="active" for="nombreusuario">Nombre</label>
				</div>
				<div class="input-field col s12">
					<input id="correousuario" type="text" name="correousuario" class="validate" disabled>
					<label class="active" for="correousuario">Correo</label>
				</div>
				<div class="col s12">
					<select id="slc-rol" name="rolusuario" class="error browser-default" required>
						<option value="" disabled selected>Selecciona una opción</option>
						@foreach ($content['roles'] as $rol)
						<option value="{{$rol->usuario_id}}">{{$rol->nombre}}</option>
						@endforeach
					</select>
					<label>Permisos</label>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
			<button form="frm-edituser" type="submit" class="waves-effect waves-light btn">Actualizar</button>

		</div>

	</div>
</form>
<!-- Fin Editar Usuario-->

<!-- Modal Structure Nuevo Usuario-->
	<form id ="frm-newuser" method="post" enctype="multipart/form-data" action="/nuevousuario">
<div id="mdl-new-user" class="modal modal-fixed-footer">

		<div class="modal-content">
			<h4>Nuevo Usuario</h4>
			<div class="row">
				<div class="input-field col s12">
					<input id="nuevonombreusuario" name="nuevonombreusuario" type="text"   >
					<label for="nuevonombreusuario">Nombre</label>
				</div>
				<div class="input-field col s12">
					<input id="nuevocorreousuario" type="text" name="nuevocorreousuario"  >
					<label for="nuevocorreousuario">Correo</label>
				</div>
				<div class="col s12">
					<select id="nuevoslc-rol" name="nuevorolusuario" class="error browser-default">
						<option value="" disabled selected>Selecciona un rol</option>
						@foreach ($content['roles'] as $rol)
						<option value="{{$rol->usuario_id}}">{{$rol->nombre}}</option>
						@endforeach
					</select>
					<label>Permisos</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
			<button form="frm-newuser" type="submit" class="waves-effect waves-light btn">Agregar</button>
		</div>
</div>
	</form>
<!-- Fin Nuevo Usuario-->

<div class="card">
	<div class="card-content">


		<table class="display" id="tableRequisitions">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Rol</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach ($content['usuarios'] as $usuario)
				<tr>
					<td>{{ $usuario->nombre }}</td>
					<td>{{ $usuario->correo }}</td>
					<td>{{ $usuario->rol }}</td>
					<td>
						<i class="material-icons tooltipped btn-edituser" href="#mdl-edituser" data-tooltip="Editar" id-record="{{ $usuario->usuario_web_id }}">create</i>
					</td>
				</tr>
				@endforeach






			</tbody>
		</table>
	</div>
</div>

<!-- Botón -->
<div class="fixed-action-btn" >
	<a class="btn-floating btn-large waves-green waves-effect waves-light tooltipped green modal-trigger" href="#mdl-new-user" data-position="top" data-tooltip="Nuevo usuario">
		<i class="large material-icons">add</i>
	</a>
</div>

@endsection


@push('scripts')
<script src="{{ asset('js/user.js') }}"></script>
<script type="text/javascript">
var content = @json( $content['usuarios']);
</script>
@endpush
