<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function store(Request $request)
    {
        // Log informasi request untuk debugging
        Log::info('Menerima request upload produk', [
            'has_file' => $request->hasFile('preview_video'),
            'content_length' => $request->header('Content-Length'),
            'content_type' => $request->header('Content-Type')
        ]);
        
        // Validasi dengan toleransi lebih longgar untuk debugging
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file_path' => 'required|file|mimes:zip,pdf,doc,docx,xls,xlsx,psd,ai,eps,svg,ppt,pptx|max:102400',
                'file_type' => 'required|string',
                'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'preview_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'preview_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'preview_video' => 'nullable|file|max:51200', // Perubahan: mimetypes diganti menjadi file
                'price' => 'required|numeric|min:0',
                'tags' => 'nullable|string',
                'license_type' => 'required|in:Standard,Extended',
                'is_active' => 'boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', [
                'errors' => $e->errors(),
                'validator' => $e->validator->failed()
            ]);
            throw $e;
        }
        
        $data = $request->except(['file_path', 'preview_image', 'preview_image_2', 'preview_image_3', 'preview_video']);
        
        // Handle file main upload
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('produks/files', $filename, 'public');
            $data['file_path'] = $path;
        }
        
        // Handle preview images
        if ($request->hasFile('preview_image')) {
            $image = $request->file('preview_image');
            $filename = time() . '_preview1.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('produks/previews', $filename, 'public');
            $data['preview_image'] = $path;
        }
        
        if ($request->hasFile('preview_image_2')) {
            $image = $request->file('preview_image_2');
            $filename = time() . '_preview2.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('produks/previews', $filename, 'public');
            $data['preview_image_2'] = $path;
        }
        
        if ($request->hasFile('preview_image_3')) {
            $image = $request->file('preview_image_3');
            $filename = time() . '_preview3.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('produks/previews', $filename, 'public');
            $data['preview_image_3'] = $path;
        }
        
        // Handle preview video dengan pendekatan berbeda
        if ($request->hasFile('preview_video')) {
            try {
                $video = $request->file('preview_video');
                
                // Log lengkap untuk diagnostik
                Log::info('Video upload details:', [
                    'original_name' => $video->getClientOriginalName(),
                    'mime_type' => $video->getMimeType(),
                    'size' => $video->getSize(),
                    'error' => $video->getError(),
                    'extension' => $video->getClientOriginalExtension(),
                    'is_valid' => $video->isValid(),
                    'upload_max_filesize' => ini_get('upload_max_filesize'),
                    'post_max_size' => ini_get('post_max_size'),
                    'max_file_uploads' => ini_get('max_file_uploads'),
                    'server_upload_progress' => $_SERVER['CONTENT_LENGTH'] ?? 'Not available'
                ]);
                
                if (!$video->isValid()) {
                    $errorMessage = 'File video tidak valid: Error code ' . $video->getError();
                    Log::error($errorMessage);
                    throw new \Exception($errorMessage);
                }
                
                // Coba pendekatan alternatif untuk upload
                $filename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                
                // Metode 1: Gunakan disk publik langsung
                $path = Storage::disk('public')->putFileAs(
                    'produks/videos', 
                    $video, 
                    $filename
                );
                
                if (!$path) {
                    throw new \Exception('Gagal menyimpan file video dengan Storage disk');
                }
                
                $data['preview_video'] = $path;
                
                Log::info('Video berhasil disimpan:', [
                    'path' => $path,
                    'database_path' => $data['preview_video'],
                    'method' => 'Storage::disk'
                ]);
                
            } catch (\Exception $e) {
                Log::error('Error saat upload video:', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return back()
                    ->withInput()
                    ->withErrors(['preview_video' => 'Gagal mengunggah video: ' . $e->getMessage()]);
            }
        }
        
        // Set is_active to false if not set
        $data['is_active'] = $request->has('is_active') ? true : false;
        
        try {
            $produk = Produk::create($data);
            Log::info('Produk berhasil dibuat', ['produk_id' => $produk->id]);
            return redirect()->route('dashboard')->with('success', 'Produk berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Error saat membuat produk:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['general' => 'Gagal membuat produk: ' . $e->getMessage()]);
        }
    }
}