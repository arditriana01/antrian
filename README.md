# Sistem Antrian Digital - Laravel + Inertia + Vue

Sistem ini merupakan aplikasi antrian digital yang mencakup:
- Halaman Display Antrian dengan notifikasi suara otomatis (Text-to-Speech)
- Dashboard monitoring staf dan statistik pelayanan
- Manajemen antrian dengan sistem pemanggilan reservasi dan walk-in (skema 2:1)

## 🚀 Fitur Utama

- Tampilan display antrian real-time
- Pemanggilan otomatis dengan Text-to-Speech
- Dashboard staf dengan statistik:
  - Jumlah antrian aktif
  - Jumlah staf aktif
  - Top 3 staf teraktif
  - Rata-rata waktu pelayanan per staf

---

## 🛠️ Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/arditriana01/antrian.git
cd antrian
```

### 2. Install Dependency Laravel
```bash
composer install
```

### 3. Install Dependency Frontend
```bash
npm install
npm run dev
```

### 4. Copy dan Konfigurasi `.env`
```bash
cp .env.example .env
```

Edit file `.env` sesuai konfigurasi lokalmu (DB, APP_URL, dll), lalu generate key:
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi dan Seeder
```bash
php artisan migrate --seed
```

### 6. Jalankan Server
```bash
php artisan serve
```

---

## 🌐 Cara Akses

### ✅ Display Antrian
**URL:** `/display`  
Menampilkan antrian secara real-time. Suara akan diputar otomatis menggunakan Text-to-Speech browser.

### ✅ Dashboard Monitoring
**URL:** `/staff/dashboard`  
Menampilkan jumlah antrian aktif, staf aktif, top 3 staf, dan statistik waktu pelayanan.

Untuk login bisa akses : `/staff/login`

Staff 1

- username : loket1
- password : loket1pass

Staff 2

- username : loket2
- password : loket2pass

Staff 3

- username : loket3
- password : loket3pass

### ✅ User Reservasi
**URL:** `/login` 
User terlebih dahulu login / register untuk melakukan reservasi antrian

- email : jack@gmail.com
- password : jack123

---

## 🧪 Data Dummy

Data dummy (antrian, staff) akan otomatis dibuat oleh seeder. Bisa mengubahnya di:

- `database/seeders/`

---

## 📁 Struktur Penting

- `app/Http/Controllers/QueueController.php` – Logika pemanggilan antrian
- `resources/js/Pages/Display.vue` – Tampilan layar antrian (dengan suara)
- `resources/js/Pages/Staff/Dashboard.vue` – Dashboard monitoring staf
- `routes/web.php` – Daftar route Inertia (frontend)

---

## 📄 Teknologi

- Laravel 12
- Inertia.js
- Vue 3
- TailwindCSS
- HTML5 TTS API
- Version PHP 8.2

---
