@extends('layouts.proceso')
@section('title', 'Planersmexico.com')
@section('content')
    <div class="row">
        <div class="col s12">
            <div class="col l6 m8 s12 push-l3 push-m2">
                <div class="section planners">
                <div class="col s12 center">
                    <h3>Bienvenido a Planners</h3>
                </div>
                <div class="divider"></div>
                <div class="col s12 center">
                    <h4>Continuaremos con el proceso de registro dentro de la app</h4>
                    
                        <div class="card-image">
                            <img width="300px" height="200px" src="{{asset('icons/plannersMX1.jpg')}}" alt="">
                            {{--<i class="material-icons md-48" style="font-size: 200px;">mail</i>--}}
                        </div>
                        <h5>Revisa en correos no deseados en caso de no ver el Correo en tu buzón de Entrada</h5>
                        <div class="col s12 right-align" >
                            {{--<h6>Cuenta de correo electronico: planers@negocio.com</h6>--}}
                        </div>
                        <div class="row"></div>
                        <div class="col s12 center" >
                            {{$id = "123"}}
                            <button class="btn waves-effect waves-light planners"><a class="white-text" href="{{route('r')}}">Reenviar el Correo de Verificación</a></button>
                       
                        </div>

                    </div>
                    <div class="col s12"><br></div>
                </div>
            </div>
        </div>
    </div>
@endsection