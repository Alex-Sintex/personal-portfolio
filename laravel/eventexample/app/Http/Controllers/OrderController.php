<?php

namespace App\Http\Controllers;

use App\Events\CreateOrderEvent;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class OrderController extends Controller
{
    public function create()
    {
        Artisan::call('make:order', ['user_id' => 75, 'amount' => 60]);
        /*
        $order = Order::create([
            'user_id' => 10,
            'amount' => 25,
        ]);*/
        //CreateOrderEvent::dispatch($order);
        return response()->json([
            'message' => 'Éxito'
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /* Example of command inside controller
    public function install()
    {
        Artisan::call('migrate');
        Artisan::call('seed:db');
    }
    */
}
