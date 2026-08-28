<x-filament::page>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        {{-- Statistik Pengguna --}}
        <x-filament::card>
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    <h2 class="text-lg font-bold">Total Pengguna</h2>
                    <p class="text-3xl font-semibold">{{ \App\Models\User::count() }}</p>
                </div>
                <x-heroicon-o-users class="w-8 h-8 text-primary-500" />
            </div>
        </x-filament::card>

        {{-- Statistik Produk --}}
        <x-filament::card>
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    <h2 class="text-lg font-bold">Total Produk</h2>
                    <p class="text-3xl font-semibold">{{ \App\Models\Produk::count() }}</p>
                </div>
                <x-heroicon-o-shopping-bag class="w-8 h-8 text-primary-500" />
            </div>
        </x-filament::card>

        {{-- Statistik Pesanan --}}
        <x-filament::card>
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    <h2 class="text-lg font-bold">Total Pesanan</h2>
                    <p class="text-3xl font-semibold">{{ \App\Models\Order::count() }}</p>
                </div>
                <x-heroicon-o-shopping-cart class="w-8 h-8 text-primary-500" />
            </div>
        </x-filament::card>
    </div>

    {{-- Grafik atau Informasi Tambahan bisa ditambahkan di sini --}}
    <div class="mt-6">
    <x-filament::card>
        <h2 class="text-lg font-bold mb-4">Aktivitas Terkini</h2>

        {{-- Produk Terbaru --}}
        <h3 class="text-md font-semibold mb-2">Produk Terbaru</h3>
        <ul class="mb-4 space-y-1">
            @foreach (\App\Models\Produk::latest()->take(5)->get() as $produk)
                <li class="text-sm text-gray-300">
                    {{ $produk->title }} - Rp{{ number_format($produk->price, 0, ',', '.') }}
                    <span class="text-xs text-gray-500">({{ $produk->created_at->diffForHumans() }})</span>
                </li>
            @endforeach
        </ul>

        {{-- Pengguna Terbaru --}}
        <h3 class="text-md font-semibold mb-2">Pengguna Terbaru</h3>
        <ul class="space-y-1">
            @foreach (\App\Models\User::latest()->take(5)->get() as $user)
                <li class="text-sm text-gray-300">
                    {{ $user->name }} ({{ $user->email }})
                    <span class="text-xs text-gray-500">({{ $user->created_at->diffForHumans() }})</span>
                </li>
            @endforeach
        </ul>
    </x-filament::card>
</div>
</x-filament::page>