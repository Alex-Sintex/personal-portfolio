<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index()
    {
        return response()->json('Hello world', 200);
    }

    public function noAccess()
    {
        return response()->json("No access", 200);
    }
}
