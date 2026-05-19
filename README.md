docker compose -f docker-compose.yml up -d --build
docker compose -f docker-compose.yml up -d --build php81
docker compose exec php74 bash
/# PHP Multi-version Docker — Profesional

Ringkasan
--------
Repositori ini menyediakan template Docker Compose untuk menjalankan beberapa versi PHP (5.6, 7.4, 8.2, 8.4, 8.5) secara bersamaan pada mesin pengembangan lokal. Setiap versi memiliki Dockerfile sendiri di bawah `php/<version>/` dan disajikan melalui port berbeda.

Fitur utama
-----------
- Build image per-versi PHP (basis: `php:<version>-apache`).
- Mount folder kerja `projects/` sebagai document root `/var/www/html`.
- Contoh instalasi Composer di image dan tombol cepat untuk phpinfo.
- Panduan singkat menambahkan layanan database (MySQL) dan Redis.

Prasyarat
---------
- Docker Desktop (Compose v2) atau Docker Engine dengan Docker Compose.

Quick start
-----------
1. Dari root proyek jalankan:

```powershell
docker compose -f docker-compose.yml up -d --build
```

2. Akses masing-masing versi di browser:
- PHP 5.6  — http://localhost:8056
- PHP 7.4  — http://localhost:8074
- PHP 8.2  — http://localhost:8082
- PHP 8.4  — http://localhost:8084
- PHP 8.5  — http://localhost:8085

Struktur singkat
----------------
- `docker-compose.yml` — konfigurasi layanan multi-container.
- `php/<version>/Dockerfile` — Dockerfile untuk setiap versi.
- `php/<version>/index.php` — halaman test (phpinfo) tiap versi.
- `projects/` — volume mount untuk kode Anda (disarankan di-ignori dari VCS).

.gitignore dan apa yang sebaiknya diabaikan
---------------------------------------
Karena `projects/` berisi kode pengembangan lokal atau repositori lain, sebaiknya jangan commit folder ini ke repo publik. Contoh entri yang disarankan untuk `.gitignore`:

```
/projects/
/vendor/
/.env
/node_modules/
/.idea/
/.vscode/
.DS_Store
```

Jika Anda ingin menyertakan contoh aplikasi, taruh contoh kecil di direktori `sample/` dan commit hanya file yang diperlukan (`composer.json`, `composer.lock`, konfigurasi contoh).

Menambahkan versi PHP baru
-------------------------
1. Buat direktori baru `php/<version>/` (mis. `php/8.1/`) dan tambahkan `Dockerfile` serta `index.php`.
2. Salin `Dockerfile` dari versi lain dan ubah baris `FROM php:<version>-apache`.
3. Tambahkan service di `docker-compose.yml` dengan pemetaan port dan volume seperti contoh yang sudah ada.
4. Jalankan build untuk service tersebut:

```powershell
docker compose -f docker-compose.yml up -d --build php81
```

Menambahkan database (MySQL) atau Redis
-------------------------------------
Tambahkan snippet layanan berikut ke `docker-compose.yml` jika diperlukan.

MySQL (contoh):

```yaml
  db:
    image: mysql:8.0
    container_name: mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: example
      MYSQL_DATABASE: appdb
      MYSQL_USER: appuser
      MYSQL_PASSWORD: secret
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306"

volumes:
  db_data:
```

Redis (contoh):

```yaml
  redis:
    image: redis:7-alpine
    container_name: redis
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data

volumes:
  redis_data:
```

Keamanan dan catatan penting
----------------------------
- Image PHP 5.6 menggunakan Debian Stretch (EOL). Untuk membangun image legacy ini, Dockerfile mengakses `archive.debian.org` dan menonaktifkan beberapa pemeriksaan apt. Ini hanya untuk tujuan pengembangan lokal/kompatibilitas — jangan gunakan konfigurasi ini di lingkungan produksi.
- Simpan kredensial di `.env` dan jangan commit file yang berisi rahasia.

Composer dan manajemen dependensi
---------------------------------
Disarankan untuk tidak commit folder `vendor/`. Commit `composer.json` dan `composer.lock` saja. Untuk menginstal dependensi gunakan composer di dalam container:

```powershell
docker compose exec php74 bash
composer install
```

