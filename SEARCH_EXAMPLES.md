# Contoh Penggunaan & Testing Search - Finesser Shop

## Contoh Penggunaan

### 1. **Basic Search**
```
URL: /search?q=template
Hasil: Mencari produk dengan kata "template" di title, description, tags, atau file_type
```

### 2. **Search dengan Filter Kategori**
```
URL: /search?q=design&category=psd
Hasil: Mencari produk dengan kata "design" dan kategori "psd"
```

### 3. **Search dengan Filter Harga**
```
URL: /search?q=logo&min_price=50000&max_price=200000
Hasil: Mencari produk "logo" dengan harga antara Rp 50.000 - Rp 200.000
```

### 4. **Search Produk Unggulan**
```
URL: /search?featured=1
Hasil: Menampilkan semua produk unggulan
```

### 5. **Search dengan Sorting**
```
URL: /search?q=template&sort=price&order=asc
Hasil: Mencari "template" diurutkan dari harga terendah
```

### 6. **Combined Filters**
```
URL: /search?q=design&category=ai&min_price=100000&featured=1&sort=created_at&order=desc
Hasil: Mencari produk "design" kategori "ai", harga minimal Rp 100.000, featured, terbaru dulu
```

## Testing Scenarios

### 1. **Functional Testing**

#### Test Case 1: Basic Search
```
Input: Ketik "template" di search box
Expected: Menampilkan produk yang mengandung kata "template"
```

#### Test Case 2: Empty Search
```
Input: Search dengan query kosong
Expected: Menampilkan semua produk atau pesan error
```

#### Test Case 3: Special Characters
```
Input: Search dengan karakter khusus: "template@#$%"
Expected: Menangani karakter khusus dengan aman
```

#### Test Case 4: Long Query
```
Input: Search dengan query panjang (100+ karakter)
Expected: Menangani query panjang dengan baik
```

### 2. **Filter Testing**

#### Test Case 5: Category Filter
```
Input: Pilih kategori "PSD"
Expected: Menampilkan hanya produk dengan kategori PSD
```

#### Test Case 6: Price Range Filter
```
Input: Set min_price=50000, max_price=200000
Expected: Menampilkan produk dengan harga dalam range tersebut
```

#### Test Case 7: Featured Filter
```
Input: Check "Produk Unggulan"
Expected: Menampilkan hanya produk yang featured
```

#### Test Case 8: Multiple Filters
```
Input: Kombinasi category + price + featured
Expected: Menampilkan produk yang memenuhi semua kriteria
```

### 3. **Sorting Testing**

#### Test Case 9: Sort by Name
```
Input: Sort by "Nama Produk" A-Z
Expected: Produk diurutkan alphabetically ascending
```

#### Test Case 10: Sort by Price
```
Input: Sort by "Harga" Tinggi-Rendah
Expected: Produk diurutkan dari harga tertinggi
```

#### Test Case 11: Sort by Date
```
Input: Sort by "Terbaru"
Expected: Produk diurutkan dari yang terbaru
```

### 4. **AJAX Search Testing**

#### Test Case 12: Real-time Search
```
Input: Ketik "temp" di search box
Expected: Suggestions muncul dalam 300ms
```

#### Test Case 13: Search History
```
Input: Ketik kata yang pernah dicari sebelumnya
Expected: Riwayat pencarian muncul di suggestions
```

#### Test Case 14: Keyboard Navigation
```
Input: Gunakan arrow keys di suggestions
Expected: Focus berpindah antar suggestions
```

### 5. **Mobile Testing**

#### Test Case 15: Mobile Search
```
Input: Test search di mobile device
Expected: Interface responsive dan touch-friendly
```

#### Test Case 16: Mobile Suggestions
```
Input: Test suggestions di mobile
Expected: Suggestions mudah di-tap dan tidak overlap
```

### 6. **Performance Testing**

#### Test Case 17: Large Dataset
```
Input: Search dengan 1000+ produk
Expected: Response time < 2 detik
```

#### Test Case 18: Concurrent Users
```
Input: 10+ users search bersamaan
Expected: Tidak ada timeout atau error
```

