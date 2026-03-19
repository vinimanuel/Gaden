# 🏦 Pegadaian Admin Panel — Laravel

Sistem admin pegadaian berbasis Laravel dengan fitur: Dashboard, Barang Gadai (CRUD), Riwayat Transaksi, dan Laporan Keuangan.

---

## 📁 Struktur File Proyek

```
app/
├── helpers.php                          ← fungsi rupiah()
├── Models/
│   ├── BarangGadai.php                  ← Model utama + business logic
│   └── Transaksi.php                    ← Model log transaksi
└── Http/Controllers/
    ├── DashboardController.php
    ├── BarangGadaiController.php        ← CRUD + Tebus + Perpanjang
    ├── RiwayatController.php
    └── KeuanganController.php

config/
└── pegadaian.php                        ← Konfigurasi bunga & biaya

database/
├── migrations/
│   ├── ..._create_barang_gadai_table.php
│   └── ..._create_transaksi_table.php
└── seeders/
    └── DatabaseSeeder.php               ← Data demo

routes/
└── web.php

resources/views/
├── layouts/app.blade.php                ← Master layout + sidebar + CSS
├── dashboard/index.blade.php
├── barang/
│   ├── index.blade.php                  ← List + filter
│   ├── create.blade.php                 ← Form tambah + preview bunga
│   ├── show.blade.php                   ← Detail + riwayat transaksi
│   ├── edit.blade.php
│   ├── tebus.blade.php                  ← Konfirmasi tebus
│   └── perpanjang.blade.php             ← Konfirmasi perpanjang
├── riwayat/index.blade.php
└── keuangan/index.blade.php
```

---

## ⚡ Cara Instalasi

### 1. Buat project Laravel baru

```bash
composer create-project laravel/laravel pegadaian
cd pegadaian
```

### 2. Copy semua file dari repo ini ke dalam folder Laravel

Salin seluruh isi folder ini ke dalam project Laravel, sesuaikan path masing-masing.

### 3. Daftarkan helper di composer.json

Tambahkan di `composer.json` bagian `autoload`:

```json
"autoload": {
    "files": [
        "app/helpers.php"
    ],
    "psr-4": {
        "App\\": "app/",
        ...
    }
}
```

Lalu jalankan:

```bash
composer dump-autoload
```

### 4. Konfigurasi database di `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pegadaian
DB_USERNAME=root
DB_PASSWORD=

# Opsional: override ketentuan bunga
PEGADAIAN_BUNGA_NORMAL=10
PEGADAIAN_BUNGA_KHUSUS=5
PEGADAIAN_BIAYA_PERP=10
```

### 5. Jalankan migration & seeder

```bash
php artisan migrate
php artisan db:seed
```

### 6. Tambahkan Carbon locale Indonesia di `AppServiceProvider.php`

```php
use Carbon\Carbon;

public function boot(): void
{
    Carbon::setLocale('id');
}
```

### 7. Jalankan server

```bash
php artisan serve
```

Akses di: **http://localhost:8000**

---

## 🔗 Daftar Route

| Method | URL | Name | Fungsi |
|--------|-----|------|--------|
| GET | `/` | `dashboard` | Beranda |
| GET | `/barang` | `barang.index` | List barang gadai |
| GET | `/barang/create` | `barang.create` | Form tambah |
| POST | `/barang` | `barang.store` | Simpan gadai baru |
| GET | `/barang/{id}` | `barang.show` | Detail barang |
| GET | `/barang/{id}/edit` | `barang.edit` | Form edit |
| PUT | `/barang/{id}` | `barang.update` | Update data |
| DELETE | `/barang/{id}` | `barang.destroy` | Hapus (soft delete) |
| GET | `/barang/{id}/tebus` | `barang.tebus.form` | Form konfirmasi tebus |
| POST | `/barang/{id}/tebus` | `barang.tebus.store` | Proses tebus |
| GET | `/barang/{id}/perpanjang` | `barang.perpanjang.form` | Form perpanjang |
| POST | `/barang/{id}/perpanjang` | `barang.perpanjang.store` | Proses perpanjang |
| GET | `/riwayat` | `riwayat.index` | Riwayat transaksi |
| GET | `/keuangan` | `keuangan.index` | Laporan keuangan |

---

## ⚙️ Ketentuan Bunga (dapat diubah di `config/pegadaian.php`)

| Kondisi | Bunga |
|---------|-------|
| Tebus > ½ masa gadai | 10% (normal) |
| Tebus ≤ ½ masa gadai | 5% (khusus ⚡) |
| Biaya perpanjangan | 10% flat |

---

## 🗄️ Skema Database

### `barang_gadai`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | |
| kode_gadai | varchar(20) UNIQUE | GD-001, GD-002, ... |
| nasabah | varchar | |
| ktp | varchar(20) nullable | |
| no_telp | varchar(20) nullable | |
| barang | varchar | |
| kategori | enum | Elektronik/Perhiasan/Kendaraan/Lainnya |
| nilai_taksiran | bigint | |
| nilai_pinjaman | bigint | |
| tgl_gadai | date | |
| jatuh_tempo | date | |
| bulan_gadai | tinyint | |
| keterangan | text nullable | |
| status | enum | aktif/ditebus/jatuh_tempo |
| deleted_at | timestamp | soft delete |

### `transaksi`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | |
| tgl_transaksi | date | |
| tipe | enum | Gadai Baru/Perpanjang/Tebus |
| barang_gadai_id | FK → barang_gadai | |
| kode_gadai | varchar | denormalized untuk query cepat |
| nasabah | varchar | |
| barang | varchar | |
| nilai_pinjaman | bigint | |
| biaya | bigint | bunga atau biaya perpanjang |
| keterangan | text nullable | |
