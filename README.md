# Reservasi Tamu Gedung Wijaya

## Deskripsi

Reservasi Tamu Gedung Wijaya merupakan aplikasi berbasis web yang dibuat untuk membantu proses pengelolaan reservasi tamu yang berkunjung ke Gedung Wijaya. Sistem ini memudahkan admin dalam mencatat data tamu, mengelola jadwal kunjungan, serta memantau status reservasi secara lebih terstruktur dan efisien.

Aplikasi ini dikembangkan sebagai bagian dari tugas magang di Diskominfo Kabupaten Sukoharjo.

## Fitur Utama

* Manajemen data tamu
* Sistem reservasi kunjungan
* Cek Status Reservasi
* Dashboard admin per-OPD dan superadmin
* Pengelolaan data instansi
* Monitoring status reservasi
* Upload dokumen pendukung reservasi
* Generate laporan reservasi

## Teknologi yang Digunakan

* Laravel (PHP Framework)
* MySQL Database
* HTML, CSS, JavaScript
* Bootstrap

## Database

Database project tersedia pada folder:

database/dump/sijamu_db.sql

Import file tersebut ke MySQL menggunakan phpMyAdmin atau TablePlus sebelum menjalankan aplikasi.

## Cara Menjalankan Project

1. Clone repository ini
2. Masuk ke folder project
3. Install dependency Laravel

```
composer install
```

4. Copy file environment

```
cp .env.example .env
```

5. Generate application key

```
php artisan key:generate
```

6. Jalankan server

```
php artisan serve
```

## Kontributor

Project ini dikembangkan oleh:

* Adella Putri Ayu 
* Ardita Putri Cahyania

Mahasiswa PTIK UNS magang di Diskominfo Kabupaten Sukoharjo.

## Tujuan Pengembangan

Sistem ini dibuat untuk membantu meningkatkan efisiensi pengelolaan reservasi tamu di Gedung Wijaya serta mendukung digitalisasi layanan di lingkungan pemerintahan.
