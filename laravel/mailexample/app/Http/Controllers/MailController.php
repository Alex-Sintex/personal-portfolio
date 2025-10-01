<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Example;
use App\Mail\ExampleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function mailMe()
    {
        Mail::to('al3xander4976@gmail.com')->send(new ExampleMail('Alex Sintex'));
        return view('sent');
    }
}
