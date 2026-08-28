<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'preview_image',
        'preview_image_2',
        'preview_image_3',
        'preview_video',
        'price',
        'editable_layers',
        'tags',
        'license_type',
        'is_active',
        'is_featured',
        'is_bundling'
    ];

    protected $casts = [
        'editable_layers' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_bundling' => 'boolean'
    ];
}