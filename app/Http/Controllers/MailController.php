<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;

class MailController extends Controller
{
    public function send()
    {
        Mail::to('oguerreroortega@gmail.com')
        ->queue(new SignUp());
        return view('inicio');
    }
}
