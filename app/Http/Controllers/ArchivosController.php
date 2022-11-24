<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivosController extends Controller
{
    public function __construct()
    {
        
    }
    public function guardar_docto_local(Request $request){
        if(Storage::disk('local')->exists($request));
    }
}
