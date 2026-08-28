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
                    <a href="{{ route('admin.produks.index') }}" class="nav-link">
                        <i class="fas fa-box me-2"></i> Produk
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                    <a href="{{ route('admin.settings') }}" class="nav-link active">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="mb-4">
                <h2>Pengaturan Website</h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Website</label>
                            <input type="text" name="site_name" class="form-control" value="{{ $settings->site_name ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo Website</label>
                            <input type="file" name="site_logo" class="form-control">
                            @if(isset($settings->site_logo))
                                <img src="{{ asset('storage/' . $settings->site_logo) }}" 
                                     alt="Logo" 
                                     class="mt-2" 
                                     style="max-height: 50px;">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Kontak</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $settings->contact_email ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ $settings->contact_phone ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="3">{{ $settings->address ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Footer Text</label>
                            <textarea name="footer_text" class="form-control" rows="2">{{ $settings->footer_text ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Pengaturan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection