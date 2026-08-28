<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::where('is_active', true);
        
        // Filter berdasarkan kategori
        if ($request->has('category')) {
            $category = $request->category;
            $query->where('file_type', $category);
        }
        
        $produks = $query->get();
        $activeCategory = $request->category ?? 'all';
        
        return view('shop', compact('produks', 'activeCategory'));
    }
}