<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $user = new User;
        $user->name = "Juanjo";
        $user->email = "demo@demo.com";
        $user->password = Hash::make('123456');
        $user->age = 25;
        $user->address = "Calle demostración 12";
        $user->zip_code = 290909;
        $user->save();

        User::create([
            "name" => "Ruiz",
            "email" => "info@demo.com",
            "password" => Hash::make('12345678'),
            "age" => 42,
            "address" => "Avenida de pruebas 17",
            "zip_code" => 280808
        ]);

        User::create([
            "name" => "Alejandro",
            "email" => "info@demodemo.com",
            "password" => Hash::make('12345678'),
            "age" => 40,
            "address" => "Avenida de pruebas 19",
            "zip_code" => 280808
        ]);

        return redirect()->route('user.index');
    }
}
