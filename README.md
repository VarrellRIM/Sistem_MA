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
### Dashboard
<img width="1910" height="931" alt="image" src="https://github.com/user-attachments/assets/dde5327d-64c4-4568-8c41-2e32497a6a4a" />
### Devices
<img width="1914" height="934" alt="image" src="https://github.com/user-attachments/assets/3a6f67be-6da2-4221-874d-e7bf7fdbdd8e" />
### Spareparts
<img width="1915" height="932" alt="image" src="https://github.com/user-attachments/assets/4ae70013-6da6-4180-a671-a70c3635e34e" />
### Transactions
<img width="1911" height="929" alt="image" src="https://github.com/user-attachments/assets/81ff23a6-3f60-4f63-90d9-59b4a06be365" />
### Maintenance Log
<img width="1911" height="931" alt="image" src="https://github.com/user-attachments/assets/c24aca6f-aa5a-450d-a5be-a785cae2e0c7" />



## Dump Database

File dump SQL tersedia di: `database/sistem_ma.sql`

---

**Global Putra International Group** | Jl. Ir H. Juanda 3 No. 26 AB, Jakarta Pusat 10120
