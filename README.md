# Sistem MA — IT Asset Management & Sparepart Inventory System

Aplikasi manajemen aset IT dan inventory sparepart untuk departemen IT **Global Putra International Group**.

## Fitur

- **Manajemen Perangkat** — CRUD PC, Laptop, Server dengan soft delete, filter, dan pencarian
- **Manajemen Sparepart** — CRUD stok sparepart dengan alert stok rendah (highlight merah)
- **Transaksi Sparepart** — Pencatatan barang masuk (restock) & keluar (penggunaan) dengan DB transaction atomik
- **Log Maintenance** — Riwayat perawatan perangkat beserta jadwal maintenance berikutnya
- **Dashboard** — Statistik aset, alert stok rendah, jadwal maintenance 7 hari ke depan

## Tech Stack

| Komponen    | Teknologi                  |
|-------------|----------------------------|
| Backend     | Laravel 13, PHP 8.3        |
| Database    | MySQL                      |
| Frontend    | Bootstrap 5 + Bootstrap Icons |
| Font        | Google Fonts (Inter)       |

## Cara Instalasi

### Prerequisites
- PHP 8.3+
- Composer
- Node.js & npm
- MySQL

### Langkah Instalasi

```bash
# 1. Clone repository
git clone <repo-url>
cd SistemMA

# 2. Install dependencies PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Konfigurasi database di .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=sistem_ma
#    DB_USERNAME=root
#    DB_PASSWORD=your_password

# 6. Buat database (jika belum ada)
mysql -u root -p -e "CREATE DATABASE sistem_ma CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 7. Jalankan migration
php artisan migrate

# 8. (Opsional) Isi data dummy
php artisan db:seed

# 9. Jalankan server
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

## Struktur Database

| Tabel              | Deskripsi                          |
|--------------------|-------------------------------------|
| `devices`          | Perangkat IT (PC, Laptop, Server)   |
| `spareparts`       | Inventory sparepart                 |
| `transactions`     | Transaksi masuk/keluar sparepart    |
| `maintenance_logs` | Riwayat perawatan perangkat         |

## Screenshot
<img width="1918" height="936" alt="image" src="https://github.com/user-attachments/assets/79103663-f57d-4c51-9488-9c74de02f115" />
<img width="1906" height="932" alt="image" src="https://github.com/user-attachments/assets/3b231682-eb07-42fa-9113-c35385e82d8b" />
<img width="1911" height="928" alt="image" src="https://github.com/user-attachments/assets/f9e7afe6-4113-44a9-a6d6-aa9da0fd2603" />
<img width="1911" height="931" alt="image" src="https://github.com/user-attachments/assets/3ca0a960-9ab5-4376-9514-3976385ea9aa" />
<img width="1914" height="934" alt="image" src="https://github.com/user-attachments/assets/da90d55e-e8c0-4afe-9b31-bfe83e263daa" />


## Dump Database

File dump SQL tersedia di: `database/sistem_ma.sql`

---

**Global Putra International Group** | Jl. Ir H. Juanda 3 No. 26 AB, Jakarta Pusat 10120
