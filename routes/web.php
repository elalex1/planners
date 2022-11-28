<?php



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/

use App\Http\Middleware\ValidateSignature;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\RequisitionController;

//=====================================================

use App\Http\Controllers\Catalogos\EmpleadosController;
use App\Http\Controllers\Catalogos\ClientesController;
use App\Http\Controllers\UserController;

/*######################################################################################################*/

/****                                  CLEAR CACHE                                                   ****/

/*######################################################################################################*/

  Route::get('/clear-cache', function() {

      $exitCode = Artisan::call('cache:clear');

      return '<h1>Cache facade value cleared</h1>';

  });



  //Reoptimized class loader:

  Route::get('/optimize', function() {

      $exitCode = Artisan::call('optimize');

      return '<h1>Reoptimized class loader</h1>';

  });



  //Route cache:

  Route::get('/route-cache', function() {

      $exitCode = Artisan::call('route:cache');

      return '<h1>Routes cached</h1>';

  });



  //Clear Route cache:

  Route::get('/route-clear', function() {

      $exitCode = Artisan::call('route:clear');

      return '<h1>Route cache cleared</h1>';

  });



  //Clear View cache:

  Route::get('/view-clear', function() {

      $exitCode = Artisan::call('view:clear');

      return '<h1>View cache cleared</h1>';

  });



  //Clear Config cache:

  Route::get('/config-cache', function() {

      $exitCode = Artisan::call('config:cache');

      return '<h1>Clear Config cleared</h1>';

  });

/*######################################################################################################*/

/****                                URL'S OUT OF MIDLWARE                                           ****/

/*######################################################################################################*/

  //Requisiciones

  Route::get('email/{id}', 'RequisitionController@EmailView')->name('email');
//======================================================================================
Route::get('userempresa', [UserController::class, 'index'])->name('usuarioempresa');
Route::get('usess', [LoginController::class, 'CrearUsuario'])->name('getcorreo');

//=======================================================================================

  //Login

  //Route::post('login', 'LoginController@Login')->name('login');

  Route::post('login',[LoginController::class, 'Login'])->name('login');



  Route::get('logout', [LoginController::class, 'Logout'])->name('logout');

//=================================================================================================================================

Route::get('crearusuario', [LoginController::class, 'CrearUsuario'])->name('CrearUsuario');
Route::get('/reenviarcorreo{id}', [LoginController::class, 'ReenviarCorreo'])->name('ReenviarCorreo');
Route::get('/reenviarcorreo', [LoginController::class, 'r'])->name('r');
Route::get('/correoconfirmacion{id}', [LoginController::class, 'ConfirmarCorreo'])->name('ConfirmarCorreo');
Route::post('/crearcontrasena{id}', [LoginController::class, 'CrearContraseña'])->name('crearcontrasena');
Route::get('ExportEmpleados', [EmpleadosController::class, 'ExportEmpleados'])->name('ExportEmpleados');
Route::post('ImportEmpleados', [EmpleadosController::class, 'ImportEmpleados'])->name('ImportEmpleados');
Route::get('clientes', [ClientesController::class, 'index'])->name('Clientes');
//=================================================================================================================================

//=======================================================================//
//                        Clientes                                       //
//=======================================================================//

Route::get('clientes', [ClientesController::class, 'index'])->name('Clientes');
Route::get('exportClientes', [ClientesController::class, 'ExportClientes'])->name('ExportClientes');
Route::post('importClientes', [ClientesController::class, 'ImportClientes'])->name('ImportClientes');

  Route::get('/', function () {



  //phpinfo();

      if (\Session::get('user') === null) {

        return view('login');

        //return view('mantenimiento');

      }else{

        if (\Session::get('rol') === "Administrador") {

          return redirect('inicio');

        }else{

          return redirect('inicio');

        }

      }

  })->name('home');



  //Actividades

  Route::get('email/{id}', 'ActivityController@EmailView')->name('emailact');

  Route::get('ordencompra/email/{id}', 'Compras\OrdenesComprasController@EmailView')->name('sendemailordencompraview');

  Route::get('cotizacion/pdf/{id}','Compras\CotizacionesController@CotizacionPDF')->name('cotizaciones_pdf');





  //Route::group(['middleware' => ['Auth']], function(){



  Route::view('/inicio', 'inicio');

/*######################################################################################################*/

/****                                  REQUISICIÓN                                                   ****/

