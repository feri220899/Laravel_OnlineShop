# Deployment guite 
Panduan ini menjelaskan langkah-langkah untuk Deployment guite aplikasi toko online sederhana, melakukan migrasi database, dan menambahkan data awal menggunakan seeder.

---

## 1. Instalasi Laravel
### Prasyarat
- **PHP**: Versi 8.0 atau lebih baru.
- **Composer**: Dependency manager untuk PHP.
- **Database**: PostgreSQL
- **Web Server**: Apache atau Nginx.

### Langkah Instalasi
1. **Clone Proyek**:
   ```bash
   git clone https://github.com/feri220899/LaravelOnlineShop.git
   ```
2. **Instal Dependency**:
   ```bash
   composer install
   ```
3. **Konfigurasi File `.env`**:
   - Salin file `.env.example` menjadi `.env`:
     ```bash
     cp .env.example .env
     ```
   - Edit file `.env` untuk menyesuaikan dengan konfigurasi database Anda:
     ```env
     DB_CONNECTION=pgsql
     DB_HOST=127.0.0.1
     DB_PORT=5432
     DB_DATABASE=shop
     DB_USERNAME=postgres
     DB_PASSWORD=root
     ```
4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Perintah storage link**:
   ```bash
   php artisan storage:link
---

## 2. Migrasi Database
### Menjalankan Migrasi
1. Pastikan database yang Anda tentukan di file `.env` telah dibuat.
2. Jalankan perintah berikut untuk melakukan migrasi:
   ```bash
   php artisan migrate
   ```
   Perintah ini akan membuat tabel-tabel yang didefinisikan dalam file migrasi di direktori `database/migrations`.

---

## 3. Menambahkan Data Awal dengan Seeder

### Menjalankan Seeder
1. Jalankan seeder dengan perintah:
   ```bash
   php artisan db:seed --class=UserSeeder
   ```
2. Untuk menjalankan semua seeder di direktori `database/seeders`, gunakan:
   ```bash
   php artisan db:seed
   ```

---

