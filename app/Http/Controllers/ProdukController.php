<?php
namespace App\Http\Controllers;
use App\Models\Produk;
use Illuminate\Http\Request;
class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::where('is_active', true)->get();
        return view('welcome', compact('produks'));
    }
    
    public function show($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            // Debug info
            \Log::info('Product data: ' . json_encode($produk->toArray()));
            // Debugging untuk memeriksa data
            // dd($produk);
            return view('produk.show', compact('produk'));
        } catch (\Exception $e) {
            \Log::error('Error displaying product: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Produk tidak ditemukan.');
        }
    }
}