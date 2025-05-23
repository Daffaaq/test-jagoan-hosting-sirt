# Panduan Instalasi Aplikasi

> **Catatan Penting:**  
> Jika panduan ini tidak diikuti secara lengkap dan benar, maka proses instalasi dianggap gagal.

---

## Persyaratan Sistem

- PHP 8.1.10 atau lebih tinggi  
- Composer  
- Database MySQL / MariaDB  
- Node.js dan npm

---

## ERD

[Klik di sini untuk melihat ERD](https://dbdiagram.io/d/6830aa30b9f7446da3e558af)

## Langkah Instalasi

1. **Clone repository**  
   ```bash
   git clone https://github.com/Daffaaq/test-jagoan-hosting-sirt
   cd projectname
2. **Install dependencies PHP**
   ```bash
   composer install
   ```
3. **Install dependencies frontend**
   ```bash
   npm install
   ```
4. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   ```
5. **Generate application key**
   ```bash
   php artisan key:generate
   ```
6. **Migrasi dan seed database**
   ```bash
   php artisan migrate:fresh --seed
   ```
7. **Build asset frontend**
   ```bash
   npm run build
   ```
8. **Storage**
   ```bash
   php artisan storage:link
   ```
8. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

## Troubleshooting

1. Pastikan PHP, Composer, Node.js, dan npm sudah terinstall dengan benar dan versinya sesuai.
2. Pastikan konfigurasi database di file .env sudah tepat dan database aktif.
3. Cek log error di storage/logs/laravel.log untuk debug jika terjadi masalah.
4. Jika masalah terkait asset frontend, coba ulangi ```npm install``` dan build ulang dengan ```npm run build```

## Catatan Penting Terkait Ketentuan Skill Fit Test
Aplikasi ini dikembangkan untuk memenuhi tantangan Skill Fit Test - Full Stack Programmer dengan ketentuan sebagai berikut:

✅ Backend: Laravel

✅ DBMS: MySQL

⚠️ Frontend: Seharusnya menggunakan React, namun...

Catatan:
>Saat ini saya masih dalam proses pembelajaran React JS, sehingga frontend pada aplikasi ini masih menggunakan Blade Template bawaan Laravel.
>Saya mohon maaf atas keterbatasan ini, dan berharap tetap dapat dinilai berdasarkan fungsionalitas serta struktur backend yang telah saya bangun.
>Saya berkomitmen untuk terus belajar dan meningkatkan kemampuan React saya ke depannya.

## Kontak Dukungan

Jika mengalami kesulitan selama proses instalasi, silakan hubungi tim pengembang melalui:

📧 Email: [daffaaqila48@gmail.com](mailto:daffaaqila48@gmail.com)
