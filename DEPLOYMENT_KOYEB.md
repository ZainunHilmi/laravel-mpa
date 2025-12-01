# 🚀 Panduan Deployment Laravel ke Koyeb

Panduan lengkap untuk deploy aplikasi Laravel backend POS Mobile ke platform Koyeb menggunakan GitHub.

## 📋 Prasyarat

- Akun GitHub
- Akun Koyeb (gratis di [koyeb.com](https://www.koyeb.com))
- Repository GitHub untuk proyek ini
- Database PostgreSQL (akan disediakan oleh Koyeb)

## 📁 File-File yang Telah Disiapkan

Proyek ini sudah dilengkapi dengan file-file berikut untuk deployment:

- `Dockerfile` - Konfigurasi Docker container
- `.dockerignore` - File yang diabaikan saat build Docker
- `docker-compose.yml` - Untuk testing lokal
- `docker/nginx.conf` - Konfigurasi Nginx
- `docker/default.conf` - Server block Nginx
- `docker/supervisord.conf` - Process manager
- `docker/deploy.sh` - Script deployment otomatis

## 🔧 Langkah 1: Persiapan Repository GitHub

### 1.1 Inisialisasi Git (jika belum)

```bash
cd "d:\kuliah\pak husen\mpa\testclassrom\backendposmobilelaravel (2) - Copy\backendposmobilelaravel"
git init
git add .
git commit -m "Initial commit - Laravel POS Backend"
```

### 1.2 Buat Repository di GitHub

1. Buka [github.com](https://github.com) dan login
2. Klik tombol **"+"** di pojok kanan atas → **"New repository"**
3. Isi detail repository:
   - **Repository name**: `backend-pos-mobile-laravel`
   - **Description**: Backend API untuk aplikasi POS Mobile
   - **Visibility**: Public atau Private (terserah Anda)
   - **JANGAN** centang "Initialize with README"
4. Klik **"Create repository"**

### 1.3 Push ke GitHub

```bash
git remote add origin https://github.com/USERNAME/backend-pos-mobile-laravel.git
git branch -M main
git push -u origin main
```

> **Catatan**: Ganti `USERNAME` dengan username GitHub Anda

## 🌐 Langkah 2: Setup Koyeb

### 2.1 Buat Akun Koyeb

1. Kunjungi [koyeb.com](https://www.koyeb.com)
2. Klik **"Sign Up"** atau **"Get Started"**
3. Daftar menggunakan akun GitHub Anda (recommended)

### 2.2 Hubungkan GitHub ke Koyeb

1. Setelah login, Koyeb akan meminta akses ke GitHub
2. Klik **"Authorize Koyeb"**
3. Pilih repository yang ingin Anda deploy

## 🚀 Langkah 3: Deploy Aplikasi

### 3.1 Buat Service Baru

1. Di dashboard Koyeb, klik **"Create Service"**
2. Pilih **"GitHub"** sebagai deployment method
3. Pilih repository **backend-pos-mobile-laravel**
4. Pilih branch **main**

### 3.2 Konfigurasi Build

1. **Builder**: Pilih **"Dockerfile"**
2. **Dockerfile path**: `Dockerfile` (default)
3. **Build context**: `/` (root directory)

### 3.3 Konfigurasi Service

1. **Service name**: `laravel-pos-api`
2. **Region**: Pilih region terdekat (misalnya: Singapore)
3. **Instance type**: Pilih **"Free"** untuk testing

### 3.4 Konfigurasi Port

1. **Port**: `8000`
2. **Protocol**: HTTP

### 3.5 Environment Variables

Tambahkan environment variables berikut:

| Variable | Value | Keterangan |
|----------|-------|------------|
| `APP_NAME` | `Laravel POS API` | Nama aplikasi |
| `APP_ENV` | `production` | Environment |
| `APP_DEBUG` | `false` | Debug mode (false untuk production) |
| `APP_KEY` | `base64:...` | Copy dari .env lokal Anda |
| `APP_URL` | `https://laravel-pos-api-XXXXX.koyeb.app` | URL akan diberikan Koyeb |
| `DB_CONNECTION` | `pgsql` | Database driver |
| `DB_HOST` | `(akan diisi dari Koyeb Database)` | Host database |
| `DB_PORT` | `5432` | Port PostgreSQL |
| `DB_DATABASE` | `(akan diisi dari Koyeb Database)` | Nama database |
| `DB_USERNAME` | `(akan diisi dari Koyeb Database)` | Username database |
| `DB_PASSWORD` | `(akan diisi dari Koyeb Database)` | Password database |
| `LOG_CHANNEL` | `stack` | Log channel |
| `SESSION_DRIVER` | `file` | Session driver |
| `QUEUE_CONNECTION` | `sync` | Queue connection |

> **Penting**: Untuk mendapatkan `APP_KEY`, jalankan `php artisan key:generate --show` di lokal

## 🗄️ Langkah 4: Setup Database PostgreSQL

### 4.1 Buat Database Service

1. Di dashboard Koyeb, klik **"Create Service"** lagi
2. Pilih **"Database"** → **"PostgreSQL"**
3. Atau gunakan database eksternal seperti:
   - [Supabase](https://supabase.com) (Gratis)
   - [Neon](https://neon.tech) (Gratis)
   - [Railway](https://railway.app) (Gratis dengan limit)

### 4.2 Konfigurasi Database (Jika menggunakan Koyeb)

1. **Database name**: `laravel_pos_db`
2. **Region**: Sama dengan region aplikasi
3. **Instance type**: Free tier

### 4.3 Update Environment Variables

Setelah database dibuat, update environment variables di service Laravel:

1. Kembali ke service `laravel-pos-api`
2. Klik **"Settings"** → **"Environment Variables"**
3. Update nilai `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
4. Klik **"Save"**

### 4.4 Alternatif: Menggunakan Supabase (Recommended untuk Free Tier)

1. Buat akun di [supabase.com](https://supabase.com)
2. Buat project baru
3. Di **Settings** → **Database**, copy connection string
4. Parse connection string dan masukkan ke environment variables Koyeb:
   - Host: `db.xxxxx.supabase.co`
   - Port: `5432`
   - Database: `postgres`
   - Username: `postgres`
   - Password: `(dari Supabase)`

## 🔄 Langkah 5: Deploy & Migrasi Database

### 5.1 Deploy Aplikasi

1. Setelah semua konfigurasi selesai, klik **"Deploy"**
2. Koyeb akan mulai build dan deploy aplikasi
3. Tunggu hingga status berubah menjadi **"Healthy"** (sekitar 5-10 menit)

### 5.2 Jalankan Migrasi Database

Untuk menjalankan migrasi, Anda perlu mengakses console:

**Opsi 1: Menggunakan Koyeb CLI**

```bash
# Install Koyeb CLI
npm install -g @koyeb/koyeb-cli

# Login
koyeb login

# Jalankan migrasi
koyeb exec laravel-pos-api -- php artisan migrate --force
```

**Opsi 2: Trigger via GitHub**

Tambahkan file `docker/entrypoint.sh`:

```bash
#!/bin/sh
php artisan migrate --force
php artisan config:cache
php artisan route:cache
exec "$@"
```

Update `Dockerfile` untuk menggunakan entrypoint ini.

### 5.3 Seed Database (Opsional)

Jika ingin mengisi data awal:

```bash
koyeb exec laravel-pos-api -- php artisan db:seed --force
```

## ✅ Langkah 6: Verifikasi Deployment

### 6.1 Cek URL Aplikasi

1. Di dashboard Koyeb, copy URL aplikasi (contoh: `https://laravel-pos-api-xxxxx.koyeb.app`)
2. Buka di browser atau Postman
3. Test endpoint:
   - `GET /api/products` - List produk
   - `POST /api/login` - Login
   - `POST /api/register` - Register

### 6.2 Test API Endpoints

**Login:**
```bash
curl -X POST https://laravel-pos-api-xxxxx.koyeb.app/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

**Get Products:**
```bash
curl https://laravel-pos-api-xxxxx.koyeb.app/api/products
```

## 🔄 Langkah 7: Auto-Deploy dari GitHub

### 7.1 Konfigurasi Auto-Deploy

Koyeb sudah otomatis mengaktifkan auto-deploy. Setiap kali Anda push ke branch `main`, aplikasi akan otomatis di-rebuild dan di-deploy.

### 7.2 Workflow

1. Buat perubahan di lokal
2. Commit dan push ke GitHub:
   ```bash
   git add .
   git commit -m "Update feature X"
   git push origin main
   ```
3. Koyeb akan otomatis detect perubahan dan deploy ulang

## 🛠️ Troubleshooting

### Error: "Application Error"

1. Cek logs di dashboard Koyeb
2. Pastikan `APP_KEY` sudah diset
3. Pastikan database credentials benar

### Error: "Database Connection Failed"

1. Verifikasi environment variables database
2. Cek apakah database service sudah running
3. Test koneksi database dari lokal

### Error: "500 Internal Server Error"

1. Set `APP_DEBUG=true` sementara untuk melihat error detail
2. Cek logs: `koyeb logs laravel-pos-api`
3. Pastikan storage permissions sudah benar

### Build Failed

1. Cek Dockerfile syntax
2. Pastikan semua dependencies ada di `composer.json`
3. Cek build logs di Koyeb dashboard

## 📝 Catatan Penting

1. **APP_KEY**: Jangan lupa generate dan set di environment variables
2. **Database**: Gunakan PostgreSQL, bukan MySQL
3. **Storage**: File upload akan hilang saat redeploy. Gunakan S3 atau cloud storage untuk production
4. **HTTPS**: Koyeb otomatis menyediakan SSL certificate
5. **CORS**: Pastikan konfigurasi CORS sudah benar untuk mobile app

## 🔐 Keamanan

1. Jangan commit file `.env` ke GitHub
2. Gunakan environment variables untuk semua credentials
3. Set `APP_DEBUG=false` di production
4. Aktifkan rate limiting untuk API
5. Gunakan HTTPS untuk semua request

## 📚 Resources

- [Koyeb Documentation](https://www.koyeb.com/docs)
- [Laravel Deployment](https://laravel.com/docs/10.x/deployment)
- [Docker Best Practices](https://docs.docker.com/develop/dev-best-practices/)

## 🆘 Bantuan

Jika mengalami masalah:

1. Cek logs di Koyeb dashboard
2. Baca dokumentasi Koyeb
3. Hubungi support Koyeb via chat di dashboard

---

**Selamat! Aplikasi Laravel Anda sudah siap di-deploy ke Koyeb! 🎉**
