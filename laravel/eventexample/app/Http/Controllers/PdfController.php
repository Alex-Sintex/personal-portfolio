<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function download()
    {
        $data = "Kevin";
        $pdf = PDF::loadView('pdf.example', ['data' => $data]);
        //$pdf->save('/my_file.pdf');
        return $pdf->download('my-example.pdf');
    }
}
