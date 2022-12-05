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
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProviderArticlesController;

//inventarios=============================================
use App\Http\Controllers\Catalogos\ClientesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
//Compras=================================================
use App\Http\Controllers\Compras\CotizacionesController;
use App\Http\Controllers\Compras\OrdenesComprasController;
use App\Http\Controllers\Compras\RecepcionController;
use App\Http\Controllers\Compras\DevRecepcionesController;
use App\Http\Controllers\Compras\ComprasController;
use App\Http\Controllers\Compras\DevComprasController;
//catalogos================================================
use App\Http\Controllers\Catalogos\EmpleadosController;
use App\Http\Controllers\Catalogos\ConceptosNominaController;
use App\Http\Controllers\Catalogos\TablasAntiguedadesController;
use App\Http\Controllers\Catalogos\RegistrosPatronalesController;
use App\Http\Controllers\Catalogos\TiposContratosController;
use App\Http\Controllers\Catalogos\FrecuenciasNominasController;
use App\Http\Controllers\Catalogos\DepartamentosController;
use App\Http\Controllers\Catalogos\PuestosController;
use App\Http\Controllers\Catalogos\ArticulosController;
use App\Http\Controllers\Catalogos\ProveedoresController;
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

  Route::get('email/{id}', [ActivityController::class, 'EmailView'])->name('emailact');
  Route::get('ordencompra/email/{id}', [OrdenesComprasController::class,'EmailView'])->name('sendemailordencompraview');
  Route::get('cotizacion/pdf/{id}',[CotizacionesController::class,'CotizacionPDF'])->name('cotizaciones_pdf');
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
  Route::post('requisicion/cancelar', [RequisitionController::class,'CancelRequisition'])->name('cancelar');
  Route::post('requisicion/cancelar', [RequisitionController::class, 'CancelRequisition'])->name('cancelar');
  Route::get('requisicion/nueva', [RequisitionController::class,'NewRequisition'])->name('nueva');
  //Route::get('', [UserController::class, 'index'])->name('user.index');
  Route::post('requisicion/submit', [RequisitionController::class,'SubmitRequisition'])->name('submit');
  Route::post('requisicion/update', [RequisitionController::class,'UpdateRequisition']);
  //Route::post('requisicion/update', [RequisitionController::class,'UpdateRequisition']);
  Route::post('requisicion/submitarticles', [RequisitionController::class,'NewRequisitionDetail'])->name('submitarticles');
  Route::post('requisicion/images', [RequisitionController::class,'RequisitionImagen'])->name('images');
  Route::get('requisicion/edit/{id}', [RequisitionController::class,'EditRequisition'])->where('id', '[0-9]+');
  Route::post('requisicion/deletearticle', [RequisitionController::class,'DeleteArticle']);
  Route::post('requisicion/articles', [RequisitionController::class,'GetArticlesRequisition']);
  Route::post('requisicion/articlesbytype', [RequisitionController::class,'GetArticlesRequisitionByType']);
  Route::get('requisicion/costsbytype/{parameter?}', [RequisitionController::class,'GetCostsByType'])->name('costsbytype');
  Route::post('requisicion/sendemail', [RequisitionController::class,'SendEmail'])->name('sendemail');
  Route::post('requisicion/apply', [RequisitionController::class,'AppRequisition'])->name('apprequisition');
  ///ruta pdf
  Route::get('pdf/{id}', [RequisitionController::class,'PDFView'])->name('pdf');
  Route::post('requisicion/sendpdf', [RequisitionController::class,'SendEmailPDFAuth'])->name('sendpdf');
  //ver
  Route::get('requisicion/ver/{id}', [RequisitionController::class,'VerRequisition'])->where('id', '[0-9]+')->name('ver-auth');
  //autoriza
  Route::get('requisicion/autoriza/{id}', [RequisitionController::class,'AutorizaRequisition'])->where('id', '[0-9]+')->name('autoriza');
  Route::post('requisicion/deleteimage', [RequisitionController::class,'DeleteImage'])->name('del-images');
  Route::post('cambiapassword', [RequisitionController::class,'CambiarPassword']);
  Route::post('cambiarpassword', [RequisitionController::class, 'ChangePassword'])->name('CambiarPassword');
  Route::post('user', 'UserController@index')->name('user');
  Route::get('requisicion/soporte/{id}', [RequisitionController::class,'SupportRequisitionCompleted'])->where('id', '[0-9]+')->name('soporte');
  Route::get('requisicion/particion/{id}', [RequisitionController::class,'PartitionRequisition'])->where('id', '[0-9]+')->name('particion');
  Route::post('requisicion/particionar', [RequisitionController::class,'PartitionRequisitionDetail'])->name('particionar');
  Route::get('requisicion/reporterequisicion', [RequisitionController::class,'BitacoraRequisicion'])->name('reporterequisicion');

/*######################################################################################################*/

/****                                     USUARIO                                                    ****/

/*######################################################################################################*/

  //Usuarios

  Route::get('usuarios', [UserController::class,'User'])->name('usuario');
  Route::post('editarusuario', [UserController::class,'EditUser']);
  Route::post('nuevousuario', [UserController::class,'NewUser']);

/*######################################################################################################*/

/****                                   APLICACION                                                   ****/

