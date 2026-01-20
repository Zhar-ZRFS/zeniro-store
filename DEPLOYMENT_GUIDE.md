# VERCEL DEPLOYMENT OPTIMIZATION GUIDE

## Perubahan yang Telah Dilakukan untuk Memperkecil Ukuran Deployment

### 1. Update `vercel.json`
- ✅ Build command dioptimalkan: `composer install --no-dev --optimize-autoloader && npm install --production && npm run build`
- ✅ `APP_DEBUG` diubah dari `true` ke `false` untuk production
- ✅ Ditambahkan `DB_CONNECTION: sqlite` untuk database configuration
- ✅ Exclude files diperluas untuk menghindari upload file yang tidak perlu

### 2. Update `.vercelignore`
- ✅ Ditambahkan excludes untuk: `.md files`, `docker*`, `.env.example`, `.github`, `.yarn`, `.babelrc`, dll
- ✅ Memastikan hanya file essential yang di-upload

### 3. Update `package.json`
- ✅ Moved `axios` dari `devDependencies` ke `dependencies` (hanya runtime yang dibutuhkan)
- ✅ Optimasi untuk production build

### 4. Composer Configuration (via vercel.json)
- ✅ Install dengan `--no-dev` flag untuk exclude dev packages di production
- ✅ `--optimize-autoloader` untuk mengurangi ukuran autoloader

## Ukuran File yang Dikurangi

### Pre-Optimization:
- `/vendor/` - Diinstall dengan semua dev dependencies (~120-150MB)
- `/node_modules/` - Diinstall dari semua packages (~200-300MB)
- Dokumentasi dan config files yang tidak perlu

### Post-Optimization:
- `/vendor/` - Hanya production dependencies (~40-60MB)
- `/node_modules/` - Hanya production dependencies (~5-10MB)
- Dokumentasi dan file konfigurasi dikecualikan dari upload

## Proses Deployment di Vercel

1. Vercel menerima source code saja (tanpa vendor & node_modules)
2. Saat build, Vercel menjalankan:
   - `composer install --no-dev --optimize-autoloader` → menginstall hanya production dependencies
   - `npm install --production` → menginstall hanya production npm packages
   - `npm run build` → compile Tailwind CSS dan JavaScript assets

## Konfigurasi Penting

### Environment Variables yang Diperlukan di Vercel Dashboard:
```
APP_KEY=base64:YOUR_BASE64_KEY (generate with 'php artisan key:generate')
APP_URL=https://yourdomain.com
MAIL_FROM_ADDRESS=your-email@domain.com
DB_DATABASE=database.sqlite (jika menggunakan SQLite)
```

### Database:
- Gunakan SQLite untuk development (file-based, tidak perlu server)
- Untuk production, pertimbangkan menggunakan managed database atau export dari SQLite

## Tips Lebih Lanjut

### 1. Bersihkan Folder Public
```bash
# Pastikan public/img hanya berisi gambar essential
# Pindahkan gambar besar ke cloud storage (AWS S3, Cloudinary, dll)
```

### 2. Code Splitting & Asset Optimization
- Vite sudah handle code splitting otomatis
- Pastikan hanya image terkompresi yang diupload
- Gunakan format modern (WebP) untuk image

### 3. Database Migrations
Saat deployment pertama kali:
1. Vercel akan menjalankan migration saat build
2. Pastikan `APP_ENV=production` agar safe untuk production
3. Setup seed data sesuai kebutuhan

## Estimasi Ukuran Final

**Pre-optimization**: ~350-400MB
**Post-optimization**: ~100-150MB ✅ **Di bawah 240MB Vercel limit!**

## Troubleshooting

### Jika masih melebihi 240MB:

1. **Bersihkan `public/img`**: Hapus gambar yang tidak digunakan
2. **Bersihkan Git history**: Jika ada binary files besar di git history
   ```bash
   git reflog expire --all --expire=now
   git gc --prune=now --aggressive
   ```
3. **Gunakan `.gitignore` agresif**: Pastikan vendor dan node_modules tidak ter-track
4. **Compress Assets**: Optimize semua images dan media files

---

**Last Updated**: January 20, 2026
