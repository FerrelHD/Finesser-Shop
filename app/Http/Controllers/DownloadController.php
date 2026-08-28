<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download(Order $order)
    {
        // Pastikan user yang login adalah pemilik order atau admin
        if (auth()->id() !== $order->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan order sudah diverifikasi
        if ($order->status !== 'verified') {
            return redirect()->back()->with('error', 'Pembayaran belum diverifikasi.');
        }

        // Ambil file dari produk
        $file = $order->product->file_path;
        
        // Pastikan file ada
        if (!Storage::exists($file)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        // Return file untuk didownload
        return Storage::download($file, $order->product->title . '.' . pathinfo($file, PATHINFO_EXTENSION));
    }
}