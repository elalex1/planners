<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>

  <body>


    <div class="valign-wrapper" style="width:100%;height:100%;position: absolute;">
        <div class="valign" style="width:100%;">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 offset-m3">
                        <div class="card">
                            <div class="card-content">
                               <span class="card-title black-text">Recuperar Contraseña</span>
                               <div class="row"></div>
                               <p>Ingresa tu correo para enviarte un codigo de confirmacion</p>
                               <div class="row"></div>
                               
                               <form action=" {{route('ResetPost')}} " method="post">
                                    @csrf
                                  <div class="row">
                                     <div class="input-field col s12">
                                        <input id="Correo" type="text" class="validate" name="correo">
                                        <label for="Correo" class="active">Correo Electronico</label>
                                     </div>
                                  </div>
                            </div>
                            
                            <div class="card-action center-align">
                               <input type="submit" class="btn" value="Mandar codigo de confirmacion">
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  </body>
</html>
