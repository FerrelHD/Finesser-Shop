<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produk;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Produk::count(),
            'total_orders' => Order::count() ?? 0,
            'recent_users' => User::latest()->take(5)->get(),
            'recent_products' => Produk::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}