/*######################################################################################################*/

  //Requisiciones



 
  Route::get('requisicion', [RequisitionController::class, 'Requisition'])->name('requisicion');

  //Boton autoriza requisicion

  //Route::post('requisicion/autorizar', 'RequisitionController@AuthRequisition')->where('id', '[0-9]+')->name('autorizar');
  Route::post('requisicion/autorizar', [RequisitionController::class, 'AuthRequisition'])->where('id', '[0-9]+')->name('autorizar');


  Route::post('requisicion/cancelar', 'RequisitionController@CancelRequisition')->name('cancelar');
  Route::post('requisicion/cancelar', [RequisitionController::class, 'CancelRequisition'])->name('cancelar');


  Route::get('requisicion/nueva', 'RequisitionController@NewRequisition')->name('nueva');
  //Route::get('', [UserController::class, 'index'])->name('user.index');


  Route::post('requisicion/submit', 'RequisitionController@SubmitRequisition')->name('submit');



  Route::post('requisicion/update',  'RequisitionController@UpdateRequisition');

  //Route::post('requisicion/update', [RequisitionController::class,'UpdateRequisition']);



  Route::post('requisicion/submitarticles', 'RequisitionController@NewRequisitionDetail')->name('submitarticles');



  Route::post('requisicion/images', 'RequisitionController@RequisitionImagen')->name('images');



  Route::get('requisicion/edit/{id}', 'RequisitionController@EditRequisition')->where('id', '[0-9]+');



  Route::post('requisicion/deletearticle', 'RequisitionController@DeleteArticle');



  Route::post('requisicion/articles', 'RequisitionController@GetArticlesRequisition');



  Route::post('requisicion/articlesbytype', 'RequisitionController@GetArticlesRequisitionByType');



  Route::get('requisicion/costsbytype/{parameter?}', 'RequisitionController@GetCostsByType')->name('costsbytype');



  Route::post('requisicion/sendemail', 'RequisitionController@SendEmail')->name('sendemail');



  Route::post('requisicion/apply', 'RequisitionController@AppRequisition')->name('apprequisition');

  ///ruta pdf

  Route::get('pdf/{id}', 'RequisitionController@PDFView')->name('pdf');



  Route::post('requisicion/sendpdf', 'RequisitionController@SendEmailPDFAuth')->name('sendpdf');

  //ver

  Route::get('requisicion/ver/{id}', 'RequisitionController@VerRequisition')->where('id', '[0-9]+')->name('ver-auth');

  //autoriza

  Route::get('requisicion/autoriza/{id}', 'RequisitionController@AutorizaRequisition')->where('id', '[0-9]+')->name('autoriza');



  Route::post('requisicion/deleteimage', 'RequisitionController@DeleteImage')->name('del-images');



  Route::post('cambiapassword', 'RequisitionController@CambiarPassword');

  Route::post('cambiarpassword', [RequisitionController::class, 'ChangePassword'])->name('CambiarPassword');

Route::post('user', 'UserController@index')->name('user');

  Route::get('requisicion/soporte/{id}', 'RequisitionController@SupportRequisitionCompleted')->where('id', '[0-9]+')->name('soporte');



  Route::get('requisicion/particion/{id}', 'RequisitionController@PartitionRequisition')->where('id', '[0-9]+')->name('particion');



  Route::post('requisicion/particionar', 'RequisitionController@PartitionRequisitionDetail')->name('particionar');



  Route::get('requisicion/reporterequisicion', 'RequisitionController@BitacoraRequisicion')->name('reporterequisicion');

/*######################################################################################################*/

/****                                     USUARIO                                                    ****/

/*######################################################################################################*/

  //Usuarios

  Route::get('usuarios', 'UserController@User')->name('usuario');



  Route::post('editarusuario', 'UserController@EditUser');



  Route::post('nuevousuario', 'UserController@NewUser');

/*######################################################################################################*/

/****                                   APLICACION                                                   ****/

/*######################################################################################################*/

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



  // Aplicaciones agroquímicos



  Route::get('aplicacion', 'ApplicationController@Application')->name('aplicacion');



  Route::get('aplicacion/nueva', 'ApplicationController@NewApplication')->name('nuevaaplicacion');



  Route::get('aplicacion/lotes/{parameter?}', 'ApplicationController@GetLots')->name('lots');



  Route::post('aplicacion/loteinfo/{parameter?}', 'ApplicationController@GetLotInfo')->name('lotinfo');



  Route::post('aplicacion/submitapp', 'ApplicationController@SubmitApplication')->name('submitapp');



  Route::get('aplicacion/edit/{id}', 'ApplicationController@EditApplication')->where('id', '[0-9]+');



  Route::get('aplicacion/receta/{id}{receta}', 'ApplicationController@AplicaReceta')->where('id', '[0-9]+')->name('aplicareceta');



  Route::post('aplicacion/submitarticlesapp', 'ApplicationController@NewApplicationDetail')->name('submitarticlesapp');



  Route::get('aplicacion/ver/{id}', 'ApplicationController@ViewApplication')->where('id', '[0-9]+')->name('ver-app');



  Route::post('aplicacion/deletearticle', 'ApplicationController@DeleteArticle');



  Route::post('aplicacion/apply', 'ApplicationController@AppApplication')->name('appapplication');



  Route::post('aplicacion/receta', 'ApplicationController@AppReceta')->name('appreceta');



  Route::get('aplicacion/pdf/{id}', 'ApplicationController@PDFView')->name('apppdf');



  Route::get('aplicacion/searchobjective', 'ApplicationController@SearchObjective')->name('searchobjective');



  Route::post('aplicacion/objectiveinfo', 'ApplicationController@ObjectiveInfo')->name('objectiveinfo');

  //Bitácora plaguicidas

  Route::get('aplicacion/bitacoraplaguicida/{fechas?}', 'ApplicationController@BitacoraPlaguicida')->name('bitacoraplaguicida');

  //Bitácora fertilizantes

  Route::get('aplicacion/bitacorafertilizante/{folio?}', 'ApplicationController@BitacoraFertilizante')->name('bitacorafertilizante');

  //Reporte fertilizantes NPK

  Route::get('aplicacion/fertilizantenpk/{folio?}', 'ApplicationController@FertilizanteNPK')->name('fertilizantenpk');

  //Reporte aplicaciones

  Route::get('aplicacion/reporteaplicacion', 'ApplicationController@ReporteAplicacion')->name('reporteaplicacion');

  //Reporte de todas las aplicaciones con costo

  Route::get('aplicacion/reportecostos', 'ApplicationController@ReporteCostos')->name('reportecostos');



  Route::post('aplicacion/submitaplicador', 'ApplicationController@SubmitAplicador')->name('submitaplicador');

/*######################################################################################################*/

/****                                  ACTIVIDADES                                                   ****/

/*######################################################################################################*/



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



  // Actividades



  Route::get('actividad/manoobra', 'ActivityController@Activity')->name('actividad');



  Route::get('actividad/manoobra/nueva', 'ActivityController@NewActivity')->name('nuevaactividad');



  Route::get('actividad/manoobra/edit/{id}', 'ActivityController@EditActivity')->where('id', '[0-9]+');



  Route::post('actividad/manoobra/apply', 'ActivityController@AppActivity')->name('appactivity');



  Route::get('actividad/manoobra/ver/{id}', 'ActivityController@ViewActivity')->where('id', '[0-9]+')->name('ver-act');



  Route::get('actividad/manoobra/lotes/{parameter?}', 'ActivityController@GetLots')->name('lotsact');



  Route::get('actividad/manoobra/groupsbytype/{parameter?}', 'ActivityController@GetGroupsByType')->name('groupsbyterm');



  Route::post('actividad/manoobra/submitact', 'ActivityController@SubmitActivity')->name('submitact');



  Route::get('actividad/manoobra/actividades/{parameter?}', 'ActivityController@GetActivities')->name('actividades');



  Route::post('actividad/manoobra/submitlotact', 'ActivityController@SubmitLotActivity')->name('submitlotact');



  Route::post('actividad/manoobra/submitpaselista', 'ActivityController@SubmitList')->name('submitpaselista');



  Route::post('actividad/manoobra/submitempleado', 'ActivityController@SubmitEmployee')->name('submitempleado');



  Route::post('actividad/manoobra/sendemail', 'ActivityController@SendEmail')->name('sendemailact');



  Route::get('actividad/manoobra/autoriza/{id}', 'ActivityController@AutorizaActivity')->where('id', '[0-9]+')->name('autorizaact');



  Route::get('actividad/manoobra/pdf/{id}', 'ActivityController@PDFView')->name('pdfact');



  Route::post('actividad/manoobra/sendpdf', 'ActivityController@SendEmailPDFAuth')->name('sendpdfact');



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



  // Articulos Proveedores



  //Articulos Proveedor

  Route::get('proveedor/articulos/{id}/{estatus}', 'ProviderArticlesController@GetProviderArticles')->name('articulosproveedores');



  Route::get('proveedor/getproviders', 'ProviderArticlesController@GetProviders')->name('providers');



  Route::get('proveedor/searchproviders', 'ProviderArticlesController@SearchArticlesProvider')->name('searchproviders');



  Route::get('proveedor/articulo/{id}', 'ProviderArticlesController@GetProviderArticleData')->name('articulosproveedores');



  Route::post('proveedor/articulo/asignar', 'ProviderArticlesController@updateProviderArticle');





  //Inventarios



  Route::get('inventario/{tipo}', 'InventoryController@Inventory')->name('inventory');;



  Route::get('inventario/nuevo', 'InventoryController@NewInventory');

/*######################################################################################################*/

/****                                       COMPRA                                                   ****/

