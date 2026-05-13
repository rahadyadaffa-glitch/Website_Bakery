# 🧁 SweetBite — Sistem Pemesanan Bakery Digital (Artisanal Edition)

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

---

## 📖 Tentang Project

**SweetBite** adalah aplikasi web pemesanan makanan dan minuman premium yang dirancang khusus untuk toko bakery, dessert shop, atau artisanal cafe. Dengan estetika yang hangat, organik, dan berkelas, SweetBite membawa pengalaman memesan kue dan roti ke level yang lebih modern dan efisien.

Aplikasi ini memudahkan pelanggan untuk melakukan pemesanan secara mandiri (self-service) melalui QR Code, serta membantu operasional staf (waiter) dan admin dalam mengelola pesanan secara real-time.

---

## ✨ Fitur Utama

### 🛒 Customer Experience
- **Menu Digital Artisanal** — Katalog menu cantik dengan kategori, label khusus (Best Seller, New), dan visual produk yang menggugah selera.
- **Smart Shopping Cart** — Panel keranjang belanja yang intuitif dengan fitur tambah/kurang kuantitas dan catatan khusus per item.
- **Checkout Tanpa Repot** — Proses checkout cepat dengan input nomor meja dan nama pelanggan.
- **Seamless QR Scan** — Langsung masuk ke meja yang tepat hanya dengan memindai kode QR.

### 🤵 Waiter & Staff Tools
- **Manajemen Meja (Table Management)** — Monitor status meja secara real-time untuk memudahkan pelayanan.
- **Sistem Struk Digital (Waiter Receipts)** — Cetak struk pesanan yang ringkas dan efisien hanya untuk item yang siap diantarkan.
- **Workflow Terintegrasi** — Perubahan status pesanan (Accepted -> Ready -> Delivered) yang tersinkronisasi.

### 🔧 Admin Dashboard
- **Antrean Dapur Real-time** — Monitor pesanan masuk dengan fitur auto-refresh (polling) untuk respons yang cepat.
- **Manajemen Menu Lengkap** — CRUD menu, kategori, status ketersediaan, dan manajemen foto produk.
- **Analitik & Riwayat** — Laporan pesanan dengan filter tanggal yang fleksibel untuk memantau performa penjualan.
- **QR Code Generator** — Generate QR Code unik untuk setiap meja langsung dari dashboard.

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| **Backend** | Laravel 12 (PHP 8.2+) |
| **Frontend** | Blade + TailwindCSS 3 + Alpine.js 3 |
| **Database** | MySQL 8 |
| **Auth** | Laravel Breeze |
| **Build Tool** | Vite |
| **Typography** | Fredoka (Heading), Plus Jakarta Sans (Body), Gochi Hand (Accents) |

---

## 🎨 Design System (Artisanal Aesthetic)

SweetBite menggunakan palet warna yang terinspirasi dari bahan-bahan organik dan kehangatan toko roti tradisional namun tetap modern:

- **Primary**: Cokelat Artisanal `#8E4E14` (Representasi roti yang dipanggang sempurna)
- **Secondary**: Hijau Hutan `#366758` (Memberikan kesan segar dan alami)
- **Background**: Putih Krem `#FFF8EF` (Memberikan kenyamanan visual)
- **Style**: Rounded corners yang besar (`1rem`–`4rem`) untuk kesan yang ramah dan *bubbly*.

---

## 🚀 Instalasi & Setup

### Prasyarat
- PHP 8.2+
- Composer
- Node.js 18+ & NPM
- MySQL 8

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/rahadyadaffa-glitch/Website_Bakery.git
cd Website_Bakery

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=sweetbite
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migrasi & seeder
php artisan migrate --seed

# 6. Link storage
php artisan storage:link

# 7. Build assets
npm run build

# 8. Jalankan server
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

---

## 📁 Struktur Project

```
app/
├── Http/Controllers/
│   ├── Admin/          # Dashboard, Order, Menu, Category, Table
│   └── Customer/       # Menu, Cart, Order, Payment
├── Models/             # Menu, Order, OrderItem, Payment, MenuCategory
└── Services/           # CartService, OrderService, PaymentService

resources/views/
├── layouts/            # customer.blade.php, admin.blade.php
├── customer/           # Menu, Order, Payment views
└── admin/              # Dashboard, Orders, Menus, Categories views

docs/                   # Dokumentasi project (PRD, Architecture, UI Guide, dll)
```

---

## 👥 Kontributor

- **Rahadya Daffa** — Lead Developer & Designer

---

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik / portfolio. Silakan digunakan sebagai referensi belajar!
