@extends('app')
@section('title','Inicio')
@section('content')
{{--Mensaje de bienvenida--}}
<div class="row">
  <div class="col s12 m12">
    <div class="card White">
      <div class="card-content">
        <span class="card-title" id="saludo"></span>
        <blockquote id="mensaje"></blockquote>
      </div>
    </div>
  </div>

{{--Dashboard--}}


  <div class="col s4">
    <div class="card white">
      <div class="card-content">
        <span class="card-title">Proyectos</span>
        <p>puedo poner aqui lo de cotizaciones o no se xd.</p>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quidem sit numquam ab iste quos. Minus rerum temporibus blanditiis numquam et, architecto error! Sunt, culpa ipsam quae quo dolore minima!</p>      
</div>
      
    </div>
  </div>

  <div class="col s4">
    <div class="card white">
      <div class="card-content">
        <span class="card-title">Facturas</span>
        <p>I am a very simple card.</p>
      </div>
      
    </div>
  </div>

  <div class="col s4">
    <div class="card white">
      <div class="card-content">
        <span class="card-title">Tareas</span>
        <p>I am a very simple card.</p>
      </div>
     
    </div>
  </div>

  <div class="col s4">
    <div class="card white">
      <div class="card-content">
        <span class="card-title">Calendario</span>
        <p>I am a very simple card.</p>
      </div>
      
    </div>
  </div>

  <div class="col s4">
    <div class="card white">
      <div class="card-content">
        <span class="card-title">Reportes</span>
        <p>I am a very simple card.</p>
      </div>
      
    </div>
  </div>


  
  
</div>

{{--Script--}}

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  

<script type="text/javascript">
console.log("Hola")
  $(document).ready(function() {
 var hoy = new Date();
 var hora = hoy.getHours();
 console.log(hora);
 var fecha = "";
 var mensaje= "";
 nombre = '{{Session::get('nombre')}}';
 console.log(nombre);
 
 if(hora > 5 && hora<12){
         var fecha = "Buenos dias";
         var mensaje= "Es buena momento tomar una taza de cafe para empezar el dia!";
     }
     else if (hora > 11 && hora<20){
         var fecha = "Buenas tardes";
         var mensaje= "Como va tu dia?";
     }
     else if (hora > 19 && hora<25){
         var fecha = "Buenas Noches";
         var mensaje= "Descanza";
     }
     else if (hora > -1  && hora<6){
         var fecha = "Buenas Madrugadas";
         var mensaje= "Ya duermete ";
     }
 
     document.getElementById('saludo').innerHTML = fecha + " " + nombre ;
     document.getElementById('mensaje').innerHTML = mensaje;
     
  });
 </script>

    
@endsection
 