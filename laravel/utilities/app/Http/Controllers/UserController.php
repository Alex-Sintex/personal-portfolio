<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\Uppercase;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::paginate(15);
    }

    public function search()
    {
        return view('search');
    }

    public function searchPost(Request $request)
    {
        $users = User::where('name', 'LIKE', "%{$request->name}%")->get();
        return view('search-results', compact('users'));
    }
}
