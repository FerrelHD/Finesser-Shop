<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Events\PaymentVerified;

class AdminOrderController extends Controller
{
    public function verify(Order $order)
    {
        $order->update(['status' => 'verified']);

        event(new PaymentVerified($order));

        return back()->with('success', 'Pembayaran telah diverifikasi dan user akan auto-refresh');
    }
}