@extends('layouts.applogin')
@section('title','Planners')
@section('content')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="{{ asset('faviico.ico') }}">
<link rel="stylesheet" href="{{asset('css/signup.css')}}">
<link rel="stylesheet" href="{{ asset('css/default.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<link rel="stylesheet" href="css/login.css">

<div class="container" id="container">

    {{--Form crear cuenta--}}
	<div class="form-container sign-up-container">
    <form action="{{route('CrearUsuario')}}" id="nuevoRegistro">
      @csrf
      <h3>Crear cuenta</h3>
      <div class="row"></div>
      <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario" />
      <span class="error"></span>
      <input type="text" name="empresa" id="empresa" placeholder="Nombre empresa" />
      <span class="error"></span>
      <input type="email" name="email" id="email" placeholder="Email" />
      <span class="error"></span>
      
      <div class="row"></div>
      <div class="row"></div>
      <button type="submit">Registrate</button>
    </form>
	</div>

    {{--Form ingresar--}}
	<div class="form-container sign-in-container">
		<form id="frm-login" method="POST" action="{{ route('login') }}">
      @csrf
      {{--<div class="form-group row {{ $errors->has('nombre_corto') ? 'has-error' : ''}}" >--}}
          <h3>Ingresar</h3>
        
          
      <input id="email" type="email" placeholder="Correo" class="input-field form-control{{ $errors->has('nombre_corto') ? ' invalid' : '' }}" name="user" value="{{ old('user') }}" required {{ !$errors->has('password') ? 'autofocus' : '' }} >
      {!! $errors->first('nombre_corto', '<span class="help-block">:message</span>') !!}
    
    
          <input placeholder="Contraseña" id="password" type="password" class="form-control{{ $errors->has('password') ? ' invalid' : '' }}" name="password" required {{ $errors->has('password') ? 'autofocus' : '' }}>
      {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
      <div class="row"></div>
      
          <a href="{{route('getcorreo')}}">Olvide mi contraseña</a>
          <button waves-light red>Ingresar</button>
    </form>
		<ul>
			@foreach ($errors as $error)
				<li> {{$error}} </li>
			@endforeach
		</ul>
	</div>
{{--=========================================================================================--}}


	<div class="overlay-container">
		<div class="overlay">
            {{--Texto panel registrarse--}}
			<div class="overlay-panel overlay-left">
				<h3>Ya eres un planner?</h3>
				<p>Ingresa a tu cuenta!</p>
				<button class="ghost" id="signIn">Ingresar</button>
			</div>
            {{--Texto panel Login--}}
			<div class="overlay-panel overlay-right">
				<h3>Hola planner!</h3>
				<p>No tienes cuenta?</p>
                <div class="row"></div>
				<button class="ghost" id="signUp">Registrate</button>
			</div>

		</div>
	</div>

</div>

<script>
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
</script>
                
    
            
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!--script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script-->

<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script src="{{ asset('js/login.js') }}"></script>
@endsection