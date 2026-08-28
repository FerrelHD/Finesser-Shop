@php
    $state = $getState();
@endphp

@if ($state)
    <div class="flex flex-col gap-2">
        <img src="{{ asset('storage/' . $state) }}" alt="Bukti Pembayaran" class="max-w-md rounded-lg border border-gray-300" />
        <a href="{{ asset('storage/' . $state) }}" target="_blank" class="text-primary-600 hover:underline">
            Lihat Gambar Lengkap
        </a>
    </div>
@else
    <div class="text-gray-500">Tidak ada bukti pembayaran</div>
@endif