/*######################################################################################################*/

  /****************************************************************************************************************/

  /****                                  Cotizaciones                                                          ****/

  /****************************************************************************************************************/

  Route::get('cotizacion','Compras\CotizacionesController@CotizacionGetAll')->name('cotizaciones_all');

  Route::get('cotizacion/nueva','Compras\CotizacionesController@CotizacionNew')->name('cotizaciones_nueva');

  Route::post('cotizacion','Compras\CotizacionesController@CotizacionStore')->name('cotizaciones_store');



  Route::get('cotizacion/editar/{id}','Compras\CotizacionesController@EditCotizacion')->name('cotizaciones_editar');

  //Route::put('cotizacion','Compras\CotizacionesController@CotizacionUpdate')->name('cotizaciones_update');

  //Route::get('cotizacion/recepciones','Compras\CotizacionesController@GetRecepcionesTerminadas')->name('cotizaciones_recepciones');

  Route::post('cotizacion/add_ligada','Compras\CotizacionesController@CotizacionAddLigada')->name('cotizaciones_compra_add');

  Route::post('cotizacion/add_articles','Compras\CotizacionesController@CotizacionAddArticles')->name('cotizacion_add_articles');

  Route::delete('cotizacion/remov_articles','Compras\CotizacionesController@CotizacionRemoveArticles')->name('cotizaciones_DeleteArticle');

  Route::post('cotizacion/finalizar','Compras\CotizacionesController@CotizacionFinalizar')->name('cotizaciones_finalizar');

  Route::get('cotizacion/ver/{id}','Compras\CotizacionesController@VerCotizacion')->name('cotizaciones_ver');

  Route::post('cotizacion/add_requisiciones','Compras\CotizacionesController@CotizacionAddRequs')->name('cotizaciones_agregar_requs');

  Route::get('cotizacion/contactosemail/{parameters?}','Compras\CotizacionesController@GetContactosProv')->name('cotizaciones_contactos_prov');

  Route::post('cotizacion/enviaremailprov','Compras\CotizacionesController@SendEmailProv')->name('cotizaciones_sendemail_prov');

  Route::post('cotizacion/cancelar','Compras\CotizacionesController@CotizacionCancelar')->name('cotizaciones_cancelar');

  

  /***********************************************************************************************************/

  /****                        Ordenes de compra                                                          ****/

  /***********************************************************************************************************/

  //Ordenes de compra---------------------------------

  //Route::get('/ordencompra',[OrdenesComprasController::class, 'OrdenesCompras'])->name('ordenescompras');

  Route::get('/ordencompra','Compras\OrdenesComprasController@OrdenesCompras')->name('ordenescompras');

  Route::get('/ordencompra/cotizaciones','Compras\OrdenesComprasController@OrdenesComprasGetCotizaciones')->name('ordenescompras_get_cotizaciones');

  Route::post('/ordencompra/cotizaciones','Compras\OrdenesComprasController@OrdenesComprasDesdeCotizacion')->name('ordenescompras_desde_cotizacion');



  Route::get('ordencompra/nueva', 'Compras\OrdenesComprasController@NewOrder')->name('nuevaOrden');



  Route::post('ordencompra/submit', 'Compras\OrdenesComprasController@SubmitOrdenCompra')->name('submit.ordencompra');



  Route::get('ordencompra/edit/{id}', 'Compras\OrdenesComprasController@EditOrdenCompra')->where('id', '[0-9]+')->name('ordencompra_editar');

 // Route::get('ordencompra/articulos',  'Compras\OrdenesComprasController@getArticulos')->name('get_articles_oc');

  Route::get('ordencompra/requisiciones','Compras\OrdenesComprasController@getRequisicionesparaordenes')->name('get_requisiciones_oc');



  Route::get('ordenescompras/selectcentproveedores/{parameter?}', 'Compras\OrdenesComprasController@OCCentrosCostos')->name('select.centroscostos');

  //Route::get('ordenescompras/selectcentroscostos/{parameter?}',['as'=>'select.centroscostos','uses'=>'OrdenesComprasController@OCCentrosCostos']);

  Route::post('ordencompra/submitarticles',  'Compras\OrdenesComprasController@NewOrdenCompraDet')->name('submitarticles_oc');



  Route::delete('ordencompra/edit/ordencompra/deletearticle',  'Compras\OrdenesComprasController@DeleteArticle')->name('ordencompra_DeleteArticle');



  Route::post('ordencompra/requisicionesbytype',  'Compras\OrdenesComprasController@GetRequisitionCompraByType');



  Route::get('ordencompra/ver/{id}',  'Compras\OrdenesComprasController@VerCompra')->where('id', '[0-9]+')->name('ver-auth-oc');



  Route::post('ordencompra/compra/update',  'Compras\OrdenesComprasController@UpdateCompra')->name('ordencompra_update');



  Route::post('ordencompra/agregarrequisicion', 'Compras\OrdenesComprasController@AgregarRequisition')->name('agregar_requ_ordencompra');



  Route::post('ordencompra/apply',  'Compras\OrdenesComprasController@AppOrdenCompra')->name('appordencompra');



  Route::post('ordencompra/sendemail',  'Compras\OrdenesComprasController@SendEmail')->name('sendemailordencompra');



  Route::get('ordencompra/autoriza/{id}', 'Compras\OrdenesComprasController@AutorizaOrdenCompra')->where('id', '[0-9]+')->name('autorizaordencompra');



  Route::post('ordencompra/autorizar', 'Compras\OrdenesComprasController@AuthOrdenCompra')->where('id', '[0-9]+')->name('autorizaroc');



  Route::post('ordencompra/cancelar', 'Compras\OrdenesComprasController@CancelOrdenCompra')->name('cancelarordencompra');



  Route::get('pdfordencompra/{id}', 'Compras\OrdenesComprasController@PDFView')->name('pdfordencompra');



  Route::post('ordencompra/sendpdf', 'Compras\OrdenesComprasController@SendEmailPDFAuth')->name('sendpdfordencompra');

  

  Route::get('pdfordencompraautorizado/{id}', 'Compras\OrdenesComprasController@PDFViewAuth')->name('pdfordencompraauth');

  

  /*******************************************************************************************************************************/

  /****                                             Recepción de Mercancía                                                    ****/

  /*******************************************************************************************************************************/

  Route::get('recepcionmercancia','Compras\RecepcionController@getVistaRecepciones')->name('recepcionmercancia');



  Route::get('recepcionmercancia/nueva','Compras\RecepcionController@vistaNuevaRecepcion')->name('recepcionmercancia_nueva');



  Route::post('recepcionmercancia/store','Compras\RecepcionController@saveNuevaRecepcion')->name('recepcionmercancia_store');



  Route::get('recepcionmercancia/edit/{id}','Compras\RecepcionController@editarNuevaRecepcion')->name('recepcionmercancia_editar');



  Route::post('recepcionmercancia/agregararticulos','Compras\RecepcionController@addRenglonNuevaRecepcion')->name('recepcionmercancia_addRenglon');



  Route::delete('recepcionmercancia/editar/eliminararticulo','Compras\RecepcionController@DeleteArticle')->name('recepcionmercancia_DeleteArticle');



  Route::put('recepcionmercancia/update','Compras\RecepcionController@updateNuevaRecepcion')->name('recepcionmercancia_update');



  Route::get('recepcionmercancia/verificarmoneda/{moneda}','Compras\RecepcionController@verificarMonedaNuevaRecepcion')->name('recepcionmercancia_verif_moneda');

  Route::get('recepcionmercancia/verificarproveedor/{proveedor}','Compras\RecepcionController@verificarproveedorRecepcion')->name('recepcionmercancia_verif_prov');

  Route::get('recepcionmercancia/ordenescompraporrecibir','Compras\RecepcionController@ordenescompraRecepcion')->name('recepcionmercancia_ordenescompra');



  Route::post('recepcionmercancia/ordenescompraporrecibir/agregar','Compras\RecepcionController@addOrdenescompraRecepcion')->name('recepcionmercancia_ordenescompra_add');



  Route::put('recepcionmercancia/finalizarrecepcion','Compras\RecepcionController@RecepcionFinalizar')->name('recepcionmercancia_finalizar');



  Route::put('recepcionmercancia/cancelarrecepcion','Compras\RecepcionController@cancelarRecepcion')->name('recepcionmercancia_cancelar');

  Route::post('recepcionmercancia/recepcionimagen','Compras\RecepcionController@RecepcionImagen')->name('recepcionmercancia_doctos');

  Route::delete('recepcionmercancia/recepcionimagendelete','Compras\RecepcionController@RecepcionImagenDelete')->name('recepcionmercancia_doctos_delete');



  //Route::put('recepcionmercancia/finalizarligada','Compras\RecepcionController@finalizarRecepcionligada')->name('recepcionmercancia_finalizarligada');

  Route::get('recepcionmercancia/visualizar/{id}','Compras\RecepcionController@visualizarRecepcion')->name('recepcionmercancia_visualizar');

  Route::get('recepcionmercancia/pdf/{id}','Compras\RecepcionController@PDFView')->name('recepcionmercancia_pdf');

  Route::post('recepcionmercancia/actualizarlote','Compras\RecepcionController@guardarLote')->name('recepcionmercancia_actualizarlote');

   /******************************************************************************************************/

  /****                       Devolucion de Recepción                                                         ****/

  /******************************************************************************************************/

  Route::get('devrecepcionmercancia','Compras\DevRecepcionesController@DevRecepcionGetAll')->name('devrecepcionmercancia_all');

  Route::get('devrecepcionmercancia/nueva','Compras\DevRecepcionesController@DevRecepcionNew')->name('dev_recepciones_nueva');

  Route::post('devrecepcionmercancia','Compras\DevRecepcionesController@DevRecepcionStore')->name('dev_recepciones_store');

  Route::get('devrecepcionmercancia/edit/{id}','Compras\DevRecepcionesController@DevRecepcionEdit')->name('dev_recepciones_editar');

  Route::put('devrecepcionmercancia','Compras\DevRecepcionesController@DevRecepcionUpdate')->name('dev_recepciones_update');

  Route::post('devrecepcionmercancia/recepciones','Compras\DevRecepcionesController@DevRecepcionDesdeRecepcion')->name('dev_recepciones_desde_recepcion');

  //Route::post('cotizacion/add_ligada','Compras\CotizacionesController@CotizacionAddLigada')->name('cotizaciones_compra_add');

  Route::post('devrecepcionmercancia/add_articles','Compras\DevRecepcionesController@DevRecepcionAddArticles')->name('dev_recepciones_add_articles');

  Route::delete('devrecepcionmercancia/remov_articles','Compras\DevRecepcionesController@DevRecepcionRemoveArticles')->name('dev_recepciones_delete_article');

  Route::post('devrecepcionmercancia/finalizar','Compras\DevRecepcionesController@DevRecepcionFinalizar')->name('dev_recepciones_finalizar');

  Route::post('devrecepcionmercancia/cancelar','Compras\DevRecepcionesController@DevRecepcionCancelar')->name('dev_recepciones_cancelar');

  Route::get('devrecepcionmercancia/ver/{id}','Compras\DevRecepcionesController@DevRecepcionVer')->name('dev_recepciones_visualizar');

  /*Route::get('cotizacion/ver/{id}','Compras\CotizacionesController@VerCotizacion')->name('cotizaciones_ver');

  Route::post('cotizacion/add_requisiciones','Compras\CotizacionesController@CotizacionAddRequs')->name('cotizaciones_agregar_requs');

  Route::get('cotizacion/contactosemail/{parameters?}','Compras\CotizacionesController@GetContactosProv')->name('cotizaciones_contactos_prov');

  Route::post('cotizacion/enviaremailprov','Compras\CotizacionesController@SendEmailProv')->name('cotizaciones_sendemail_prov');*/

  /*****************************************************************************************************/

  /**** Compras ****/

  /*****************************************************************************************************/

  Route::get('compra'/*/{parameters?}'*/,'Compras\ComprasController@ComprasGetAll')->name('compras_all');

  Route::get('compra/nueva','Compras\ComprasController@ComprasNew')->name('compras_nueva');

  Route::post('compra','Compras\ComprasController@CompraStore')->name('compras_store');

  Route::get('compra/editar/{id}','Compras\ComprasController@EditCompra')->name('compras_editar');

  Route::put('compra','Compras\ComprasController@ComprasUpdate')->name('compras_update');

  Route::post('compra/archivoadd','Compras\ComprasController@ComprasArchivoAdd')->name('compras_archivo_add');

  Route::delete('compra/archivodelete','Compras\ComprasController@ComprasArchivoDelete')->name('compras_archivo_delete');

  Route::get('compra/ver/{id}','Compras\ComprasController@visualizarCompra')->name('compras_visualizar');

  Route::get('compra/recepciones','Compras\ComprasController@GetRecepcionesTerminadas')->name('compras_recepciones');

  Route::post('compra/add_ligada','Compras\ComprasController@ComprasAddLigada')->name('compra_add_recepcion');

  Route::post('compra/add_articulo','Compras\ComprasController@ComprasAddRenglon')->name('compra_add_articulo');

  Route::delete('compra/delete_articulo','Compras\ComprasController@ComprasDeleteRenglon')->name('compra_delete_articulo');

  Route::post('compra/finalizar','Compras\ComprasController@ComprasFinalizar')->name('compra_finalizar');

  Route::post('compra/cancelar','Compras\ComprasController@ComprasCancelar')->name('compra_cancelar');



  Route::get('compra/pdf/{id}','Compras\ComprasController@ComprasVerPdf')->name('compras_ver_pdf');

  /******************************************************************************************************/

  /****                       Devolucion de Compra                                                         ****/

  /******************************************************************************************************/

  Route::get('devcompra','Compras\DevComprasController@DevCompraGetAll')->name('dev_compras_all');

  Route::get('devcompra/terminadas','Compras\DevComprasController@DevCompraGetAllT')->name('dev_compras_all_t');

  Route::get('devcompra/nueva','Compras\DevComprasController@DevCompraNew')->name('dev_compras_nueva');

  Route::post('devcompra','Compras\DevComprasController@DevCompraStore')->name('dev_compras_store');

  Route::get('devcompra/editar/{id}','Compras\DevComprasController@DevCompraEdit')->name('dev_compras_editar');

  Route::put('devcompra','Compras\DevComprasController@DevCompraUpdate')->name('dev_compras_update');

  Route::post('devcompra/compras','Compras\DevComprasController@DevCompraDesdeCompra')->name('dev_compras_desde_compra');

  //Route::post('cotizacion/add_ligada','Compras\CotizacionesController@CotizacionAddLigada')->name('cotizaciones_compra_add');

  Route::post('devcompra/add_articles','Compras\DevComprasController@DevCompraAddArticles')->name('dev_compras_add_articles');

  Route::delete('devcompra/remov_articles','Compras\DevComprasController@DevCompraRemoveArticles')->name('dev_compras_delete_article');

  Route::post('devcompra/finalizar','Compras\DevComprasController@DevCompraFinalizar')->name('dev_compras_finalizar');

  Route::post('devcompra/cancelar','Compras\DevComprasController@DevCompraCancelar')->name('dev_compras_cancelar');

  Route::get('devcompra/ver/{id}','Compras\DevComprasController@DevCompraVer')->name('dev_compras_visualizar');

  /*Route::get('cotizacion/ver/{id}','Compras\CotizacionesController@VerCotizacion')->name('cotizaciones_ver');

  Route::post('cotizacion/add_requisiciones','Compras\CotizacionesController@CotizacionAddRequs')->name('cotizaciones_agregar_requs');

  Route::get('cotizacion/contactosemail/{parameters?}','Compras\CotizacionesController@GetContactosProv')->name('cotizaciones_contactos_prov');

  Route::post('cotizacion/enviaremailprov','Compras\CotizacionesController@SendEmailProv')->name('cotizaciones_sendemail_prov');*/

