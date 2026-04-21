<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   public function index()
   {
      // dd("here");
      $order = Order::with("user","plan")->get();
      return view("admin-view.orders.index",compact("order"));
   }
}
