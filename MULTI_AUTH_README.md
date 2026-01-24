# Implementasi Multi-Authentication (Livewire Volt & Laravel 11 Structure)

## Rangkuman Perubahan

1.  **Database**:
    - Kolom `role` ditambahkan ke tabel `users` (Default: 'user', Admin: 'admin').
    - Migrasi `2025_01_24_000003_rename_roles_to_role_in_users_table.php` telah dibuat dan dijalankan.

2.  **Middleware**:
    - `AdminMiddleware` dibuat di `app/Http/Middleware/AdminMiddleware.php`.
    - Middleware didaftarkan sebagai alias `'admin'` di `app/Http/Kernel.php` (kompatibel dengan Laravel 10 saat ini).
    - **Contoh Konfigurasi Laravel 11**: Lihat file `bootstrap/app_L11_example.php` untuk cara mendaftarkannya jika project di-upgrade ke Laravel 11.

3.  **Routes**:
    - Routes admin dikelompokkan dengan prefix `/admin` dan middleware `admin`.
    - `/admin/dashboard` sekarang terpisah dari `/dashboard` user biasa.

4.  **Livewire Volt**:
    - Package Livewire Volt telah diinstall via Composer.
    - *Catatan*: Karena project ini berbasis Laravel 10/Breeze 1.x, template Volt tidak bisa diinstall otomatis sepenuhnya tanpa upgrade framework. Namun package `livewire/volt` sudah ada dan siap digunakan secara manual.

## Cara Menggunakan

1.  **Login sebagai Admin**:
    - Pastikan user di database memiliki kolom `role` = 'admin'.
    - Akses `/admin/dashboard` atau route admin lainnya.

2.  **Login sebagai User**:
    - User dengan role selain 'admin' akan diredirect ke `/dashboard` jika mencoba akses area admin.

## Struktur Routes Baru

```php
// Admin (Middleware: auth, admin)
GET /admin/dashboard
RESOURCE /admin/user
RESOURCE /admin/product
RESOURCE /admin/order

// User (Middleware: auth)
GET /dashboard
GET /cart
POST /checkout
```
