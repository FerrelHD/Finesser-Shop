<?php

use App\Filament\Widgets\PendingPaymentsWidget;
use App\Filament\Widgets\ProductSalesWidget;
use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\TotalRevenue;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Produk;
use App\Models\User;
use Livewire\Livewire;

test('admin login page renders minimalist Finesser branding and stylesheet', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200)
        ->assertSee('FINESSER', false)
        ->assertSee('css/filament-admin.css', false);
});

test('authenticated admin can render Filament dashboard, widgets, and all resource pages', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $customer = User::factory()->create(['role' => 'user']);

    $produk = Produk::create([
        'title' => 'Template 3D Minimalis',
        'description' => 'Aset 3D berkualitas tinggi.',
        'file_path' => 'private/products/sample.zip',
        'file_type' => '3D',
        'preview_image' => 'produks/sample.jpg',
        'price' => 150000,
        'license_type' => 'personal',
        'is_active' => true,
        'is_featured' => true,
        'is_bundling' => false,
    ]);

    $order = Order::create([
        'user_id' => $customer->id,
        'product_id' => $produk->id,
        'quantity' => 1,
        'total_price' => 150000,
        'status' => 'pending_verification',
        'payment_method' => 'transfer_bank',
        'payment_proof' => 'payment_proofs/proof.jpg',
    ]);

    $message = ContactMessage::create([
        'name' => 'Budi',
        'email' => 'budi@example.com',
        'subject' => 'Tanya Lisensi',
        'message' => 'Apakah bisa dipakai komersial?',
        'status' => 'baru',
    ]);

    $this->actingAs($admin);

    $this->get('/admin')
        ->assertStatus(200)
        ->assertSee('FINESSER', false)
        ->assertSeeLivewire(TotalRevenue::class)
        ->assertSeeLivewire(RevenueChartWidget::class)
        ->assertSeeLivewire(PendingPaymentsWidget::class)
        ->assertSeeLivewire(ProductSalesWidget::class);

    Livewire::test(TotalRevenue::class)
        ->assertSee('Total Pendapatan')
        ->assertSee('Menunggu Verifikasi')
        ->assertSee('1 pesanan perlu ditinjau');

    Livewire::test(RevenueChartWidget::class)
        ->assertSee('Tren Pendapatan (6 Bulan Terakhir)');

    Livewire::test(PendingPaymentsWidget::class)
        ->assertSee('Pembayaran Perlu Verifikasi')
        ->assertSee('Template 3D Minimalis');

    Livewire::test(ProductSalesWidget::class)
        ->assertSee('Produk Terlaris');

    $this->get('/admin/produks')->assertStatus(200);
    $this->get('/admin/produks/create')->assertStatus(200);
    $this->get("/admin/produks/{$produk->id}/edit")->assertStatus(200);
    $this->get('/admin/payments')->assertStatus(200);
    $this->get("/admin/payments/{$order->id}")->assertStatus(200)->assertSee('Detail Transaksi', false);
    $this->get('/admin/contact-messages')->assertStatus(200);
    $this->get("/admin/contact-messages/{$message->id}")->assertStatus(200);
    $this->get('/admin/users')->assertStatus(200);
    $this->get("/admin/users/{$customer->id}/edit")->assertStatus(200);
});
