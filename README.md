# Sistem MA — IT Asset Management & Sparepart Inventory System

Aplikasi manajemen aset IT dan inventory sparepart untuk departemen IT **Global Putra International Group**.

## Fitur

- **Manajemen Perangkat** — CRUD PC, Laptop, Server dengan soft delete, filter, dan pencarian
- **Manajemen Sparepart** — CRUD stok sparepart dengan alert stok rendah (highlight merah)
- **Transaksi Sparepart** — Pencatatan barang masuk (restock) & keluar (penggunaan) dengan DB transaction atomik + pessimistic locking
- **Log Maintenance** — Riwayat perawatan perangkat beserta jadwal maintenance berikutnya
- **Dashboard** — Statistik aset, alert stok rendah, jadwal maintenance 7 hari ke depan
- **Authentication & Role-Based Access** — Login dengan 3 role (Admin, Technician, Viewer) dengan middleware authorization
- **Database Optimization** — Indexes, atomic transactions, RESTRICT cascading untuk data integrity

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

# 3. Install dependencies Node.js
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Konfigurasi database di .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=sistem_ma
#    DB_USERNAME=root
#    DB_PASSWORD=your_password

# 7. Buat database (jika belum ada)
mysql -u root -p -e "CREATE DATABASE sistem_ma CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 8. Jalankan migration & seeding (PENTING: untuk populate test users dan data)
php artisan migrate:fresh --seed

# 9. Jalankan server
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## Default Login Credentials

Setelah running `php artisan migrate:fresh --seed`, gunakan akun berikut untuk login:

| Role       | Email                   | Password   | Akses                                              |
|------------|-------------------------|------------|----------------------------------------------------|
| Admin      | `admin@test.local`      | `password` | Full access (semua fitur)                          |
| Technician | `technician@test.local` | `password` | Maintenance, Transactions, Read Devices/Spareparts |
| Viewer     | `viewer@test.local`     | `password` | Read-only access (semua halaman, tidak bisa edit)  |

**Note:** Password semua akun adalah `password`. Silakan ubah setelah login pertama kali.

---

## Struktur Database

| Tabel              | Deskripsi                          |
|--------------------|-------------------------------------|
| `users`            | Akun user dengan role-based access  |
| `devices`          | Perangkat IT (PC, Laptop, Server)   |
| `spareparts`       | Inventory sparepart                 |
| `transactions`     | Transaksi masuk/keluar sparepart    |
| `maintenance_logs` | Riwayat perawatan perangkat         |

---

## Role-Based Access Control (RBAC)

Aplikasi menggunakan middleware berbasis role untuk mengontrol akses fitur:

### **Admin** (Full Access)
- Create/Edit/Delete semua perangkat
- Create/Edit/Delete sparepart
- Input transaksi in/out
- Input maintenance log
- View dashboard & laporan

### **Technician** (Create & Use)
- View semua perangkat & sparepart
- Input transaksi sparepart (in/out)
- Create/Edit maintenance log
- View dashboard

### **Viewer** (Read-Only)
- View semua data (perangkat, sparepart, transaksi, maintenance)
- View dashboard


---

## Keamanan & Optimisasi

### Security Features
- **CSRF Protection** — Token di setiap form
- **XSS Prevention** — Template auto-escaping
- **SQL Injection Protection** — Parameterized queries via Eloquent
- **Rate Limiting** — Input validation di level controller & database
- **Authentication** — Session-based dengan role middleware
- **Atomic Transactions** — Race condition prevention dengan pessimistic locking

### Database Optimization
- **Indexes** — Pada search columns (asset_code, part_code, device_id, transaction_date, etc)
- **Soft Delete** — Perangkat yang dihapus tetap tersimpan untuk audit trail
- **Cascade Restrictions** — Device tidak bisa dihapus jika memiliki maintenance log (data integrity)
- **Pessimistic Locking** — Transaksi stok menggunakan `lockForUpdate()` untuk mencegah race condition

---

## Demo Website
https://github.com/user-attachments/assets/f3b7e849-d718-48cb-88a3-f7f3abb1aedd

## Screenshot

### Dashboard
<img width="1911" height="934" alt="image" src="https://github.com/user-attachments/assets/5339d0cd-5d02-45a2-b42f-b09f3e2d5781" />

### Devices
<img width="1909" height="935" alt="image" src="https://github.com/user-attachments/assets/e9275780-28ea-4333-9e1c-a6e3a2a6a8d5" />

### Spareparts
<img width="1907" height="936" alt="image" src="https://github.com/user-attachments/assets/ebe7e162-fc04-4000-8277-39ac2e09f71a" />

### Transactions
<img width="1911" height="936" alt="image" src="https://github.com/user-attachments/assets/c6ca1936-fbcb-4e3d-a15b-9b49e89f52aa" />

### Maintenance Log
<img width="1912" height="934" alt="image" src="https://github.com/user-attachments/assets/0135c5fc-498e-426b-847d-4ebfa0bfb58d" />

## Dump Database

File dump SQL tersedia di: `database/sistem_ma.sql`

---
