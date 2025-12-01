# ⚡ Quick Start - Deploy ke Koyeb

Panduan singkat untuk deployment cepat.

## 📦 Persiapan (5 menit)

### 1. Push ke GitHub
```bash
git init
git add .
git commit -m "Ready for Koyeb deployment"
git remote add origin https://github.com/USERNAME/backend-pos-mobile-laravel.git
git push -u origin main
```

### 2. Generate APP_KEY
```bash
php artisan key:generate --show
```
Copy hasilnya, akan digunakan di Koyeb.

## 🚀 Deploy di Koyeb (10 menit)

### 1. Buat Service
1. Login ke [koyeb.com](https://www.koyeb.com)
2. Klik **"Create Service"** → Pilih **GitHub**
3. Pilih repository Anda
4. Builder: **Dockerfile**
5. Port: **8000**

### 2. Set Environment Variables

**Wajib:**
```
APP_NAME=Laravel POS API
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... (dari step 2 di atas)
APP_URL=https://your-app.koyeb.app
```

**Database (gunakan Supabase gratis):**
```
DB_CONNECTION=pgsql
DB_HOST=db.xxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-supabase-password
```

**Lainnya:**
```
LOG_CHANNEL=stack
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### 3. Deploy
Klik **"Deploy"** dan tunggu 5-10 menit.

## 🗄️ Setup Database Supabase (5 menit)

1. Buat akun di [supabase.com](https://supabase.com)
2. Buat project baru
3. Di **Settings** → **Database**, copy:
   - Host
   - Database name
   - User
   - Password
4. Masukkan ke Environment Variables di Koyeb

## ✅ Test API

```bash
# Ganti URL dengan URL Koyeb Anda
curl https://your-app.koyeb.app/api/products
```

## 🔄 Update Aplikasi

```bash
git add .
git commit -m "Update feature"
git push origin main
```

Koyeb akan otomatis deploy ulang!

## 📚 Dokumentasi Lengkap

Lihat [DEPLOYMENT_KOYEB.md](./DEPLOYMENT_KOYEB.md) untuk panduan detail.

---

**Total waktu: ~20 menit** ⏱️
