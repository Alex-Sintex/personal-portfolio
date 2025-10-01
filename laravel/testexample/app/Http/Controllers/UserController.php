<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function detail($id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        return response()->json($user);
    }
}
