<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Download digital asset securely
     */
    public function download(Order $order)
    {
        // 1. Otorisasi: Pastikan user yang request adalah pemilik order atau admin
        if (auth()->id() !== $order->user_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh file ini.');
        }

        // 2. Validasi Status: Pastikan pembayaran order sudah verified / completed
        if (!in_array($order->status, ['verified', 'completed'])) {
            return back()->with('error', 'Pembayaran pesanan belum terverifikasi. File belum dapat diunduh.');
        }

        $product = $order->product;
        if (!$product || empty($product->file_path)) {
            return back()->with('error', 'File produk tidak ditemukan pada sistem.');
        }

        $filePath = $product->file_path;

        // 3. Cek lokasi file di storage privat
        if (Storage::disk('local')->exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION) ?: 'zip';
            $downloadName = Str::slug($product->title) . '.' . $extension;
            return Storage::disk('local')->download($filePath, $downloadName);
        }

        // Fallback jika file ada di storage_path biasa
        $absolutePath = storage_path('app/' . $filePath);
        if (file_exists($absolutePath)) {
            $extension = pathinfo($absolutePath, PATHINFO_EXTENSION) ?: 'zip';
            $downloadName = Str::slug($product->title) . '.' . $extension;
            return response()->download($absolutePath, $downloadName);
        }

        return back()->with('error', 'File fisik produk belum diunggah oleh administrator.');
    }

    public function pay(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return redirect()->route('payment.show', $order->id);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

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