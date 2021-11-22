<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Order;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $rows = Order::all();
        return view('admin::order.index', compact('rows'));
    }

    public function invoice($id)
    {
        $order=Order::find($id);
        return view('admin::order.invoice', compact('order'));
    }
}
