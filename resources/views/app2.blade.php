<!DOCTYPE html>
<html>

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mega Fresh Produce - @yield('title')</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/application.css') }}">
  <link rel="stylesheet" href="{{ asset('css/activity.css') }}">
  <link rel="stylesheet" href="{{ asset('css/providerarticle.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dropify.min.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<body>
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->
  @section('header')
  <header class="teal">
    <nav class="teal top-nav">
      <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <div class="nav-wrapper" style="padding: 0% 2%;">
        <h5 >@yield('title')</h5>
      </div>
    </nav>
    @section('menu')
        @include('template.menu')
    @show

  </header>
  @show


  <main>

    <div class="container-main">
      @yield('content')
    </div>
  </main>

  @section('footer')
    @include('template.footer')
	@show

</body>

<script type="text/javascript">
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

//aplicaciones
var path_url_lots = "{{ route('lots') }}";

//Actividades
var path_url_lots_activity = "{{ route('lotsact') }}";
var path_url_groupsbyterm = "{{ route('groupsbyterm') }}";
var path_url_activity = "{{ route('actividades') }}";
var path_url_submit_empl = "{{ route('submitempleado') }}";
var path_url_sendemail_act = "{{ route('sendemailact') }}";



//Artículos Proveedores
var path_url_providers = "{{ route('providers') }}";
var path_url_search_prov = "{{ route('searchproviders') }}";
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('js/production.js') }}"></script>
<script src="{{ asset('js/activity.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/providerarticle.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/json2/20160511/json2.js"></script>
<script src="{{ asset('js/dropify.min.js') }}"></script>

 @stack('scripts')
</html>