## Sample Data untuk Testing

### Produk Test Data
```php
// Sample products untuk testing
$products = [
    [
        'title' => 'Modern Logo Template',
        'description' => 'Professional logo design template',
        'file_type' => 'ai',
        'price' => 150000,
        'is_featured' => true,
        'tags' => 'logo, modern, professional'
    ],
    [
        'title' => 'Business Card Design',
        'description' => 'Elegant business card template',
        'file_type' => 'psd',
        'price' => 75000,
        'is_featured' => false,
        'tags' => 'business, card, elegant'
    ],
    [
        'title' => 'Website Template',
        'description' => 'Responsive website template',
        'file_type' => 'html',
        'price' => 250000,
        'is_featured' => true,
        'tags' => 'website, responsive, modern'
    ],
    [
        'title' => 'Free Icon Pack',
        'description' => 'Collection of free icons',
        'file_type' => 'svg',
        'price' => 0,
        'is_featured' => false,
        'tags' => 'icons, free, collection'
    ]
];
```

## Browser Testing Checklist

### Chrome
- [ ] Basic search functionality
- [ ] AJAX search
- [ ] Suggestions dropdown
- [ ] Keyboard navigation
- [ ] Mobile responsive
- [ ] Search history

### Firefox
- [ ] Basic search functionality
- [ ] AJAX search
- [ ] Suggestions dropdown
- [ ] Keyboard navigation
- [ ] Mobile responsive
- [ ] Search history

### Safari
- [ ] Basic search functionality
- [ ] AJAX search
- [ ] Suggestions dropdown
- [ ] Keyboard navigation
- [ ] Mobile responsive
- [ ] Search history

### Edge
- [ ] Basic search functionality
- [ ] AJAX search
- [ ] Suggestions dropdown
- [ ] Keyboard navigation
- [ ] Mobile responsive
- [ ] Search history

## Error Handling Testing

### Test Case 19: Network Error
```
Input: Disconnect internet saat search
Expected: Menampilkan error message yang user-friendly
```

### Test Case 20: Server Error
```
Input: Simulasi server error (500)
Expected: Menampilkan error message dan retry option
```

### Test Case 21: Invalid Query
```
Input: Search dengan query yang sangat panjang atau berbahaya
Expected: Menangani input dengan aman
```

## Accessibility Testing

### Test Case 22: Screen Reader
```
Input: Test dengan screen reader
Expected: Semua elemen search dapat diakses
```

### Test Case 23: Keyboard Only
```
Input: Navigasi hanya dengan keyboard
Expected: Semua fungsi dapat diakses tanpa mouse
```

### Test Case 24: High Contrast
```
Input: Test dengan high contrast mode
Expected: Text dan background kontras yang baik
```

## Security Testing

### Test Case 25: SQL Injection
```
Input: Search dengan query SQL injection
Expected: Input dibersihkan dan tidak menyebabkan error
```

### Test Case 26: XSS Attack
```
Input: Search dengan script tags
Expected: Script tidak dieksekusi
```

### Test Case 27: CSRF Protection
```
Input: Test form submission tanpa CSRF token
Expected: Request ditolak
```

## Performance Benchmarks

### Target Metrics
- **Search Response Time**: < 500ms untuk AJAX search
- **Page Load Time**: < 2s untuk search results page
- **Memory Usage**: < 50MB untuk search functionality
- **CPU Usage**: < 10% saat search aktif

### Load Testing
```bash
# Test dengan Apache Bench
ab -n 1000 -c 10 http://localhost:8000/search?q=test

# Test dengan Siege
siege -c 10 -t 30S http://localhost:8000/search?q=test
```

## Monitoring & Analytics

### Metrics to Track
1. **Search Volume**: Jumlah search per hari
2. **Popular Searches**: Query yang paling sering dicari
3. **Search Conversion**: Berapa % search yang menghasilkan klik
4. **Search Performance**: Average response time
5. **Error Rate**: Jumlah error per search

### Tools
- Google Analytics untuk search tracking
- Laravel Telescope untuk debugging
- Browser DevTools untuk performance monitoring
- Lighthouse untuk performance audit 