/*######################################################################################################*/

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  // Aplicaciones agroquímicos
  Route::get('aplicacion', [ApplicationController::class,'Application'])->name('aplicacion');
  Route::get('aplicacion/nueva', [ApplicationController::class,'NewApplication'])->name('nuevaaplicacion');
  Route::get('aplicacion/lotes/{parameter?}', [ApplicationController::class,'GetLots'])->name('lots');
  Route::post('aplicacion/loteinfo/{parameter?}', [ApplicationController::class,'GetLotInfo'])->name('lotinfo');
  Route::post('aplicacion/submitapp', [ApplicationController::class,'SubmitApplication'])->name('submitapp');
  Route::get('aplicacion/edit/{id}', [ApplicationController::class,'EditApplication'])->where('id', '[0-9]+');
  Route::get('aplicacion/receta/{id}{receta}', [ApplicationController::class,'AplicaReceta'])->where('id', '[0-9]+')->name('aplicareceta');
  Route::post('aplicacion/submitarticlesapp', [ApplicationController::class,'NewApplicationDetail'])->name('submitarticlesapp');
  Route::get('aplicacion/ver/{id}', [ApplicationController::class,'ViewApplication'])->where('id', '[0-9]+')->name('ver-app');
  Route::post('aplicacion/deletearticle', [ApplicationController::class,'DeleteArticle']);
  Route::post('aplicacion/apply', [ApplicationController::class,'AppApplication'])->name('appapplication');
  Route::post('aplicacion/receta', [ApplicationController::class,'AppReceta'])->name('appreceta');
  Route::get('aplicacion/pdf/{id}', [ApplicationController::class,'PDFView'])->name('apppdf');
  Route::get('aplicacion/searchobjective', [ApplicationController::class,'SearchObjective'])->name('searchobjective');
  Route::post('aplicacion/objectiveinfo', [ApplicationController::class,'ObjectiveInfo'])->name('objectiveinfo');
  //Bitácora plaguicidas
  Route::get('aplicacion/bitacoraplaguicida/{fechas?}', [ApplicationController::class,'BitacoraPlaguicida'])->name('bitacoraplaguicida');
  //Bitácora fertilizantes
  Route::get('aplicacion/bitacorafertilizante/{folio?}', [ApplicationController::class,'BitacoraFertilizante'])->name('bitacorafertilizante');
  //Reporte fertilizantes NPK
  Route::get('aplicacion/fertilizantenpk/{folio?}', [ApplicationController::class,'FertilizanteNPK'])->name('fertilizantenpk');
  //Reporte aplicaciones
  Route::get('aplicacion/reporteaplicacion', [ApplicationController::class,'ReporteAplicacion'])->name('reporteaplicacion');
  //Reporte de todas las aplicaciones con costo
  Route::get('aplicacion/reportecostos', [ApplicationController::class,'ReporteCostos'])->name('reportecostos');
  Route::post('aplicacion/submitaplicador', [ApplicationController::class,'SubmitAplicador'])->name('submitaplicador');

/*######################################################################################################*/

/****                                  ACTIVIDADES                                                   ****/

/*######################################################################################################*/

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Actividades
  Route::get('actividad/manoobra', [ActivityController::class,'Activity'])->name('actividad');
  Route::get('actividad/manoobra/nueva', [ActivityController::class,'NewActivity'])->name('nuevaactividad');
  Route::get('actividad/manoobra/edit/{id}', [ActivityController::class,'EditActivity'])->where('id', '[0-9]+');
  Route::post('actividad/manoobra/apply', [ActivityController::class,'AppActivity'])->name('appactivity');
  Route::get('actividad/manoobra/ver/{id}', [ActivityController::class,'ViewActivity'])->where('id', '[0-9]+')->name('ver-act');
  Route::get('actividad/manoobra/lotes/{parameter?}', [ActivityController::class,'GetLots'])->name('lotsact');
  Route::get('actividad/manoobra/groupsbytype/{parameter?}', [ActivityController::class,'GetGroupsByType'])->name('groupsbyterm');
  Route::post('actividad/manoobra/submitact', [ActivityController::class,'SubmitActivity'])->name('submitact');
  Route::get('actividad/manoobra/actividades/{parameter?}', [ActivityController::class,'GetActivities'])->name('actividades');
  Route::post('actividad/manoobra/submitlotact', [ActivityController::class,'SubmitLotActivity'])->name('submitlotact');
  Route::post('actividad/manoobra/submitpaselista', [ActivityController::class,'SubmitList'])->name('submitpaselista');
  Route::post('actividad/manoobra/submitempleado', [ActivityController::class,'SubmitEmployee'])->name('submitempleado');
  Route::post('actividad/manoobra/sendemail', [ActivityController::class,'SendEmail'])->name('sendemailact');
  Route::get('actividad/manoobra/autoriza/{id}', [ActivityController::class,'AutorizaActivity'])->where('id', '[0-9]+')->name('autorizaact');
  Route::get('actividad/manoobra/pdf/{id}', [ActivityController::class,'PDFView'])->name('pdfact');
  Route::post('actividad/manoobra/sendpdf', [ActivityController::class,'SendEmailPDFAuth'])->name('sendpdfact');

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  //Articulos Proveedor

  Route::get('proveedor/articulos/{id}/{estatus}', [ProviderArticlesController::class,'GetProviderArticles'])->name('articulosproveedores');
  Route::get('proveedor/getproviders', [ProviderArticlesController::class,'GetProviders'])->name('providers');
  Route::get('proveedor/searchproviders', [ProviderArticlesController::class,'SearchArticlesProvider'])->name('searchproviders');
  Route::get('proveedor/articulo/{id}', [ProviderArticlesController::class,'GetProviderArticleData'])->name('articulosproveedores');
  Route::post('proveedor/articulo/asignar', [ProviderArticlesController::class,'updateProviderArticle']);

  //Inventarios

  Route::get('inventario/{tipo}', [InventoryController::class,'Inventory'])->name('inventory');;
  Route::get('inventario/nuevo', [InventoryController::class,'NewInventory']);

