<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        // Validasi apakah order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.show', compact('order'));
    }

    public function process(Request $request, Order $order)
    {
        // Validasi apakah order milik user yang login
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Validasi input
        $request->validate([
            'payment_method' => 'required|in:transfer,ewallet', // Sesuaikan dengan value di form
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            // Upload bukti pembayaran
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            // Update status order
            $order->update([
                'status' => 'pending_verification',
                'payment_method' => $request->payment_method,
                'payment_proof' => $path
            ]);

            // Redirect ke halaman status pembayaran dengan pesan sukses
            return redirect()
                ->route('payment.status', $order)
                ->with('success', 'Pembayaran berhasil dikirim dan sedang menunggu verifikasi');
                
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Payment Processing Error: ' . $e->getMessage());
            
            // Redirect back dengan pesan error yang lebih spesifik
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }

    public function status(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return view('payment.status', compact('order'));
    }

    public function download(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'verified') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk mengunduh file ini');
        }
    
        $filePath = storage_path('app/public/' . $order->product->file_path);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan');
        }
    
        return response()->download($filePath);
    }
}