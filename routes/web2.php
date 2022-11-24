<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\OrdenesComprasController;
use App\Http\Controllers\ProviderArticlesController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers;
//use App\Http\Controllers\Auth;

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
//Requisiciones
Route::get('email/{id}', [RequisitionController::class,'EmailView'])->name('email');

Route::get('/', function () {
  if (session()->get('user') === null) {
    return view('login');
    //return view('welcome');
  }else{
    if (session()->get('rol') === "Administrador") {
      return redirect('inicio');
    }else{
      return redirect('requisicion');
    }

  }
})->name('home');

//Auth::routes();
Route::post('login',[LoginController::class,'Login'])->name('login');
Route::get('logout',[LoginController::class,'Logout'])->name('logout');
Route::get('password/confirm',[ConfirmPasswordController::class,'showConfirmForm'])->name('paswword.comfirm');
Route::post('password/confirm',[ConfirmPasswordController::class,'confirm']);
Route::post('password/email',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset',[ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('password/reset',[ResetPasswordController::class,'reset'])->name('password.update');
Route::get('password/reset/{token}',[ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::get('register',[RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('register',[RegisterController::class,'register'])->name('register.store');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('email/{id}', [ActivityController::class,'EmailView'])->name('emailact');
Route::get('ordencompra/email/{id}',[OrdenesComprasController::class, 'EmailView'])->name('sendemailordencompraview');


Route::group(['middleware' => ['CheckUser']], function(){

  Route::view('/inicio', 'inicio');

  //Requisiciones

  Route::get('requisicion', [RequisitionController::class,'Requisition'])->name('requisicion');
//Boton autoriza requisicion
  Route::post('requisicion/autorizar', [RequisitionController::class, 'AuthRequisition'])->where('id', '[0-9]+')->name('autorizar');

  Route::post('requisicion/cancelar', [RequisitionController::class, 'CancelRequisition'])->name('cancelar');

  Route::get('requisicion/nueva', [RequisitionController::class, 'NewRequisition'])->name('nueva');

  Route::post('requisicion/submit', [RequisitionController::class, 'SubmitRequisition'])->name('submit');

  Route::post('requisicion/update',  [RequisitionController::class, 'UpdateRequisition']);

  Route::post('requisicion/submitarticles', [RequisitionController::class, 'NewRequisitionDetail'])->name('submitarticles');

  Route::post('requisicion/images', [RequisitionController::class, 'RequisitionImagen'])->name('images');

  Route::get('requisicion/edit/{id}', [RequisitionController::class, 'EditRequisition'])->where('id', '[0-9]+');

  Route::post('requisicion/deletearticle', [RequisitionController::class, 'DeleteArticle']);

  Route::post('requisicion/articles', [RequisitionController::class, 'GetArticlesRequisition']);

  Route::post('requisicion/articlesbytype', [RequisitionController::class, 'GetArticlesRequisitionByType']);

  Route::get('requisicion/costsbytype/{parameter?}', [RequisitionController::class, 'GetCostsByType'])->name('costsbytype');
  //Route::get('requisicion/costsbytype/{parameter?}', [RequisitionController::class, 'GetCostsByType'])->name('costsbytype');

  Route::post('requisicion/sendemail', [RequisitionController::class, 'SendEmail'])->name('sendemail');

  Route::post('requisicion/apply', [RequisitionController::class, 'AppRequisition'])->name('apprequisition');
  ///ruta pdf
  Route::get('pdf/{id}', [RequisitionController::class, 'PDFView'])->name('pdf');

  Route::post('requisicion/sendpdf', [RequisitionController::class, 'SendEmailPDFAuth'])->name('sendpdf');
  //ver
  Route::get('requisicion/ver/{id}', [RequisitionController::class, 'VerRequisition'])->where('id', '[0-9]+')->name('ver-auth');
  //autoriza
  Route::get('requisicion/autoriza/{id}', [RequisitionController::class, 'AutorizaRequisition'])->where('id', '[0-9]+')->name('autoriza');

  Route::post('requisicion/deleteimage', [RequisitionController::class, 'DeleteImage'])->name('del-images');

  Route::post('cambiapassword', [RequisitionController::class, 'ChangePassword']);

  Route::get('requisicion/soporte/{id}', [RequisitionController::class, 'SupportRequisitionCompleted'])->where('id', '[0-9]+')->name('soporte');

  Route::get('requisicion/particion/{id}', [RequisitionController::class, 'PartitionRequisition'])->where('id', '[0-9]+')->name('particion');

  Route::post('requisicion/particionar', [RequisitionController::class, 'PartitionRequisitionDetail'])->name('particionar');

Route::get('requisicion/reporterequisicion', [RequisitionController::class, 'BitacoraRequisicion'])->name('reporterequisicion');

//Usuarios
  Route::get('usuarios', [UserController::class,'User'])->name('usuario');

  Route::post('editarusuario', [UserController::class,'EditUser']);

  Route::post('nuevousuario',[UserController::class,'NewUser'])->name('new.user');
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

  // Articulos Proveedores

  //Articulos Proveedor
  Route::get('proveedor/articulos/{id}/{estatus}', [ProviderArticlesController::class,'GetProviderArticles'])->name('articulosproveedores');

  Route::get('proveedor/getproviders', [ProviderArticlesController::class,'GetProviders'])->name('providers');

  Route::get('proveedor/searchproviders', [ProviderArticlesController::class,'SearchArticlesProvider'])->name('searchproviders');

  Route::get('proveedor/articulo/{id}', [ProviderArticlesController::class,'GetProviderArticleData'])->name('articulosproveedores');

  Route::post('proveedor/articulo/asignar', [ProviderArticlesController::class,'updateProviderArticle']);


  //Inventarios

  Route::get('inventario/{tipo}', [InventoryController::class,'Inventory'])->name('inventory');;

  Route::get('inventario/nuevo', [InventoryController::class,'NewInventory']);
  //Ordenes de Compras
  Route::get('/ordencompra',[OrdenesComprasController::class, 'OrdenesCompras'])->name('ordenescompras');

  Route::get('ordencompra/nueva',[OrdenesComprasController::class,'NewOrder'])->name('nuevaOrden');

  Route::post('ordencompra/submit',[OrdenesComprasController::class,'SubmitOrdenCompra'])->name('submit.ordencompra');

  Route::get('ordencompra/edit/{id}',[OrdenesComprasController::class,'EditOrdenCompra'])->where('id', '[0-9]+');

  Route::get('ordenescompras/selectcentroscostos/{parameter?}',[OrdenesComprasController::class,'OCCentrosCostos'])->name('select.centroscostos');
  //Route::get('ordenescompras/selectcentroscostos/{parameter?}',['as'=>'select.centroscostos','uses'=>'OrdenesComprasController@OCCentrosCostos']);
  Route::post('ordencompra/submitarticles', [OrdenesComprasController::class, 'NewOrdenCompraDet'])->name('submitarticles_oc');

  Route::post('ordencompra/edit/ordencompra/deletearticle', [OrdenesComprasController::class, 'DeleteArticle']);

  Route::post('ordencompra/requisicionesbytype', [OrdenesComprasController::class, 'GetRequisitionCompraByType']);

  Route::get('ordencompra/ver/{id}', [OrdenesComprasController::class, 'VerCompra'])->where('id', '[0-9]+')->name('ver-auth-oc');

  Route::post('ordencompra/compra/update', [OrdenesComprasController::class, 'UpdateCompra']);

  Route::post('ordencompra/agregarrequisicion',[OrdenesComprasController::class,'AgregarRequisition'])->name('agregar.requ.ordencompra');

  Route::post('ordencompra/apply', [OrdenesComprasController::class, 'AppOrdenCompra'])->name('appordencompra');

  Route::post('ordencompra/sendemail', [OrdenesComprasController::class, 'SendEmail'])->name('sendemailordencompra');

  Route::get('ordencompra/autoriza/{id}', [OrdenesComprasController::class, 'AutorizaOrdenCompra'])->where('id', '[0-9]+')->name('autorizaordencompra');

  Route::post('ordencompra/autorizar', [OrdenesComprasController::class, 'AuthOrdenCompra'])->where('id', '[0-9]+')->name('autorizaroc');

  Route::post('ordencompra/cancelar', [OrdenesComprasController::class, 'CancelOrdenCompra'])->name('cancelarordencompra');

  Route::get('pdfordencompra/{id}', [OrdenesComprasController::class, 'PDFView'])->name('pdfordencompra');

  Route::post('ordencompra/sendpdf', [OrdenesComprasController::class, 'SendEmailPDFAuth'])->name('sendpdfordencompra');
  
  Route::get('pdfordencompraautorizado/{id}', [OrdenesComprasController::class, 'PDFViewAuth'])->name('pdfordencompraauth');
  
});