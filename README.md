# Website Wedding Hampers Shop - Laravel 10

Aplikasi web toko hampers pernikahan yang elegan dan powerful, dibangun menggunakan Laravel 10.  
Website ini mendukung sistem multi-auth untuk pelanggan dan admin, serta menyediakan dashboard pengelolaan lengkap dan fitur transaksi pesanan.

---

## Fitur Utama

- **Landing Page** — Tampilan utama untuk pelanggan melihat produk hampers.
- **Dashboard Admin** — CRUD produk, kategori, dan manajemen pesanan.
- **Multi Auth** — Autentikasi terpisah untuk pelanggan dan admin.
- **Transaksi & Riwayat Pesanan** — Pelanggan bisa memesan dan melihat histori pembelian.

---

## Cara Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan project secara lokal:

```bash
# 1. Clone Repository
git clone https://github.com/vamatsa-vmt/hampers-wedding-shop.git
cd hampers-wedding-shop

# 2. Install Dependencies
composer install

# 3. Copy .env dan Generate Key
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi Database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=si-blissbox
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan Migration dan Seeder (jika ada)
php artisan migrate --seed

# 6. Link Storage agar gambar bisa diakses
php artisan storage:link

# 7. Jalankan Server
php artisan serve
Running di http://127.0.0.1:8000

## Demo Website
![alt text](https://github.com/vamatsa-vmt/hampers-wedding-shop/blob/main/public/images/Beranda-Blissbox.png?raw=true)