Tips publikasi GitHub
---------------------
- Tambahkan `LICENSE` (MIT umum digunakan untuk contoh kode).
- Tambahkan `.github/ISSUE_TEMPLATE` dan `PULL_REQUEST_TEMPLATE` jika ingin menerima kontribusi.
- Sertakan `README` yang ringkas namun lengkap (seperti ini) dan contoh `sample/` untuk memudahkan pengguna.

Kontribusi
----------
Silakan buka PR untuk peningkatan, tambahkan contoh aplikasi kecil, atau perbaiki dokumentasi. Gunakan `issues` untuk berdiskusi fitur baru.

Lisensi
-------
Tambahkan file `LICENSE` sesuai pilihan lisensi Anda (mis. MIT).

Kontak
------
Untuk pertanyaan, Anda dapat membuka `issue` di repository ini.


/node_modules/
/.idea/
/.vscode/
.DS_Store
```

Yang sebaiknya tetap di-commit:
- `composer.json` / `composer.lock` untuk contoh proyek yang ingin disertakan
- `.env.example` sebagai template konfigurasi (jangan commit secret nyata)
- Contoh aplikasi kecil di folder `sample/` (opsional)

## Menambah versi PHP baru

1. Buat folder `php/<version>/` (mis. `php/81/`) dan tambahkan `Dockerfile` serta `index.php`.
   - Salin `php/<version>/Dockerfile` yang ada lalu ubah base image `FROM php:<version>-apache` sesuai versi.
2. Tambahkan service di `docker-compose.yml`:

```yaml
  php81:
    build:
      context: .
      dockerfile: php/81/Dockerfile
    container_name: php81
    ports:
      - "8081:80"
    volumes:
      - ./projects:/var/www/html
      - ./php/81/index.php:/var/www/html/index.php:ro
      - ./php/81/php.ini:/usr/local/etc/php/php.ini:ro
```

3. Rebuild dan jalankan service baru:

```powershell
docker compose -f docker-compose.yml up -d --build php81
```

## Menambah database (MySQL) atau Redis

Contoh service `docker-compose` yang bisa ditambahkan ke `docker-compose.yml`:

Contoh MySQL 8:

```yaml
  db:
    image: mysql:8.0
    container_name: mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: example
      MYSQL_DATABASE: appdb
      MYSQL_USER: appuser
      MYSQL_PASSWORD: secret
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306"

volumes:
  db_data:
```

Contoh Redis:

```yaml
  redis:
    image: redis:7-alpine
    container_name: redis
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data

volumes:
  redis_data:
```

Ketika menambahkan service DB:
- Gunakan environment variable (di `.env`) untuk kredensial dan JANGAN commit secret nyata.
- Gunakan Docker volumes untuk penyimpanan persisten.
- Hanya exposed port bila perlu (untuk development lokal ok, tapi jangan asumsikan exposure di produksi).

## Catatan keamanan untuk PHP 5.6

Image PHP 5.6 berbasis Debian yang sudah EOL (Stretch). Untuk membuat `apt` bekerja, Dockerfile di repo ini menggunakan `archive.debian.org` dan menonaktifkan pemeriksaan tanda tangan/tanggal apt. Hal ini:

- Diperlukan untuk membangun image legacy
- Tidak aman untuk produksi dan sebaiknya dihindari bila memungkinkan

Jika ingin mempublikasikan repo ini secara publik, sebaiknya:
- Hapus atau jelaskan dengan jelas perilaku `php/56/Dockerfile` dan risikonya, atau
- Sediakan image prebuilt dari registry terpercaya alih-alih membangun dari Stretch.

## Composer dan build

Dockerfile di repo ini menginstal Composer saat build image. Jika Anda menaruh aplikasi PHP di `projects/` yang membutuhkan paket Composer, JANGAN commit `vendor/` — commit `composer.json` dan `composer.lock` saja. Pengguna dapat menjalankan composer di dalam container:

```powershell
docker compose exec php74 bash
composer install
```

atau menjalankan composer di host lalu mount `vendor` ke container (tidak direkomendasikan untuk repos publik).

## Kontribusi

- Tambahkan pembaruan README, contoh kecil di `sample/`, atau workflow CI.
- Gunakan `.env.example` untuk placeholder konfigurasi.

## Lisensi

Tambahkan file `LICENSE` jika Anda ingin membuat repositori ini publik. MIT adalah pilihan umum untuk contoh kode.
