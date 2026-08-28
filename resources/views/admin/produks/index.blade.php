@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar p-0">
            <div class="d-flex flex-column">
                <div class="p-3">
                    <h4>Finesser Admin</h4>
                </div>
                <nav class="nav flex-column">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.produks.index') }}" class="nav-link active">
                        <i class="fas fa-box me-2"></i> Produk
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                    <a href="{{ route('admin.settings') }}" class="nav-link">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Daftar Produk</h2>
                <a href="{{ route('admin.produks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Produk
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produks as $produk)
                                <tr>
                                    <td>{{ $produk->id }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $produk->preview_image) }}" 
                                             alt="{{ $produk->title }}" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $produk->title }}</td>
                                    <td>Rp {{ number_format($produk->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $produk->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $produk->status ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.produks.edit', $produk->id) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.produks.destroy', $produk->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection