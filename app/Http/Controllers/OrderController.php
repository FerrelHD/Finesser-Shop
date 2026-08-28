<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function download(Order $order)
    {
        // Pastikan user yang request adalah pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Pastikan order sudah completed
        if ($order->status !== 'completed') {
            return back()->with('error', 'Order belum selesai');
        }

        // Return file untuk di download
        return response()->download(storage_path('app/public/' . $order->product->file_path));
    }

    public function pay(Order $order)
    {
        // Pastikan user yang request adalah pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Redirect ke halaman pembayaran
        return redirect()->route('payment.show', $order->id);
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    if ($order->status !== 'pending') {
        return back()->with('error', 'Hanya pesanan dengan status pending yang dapat dibatalkan.');
    }

    $order->update(['status' => 'cancelled']);
    return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibatalkan.');
}

}