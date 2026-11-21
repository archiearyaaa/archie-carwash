# 🚗 Archie CarWash - Sistem Informasi & Pendaftaran Antrian Online

Aplikasi web modern untuk manajemen pelayanan jasa cuci mobil profesional berbasis antrian online (*Online Booking & Queue Management System*). Dibangun untuk meningkatkan efisiensi operasional workshop, transparansi antrian pelanggan, dan kemudahan pencatatan transaksi kasir.

---

## 🌟 Fitur Utama

### 📱 Sisi Pelanggan (Public Portal)
1. **Pendaftaran Antrian Online (Booking):**
   - Pemilihan jenis paket cucian mobil (Cucian Body, Cucian Menyeluruh, Paket Hemat).
   - **Layanan Tambahan (Add-on Services):** Pilihan opsional seperti *Fogging Disinfektan Interior*, *Pembersihan Jamur Kaca*, dan *Semir Ban Wet-Look*.
   - **Kalkulator Biaya Real-time:** Menghitung total estimasi harga paket utama dan add-on secara otomatis.
2. **Live Lacak Antrian (Queue Progress Tracker):**
   - Pelanggan dapat memasukkan nomor handphone atau nomor plat untuk memantau status mobil mereka secara langsung (Pendaftaran ➔ Sedang Dicuci ➔ Selesai).
3. **E-Ticket Digital & Struk Antrian:**
   - Halaman tiket digital dengan rincian antrian, estimasi biaya, dan tanggal pendaftaran.
   - Fitur **Kirim Tiket ke WhatsApp** secara otomatis.
   - Tombol **Cetak Tiket / PDF** langsung dari browser.
4. **Status Jam Operasional Otomatis:**
   - Indikator buka/tutup dinamis menyesuaikan jam operasional (Senin-Jumat 07:30 - 18:00 WIB, Sabtu-Minggu 07:30 - 17:00 WIB).
5. **Peta Interaktif Google Maps:**
   - Embed peta workshop (Nangnung Tengah, dekat Kampus Polman Babel, Sungailiat) beserta tombol penunjuk arah instan.
6. **Form Kritik, Saran & Rating Kepuasan Pelanggan:**
   - Sistem penilaian bintang (Kebersihan, Keramahan, Ketelitian).

---

### 🖥️ Display TV Ruang Tunggu (`display_antrian.php`)
- Tampilan layar penuh (*Full Screen Display TV*) modern bernuansa *dark mode*.
- Jam digital real-time & status operasional.
- Kartu antrian besar untuk mobil yang **Sedang Dicuci** dan **Antrian Berikutnya**.
- **Auto-Refresh** data setiap 10 detik tanpa memuat ulang seluruh halaman.

---

### 💼 Sisi Administrator & Kasir (`admin/`)
1. **Manajemen Transaksi & Kasir:**
   - Pencatatan pembayaran, nominal bayar, dan uang kembali.
   - **Cetak Nota Kasir Thermal (58mm / 80mm):** Layout struk kasir profesional khusus printer thermal POS.
2. **Kelola Paket Cucian & Kendaraan:**
   - Tambah, ubah, dan hapus jenis cucian mobil beserta harga.
3. **Rekap Saran & Ulasan:**
   - Melihat feedback pelanggan dan persentase kepuasan.
4. **Laporan & Export Excel:**
   - Filter laporan berdasarkan rentang tanggal.
   - **Export ke Microsoft Excel (.xls)** dengan format tabel bersih dan rekapitulasi total pendapatan.
   - Cetak Laporan PDF.

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP (Native)
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript, jQuery
- **Framework UI:** Bootstrap 3 (Customized Modern Responsive Styling)
- **Icons & Visual:** Font Awesome, Owl Carousel, WOW.js, Animate.css
- **PDF Engine:** FPDF

---

## 🚀 Panduan Instalasi (Localhost)

### 1. Kebutuhan Sistem
- Web Server: **Laragon** (Rekomendasi) atau **XAMPP**
- PHP Versi: 7.x / 8.x
- MySQL / MariaDB

### 2. Langkah-langkah
1. **Clone repository ini:**
   ```bash
   git clone https://github.com/archiearyaaa/archie-carwash.git
   ```
   *Atau salin folder proyek ke direktori `C:\laragon\www\` (Laragon) atau `C:\xampp\htdocs\` (XAMPP).*

2. **Setup Database:**
   - Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
   - Buat database baru dengan nama `jasa`.
   - Pilih tab **Import**, lalu pilih file `database/jasa.sql` yang ada di dalam proyek ini.
   - Klik **Go / Kirim**.

3. **Konfigurasi Koneksi:**
   - Periksa file `config/koneksi.php`:
     ```php
     $host = "localhost";
     $user = "root";
     $pass = "";
     $db   = "jasa";
     ```
   - Sesuaikan *username* dan *password* database Anda bila berbeda.

4. **Jalankan Aplikasi:**
   - Akses via browser:
     - **Halaman Utama (Pelanggan):** `http://localhost/archie-carwash/`
     - **Display TV Antrian:** `http://localhost/archie-carwash/display_antrian.php`
     - **Login Admin/Kasir:** `http://localhost/archie-carwash/login.php`

---

## 👤 Pengembang

- **Nama:** Archie Arya Manggala
- **Email:** archiearyamanggala7@gmail.com
- **Lokasi:** Sungailiat, Bangka Belitung, Indonesia