/*######################################################################################################*/

/****                                       NOMINA                                                   ****/

/*######################################################################################################*/

  /******************************************************************************************************/ 

  /****                                   CATALOGOS                                                  ****/ 

  /******************************************************************************************************/  

    ////////////////////////////////empleados

    
    //Route::get('empleado','Catalogos\EmpleadosController@index')->name('empleados');
    Route::get('empleado', [EmpleadosController::class, 'index'])->name('empleados');

    Route::post('empleado','Catalogos\EmpleadosController@empleadoStore')->name('empleados_store');

    Route::get('empleado/all','Catalogos\EmpleadosController@getAll')->name('empleados_all');

    Route::get('empleado/edit/{id}','Catalogos\EmpleadosController@empleadoEdit')->name('empleados_edit');

    Route::post('empleado/edit/{id}','Catalogos\EmpleadosController@empleadoUpdate')->name('empleados_update');

    Route::put('empleado/edit/{id}','Catalogos\EmpleadosController@empleadoUpdateSC')->name('empleados_update2');

    Route::post('empleado/nuevocontrato','Catalogos\EmpleadosController@empleadoNewContract')->name('empleados_nuevocontrato');

    Route::get('empleado/validartipocontrato/{parameter?}','Catalogos\EmpleadosController@validarTipocontrato')->name('empleados_validartipocontrato');

    Route::post('empleado/cancelar_contrato','Catalogos\EmpleadosController@cancelarContratoEmpleado')->name('empleados_cancelar_contrato');

    Route::post('empleado/suspender_contrato','Catalogos\EmpleadosController@suspenderContratoEmpleado')->name('empleados_suspender_contrato');

    Route::post('empleado/aplicar_contrato','Catalogos\EmpleadosController@aplicarContratoEmpleado')->name('empleados_aplicar_contrato');

    Route::post('empleado/agregar_conceptos','Catalogos\EmpleadosController@agregarConceptosContratoEmpleado')->name('empleados_agrega_concepto_contrato');

    Route::post('empleado/quitar_conceptos','Catalogos\EmpleadosController@quitarConceptoContratoEmpleado')->name('empleados_quitar_concepto_contrato');

    ////////////////////////////////////conceptos nomina

    Route::get('conceptosnomina','Catalogos\ConceptosNominaController@index')->name('conceptos_nomina');

    Route::post('conceptosnomina','Catalogos\ConceptosNominaController@conceptoNominaStore')->name('conceptos_nomina_store');

    Route::get('conceptosnomina/edit/{id}','Catalogos\ConceptosNominaController@conceptoNominaEditar')->name('conceptos_nomina_edit');

    Route::post('conceptosnomina/edit/{id}','Catalogos\ConceptosNominaController@conceptoNominaUpdate')->name('conceptos_nomina_update');

    Route::get('conceptosnomina/gettipos/{parameter?}','Catalogos\ConceptosNominaController@getTiposConceptosSat')->name('conceptos_nomina_getTipos');

        ////////////////////////////////////tablas antiguedades

    Route::get('tablasantiguedades','Catalogos\TablasAntiguedadesController@index')->name('tablas_antiguedades');

    Route::post('tablasantiguedades','Catalogos\TablasAntiguedadesController@TablaAntiguedadStore')->name('tablas_antiguedades_store');

    Route::get('tablasantiguedades/edit/{id}','Catalogos\TablasAntiguedadesController@TablaAntiguedadEditar')->name('tablas_antiguedades_edit');

    Route::post('tablasantiguedades/agregarrenglon','Catalogos\TablasAntiguedadesController@TablaAntiguedadAddRow')->name('tablas_antiguedades_adddet');

    Route::post('tablasantiguedades/eliminarrenglon','Catalogos\TablasAntiguedadesController@TablaAntiguedadDeleteRow')->name('tablas_antiguedades_deletedet');

        ////////////////////////////////////registros patronales

    Route::get('registrospatronales','Catalogos\RegistrosPatronalesController@index')->name('registrospatronales');

    Route::post('registrospatronales','Catalogos\RegistrosPatronalesController@RegistroPatronalStore')->name('registrospatronales_store');

    Route::get('registrospatronales/edit/{id}','Catalogos\RegistrosPatronalesController@RegistroPatronalEdit')->name('registrospatronales_edit');

    Route::post('registrospatronales/addriesgo','Catalogos\RegistrosPatronalesController@RegistroPatronalAddRiesgo')->name('registrospatronales_addRiesgo');

    Route::post('registrospatronales/deleteriesgo','Catalogos\RegistrosPatronalesController@RegistroPatronalDeleteRiesgo')->name('registrospatronales_deleteRiesgo');

        ////////////////////////////////////tipos contratos

    Route::get('tiposcontratos','Catalogos\TiposContratosController@index')->name('tiposcontratos');

    Route::post('tiposcontratos','Catalogos\TiposContratosController@TipoContratoStore')->name('tiposcontratos_store');

    Route::post('tiposcontratos/actualizar','Catalogos\TiposContratosController@TipoContratoUpdate')->name('tiposcontratos_update');

        ////////////////////////////////////frecuencias nominas

    Route::get('frecuenciasnominas','Catalogos\FrecuenciasNominasController@index')->name('frecuenciasnominas');

    Route::post('frecuenciasnominas','Catalogos\FrecuenciasNominasController@FrecuenciaNominaStore')->name('frecuenciasnominas_store');

    Route::get('frecuenciasnominas/edit/{id}','Catalogos\FrecuenciasNominasController@FrecuenciaNominaStoreGetData')->name('frecuenciasnominas_edit');

        ////////////////////////////////////Departamentos

    Route::get('deperatmentos','Catalogos\DepartamentosController@index')->name('deperatmentos');

    Route::post('deperatmentos','Catalogos\DepartamentosController@DepartamentosStore')->name('deperatmentos_store');

    // Route::get('deperatmentos/edit/{id}','Catalogos\DepartamentosController@DepartamentosEdit')->name('deperatmentos_editar');

        ////////////////////////////////////puestos

    Route::get('puestos','Catalogos\PuestosController@index')->name('puestos');

    Route::post('puestos','Catalogos\PuestosController@PuestoStore')->name('puestos_store');

    //Route::post('conceptosnomina','Catalogos\ConceptosNominaController@conceptoNominaStore')->name('conceptos_nomina_store');

    //Route::get('conceptosnomina/edit/{id}','Catalogos\ConceptosNominaController@conceptoNominaEditar')->name('conceptos_nomina_edit');

    ////////////////////////////////////////Articulos

    Route::get('articulos','Catalogos\ArticulosController@articulosAll')->name('cat_articulos');

    Route::post('articulos/kardexexistencias','Catalogos\ArticulosController@articulosKardexExistencias')->name('cat_articulos_kardex_existencias');

    Route::post('articulos/kardexvista','Catalogos\ArticulosController@articulosKardexMov')->name('cat_articulos_kardex_vista');

  /* */

  /******************************************************************************************************/

  /****                       SelectsByTerms                                                         ****/

  /******************************************************************************************************/

  Route::get('paises_entidades/{parameter?}', 'AutoLoadController@GetEntidadesByTerm')->name('select_entidades_by_term');

  Route::get('entidades_ciudades/{parameter?}', 'AutoLoadController@GetCiudadesByTerm')->name('select_ciudades_by_term');

  Route::get('catalogos_proveedores/{parameter?}', 'AutoLoadController@GetProveedoresByTerm')->name('select_proveedor_by_term');

  Route::get('catalogos_familias/{parameter?}','AutoLoadController@GetFamiliasByReqs')->name('select_fam_by_reqs');

  Route::get('catalogos_puestos/{parameter?}','AutoLoadController@getPuestos')->name('select_puestos_by_term');

  Route::get('catalogos_departamentos/{parameter?}','AutoLoadController@getDepartamentos')->name('select_departamentos_by_term');

  Route::get('catalogos_articulos','AutoLoadController@getArticulosTable')->name('get_articles_oc');

  Route::get('catalogos_conceptos_nom','AutoLoadController@getConceptosNomTable')->name('get_conceptosnom_al');

  Route::get('catalogos_centroscostos/{parameter?}','AutoLoadController@getCentrosCostos')->name('select_centros_costos_by_term');



  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



  //Inventarios



  Route::get('inventario/{tipo}', 'InventoryController@Inventory')->name('inventory');



  Route::get('inventario/{tipo_inventario}/nuevo', 'InventoryController@NewInventory');



  Route::post('inventario/{tipo_inventario}/submitinv', 'InventoryController@SubmitInventory')->name('submitinv');



  Route::get('inventario/{tipo_inventario}/edit/{id}', 'InventoryController@EditInventory')->where('id', '[0-9]+')->name('editinv');



  Route::post('inventario/{tipo_inventario}/submitarticles', 'InventoryController@NewInventoryDetail')->name('submitarticlesinv');



  Route::post('inventario/{tipo_inventario}/update',  'InventoryController@UpdateInventory')->name('updateinventory');



  Route::post('inventario/{tipo_inventario}/deletearticle', 'InventoryController@DeleteArticle');



  Route::post('inventario/{tipo_inventario}/apply', 'InventoryController@AppInventory')->name('appinventory');



  Route::get('inventario/pdf/{id}', 'InventoryController@PDFView')->name('pdfinv');



  Route::post('inventario/requierecc/{concepto?}', 'InventoryController@RequestCC')->name('requiereccinv');



//;



//Auth::routes();

