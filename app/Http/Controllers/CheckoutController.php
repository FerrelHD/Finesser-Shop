<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Produk $produk)
    {
        return view('checkout.show', compact('produk'));
    }

    public function store(Request $request, Produk $produk)
    {
        // Validasi user harus login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            // Jika produk gratis, langsung set status verified
            $status = $produk->price == 0 ? 'verified' : 'pending';
            
            // Buat order baru
            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $produk->id,
                'quantity' => 1,
                'total_price' => $produk->price,
                'status' => $status
            ]);

            // Jika produk gratis, langsung ke halaman download
            if ($produk->price == 0) {
                return redirect()->route('download.file', $order)->with('success', 'Produk berhasil didapatkan');
            }

            // Jika berbayar, redirect ke halaman pembayaran
            return redirect()->route('payment.show', $order)->with('success', 'Order berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat order: ' . $e->getMessage());
        }
    }
}