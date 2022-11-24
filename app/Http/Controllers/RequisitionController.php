<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Html\FormFacade;

use Illuminate\Html\HtmlFacade;

use App\Http\Requests;

use App\Models\RequisitionModel;

use Exception;

use Illuminate\Http\Exceptions;

use Illuminate\Support\Facades\Config;

use Mail;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

use PDF;

use Illuminate\Support\Str;





class RequisitionController extends Controller

{

  protected $RequisitionModel;



  public function __construct() {

    $this->RequisitionModel = new RequisitionModel();

  }



  public function Requisition()

  {

    $content = array();

    $usuario = \Session::get('email');

    $rol = \Session::get('rol');

    //requisiciones



      try {

        $requisiciones = $this->RequisitionModel->getRequisiciones($usuario);

      }

      catch (\Exception $e) {

        return $e->getMessage();

      }







    //estatus password

    try {

      $statuspassword = $this->RequisitionModel->getStatusPassword($usuario);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['requisiciones'] = $requisiciones;

    $content['status_password'] = $statuspassword;

    $content['totalrequisiciones'] = count($requisiciones);



    return view('requisicion.requisicion', ['content' => $content]);

  }



  public function getRequisitionData($id)

  {

    $content = array();

    $content['id_requisicion'] = $id;



    //datos de la requisición

    try {

      $requisicion = $this->RequisitionModel->getDoctoRequisicion($id);



    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    $content['requisicion'] = $requisicion;





    //articulos de la requisición

    try {

      $articulos_requisicion = $this->RequisitionModel->getArticulosRequisicion($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['articulos_requisicion'] = $articulos_requisicion;



    return $content;

  }



  public function NewRequisition()

  {



    $content = array();



    //conceptos requisiciones

    try {

      $conceptos_requisiciones = $this->RequisitionModel->getConceptosRequisiciones();

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['conceptos_requisiciones'] = $conceptos_requisiciones;





    return view('requisicion.nuevarequisicion', ['content' => $content]);

  }





  public function EditRequisition($id)

  {

    $usuario = \Session::get('email');

    $rol = \Session::get('rol');



    try {

      if ($rol == 'Administrador') {

        $result = $this->RequisitionModel->validateRequisicionid($id);

      }

      else {

      $result = $this->RequisitionModel->validateRequisicionidUsuario($id, $usuario);

      }

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    if (count($result) == 0) {

      return back();

    }



    $content = array();

    $content['id_requisicion'] = $id;





    //datos de la requisición

    try {

      $requisicion = $this->RequisitionModel->getDoctoRequisicion($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    $content['requisicion'] = $requisicion;

    // print_r($content['requisicion'][0]->nombre);

    // die();



    //articulos de la requisición

    try {

      $articulos_requisicion = $this->RequisitionModel->getArticulosRequisicion($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['articulos_requisicion'] = $articulos_requisicion;



    //articulos

    try {

      $articulos = $this->RequisitionModel->getArticulos($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['articulos'] = $articulos;



    // if (Storage::disk('s3')->exists('requisiciones/2022-06-27-08-53-13pm.jpg')) {

    //   return 'data';

    // }

    //imágenes

    //$path = Storage::disk('s3')->get('requisiciones/2022-06-27-08-53-13pm.jpg');

    // $path = Storage::get('https://bucketerpmega.s3.amazonaws.com/requisiciones/2022-06-27-08-53-13pm.jpg');

    // $path= Storage::getFacadeRoot('requisiciones/2022-06-27-08-53-13pm.jpg');

    //return Storage::download('requisiciones/2022-06-27-08-53-13pm.jpg');

      //$path='https://'.Config::get('filesystems.disks.s3.url').'/requisiciones/2022-06-27-08-53-13pm.jpg';

    //return $path;

    try {

      $imagenes = $this->RequisitionModel->getImagenes($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    /*foreach($imagenes as $img){

      $img=Storage::disk('s3')->url($img->ruta);

      return $img;

      $img->ruta='https://'.Config::get('filesystems.disks.s3.url').'/'.$img->ruta;

      return $img->ruta;

    }*/



    $content['imagenes'] = $imagenes;





    return view('requisicion.editarequisicion', ['content' => $content]);



  }



  public function SubmitRequisition(Request $request)

  {

    $content = array();

    $response = array("status" => false, "data" => array());



    if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";

    }



    $post = $request->request->all();



    $concepto_requisicion = $post['concepto_requisicion'];

    $descripciond = $post['descripciond'];

    $fechad = date("Y-m-d");

    $usuario = \Session::get('email');





    try {

      $result = $this->RequisitionModel->insertRequisicion($concepto_requisicion, $fechad, $descripciond, $usuario);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    //

    $result = json_decode(json_encode($result), true);

    $id_requisicion = $result[0]['Proceso'];

    $content['id_requisicion'] = $id_requisicion;





    return $content;



  }



  public function UpdateRequisition(Request $request)

  {

    

    $content = array();

    $response = array("status" => false, "data" => array());

    

    if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";

    }



    $post = $request->request->all();



    $descripciond = $post['descripciond'];

    $id = $post['requisicion_id'];

    



    try {

      $result = $this->RequisitionModel->updateRequisicion($id, $descripciond);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    return $this->getResponse($response);



  }





  //////////////IMAGEN/////////////////////

 public function RequisitionImagen(Request $request)

  {

    $usuario = \Session::get('email');

    $post = $request->request->all();

    $doctorequisicionid = $post['id_requisicion'];

    // $imagen = addslashes(file_get_contents($_FILES['uploadedfile']['tmp_name']));   //$post['file'];

    $imagen = file_get_contents($_FILES['uploadedfile']['tmp_name']);

    $extension = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);

    $nombre = date("Y-m-d") . '-' . date("h-i-sa") . '.' . $extension;



    if (isset($post['descripcionimg'])) {

      $descripcion = $post['descripcionimg'];

    } else {

      $descripcion = "";

    }

    $carpeta = 'requisiciones/' ;

    $archivo = $carpeta . $nombre;

    if(!Storage::disk('s3')->exists($archivo)){

      try{

        if(!Storage::disk('s3')->put($carpeta.$nombre,$imagen)){

          $resp[0]['Proceso']= 'No se pudo agregar la imagen';

          return $resp;

        }

      }catch(\Exception $e){

        $resp[0]['Proceso']= 'error:'.$e->getMessage();

        return $resp;

      }

    }else{

      $resp[0]['Proceso']= 'Este archivo ya existe';

      return $resp;

    }

    //$archivo="requisiciones/2022-06-30-02-44-15pm.jpg";

    try {

    //  $result = $this->RequisitionModel->($doctorequisicionid, $imagen, "jpeg", "nombrearchivo", "descripcion", "cualquierusuario" );

        $result = $this->RequisitionModel->RequisitionImagen($doctorequisicionid, $archivo, $extension, $nombre, $descripcion, $usuario);

        if($result[0]->Proceso != 'Imagen agregada'){

          Storage::disk('s3')->delete($archivo);

        }

      return $result;

    }

    catch (\Exception $e) {

      $resp[0]['Proceso']=$e->getMessage();

      Storage::disk('s3')->delete($archivo);

      return $resp;

    }

  }

  ///////////////////////////////////////////////////////7



  //articles = array

  //centrocostdod = string

  //cantidad = decimal

  //notad = string

  //doctorequisicionid = int



  public function NewRequisitionDetail(Request $request)

  {

    $usuario = \Session::get('email');

    $response = array("status" => false, "data" => array());



    if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";

    }



    $post = $request->request->all();

    $articles = json_decode($post['jsonArticles'], True);



    foreach ($articles as $article=>$value) {



      $cantidadd = (int)$value['cantidad'];



      $id_requisicion = (int)$value['req'];



      if ($value['nombre']) {

        $articulod = $value['nombre'] ;

      } else {

        $articulod = "";

      }





      if (isset($value['seleccionado'])) {



        $centrocostod = $value['seleccionado'] ;

      } else {



        $centrocostod = "";

      }





      if (isset($value['nota'])) {

        $notad = $value['nota'];

      } else {

        $notad = "";

      }





      if ($cantidadd ) {



        try {

          $result = $this->RequisitionModel->insertRequisicion_det($articulod, $centrocostod, $cantidadd, $notad, $id_requisicion, $usuario);



        }

        catch (\Exception $e) {

          return $e->getMessage();

        }





      } else{



      }







    }

    $result = json_decode(json_encode($result), true);

    $id_requisicion_det = $result[0]['Proceso'];





    return $id_requisicion_det;



  }



  public function DeleteArticle(Request $request)

  {

    $usuario = \Session::get('email');

    if ($request->getMethod() != 'POST') {



      $response['data'] = "Not Authorized";

    }



    $post = $request->request->all();





    $doctorequisiciondetid = (int) $post['articulo_id'];

    $requisicion_id = (int) $post['requisicion_id'];







    try {

      $result = $this->RequisitionModel->deleteArticuloRequisicion($requisicion_id, $doctorequisiciondetid, $usuario );

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



      return $this->getResponse($result);

  }



  public function GetArticlesRequisition(Request $request) {

       $content = array();

       $post = $request->request->all();

       $id = (int) $post['requisicion_id'];





       //articulos de la requisición

       try {

         $articulos_requisicion = $this->RequisitionModel->getArticulosRequisicion($id);

       }

       catch (\Exception $e) {

         return $e->getMessage();

       }



       $content['articulos_requisicion'] = $articulos_requisicion;





       return $this->getResponse($content);

   }



   public function GetArticlesRequisitionByType(Request $request) {

        $content = array();

        $post = $request->request->all();

        $id = (int) $post['requisicion_id'];





        //articulos

        try {

          $articulos = $this->RequisitionModel->getArticulos($id);

        }

        catch (\Exception $e) {

          return $e->getMessage();

        }



        $content['articulos'] = $articulos;







        return $this->getResponse($content);

    }



    public function GetCostsByType(Request $request) {

         $content = array();

         $post = $request->request->all();



         if (isset($post['term'])) {

           $term = $post['term'];

         } else {

           $term = "";

         }

         //centros de costos

         try {

           $centros_costos = $this->RequisitionModel->getCentrosCostosbyTerm($term);

         }

         catch (\Exception $e) {

           return $e->getMessage();

         }

         $content['results'] = $centros_costos;

         $content['pagination']['more'] = true;





         return $this->getResponse($content);

     }



   public function AppRequisition(Request $request)

   {

     $usuario = \Session::get('email');

     $response = array("status" => false, "data" => array());

     if ($request->getMethod() != 'POST') {

       $response['data'] = "Not Authorized";

     }



     $post = $request->request->all();

     $id = (int) $post['requisicion_id'];



     //Aplicar la requisicón

     try {

       $result = $this->RequisitionModel->aplicaRequisicion($id, $usuario);

     }

     catch (\Exception $e) {

       return $e->getMessage();

     }

     $result = json_decode(json_encode($result), true);



     if (count($result) != 0) {

      $response['data'] = $result[0]['Proceso'];

     }else{

       $response['data'] = "exitoso";

     }



      return $this->getResponse($response);

   }



   public function SendEmail(Request $request)

   {



     $response = array("status" => false, "data" => array());



     if ($request->getMethod() != 'POST') {

       $response['data'] = "Not Authorized";

     }



     $post = $request->request->all();

      $id = (int) $post['requisicion_id'];

     $content = array();

     $content = $this->getRequisitionData($id);



     $content['id_requisicion'] = $id;

     $email = $this->RequisitionModel->getEmailToAuthRequisition($id);

     //$list_email = ['julianamoncada4@hotmail.com','kiuboparce@hotmail.com'];

     // print_r($email);



     // die();

     $email = $email[0]->correo_notificacion;

     $list_email = explode(",",$email);



     //Datos del email

       $content['datamail'] = [

         //'email'=>'jfsayeg@megafreshproduce.com.mx',

         'email'=>$list_email,

         'subject'=>'Nueva requisición a autorizar',

         'bodyMessage'=>'Prueba',

       ];





       //Enviar el mail

       try {

         $mail = Mail::send('requisicion.email', ['content' => $content],function($message) use ($content){

           $message->from('requisiciones@megafreshproduce.com.mx', 'Requisiciones Mega Fresh Produce');

           $message->to($content['datamail']['email']);

           $message->subject($content['datamail']['subject']);



         });

       }

       catch (\Exception $e) {

         return $e->getMessage();

       }

        $response['data'] = "Correo enviado exitosamente";

         return $this->getResponse($response);

   }



   public function SendEmailPDFAuth(Request $request)

   {

     $response = array("status" => false, "data" => array());



     if ($request->getMethod() != 'POST') {

       $response['data'] = "Not Authorized";

     }



     $post = $request->request->all();

     $id = (int) $post['requisicion_id'];



     $content = array();



     $content = $this->getRequisitionData($id);

     $content['id_requisicion'] = (int)$id;



     $email = $content['requisicion'][0]->email;

     $folio = $content['requisicion'][0]->folio;

     $list_email = explode(",",$email);

    // $pdf = $this->PDFView($id);





     //Datos del email

       $content['datamail'] = [

         //'email'=>'jfsayeg@megafreshproduce.com.mx',

         'email'=>$list_email,

         'subject'=>'Requisición autorizada '. $folio,

         'bodyMessage'=>'Prueba',

       ];



       //Enviar el mail

       try {

         $mail = Mail::send('requisicion.emailautorizado', ['content' => $content],function($message) use ($content){

           $message->from('requisiciones@megafreshproduce.com.mx', 'Requisiciones Mega Fresh Produce');

           $message->to($content['datamail']['email']);

           $message->subject($content['datamail']['subject']);

           // $message->attach('http://www.megafreshproduce.com.mx/erp-web/requisicion/pdf/218', array(

           //            'as' => 'requisicion.pdf',

           //            'mime' => 'application/pdf')

           //            );

         });

       }

       catch (\Exception $e) {

         return $e->getMessage();



       }

        $response['data'] = "Correo enviado exitosamente";

         return $this->getResponse($response);

   }



///////////////////////////////////////

 public function PDFView($id)

   {

     $usuario = \Session::get('email');

     $rol = \Session::get('rol');



     // try {

     //   if ($rol == 'Administrador') {

     //     $result = $this->RequisitionModel->validateRequisicionid($id);

     //   }

     //   else {

     //   $result = $this->RequisitionModel->validateRequisicionidUsuario($id, $usuario);

     //   }

     // }

     // catch (\Exception $e) {

     //   return $e->getMessage();

     // }

     //

     // if (count($result) == 0) {

     //   return back();

     // }



     $content = array();

     $content = $this->getRequisitionData($id);



     //return view('requisicion.pdf', ['content' => $content]);

     $pdf = PDF::loadView('requisicion.pdf', ['content' => $content])->setPaper('a4');

     return $pdf->stream();

     //return $pdf->download('hdtuto.pdf');

}









///////////////////////////

   public function EmailView($id)

   {



     $content = array();

     $content = $this->getRequisitionData($id);

     return view('requisicion.email', ['content' => $content]);

   }



   public function AuthRequisition(Request $request)

   {

     if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";

    }



    $post = $request->request->all();



    $id = $post['requisicion_id'];



     $usuario = \Session::get('email');

     //Autorizar la requisición

     try {

       $result = $this->RequisitionModel->autorizaRequisicion($id, $usuario);

     }

     catch (\Exception $e) {

       return $e->getMessage();

     }



     $result = json_decode(json_encode($result), true);



     if (count($result) != 0) {

       //$this->SendEmailPDFAuth($id);

        return $result[0]['Proceso'];

     }

   }



   ///------------------------------------------//////////7

    public function CancelRequisition(Request $request)

   {

     if ($request->getMethod() != 'POST') {

      $response['data'] = "Not Authorized";

    }



    $post = $request->request->all();



    $id = $post['requisicion_id'];

    $descripcion = "prueba";







     $usuario = \Session::get('email');





     //Cancelar la requisición

     try {

       $result = $this->RequisitionModel->cancelaRequisicion($id, $usuario, $descripcion);

     }

     catch (\Exception $e) {

       return $e->getMessage();

     }



     $result = json_decode(json_encode($result), true);



     if (count($result) != 0) {

        return $result[0]['Proceso'];

     }

   }



    ///------------------------------------------//////////7





  //////////////////////////// Ver _____________________________________-



   public function VerRequisition($id)

  {

    $usuario = \Session::get('email');

    $rol = \Session::get('rol');



    try {

        $result = $this->RequisitionModel->validateRequisicionid($id);



    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    if (count($result) == 0) {

      return back();

    }



    $content = array();

    $content['id_requisicion'] = $id;





    //datos de la requisición

    try {

      $requisicion = $this->RequisitionModel->getDoctoRequisicion($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    $content['requisicion'] = $requisicion;

    // print_r($content['requisicion'][0]->nombre);

    // die();



    //articulos de la requisición

    try {

      $articulos_requisicion = $this->RequisitionModel->getArticulosRequisicion($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['articulos_requisicion'] = $articulos_requisicion;



    //articulos

    try {

      $articulos = $this->RequisitionModel->getArticulos($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['articulos'] = $articulos;





    //imágenes

    try {

      $imagenes = $this->RequisitionModel->getImagenes($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    // foreach($imagenes as $img){

    //   $img->ruta='https://'.Config::get('filesystems.disks.s3.url').'/'.$img->ruta;

    // }



    $content['imagenes'] = $imagenes;



    return view('requisicion.terminarequisicion', ['content' => $content]);



  }



  public function AutorizaRequisition($id)

 {



   $usuario = \Session::get('email');

   $rol = \Session::get('rol');



   try {

     if ($rol == 'Administrador') {

       $result = $this->RequisitionModel->validateRequisicionid($id);

     }

     else {

     $result = $this->RequisitionModel->validateRequisicionidUsuario($id, $usuario);

     }

   }

   catch (\Exception $e) {

     return $e->getMessage();

   }



   if (count($result) == 0) {

     return back();

   }



   $content = array();

   $content['id_requisicion'] = $id;



   //datos de la requisición

   try {

     $requisicion = $this->RequisitionModel->getDoctoRequisicion($id);

   }

   catch (\Exception $e) {

     return $e->getMessage();

   }

   $content['requisicion'] = $requisicion;



   //articulos de la requisición

   try {

     $articulos_requisicion = $this->RequisitionModel->getArticulosRequisicion($id);

   }

   catch (\Exception $e) {

     return $e->getMessage();

   }



   $content['articulos_requisicion'] = $articulos_requisicion;



   //articulos

   try {

     $articulos = $this->RequisitionModel->getArticulos($id);

   }

   catch (\Exception $e) {

     return $e->getMessage();

   }



   $content['articulos'] = $articulos;







   //imágenes

   try {

     $imagenes = $this->RequisitionModel->getImagenes($id);

   }

   catch (\Exception $e) {

     return $e->getMessage();

   }

  // foreach($imagenes as $img){

  //   $img->ruta='https://'.Config::get('filesystems.disks.s3.url').'/'.$img->ruta;

  // }

   $content['imagenes'] = $imagenes;



   return view('requisicion.autorizarequisicion', ['content' => $content]);



 }





public function DeleteImage(Request $request){

  if ($request->getMethod() != 'POST') {



    $response['data'] = "Not Authorized";

  }

  $usuario = \Session::get('email');

  $post = $request->request->all();

  $imagen_id = (int) $post['imagen_id'];

  $requisicion_id = (int) $post['requisicion_id'];

  $archivo=$this->RequisitionModel->getImagenRuta($imagen_id);

  try {

    $result = $this->RequisitionModel->deleteImagenRequisicion($requisicion_id, $imagen_id, $usuario);

    if($result[0]->Proceso == 'Imagen eliminada'){

     Storage::disk('s3')->delete($archivo);

    }

  }

  catch (\Exception $e) {

    $res[0]['Proceso']=$e->getMessage();

    return $res;

  }

    return $result;

}



 public function ChangePassword(Request $request)

{

  if ($request->getMethod() != 'POST') {

   $response['data'] = "Not Authorized";

 }



 $post = $request->request->all();



  $usuario = \Session::get('email');

  $newpassword = $post['newpasswordconfirmation'];

  $passwordEncrypted = $this->encryptValue($newpassword);







  //Cancelar la requisición

  try {

    $result = $this->RequisitionModel->updatePassword($usuario, $passwordEncrypted);

  }

  catch (\Exception $e) {

    return $e->getMessage();

  }



return $result;

}



public function SupportRequisitionCompleted($id)

  {

    $usuario = \Session::get('email');

    $rol = \Session::get('rol');



    try {

      if ($rol == 'Administrador') {

        $result = $this->RequisitionModel->validateRequisicionid($id);

      }

      else {

      $result = $this->RequisitionModel->validateRequisicionidUsuario($id, $usuario);

      }

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    if (count($result) == 0) {

      return back();

    }





    $content = array();

    $content = $this->getRequisitionData($id);



    //imágenes

    try {

      $imagenes = $this->RequisitionModel->getImagenes($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    // foreach($imagenes as $img){

    //   $img->ruta='https://'.Config::get('filesystems.disks.s3.url').'/'.$img->ruta;

    // }



    $content['imagenes'] = $imagenes;



    return view('requisicion.imagensoporte', ['content' => $content]);

}



public function PartitionRequisition($id)

  {

    $usuario = \Session::get('email');

    $rol = \Session::get('rol');



    try {

      if ($rol == 'Administrador') {

        $result = $this->RequisitionModel->validateRequisicionid($id);

      }

      else {

      $result = $this->RequisitionModel->validateRequisicionidUsuario($id, $usuario);

      }

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    if (count($result) == 0) {

      return back();

    }



    $content = array();

    $content['id_requisicion'] = $id;



    //datos de la requisición

    try {

      $requisicion = $this->RequisitionModel->getDoctoRequisicion($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }

    $content['requisicion'] = $requisicion;



    //articulos de la requisición

    try {

      $articulos_requisicion = $this->RequisitionModel->getArticulosRequisicion($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['articulos_requisicion'] = $articulos_requisicion;



    //articulos

    try {

      $articulos = $this->RequisitionModel->getArticulos($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['articulos'] = $articulos;







    //imágenes

    try {

      $imagenes = $this->RequisitionModel->getImagenes($id);

    }

    catch (\Exception $e) {

      return $e->getMessage();

    }



    $content['imagenes'] = $imagenes;





    return view('requisicion.particionrequisicion', ['content' => $content]);

}



public function PartitionRequisitionDetail(Request $request)

{

  $usuario = \Session::get('email');

  $response = array("status" => false, "data" => array());



  if ($request->getMethod() != 'POST') {

    $response['data'] = "Not Authorized";

  }



  $post = $request->request->all();

  $articles = json_decode($post['jsonArticles'], True);



  foreach ($articles as $article=>$value) {



    $cantidadd = (int)$value['cantidad'];



    $id_requisicion = (int)$value['req'];



    if ($value['nombre']) {

      $articulod = $value['nombre'] ;

    } else {

      $articulod = "";

    }





    if (isset($value['seleccionado'])) {



      $centrocostod = $value['seleccionado'] ;

    } else {



      $centrocostod = "";

    }





    if (isset($value['nota'])) {

      $notad = $value['nota'];

    } else {

      $notad = "";

    }





    if ($cantidadd ) {



      try {

        $result = $this->RequisitionModel->insertRequisicion_det($articulod, $centrocostod, $cantidadd, $notad, $id_requisicion, $usuario);



      }

      catch (\Exception $e) {

        return $e->getMessage();

      }





    } else{



    }







  }

  $result = json_decode(json_encode($result), true);

  $id_requisicion_det = $result[0]['Proceso'];





  return $id_requisicion_det;



}



public function BitacoraRequisicion()

{



  try {

    $bitacorarequisicion = $this->RequisitionModel->getBitacoraRequisicion();

  }

  catch (\Exception $e) {

    return $e->getMessage();

  }



  $content['bitacorarequisiciones'] = $bitacorarequisicion;





  return view('requisicion.bitacorarequisiciones', ['content' => $content]);

}



public function encryptValue($value)

{

  $key = \Config::get('app.key');

  if (Str::startsWith($key, 'base64:')) {

      $key = base64_decode(substr($key, 7));

  }



  return hash_hmac('sha256', $value , $key);

}



   public function getResponse($data) {

     $response = new Response(json_encode($data), 200, array('Content-Type', 'text/json'));

     $response->headers->set('Access-Control-Allow-Origin', '*');

     $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, *');

     return $response;

   }

   //=================================================================================

   public function usuarioempresa(Request $request)
   {
   
    //=====================================================================================
    $nombreP = $request->nombre;
    $emailP = $request->correo;
    $empresa = $request->empresa;
    $claveP = $this->encryptValue($request->password);
    $tipo = 2;
    $idP = DB::table('empresas')->where('correo_empresa', $empresa)->value('empresa_id');
    //======================================================================================
    $query = "call NUEVOUSUARIOWEB('$nombreP','$emailP','$claveP','$idP','$tipo');";
      try {
      $resultado = DB::select($query,array()); 
      $resultado = $resultado[0]->Respuesta; //Respuesta es lit la respuesta del store xD
      } catch (\Exception $th) {
      $resultado = $th->getMessage();
      }
   return redirect()->back();
   }



}

