<form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="title">Nama Produk</label>
        <input type="text" name="title" id="title" class="form-control" required value="{{ $produk->title ?? old('title') }}">
    </div>
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" class="form-control">{{ $produk->description ?? old('description') }}</textarea>
    </div>
    <div class="form-group">
        <label for="price">Harga</label>
        <input type="number" name="price" id="price" class="form-control" required min="0" value="{{ $produk->price ?? old('price') }}">
    </div>
    <div class="form-group">
        <label for="file_type">Tipe File</label>
        <input type="text" name="file_type" id="file_type" class="form-control" required value="{{ $produk->file_type ?? old('file_type') }}">
    </div>
    <div class="form-group">
        <label for="file_path">File Utama</label>
        <input type="file" name="file_path" id="file_path" class="form-control" {{ isset($produk) ? '' : 'required' }}>
    </div>
    <div class="form-group">
        <label for="license_type">Tipe Lisensi</label>
        <select name="license_type" id="license_type" class="form-control" required>
            <option value="">Pilih Tipe Lisensi</option>
            <option value="Standard" {{ (isset($produk) && $produk->license_type == 'Standard') ? 'selected' : '' }}>Standard</option>
            <option value="Extended" {{ (isset($produk) && $produk->license_type == 'Extended') ? 'selected' : '' }}>Extended</option>
        </select>
    </div>
    <div class="form-group">
        <label for="tags">Tags</label>
        <input type="text" name="tags" id="tags" class="form-control" value="{{ $produk->tags ?? old('tags') }}">
        <small class="form-text text-muted">Pisahkan tags dengan koma</small>
    </div>
    <div class="form-group">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ (isset($produk) && $produk->is_active) ? 'checked' : '' }}>
            <label class="custom-control-label" for="is_active">Aktif</label>
        </div>
    </div>
    <div class="form-group">
        <label for="preview_image">Gambar Preview Utama</label>
        <input type="file" name="preview_image" id="preview_image" class="form-control">
    </div>
    <div class="form-group">
        <label for="preview_image_2">Gambar Preview 2</label>
        <input type="file" name="preview_image_2" id="preview_image_2" class="form-control">
    </div>
    <div class="form-group">
        <label for="preview_image_3">Gambar Preview 3</label>
        <input type="file" name="preview_image_3" id="preview_image_3" class="form-control">
    </div>
    <!-- Field untuk preview video -->
    <div class="form-group">
        <label for="preview_video">Video Preview</label>
        <input type="file" name="preview_video" id="preview_video" class="form-control" accept="video/*">
        <small class="form-text text-muted">Format video yang didukung: MP4, WebM, Ogg</small>
    </div>
    
    <!-- Tombol Submit -->
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
    </div>
</form>