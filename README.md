# ZENIRO Furniture Store

**ZENIRO** adalah aplikasi web E-Commerce monolitik yang dirancang untuk mensimulasikan operasional bisnis furnitur modern. Aplikasi ini mencakup ekosistem lengkap mulai dari katalog produk, manajemen keranjang belanja, pelacakan pesanan, hingga panel administrasi yang komprehensif.

Project ini dikembangkan sebagai pemenuhan **Tugas Besar (Final Project)** untuk dua mata kuliah sekaligus:

1. **Pemrograman Web** (Frontend Focus)
    
2. **Pemrograman Back-End** (Backend Logic & Database)
    

---

## 🏗️ Development Lifecycle

Project ini tidak dibangun secara instan, melainkan melalui tahapan rekayasa perangkat lunak yang terstruktur:

1. **Requirement Gathering:** Penyusunan SRS (Software Requirement Specification).
    
2. **System Design:** Perancangan ERD (Entity Relationship Diagram) dan Use Case.
    
3. **UI/UX Design:** Prototyping antarmuka menggunakan **Figma**.
    
4. **Development:** Implementasi kode menggunakan Framework Laravel & Tailwind CSS.
    

---

## 🚀 Tech Stack

- **Backend Framework:** Laravel 10/11 (PHP 8.1+)
    
- **Frontend Styling:** Tailwind CSS
    
- **Interactivity:** Alpine.js (Lightweight JavaScript)
    
- **Database:** MySQL
    
- **Version Control:** Git & GitHub
    

---

## 🔥 Key Features

### 🛒 User Modules (Front-Office)

Fitur yang dapat diakses oleh pelanggan (Guest & Registered User):

1. **Home & Company Profile:** Landing page informatif yang memuat profil perusahaan, layanan unggulan, ikhtisar katalog, dan formulir _Contact Us_ yang terhubung ke Admin.
    
2. **E-Commerce Catalog:** Halaman eksplorasi produk lengkap dengan fitur pencarian dan filter.
    
3. **Smart Cart & Checkout:**
    
    - Manajemen keranjang belanja (tambah/hapus item).
        
    - Kalkulasi harga otomatis (Subtotal, Diskon, Grand Total).
        
    - Checkout sederhana (Input Nama, Email, Telepon, Alamat).
        
4. **Product Detail:** Informasi mendalam mengenai spesifikasi produk dengan opsi _Add to Cart_ atau _Direct Purchase_.
    
5. **Order History (Auth Only):** Fitur khusus member untuk melihat riwayat belanja dan status pesanan terkini.
    
6. **Guest Order Tracking:** Fitur pelacakan pesanan untuk pengguna non-login menggunakan _Order Number_ dan _Email_.
    

### 🛡️ Admin Modules (Back-Office)

Panel kontrol untuk pengelolaan operasional bisnis:

1. **Executive Dashboard:**
    
    - Overview statistik real-time (Total Produk, Total Order, Pending Orders, Total Users).
        
    - Daftar order terbaru (Recent Orders).
        
    - Aksi cepat (Quick Actions).
        
2. **Product Management:** CRUD (Create, Read, Update, Delete) data produk furnitur.
    
3. **Order Management:** Memantau pesanan masuk dan mengubah status pesanan (_Pending -> Paid -> Shipped -> Completed/Cancelled_).
    
4. **Message Inbox:** Kotak masuk untuk pesan dari form _Contact Us_. Admin dapat menghapus pesan atau membalas via email (Direct `mailto`).
    
5. **User Management (CRM Sederhana):**
    
    - Memantau daftar pengguna aktif.
        
    - Menambah user baru & mengatur Role (Admin/User).
        
    - **User Insights:** Melihat detail user spesifik (Total pengeluaran, riwayat order, pesan yang dikirim).
        
6. **Admin Profile:** Pengaturan akun admin (Edit Nama, Telepon, dan Ganti Password).

---

## 🛠️ Installation & Setup

Ikuti langkah berikut untuk menjalankan project di komputer lokal:

1. **Clone Repository**
    
    Bash
    
    ```
    git clone https://github.com/USERNAME_LO/zeniro.git
    cd zeniro
    ```
    
2. **Install Dependencies**
    
    Bash
    
    ```
    composer install
    npm install && npm run build
    ```
    
3. **Environment Setup**
    
    - Duplikasi file `.env.example` menjadi `.env`.
        
    - Sesuaikan konfigurasi database.
        
    
    Bash
    
    ```
    cp .env.example .env
    php artisan key:generate
    ```
    
4. **Database Migration & Seeding**
    
    Bash
    
    ```
    php artisan migrate:fresh --seed
    ```
    
5. **Link Storage (Wajib untuk Gambar Produk)**
    
    Bash
    
    ```
    php artisan storage:link
    ```
    
6. **Run Server**
    
    Bash
    
    ```
    php artisan serve
    ```
    

---

## 📝 Project Limitations (Scope)

Project ini memiliki batasan pengembangan (Project Scope) sebagai berikut:

- **Pembayaran Manual:** Verifikasi pembayaran dilakukan secara manual oleh Admin (belum terintegrasi Payment Gateway).
    
- **Logistik:** Perhitungan ongkos kirim diasumsikan _flat rate_ atau ditangani di luar sistem.
    
- **Notifikasi:** Sistem notifikasi real-time (Email/WA) tidak diimplementasikan pada versi ini.
    

---

Developed by ZRFS Student of Information Systems
