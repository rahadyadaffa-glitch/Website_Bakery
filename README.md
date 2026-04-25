# 🧁 SweetBite — Sistem Pemesanan Bakery Digital

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

---

## 📖 Tentang Project

**SweetBite** adalah aplikasi web pemesanan makanan dan minuman untuk toko bakery/dessert cafe. Dibangun dengan target pengguna **Gen Z**, mengutamakan pengalaman yang fun, colorful, dan playful.

Pelanggan bisa langsung scan QR di meja, pilih menu, checkout, dan bayar — semua dari HP tanpa perlu antri.

---

## ✨ Fitur Utama

### 🛒 Customer Side
- **Menu Digital** — Tampilan menu interaktif dengan kategori, badge (Best Seller, New), dan gambar
- **Keranjang Belanja** — Slide panel cart dengan tambah/kurang quantity dan catatan per item
- **Checkout & Pembayaran** — Form checkout dengan nomor meja, nama, dan catatan tambahan
- **QR Code Meja** — Scan QR langsung masuk ke halaman menu

### 🔧 Admin Dashboard
- **Antrean Dapur** — Real-time polling pesanan masuk (auto-refresh 5 detik)
- **Kelola Menu** — CRUD menu lengkap dengan upload foto, badge, dan toggle status (Tersedia/Habis)
- **Riwayat Pesanan** — History pesanan selesai dengan filter tanggal (Hari Ini, Kemarin, atau pilih tanggal)
- **Kategori Menu** — Kelola kategori menu (Kue, Minuman, Dessert, Paket, dll)
- **QR Code Generator** — Generate QR code untuk setiap nomor meja

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| **Backend** | Laravel 12 (PHP 8.2+) |
| **Frontend** | Blade + TailwindCSS 3 + Alpine.js 3 |
| **Database** | MySQL 8 |
| **Auth** | Laravel Breeze |
| **Build Tool** | Vite |
| **Font** | Fredoka (Heading) + Plus Jakarta Sans (Body) |

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
git clone https://github.com/rahadyadaffa-glitch/Websit_Bakery.git
cd Websit_Bakery

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

## 🎨 Design System

- **Warna Utama**: Biru `#427AB5` + Kuning `#F7DD7D`
- **Background**: Putih hangat `#FFFDF7`
- **Mood**: Fun, colorful, playful — seperti dessert cafe kekinian
- **Border Radius**: Rounded besar (16px–32px)
- **Shadow**: Bubbly shadow style

---

## 👥 Kontributor

- **Rahadya Daffa** — Developer

---

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik / portfolio.
