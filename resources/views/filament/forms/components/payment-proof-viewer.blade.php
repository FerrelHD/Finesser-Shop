@php
    $state = $getState();
@endphp

@if ($state)
    <div class="flex flex-col gap-3">
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <img
                src="{{ asset('storage/' . $state) }}"
                alt="Bukti Pembayaran"
                class="max-h-96 w-full object-contain"
            />
        </div>
        <div>
            <a
                href="{{ asset('storage/' . $state) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-900 transition hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700"
            >
                Buka Gambar Ukuran Penuh
            </a>
        </div>
    </div>
@else
    <div class="rounded-xl border border-dashed border-zinc-300 p-6 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
        Belum ada bukti pembayaran yang diunggah.
    </div>
@endif
