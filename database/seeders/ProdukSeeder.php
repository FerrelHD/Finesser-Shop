<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produks = [
            [
                'title' => 'Pink Frosted Donut 3D Model',
                'description' => 'Model 3D Donat realistis dengan icing pink lezat dan taburan meses warna-warni. Dibuat menggunakan Blender, dioptimasi dengan shader PBR beresolusi tinggi, siap digunakan untuk render produk, animasi motion graphics, atau game engine.',
                'file_path' => 'private/products/asset-sample.zip',
                'file_type' => '3d',
                'preview_image' => 'produks/donut-3d.png',
                'preview_image_2' => 'produks/creator-bundle.png',
                'preview_image_3' => null,
                'preview_video' => null,
                'price' => 75000,
                'editable_layers' => [
                    'Geometry Mesh (Low & High Poly)',
                    'Procedural Sprinkles Geometry Nodes',
                    'Subsurface Scattering Material',
                    'Studio Lighting Setup & Camera Rig'
                ],
                'tags' => '3d, blender, donut, food, realistic, asset',
                'license_type' => 'commercial',
                'is_active' => true,
                'is_featured' => true,
                'is_bundling' => false,
            ],
            [
                'title' => 'Tanjiro Green Aura Anime VFX Template',
                'description' => 'Project file After Effects untuk efek visual anime aura hijau neon bercahaya dengan partikel bara api melayang dan sword trail dinamis. Sangat mudah disesuaikan untuk kebutuhan AMV, short movie, atau video reels.',
                'file_path' => 'private/products/asset-sample.zip',
                'file_type' => 'mp4',
                'preview_image' => 'produks/tanjiro-vfx.png',
                'preview_image_2' => 'produks/anime-vfx-pack.png',
                'preview_image_3' => null,
                'preview_video' => null,
                'price' => 120000,
                'editable_layers' => [
                    'Energy Aura Glow Composition',
                    'Saber Plugin Preset & Settings',
                    'Ember Spark Particle Emitter',
                    'Cinematic Color Correction LUT'
                ],
                'tags' => 'video, after effects, anime, vfx, tanjiro, aura',
                'license_type' => 'personal',
                'is_active' => true,
                'is_featured' => true,
                'is_bundling' => false,
            ],
            [
                'title' => 'Call Me If You Get Lost Vintage ID Card Template',
                'description' => 'Template PSD Photoshop ID Card gaya vintage retro terinspirasi album CMIYGL. Dilengkapi smart object untuk foto potret, stempel passpor, border bintang, dan efek tekstur kertas grunge otentik.',
                'file_path' => 'private/products/asset-sample.zip',
                'file_type' => 'psd',
                'preview_image' => 'produks/cmiyl-card.png',
                'preview_image_2' => 'produks/creator-bundle.png',
                'preview_image_3' => null,
                'preview_video' => null,
                'price' => 50000,
                'editable_layers' => [
                    'Photo Portrait Smart Object',
                    'Editable Vector Star Border',
                    'Grunge Paper Texture Overlay',
                    'Passport Stamp & Travel Seal'
                ],
                'tags' => 'design, psd, card, vintage, aesthetic, typography',
                'license_type' => 'personal',
                'is_active' => true,
                'is_featured' => false,
                'is_bundling' => false,
            ],
            [
                'title' => 'Ultimate Anime Scene & Lightning VFX Pack',
                'description' => 'Koleksi scene editing siap pakai dengan lighting dramatis pohon biru neon raksasa, background gelap bernuansa malam, dan efek partikel anime cinematic untuk video editor YouTube, TikTok, dan AMV.',
                'file_path' => 'private/products/asset-sample.zip',
                'file_type' => 'mp4',
                'preview_image' => 'produks/anime-vfx-pack.png',
                'preview_image_2' => 'produks/tanjiro-vfx.png',
                'preview_image_3' => null,
                'preview_video' => null,
                'price' => 150000,
                'editable_layers' => [
                    'World Tree Glowing Effect',
                    'Atmospheric Fog & Rain Generator',
                    'Letterbox 2.35:1 Cinematic Mask',
                    'HQ Anime Sound FX Included'
                ],
                'tags' => 'video, vfx, anime, premiere pro, after effects, pack',
                'license_type' => 'commercial',
                'is_active' => true,
                'is_featured' => true,
                'is_bundling' => true,
            ],
            [
                'title' => 'Creator All-in-One Mega Bundle (3D + Video + PSD)',
                'description' => 'Paket bundling terlengkap dan paling hemat! Dapatkan model 3D donut, ID card template vintage, serta preset efek visual anime dalam satu arsip komprehensif dengan lisensi komersial tak terbatas.',
                'file_path' => 'private/products/asset-sample.zip',
                'file_type' => 'zip',
                'preview_image' => 'produks/creator-bundle.png',
                'preview_image_2' => 'produks/donut-3d.png',
                'preview_image_3' => 'produks/cmiyl-card.png',
                'preview_video' => null,
                'price' => 199000,
                'editable_layers' => [
                    'Semua Model 3D (.blend / .fbx)',
                    'Semua Project File After Effects (.aep)',
                    'Semua Template Photoshop (.psd)',
                    'PDF Panduan Instalasi & Free Fonts'
                ],
                'tags' => 'bundling, mega pack, 3d, vfx, psd, all-in-one',
                'license_type' => 'commercial',
                'is_active' => true,
                'is_featured' => true,
                'is_bundling' => true,
            ],
        ];

        foreach ($produks as $produkData) {
            Produk::updateOrCreate(
                ['title' => $produkData['title']],
                $produkData
            );
        }
    }
}
