<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InfoRequest;
use App\Models\Info;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::get();
        return view('index', compact('infos'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(InfoRequest $request)
    {
        $fileName = time().'.'.$request->file->extension();
        // Guardar en public
        //$request->file->move(public_path('images'), $fileName);

        // Guardar en (storage)
        $request->file->storeAs('images', $fileName, 'public');

        $info = new Info;
        $info->name = $request->name;
        $info->file_uri = $fileName;
        $info->save();

        // Download the file
        return Storage::download('descarga.jpg', $info->file_uri);

        Storage::url($info->file_uri);
        // Create a temporal url
        Storage::temporaryUrl('my_image.jpg', now()->addMinutes(10));
    }
}