/*######################################################################################################*/

/****                                       COMPRA                                                   ****/

/*######################################################################################################*/

  /****************************************************************************************************************/

  /****                                  Cotizaciones                                                          ****/

  /****************************************************************************************************************/

  //Route::get('cotizacion','Compras\CotizacionesController@CotizacionGetAll')->name('cotizaciones_all');
  Route::get('cotizacion', [CotizacionesController::class, 'CotizacionGetAll'])->name('cotizaciones_all');
  //Route::get('cotizacion/nueva','Compras\CotizacionesController@CotizacionNew')->name('cotizaciones_nueva');
  Route::get('cotizacion/nueva', [CotizacionesController::class, 'CotizacionNew'])->name('cotizaciones_nueva');
  //Route::post('cotizacion','Compras\CotizacionesController@CotizacionStore')->name('cotizaciones_store');
  Route::post('cotizacion', [CotizacionesController::class, 'CotizacionStore'])->name('cotizaciones_store');  
  //Route::get('cotizacion/editar/{id}','Compras\CotizacionesController@EditCotizacion')->name('cotizaciones_editar');
  Route::get('cotizacion/editar/{id}', [CotizacionesController::class, 'EditCotizacion'])->name('cotizaciones_editar');
  //Route::put('cotizacion','Compras\CotizacionesController@CotizacionUpdate')->name('cotizaciones_update');
  //Route::get('cotizacion/recepciones','Compras\CotizacionesController@GetRecepcionesTerminadas')->name('cotizaciones_recepciones');
  //Route::post('cotizacion/add_ligada','Compras\CotizacionesController@CotizacionAddLigada')->name('cotizaciones_compra_add');
  Route::post('cotizacion/add_ligada', [CotizacionesController::class, 'CotizacionAddLigada'])->name('cotizaciones_compra_add');
  //Route::post('cotizacion/add_articles','Compras\CotizacionesController@CotizacionAddArticles')->name('cotizacion_add_articles');
  Route::post('cotizacion/add_articles', [CotizacionesController::class, 'CotizacionAddArticles'])->name('cotizacion_add_articles');
  //Route::delete('cotizacion/remov_articles','Compras\CotizacionesController@CotizacionRemoveArticles')->name('cotizaciones_DeleteArticle');
  Route::delete('cotizacion/remov_articles', [CotizacionesController::class, 'CotizacionRemoveArticles'])->name('cotizaciones_DeleteArticle');
  //Route::post('cotizacion/finalizar','Compras\CotizacionesController@CotizacionFinalizar')->name('cotizaciones_finalizar');
  Route::post('cotizacion/finalizar', [CotizacionesControlle::class, 'CotizacionFinalizar'])->name('cotizaciones_finalizar');
  //Route::get('cotizacion/ver/{id}','Compras\CotizacionesController@VerCotizacion')->name('cotizaciones_ver');
  Route::get('cotizacion/ver/{id}', [CotizacionesController::class, 'VerCotizacion'])->name('cotizaciones_ver');
  //Route::post('cotizacion/add_requisiciones','Compras\CotizacionesController@CotizacionAddRequs')->name('cotizaciones_agregar_requs');
  Route::post('cotizacion/add_requisiciones', [CotizacionesController::class, 'CotizacionAddRequs'])->name('cotizaciones_agregar_requs');
  //Route::get('cotizacion/contactosemail/{parameters?}','Compras\CotizacionesController@GetContactosProv')->name('cotizaciones_contactos_prov');
  Route::get('cotizacion/contactosemail/{parameters?}', [CotizacionesController::class, 'GetContactosProv'])->name('cotizaciones_contactos_prov');
  //Route::post('cotizacion/enviaremailprov','Compras\CotizacionesController@SendEmailProv')->name('cotizaciones_sendemail_prov');
  Route::post('cotizacion/enviaremailprov', [CotizacionesController::class, 'SendEmailProv'])->name('cotizaciones_sendemail_prov');
  //Route::post('cotizacion/cancelar','Compras\CotizacionesController@CotizacionCancelar')->name('cotizaciones_cancelar');
  Route::get('cotizacion/cancelar', [CotizacionesController::class, 'CotizacionCancelar'])->name('cotizaciones_cancelar');
  

  /***********************************************************************************************************/

  /****                        Ordenes de compra                                                          ****/

  /***********************************************************************************************************/

  //Ordenes de compra---------------------------------

  //Route::get('/ordencompra',[OrdenesComprasController::class, 'OrdenesCompras'])->name('ordenescompras');

  //Route::get('/ordencompra','Compras\OrdenesComprasController@OrdenesCompras')->name('ordenescompras');
  Route::get('ordencompra', [OrdenesComprasController::class, 'OrdenesCompras'])->name('ordenescompras');
  //Route::get('/ordencompra/cotizaciones','Compras\OrdenesComprasController@OrdenesComprasGetCotizaciones')->name('ordenescompras_get_cotizaciones');
  Route::get('/ordencompra/cotizaciones', [OrdenesComprasController::class, 'OrdenesComprasGetCotizaciones'])->name('ordenescompras_get_cotizaciones');
  //Route::post('/ordencompra/cotizaciones','Compras\OrdenesComprasController@OrdenesComprasDesdeCotizacion')->name('ordenescompras_desde_cotizacion');
  Route::post('/ordencompra/cotizaciones', [OrdenesComprasController::class, 'OrdenesComprasDesdeCotizacion'])->name('ordenescompras_desde_cotizacion');
  //Route::get('ordencompra/nueva', 'Compras\OrdenesComprasController@NewOrder')->name('nuevaOrden');
  Route::get('ordencompra/nueva', [OrdenesComprasController::class, 'NewOrder'])->name('nuevaOrden');
  //Route::post('ordencompra/submit', 'Compras\OrdenesComprasController@SubmitOrdenCompra')->name('submit.ordencompra');
  Route::post('ordencompra/submit', [OrdenesComprasController::class, 'SubmitOrdenCompra'])->name('submit.ordencompra');
  //Route::get('ordencompra/edit/{id}', 'Compras\OrdenesComprasController@EditOrdenCompra')->where('id', '[0-9]+')->name('ordencompra_editar');
  Route::get('ordencompra/edit/{id}', [OrdenesComprasController::class, 'EditOrdenCompra'])->where('id', '[0-9]+')->name('ordencompra_editar');
 // Route::get('ordencompra/articulos',  'Compras\OrdenesComprasController@getArticulos')->name('get_articles_oc');
  //Route::get('ordencompra/requisiciones','Compras\OrdenesComprasController@getRequisicionesparaordenes')->name('get_requisiciones_oc');
  Route::get('ordencompra/requisiciones', [OrdenesComprasController::class, 'getRequisicionesparaordenes'])->name('get_requisiciones_oc');
  //Route::get('ordenescompras/selectcentproveedores/{parameter?}', 'Compras\OrdenesComprasController@OCCentrosCostos')->name('select.centroscostos');
  Route::get('ordenescompras/selectcentproveedores/{parameter?}', [OrdenesComprasController::class, 'OCCentrosCostos'])->name('select.centroscostos');
  //Route::get('ordenescompras/selectcentroscostos/{parameter?}',['as'=>'select.centroscostos','uses'=>'OrdenesComprasController@OCCentrosCostos']);
  //Route::post('ordencompra/submitarticles',  'Compras\OrdenesComprasController@NewOrdenCompraDet')->name('submitarticles_oc');
  Route::post('ordencompra/submitarticles', [OrdenesComprasController::class, 'NewOrdenCompraDet'])->name('submitarticles_oc');
  //Route::delete('ordencompra/edit/ordencompra/deletearticle',  'Compras\OrdenesComprasController@DeleteArticle')->name('ordencompra_DeleteArticle');
  Route::delete('ordencompra/edit/ordencompra/deletearticle', [OrdenesComprasController::class, 'DeleteArticle'])->name('ordencompra_DeleteArticle');
  //Route::post('ordencompra/requisicionesbytype',  'Compras\OrdenesComprasController@GetRequisitionCompraByType');
  Route::post('ordencompra/requisicionesbytype', [OrdenesComprasController::class, 'GetRequisitionCompraByType']);
  //Route::get('ordencompra/ver/{id}',  'Compras\OrdenesComprasController@VerCompra')->where('id', '[0-9]+')->name('ver-auth-oc');
  Route::get('ordencompra/ver/{id}', [OrdenesComprasController::class, 'VerCompra'])->where('id', '[0-9]+')->name('ver-auth-oc');
  //Route::post('ordencompra/compra/update',  'Compras\OrdenesComprasController@UpdateCompra')->name('ordencompra_update');
  Route::post('ordencompra/compra/update', [OrdenesComprasController::class, 'UpdateCompra'])->name('ordencompra_update');
  //Route::post('ordencompra/agregarrequisicion', 'Compras\OrdenesComprasController@AgregarRequisition')->name('agregar_requ_ordencompra');
  Route::post('ordencompra/agregarrequisicion', [OrdenesComprasController::class, 'AgregarRequisition'])->name('agregar_requ_ordencompra');
  //Route::post('ordencompra/apply',  'Compras\OrdenesComprasController@AppOrdenCompra')->name('appordencompra');
  Route::post('ordencompra/apply', [OrdenesComprasController::class, 'AppOrdenCompra'])->name('appordencompra');
  //Route::post('ordencompra/sendemail',  'Compras\OrdenesComprasController@SendEmail')->name('sendemailordencompra');
  Route::post('ordencompra/sendemail', [OrdenesComprasController::class, 'SendEmail'])->name('sendemailordencompra');
  //Route::get('ordencompra/autoriza/{id}', 'Compras\OrdenesComprasController@AutorizaOrdenCompra')->where('id', '[0-9]+')->name('autorizaordencompra');
  Route::get('ordencompra/autoriza/{id}', [OrdenesComprasController::class, 'AutorizaOrdenCompra'])->where('id', '[0-9]+')->name('autorizaordencompra');
  //Route::post('ordencompra/autorizar', 'Compras\OrdenesComprasController@AuthOrdenCompra')->where('id', '[0-9]+')->name('autorizaroc');
  Route::post('ordencompra/autorizar', [OrdenesComprasController::class, 'AuthOrdenCompra'])->where('id', '[0-9]+')->name('autorizaroc');
  //Route::post('ordencompra/cancelar', 'Compras\OrdenesComprasController@CancelOrdenCompra')->name('cancelarordencompra');
  Route::post('ordencompra/cancelar', [OrdenesComprasController::class, 'CancelOrdenCompra'])->name('cancelarordencompra');
  //Route::get('pdfordencompra/{id}', 'Compras\OrdenesComprasController@PDFView')->name('pdfordencompra');
  Route::get('pdfordencompra/{id}', [OrdenesComprasController::class, 'PDFView'])->name('pdfordencompra');
  //Route::post('ordencompra/sendpdf', 'Compras\OrdenesComprasController@SendEmailPDFAuth')->name('sendpdfordencompra');
  Route::post('ordencompra/sendpdf', [OrdenesComprasController::class, 'SendEmailPDFAuth'])->name('sendpdfordencompra');
  //Route::get('pdfordencompraautorizado/{id}', 'Compras\OrdenesComprasController@PDFViewAuth')->name('pdfordencompraauth');
  Route::get('pdfordencompraautorizado/{id}', [OrdenesComprasController::class, 'PDFViewAuth'])->name('pdfordencompraauth');
  

  /*******************************************************************************************************************************/

  /****                                             Recepción de Mercancía                                                    ****/

  /*******************************************************************************************************************************/

  //Route::get('recepcionmercancia','Compras\RecepcionController@getVistaRecepciones')->name('recepcionmercancia');
  Route::get('recepcionmercancia', [RecepcionController::class, 'getVistaRecepciones'])->name('recepcionmercancia');
  //Route::get('recepcionmercancia/nueva','Compras\RecepcionController@vistaNuevaRecepcion')->name('recepcionmercancia_nueva');
  Route::get('recepcionmercancia/nueva', [RecepcionController::class, 'vistaNuevaRecepcion'])->name('recepcionmercancia_nueva');
  //Route::post('recepcionmercancia/store','Compras\RecepcionController@saveNuevaRecepcion')->name('recepcionmercancia_store');
  Route::post('recepcionmercancia/store', [RecepcionController::class, 'saveNuevaRecepcion'])->name('user.index');
  Route::get('recepcionmercancia/edit/{id}',[RecepcionController::class, 'editarNuevaRecepcion'])->name('recepcionmercancia_editar');
  Route::post('recepcionmercancia/agregararticulos',[RecepcionController::class, 'addRenglonNuevaRecepcion'])->name('recepcionmercancia_addRenglon');
  Route::delete('recepcionmercancia/editar/eliminararticulo', [RecepcionController::class, 'DeleteArticle'])->name('recepcionmercancia_DeleteArticle');
  Route::put('recepcionmercancia/update', [RecepcionController::class, 'updateNuevaRecepcion'])->name('recepcionmercancia_update');
  Route::get('recepcionmercancia/verificarmoneda/{moneda}',[RecepcionController::class, 'verificarMonedaNuevaRecepcion'])->name('recepcionmercancia_verif_moneda');
  Route::get('recepcionmercancia/verificarproveedor/{proveedor}',[RecepcionController::class, 'verificarproveedorRecepcion'])->name('recepcionmercancia_verif_prov');
  Route::get('recepcionmercancia/ordenescompraporrecibir',[RecepcionController::class, 'ordenescompraRecepcion'])->name('recepcionmercancia_ordenescompra');
  Route::post('recepcionmercancia/ordenescompraporrecibir/agregar',[RecepcionController::class, 'addOrdenescompraRecepcion'])->name('recepcionmercancia_ordenescompra_add');
  Route::put('recepcionmercancia/finalizarrecepcion',[RecepcionController::class, 'RecepcionFinalizar'])->name('recepcionmercancia_finalizar');
  Route::put('recepcionmercancia/cancelarrecepcion',[RecepcionController::class, 'cancelarRecepcion'])->name('recepcionmercancia_cancelar');
  Route::post('recepcionmercancia/recepcionimagen',[RecepcionController::class, 'RecepcionImagen'])->name('recepcionmercancia_doctos');
  Route::delete('recepcionmercancia/recepcionimagendelete',[RecepcionController::class, 'RecepcionImagenDelete'])->name('recepcionmercancia_doctos_delete');
  //Route::put('recepcionmercancia/finalizarligada','Compras\RecepcionController@finalizarRecepcionligada')->name('recepcionmercancia_finalizarligada');
  Route::get('recepcionmercancia/visualizar/{id}',[RecepcionController::class, 'visualizarRecepcion'])->name('recepcionmercancia_visualizar');
  Route::get('recepcionmercancia/pdf/{id}',[RecepcionController::class, 'PDFView'])->name('recepcionmercancia_pdf');
  Route::post('recepcionmercancia/actualizarlote',[RecepcionController::class, 'guardarLote'])->name('recepcionmercancia_actualizarlote');

   /******************************************************************************************************/

  /****                       Devolucion de Recepción                                                         ****/

  /******************************************************************************************************/

  //Route::get('devrecepcionmercancia','Compras\DevRecepcionesController@DevRecepcionGetAll')->name('devrecepcionmercancia_all');
  Route::get('devrecepcionmercancia', [DevRecepcionesController::class, 'DevRecepcionGetAll'])->name('devrecepcionmercancia_all');
  Route::get('devrecepcionmercancia/nueva',[DevRecepcionesController::class,'DevRecepcionNew'])->name('dev_recepciones_nueva');
  Route::post('devrecepcionmercancia',[DevRecepcionesController::class,'DevRecepcionStore'])->name('dev_recepciones_store');
  Route::get('devrecepcionmercancia/edit/{id}',[DevRecepcionesController::class,'DevRecepcionEdit'])->name('dev_recepciones_editar');
  Route::put('devrecepcionmercancia',[DevRecepcionesController::class,'DevRecepcionUpdate'])->name('dev_recepciones_update');
  Route::post('devrecepcionmercancia/recepciones',[DevRecepcionesController::class,'DevRecepcionDesdeRecepcion'])->name('dev_recepciones_desde_recepcion');
  //Route::post('cotizacion/add_ligada','Compras\CotizacionesController@CotizacionAddLigada')->name('cotizaciones_compra_add');
  Route::post('devrecepcionmercancia/add_articles',[DevRecepcionesController::class,'DevRecepcionAddArticles'])->name('dev_recepciones_add_articles');
  Route::delete('devrecepcionmercancia/remov_articles',[DevRecepcionesController::class,'DevRecepcionRemoveArticles'])->name('dev_recepciones_delete_article');
  Route::post('devrecepcionmercancia/finalizar',[DevRecepcionesController::class,'DevRecepcionFinalizar'])->name('dev_recepciones_finalizar');
  Route::post('devrecepcionmercancia/cancelar',[DevRecepcionesController::class,'DevRecepcionCancelar'])->name('dev_recepciones_cancelar');
  Route::get('devrecepcionmercancia/ver/{id}',[DevRecepcionesController::class,'DevRecepcionVer'])->name('dev_recepciones_visualizar');
  /*Route::get('cotizacion/ver/{id}','Compras\CotizacionesController@VerCotizacion')->name('cotizaciones_ver');
  Route::post('cotizacion/add_requisiciones','Compras\CotizacionesController@CotizacionAddRequs')->name('cotizaciones_agregar_requs');
  Route::get('cotizacion/contactosemail/{parameters?}','Compras\CotizacionesController@GetContactosProv')->name('cotizaciones_contactos_prov');
  Route::post('cotizacion/enviaremailprov','Compras\CotizacionesController@SendEmailProv')->name('cotizaciones_sendemail_prov');*/

  /*****************************************************************************************************/

  /****                                        Compras                                              ****/

  /*****************************************************************************************************/

  //Route::get('compra'/*/{parameters?}'*/,'Compras\ComprasController@ComprasGetAll')->name('compras_all');
  Route::get('compra', [ComprasController::class, 'ComprasGetAll'])->name('compras_all');
  Route::get('compra/nueva',[ComprasController::class, 'ComprasNew'])->name('compras_nueva');
  Route::post('compra',[ComprasController::class, 'CompraStore'])->name('compras_store');
  Route::get('compra/editar/{id}',[ComprasController::class,'EditCompra'])->name('compras_editar');
  Route::put('compra',[ComprasController::class,'ComprasUpdate'])->name('compras_update');
  Route::post('compra/archivoadd',[ComprasController::class,'ComprasArchivoAdd'])->name('compras_archivo_add');
  Route::delete('compra/archivodelete',[ComprasController::class,'ComprasArchivoDelete'])->name('compras_archivo_delete');
  Route::get('compra/ver/{id}',[ComprasController::class,'visualizarCompra'])->name('compras_visualizar');
  Route::get('compra/recepciones',[ComprasController::class,'GetRecepcionesTerminadas'])->name('compras_recepciones');
  Route::post('compra/add_ligada',[ComprasController::class,'ComprasAddLigada'])->name('compra_add_recepcion');
  Route::post('compra/add_articulo',[ComprasController::class,'ComprasAddRenglon'])->name('compra_add_articulo');
  Route::delete('compra/delete_articulo',[ComprasController::class,'ComprasDeleteRenglon'])->name('compra_delete_articulo');
  Route::post('compra/finalizar',[ComprasController::class,'ComprasFinalizar'])->name('compra_finalizar');
  Route::post('compra/cancelar',[ComprasController::class,'ComprasCancelar'])->name('compra_cancelar');
  Route::get('compra/pdf/{id}',[ComprasController::class,'ComprasVerPdf'])->name('compras_ver_pdf');

  /******************************************************************************************************/

  /****                       Devolucion de Compra                                                         ****/

  /******************************************************************************************************/

  Route::get('devcompra',[DevComprasController::class,'DevCompraGetAll'])->name('dev_compras_all');
  Route::get('devcompra/terminadas',[DevComprasController::class,'DevCompraGetAllT'])->name('dev_compras_all_t');
  Route::get('devcompra/nueva',[DevComprasController::class,'DevCompraNew'])->name('dev_compras_nueva');
  Route::post('devcompra',[DevComprasController::class,'DevCompraStore'])->name('dev_compras_store');
  Route::get('devcompra/editar/{id}',[DevComprasController::class,'DevCompraEdit'])->name('dev_compras_editar');
  Route::put('devcompra',[DevComprasController::class,'DevCompraUpdate'])->name('dev_compras_update');
  Route::post('devcompra/compras',[DevComprasController::class,'DevCompraDesdeCompra'])->name('dev_compras_desde_compra');
  //Route::post('cotizacion/add_ligada','Compras\CotizacionesController@CotizacionAddLigada')->name('cotizaciones_compra_add');
  Route::post('devcompra/add_articles',[DevComprasController::class,'DevCompraAddArticles'])->name('dev_compras_add_articles');
  Route::delete('devcompra/remov_articles',[DevComprasController::class,'DevCompraRemoveArticles'])->name('dev_compras_delete_article');
  Route::post('devcompra/finalizar',[DevComprasController::class,'DevCompraFinalizar'])->name('dev_compras_finalizar');
  Route::post('devcompra/cancelar',[DevComprasController::class,'DevCompraCancelar'])->name('dev_compras_cancelar');
  Route::get('devcompra/ver/{id}',[DevComprasController::class,'DevCompraVer'])->name('dev_compras_visualizar');
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
    Route::post('empleado',[EmpleadosController::class,'empleadoStore'])->name('empleados_store');
    Route::get('empleado/all',[EmpleadosController::class,'getAll'])->name('empleados_all');
    Route::get('empleado/edit/{id}',[EmpleadosController::class,'empleadoEdit'])->name('empleados_edit');
    Route::post('empleado/edit/{id}',[EmpleadosController::class,'empleadoUpdate'])->name('empleados_update');
    Route::put('empleado/edit/{id}',[EmpleadosController::class,'empleadoUpdateSC'])->name('empleados_update2');
    Route::post('empleado/nuevocontrato',[EmpleadosController::class,'empleadoNewContract'])->name('empleados_nuevocontrato');
    Route::get('empleado/validartipocontrato/{parameter?}',[EmpleadosController::class,'validarTipocontrato'])->name('empleados_validartipocontrato');
    Route::post('empleado/cancelar_contrato',[EmpleadosController::class,'cancelarContratoEmpleado'])->name('empleados_cancelar_contrato');
    Route::post('empleado/suspender_contrato',[EmpleadosController::class,'suspenderContratoEmpleado'])->name('empleados_suspender_contrato');
    Route::post('empleado/aplicar_contrato',[EmpleadosController::class,'aplicarContratoEmpleado'])->name('empleados_aplicar_contrato');
    Route::post('empleado/agregar_conceptos',[EmpleadosController::class,'agregarConceptosContratoEmpleado'])->name('empleados_agrega_concepto_contrato');
    Route::post('empleado/quitar_conceptos',[EmpleadosController::class,'quitarConceptoContratoEmpleado'])->name('empleados_quitar_concepto_contrato');

    ////////////////////////////////////conceptos nomina

    Route::get('conceptosnomina',[ConceptosNominaController::class,'index'])->name('conceptos_nomina');
    Route::post('conceptosnomina',[ConceptosNominaController::class,'conceptoNominaStore'])->name('conceptos_nomina_store');
    Route::get('conceptosnomina/edit/{id}',[ConceptosNominaController::class,'conceptoNominaEditar'])->name('conceptos_nomina_edit');
    Route::post('conceptosnomina/edit/{id}',[ConceptosNominaController::class,'conceptoNominaUpdate'])->name('conceptos_nomina_update');
    Route::get('conceptosnomina/gettipos/{parameter?}',[ConceptosNominaController::class,'getTiposConceptosSat'])->name('conceptos_nomina_getTipos');

        ////////////////////////////////////tablas antiguedades

    Route::get('tablasantiguedades',[TablasAntiguedadesController::class,'index'])->name('tablas_antiguedades');
    Route::post('tablasantiguedades',[TablasAntiguedadesController::class,'TablaAntiguedadStore'])->name('tablas_antiguedades_store');
    Route::get('tablasantiguedades/edit/{id}',[TablasAntiguedadesController::class,'TablaAntiguedadEditar'])->name('tablas_antiguedades_edit');
    Route::post('tablasantiguedades/agregarrenglon',[TablasAntiguedadesController::class,'TablaAntiguedadAddRow'])->name('tablas_antiguedades_adddet');
    Route::post('tablasantiguedades/eliminarrenglon',[TablasAntiguedadesController::class,'TablaAntiguedadDeleteRow'])->name('tablas_antiguedades_deletedet');

        ////////////////////////////////////registros patronales

    Route::get('registrospatronales',[RegistrosPatronalesController::class,'index'])->name('registrospatronales');
    Route::post('registrospatronales',[RegistrosPatronalesController::class,'RegistroPatronalStore'])->name('registrospatronales_store');
    Route::get('registrospatronales/edit/{id}',[RegistrosPatronalesController::class,'RegistroPatronalEdit'])->name('registrospatronales_edit');
    Route::post('registrospatronales/addriesgo',[RegistrosPatronalesController::class,'RegistroPatronalAddRiesgo'])->name('registrospatronales_addRiesgo');
    Route::post('registrospatronales/deleteriesgo',[RegistrosPatronalesController::class,'RegistroPatronalDeleteRiesgo'])->name('registrospatronales_deleteRiesgo');

        ////////////////////////////////////tipos contratos

    Route::get('tiposcontratos',[TiposContratosController::class,'index'])->name('tiposcontratos');
    Route::post('tiposcontratos',[TiposContratosController::class,'TipoContratoStore'])->name('tiposcontratos_store');
    Route::post('tiposcontratos/actualizar',[TiposContratosController::class,'TipoContratoUpdate'])->name('tiposcontratos_update');

        ////////////////////////////////////frecuencias nominas

    Route::get('frecuenciasnominas',[FrecuenciasNominasController::class,'index'])->name('frecuenciasnominas');
    Route::post('frecuenciasnominas',[FrecuenciasNominasController::class,'FrecuenciaNominaStore'])->name('frecuenciasnominas_store');
    Route::get('frecuenciasnominas/edit/{id}',[FrecuenciasNominasController::class,'FrecuenciaNominaStoreGetData'])->name('frecuenciasnominas_edit');

        ////////////////////////////////////Departamentos

    Route::get('deperatmentos',[DepartamentosController::class,'index'])->name('deperatmentos');
    Route::post('deperatmentos',[DepartamentosController::class,'DepartamentosStore'])->name('deperatmentos_store');

    // Route::get('deperatmentos/edit/{id}','Catalogos\DepartamentosController@DepartamentosEdit')->name('deperatmentos_editar');

        ////////////////////////////////////puestos

    Route::get('puestos',[PuestosController::class,'index'])->name('puestos');
    Route::post('puestos',[PuestosController::class,'PuestoStore'])->name('puestos_store');
    //Route::post('conceptosnomina','Catalogos\ConceptosNominaController@conceptoNominaStore')->name('conceptos_nomina_store');
    //Route::get('conceptosnomina/edit/{id}','Catalogos\ConceptosNominaController@conceptoNominaEditar')->name('conceptos_nomina_edit');

    ////////////////////////////////////////Articulos

    Route::get('articulos',[ArticulosController::class,'articulosAll'])->name('cat_articulos');
    Route::post('articulos/kardexexistencias',[ArticulosController::class,'articulosKardexExistencias'])->name('cat_articulos_kardex_existencias');
    Route::post('articulos/kardexvista',[ArticulosController::class,'articulosKardexMov'])->name('cat_articulos_kardex_vista');
    Route::get('articulos/export', [ArticulosController::class, 'ExportExcel'])->name('ExportArticulos');
    Route::post('articulos/import', [ArticulosController::class, 'ImportExcel'])->name('ImportArticulos');
  /*================== */
   

  /******************************************************************************************************/

  /****                       SelectsByTerms                                                         ****/

  /******************************************************************************************************/

  Route::get('paises_entidades/{parameter?}', [AutoLoadController::class, 'GetEntidadesByTerm'])->name('select_entidades_by_term');
  Route::get('entidades_ciudades/{parameter?}',  [AutoLoadController::class, 'GetCiudadesByTerm'])->name('select_ciudades_by_term');
  Route::get('catalogos_proveedores/{parameter?}',  [AutoLoadController::class, 'GetProveedoresByTerm'])->name('select_proveedor_by_term');
  Route::get('catalogos_familias/{parameter?}', [AutoLoadController::class, 'GetFamiliasByReqs'])->name('select_fam_by_reqs');
  Route::get('catalogos_puestos/{parameter?}', [AutoLoadController::class, 'getPuestos'])->name('select_puestos_by_term');
  Route::get('catalogos_departamentos/{parameter?}', [AutoLoadController::class, 'getDepartamentos'])->name('select_departamentos_by_term');
  Route::get('catalogos_articulos', [AutoLoadController::class, 'getArticulosTable'])->name('get_articles_oc');
  Route::get('catalogos_conceptos_nom', [AutoLoadController::class, 'getConceptosNomTable'])->name('get_conceptosnom_al');
  Route::get('catalogos_centroscostos/{parameter?}', [AutoLoadController::class, 'getCentrosCostos'])->name('select_centros_costos_by_term');

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  //Inventarios

  Route::get('inventario/{tipo}', [InventoryController::class, 'Inventory'])->name('inventory');
  Route::get('inventario/{tipo_inventario}/nuevo', [InventoryController::class,'NewInventory']);
  Route::post('inventario/{tipo_inventario}/submitinv', [InventoryController::class,'SubmitInventory'])->name('submitinv');
  Route::get('inventario/{tipo_inventario}/edit/{id}', [InventoryController::class,'EditInventory'])->where('id', '[0-9]+')->name('editinv');
  Route::post('inventario/{tipo_inventario}/submitarticles', [InventoryController::class,'NewInventoryDetail'])->name('submitarticlesinv');
  Route::post('inventario/{tipo_inventario}/update',  [InventoryController::class,'UpdateInventory'])->name('updateinventory');
  Route::post('inventario/{tipo_inventario}/deletearticle', [InventoryController::class,'DeleteArticle']);
  Route::post('inventario/{tipo_inventario}/apply', [InventoryController::class,'AppInventory'])->name('appinventory');
  Route::get('inventario/pdf/{id}', [InventoryController::class,'PDFView'])->name('pdfinv');
  Route::post('inventario/requierecc/{concepto?}', [InventoryController::class,'RequestCC'])->name('requiereccinv');
//;
//Auth::routes();

//==========================================================//
//                   Proveedores                            //
//==========================================================//

Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores');
Route::post('/ImportProveedores', [ProveedoresController::class, 'ImportProveedores'])->name('ImportProveedores');
Route::get('ExportProveedores', [ProveedoresController::class, 'ExportProveedores'])->name('ExportProveedores');