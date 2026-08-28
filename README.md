# 🎬 Finesser Shop - Digital Assets E-Commerce Platform

<p align="center">
  <strong>Platform toko online modern untuk aset digital: Project File Video Editing, Motion Graphics, dan 3D Assets.</strong>
</p>

---

## 📌 Tentang Proyek

**Finesser Shop** adalah aplikasi web e-commerce berbasis **Laravel 12** yang dirancang khusus untuk memfasilitasi penjualan dan distribusi aset digital kreatif. Platform ini memungkinkan video editor, 3D artist, dan content creator untuk menemukan serta membeli project file berkualitas tinggi (seperti project file After Effects, Premiere Pro, model 3D OBJ/FBX, template mockup, dll).

---

## ✨ Fitur Utama

### 🛍️ Pengguna (Frontend & Belanja)
- **Katalog Produk Interaktif:** Eksplorasi produk digital berdasarkan kategori (*Video*, *3D Assets*, *Featured/Unggulan*, dan *Bundling Pack*).
- **Detail Produk Lengkap:** Pratinjau multi-gambar, video preview responsif, informasi format file, detail editable layers, dan tipe lisensi (Personal / Commercial).
- **Pencarian Cerdas (Live AJAX Search):** Fitur pencarian instan dengan auto-suggestions dan filter tag.
- **Sistem Keranjang & Checkout:** Keranjang belanja interaktif dan alur pemesanan yang mudah.
- **Upload Bukti Pembayaran:** Kemudahan konfirmasi pembayaran melalui upload struk/bukti transfer.
- **Secure Digital Downloads:** Akses download file aset hanya dapat diunduh oleh pembeli setelah pembayaran diverifikasi oleh admin.
- **Autentikasi & Profil Pengguna:** Registrasi, login, manajemen profil, dan riwayat pesanan (*Order History*).

### ⚙️ Panel Admin (Filament v3)
- **Dashboard Analitik:** Ringkasan statistik penjualan, pesanan, dan produk aktif.
- **Manajemen Produk:** Tambah, edit, upload asset file utama, multiple preview images, preview video, status bundling, dan produk unggulan.
- **Verifikasi Pesanan & Pembayaran:** Verifikasi bukti transfer pelanggan untuk membuka akses download file.
- **Manajemen Pengguna:** Pengelolaan role user dan data pelanggan.
- **Kotak Masuk Pesan:** Manajemen pesan kontak dari form feedback pengguna.

---

## 🛠️ Tech Stack

- **Backend:** [Laravel 12](https://laravel.com/) (PHP 8.2+)
- **Admin Panel:** [Filament v3](https://filamentphp.com/)
- **Frontend:** Blade Templating, Bootstrap 5, [Tailwind CSS](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/)
- **Build Tool:** [Vite 6](https://vitejs.dev/)
- **Database:** SQLite (default) / MySQL / PostgreSQL
- **Testing:** Pest PHP / PHPUnit

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan lokal:

### 1. Prasyarat Sistem
- PHP >= 8.2
- Composer
- Node.js (v18+) & npm
- SQLite / MySQL

### 2. Clone Repository
```bash
git clone https://github.com/FerrelHD/Finesser-Shop.git
cd Finesser-Shop
```

### 3. Install Dependensi
```bash
composer install
npm install
```

### 4. Konfigurasi Environment
Salin file `.env.example` ke `.env` dan generate application key:
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Setup Database & Storage Link
Jalankan migrasi database dan seeder data awal:
```bash
touch database/database.sqlite # jika file sqlite belum ada
php artisan migrate --seed
php artisan storage:link
```

### 6. Build Aset Frontend
```bash
npm run build
# Atau untuk mode development: npm run dev
```

### 7. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di **`http://127.0.0.1:8000`**.

---

## 🔐 Akun Bawaan (Default Credentials)

| Role | Email | Password | Akses URL |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@finesser.com` | `admin123` | `/admin` atau `/login` |
| **User** | `test@example.com` | `password` | `/login` |

---

## 📂 Struktur Direktori Utama

```
├── app/
│   ├── Filament/          # Resource & Pages Panel Admin Filament
│   ├── Http/Controllers/  # Controller Frontend & Admin
│   └── Models/            # Model Eloquent (Produk, Order, User, dll)
├── config/                # Konfigurasi aplikasi Laravel
├── database/
│   ├── migrations/        # Skema migrasi database
│   └── seeders/           # Seeder admin & user
├── public/                # Asset publik (CSS, JS, Gambar Banner)
├── resources/
│   ├── views/             # Template Blade UI (Frontend, Auth, Layouts)
│   └── css/ & js/         # Source styles dan script Vite
├── routes/                # Definisi rute (web.php, auth.php)
└── storage/               # File upload & digital product assets
```

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan penulisan ilmiah dan berlisensi di bawah [MIT License](LICENSE).
