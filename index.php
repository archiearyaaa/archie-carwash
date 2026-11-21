<?php
include "config/koneksi.php";
error_reporting(0);
session_start();

date_default_timezone_set('Asia/Jakarta');
$tgl_pendaftaran = date("Y-m-d");
$hari_ini_num = intval(date('N')); // 1=Senin, 7=Minggu
$jam_sekarang = date('H:i');
$jam_tutup_hari_ini = ($hari_ini_num >= 6) ? '17:00' : '18:00';
$is_bengkel_buka = ($jam_sekarang >= '07:30' && $jam_sekarang < $jam_tutup_hari_ini);

// Hitung nomor antrian hari ini
$queryy = mysql_query("SELECT no_antrian FROM pendaftaran WHERE tgl_pendaftaran = '$tgl_pendaftaran'");
$htg = mysql_num_rows($queryy);
$next = $htg + 1;
$no_antrian = $tgl_pendaftaran . '/' . $next;

// Cari id_customer berikutnya
$hitung = mysql_query("SELECT max(id_customer) as id_terakhir from customer");
$cari = mysql_fetch_array($hitung);
$id_lanjut = !empty($cari['id_terakhir']) ? ($cari['id_terakhir'] + 1) : 1;
?>
<!DOCTYPE html>
<html lang="id">

<head>
     <title>Archie CarWash - Jasa Cuci Mobil Berkualitas & Antrian Online</title>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="Jasa Cuci Mobil Profesional, Cepat, Bersih dan Mengkilap di Sungailiat Bangka. Booking antrian online sekarang!">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/animate.css">
     <link rel="stylesheet" href="css/owl.carousel.css">
     <link rel="stylesheet" href="css/owl.theme.default.min.css">

     <link rel="shortcut icon" type="image/x-icon" href="images/2.png" sizes="32x32">
     
     <!-- MAIN CSS -->
     <link rel="stylesheet" href="css/tooplate-style.css">
     <!-- CUSTOM MODERN RESPONSIVE UI CSS -->
     <link rel="stylesheet" href="css/custom-modern.css">
</head>

<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

     <!-- PRE LOADER -->
     <section class="preloader">
          <div class="spinner">
               <span class="spinner-rotate"></span>
          </div>
     </section>

     <!-- TOP HEADER -->
     <header>
          <div class="container">
               <div class="row">
                    <div class="col-md-5 col-sm-6 col-xs-12">
                         <p><i class="fa fa-map-marker"></i> Nangnung Tengah (Dekat Polman Babel), Sungailiat</p>
                    </div>

                    <div class="col-md-7 col-sm-6 col-xs-12 text-align-right">
                         <span class="phone-icon"><i class="fa fa-whatsapp"></i> <a href="https://wa.me/6287706662738" target="_blank" style="color: inherit;">0877-0666-2738</a></span>
                         <span class="clock-icon"><i class="fa fa-clock-o"></i> 07:30 - <?= $jam_tutup_hari_ini; ?> WIB</span>
                         <?php if ($is_bengkel_buka): ?>
                              <span class="badge-operational-open"><span class="pulse-dot-mini"></span> Buka Sekarang</span>
                         <?php else: ?>
                              <span class="badge-operational-closed"><i class="fa fa-moon-o"></i> Sedang Tutup</span>
                         <?php endif; ?>
                    </div>
               </div>
          </div>
     </header>

     <!-- NAVIGATION -->
     <section class="navbar navbar-default navbar-static-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" aria-label="Toggle Navigation">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <a href="index.php" class="navbar-brand">
                         <i class="fa fa-car"></i> Archie CarWash
                    </a>
               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                         <li><a href="#home" class="smoothScroll">Beranda</a></li>
                         <li><a href="#keunggulan" class="smoothScroll">Keunggulan</a></li>
                         <li><a href="#pelayanan" class="smoothScroll">Layanan & Tarif</a></li>
                         <li><a href="#cara-antri" class="smoothScroll">Alur Antrian</a></li>
                         <li><a href="#lacak" class="smoothScroll" style="color: #0284c7 !important; font-weight: 600;"><i class="fa fa-search"></i> Lacak Antrian</a></li>
                         <li><a href="#appointment" class="smoothScroll">Pendaftaran</a></li>
                         <li><a href="#saran" class="smoothScroll">Kritik & Saran</a></li>
                         <li><a href="#about" class="smoothScroll">Tentang Kami</a></li>

                         <?php if(isset($_SESSION['user_name'])): ?>
                              <li><a href="#"><i class="fa fa-user-circle"></i> <?= htmlspecialchars($_SESSION['user_name']); ?></a></li>
                              <li><a href="config/logout.php" style="color: #ef4444 !important;"><i class="fa fa-sign-out"></i> Keluar</a></li>
                         <?php elseif(isset($_SESSION['admin_name'])): ?>
                              <li><a href="admin/index.php" class="nav-btn-login"><i class="fa fa-dashboard"></i> Panel Admin</a></li>
                              <li><a href="config/logout.php" style="color: #ef4444 !important;"><i class="fa fa-sign-out"></i> Keluar</a></li>
                         <?php else: ?>
                              <li><a href="login.php" class="nav-btn-login"><i class="fa fa-sign-in"></i> Masuk / Login</a></li>
                         <?php endif; ?>
                    </ul>
               </div>

          </div>
     </section>

     <!-- HOME SLIDER -->
     <section id="home" class="slider" data-stellar-background-ratio="0.5">
          <div class="container">
               <div class="row">
                    <div class="owl-carousel owl-theme">
                         <div class="item item-first">
                              <div class="caption">
                                   <div class="col-md-offset-1 col-md-10 col-xs-12 text-center">
                                        <h3>Solusi Perawatan Mobil Bersih, Kilat & Terpercaya</h3>
                                        <h1>Archie CarWash Sungailiat</h1>
                                        <div class="hero-btn-group">
                                             <a href="#appointment" class="btn-hero-primary smoothScroll"><i class="fa fa-calendar-check-o"></i> Booking Antrian Online</a>
                                             <a href="#lacak" class="btn-hero-secondary smoothScroll"><i class="fa fa-search"></i> Cek Status Mobil</a>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="item item-second">
                              <div class="caption">
                                   <div class="col-md-offset-1 col-md-10 col-xs-12 text-center">
                                        <h3>Kinclongkan Mobil Anda Tanpa Ribet Antri Lama</h3>
                                        <h1>Pesan Nomor Antrian Dari Rumah</h1>
                                        <div class="hero-btn-group">
                                             <a href="#appointment" class="btn-hero-primary smoothScroll"><i class="fa fa-ticket"></i> Ambil Nomor Antrian</a>
                                             <a href="#lacak" class="btn-hero-secondary smoothScroll"><i class="fa fa-search"></i> Cek Status Mobil</a>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="item item-third">
                              <div class="caption">
                                   <div class="col-md-offset-1 col-md-10 col-xs-12 text-center">
                                        <h3>Shampoo Snow Foam Premium & Tenaga Berpengalaman</h3>
                                        <h1>Kepuasan & Kilau Mobil Prioritas Kami</h1>
                                        <div class="hero-btn-group">
                                             <a href="#appointment" class="btn-hero-primary smoothScroll"><i class="fa fa-car"></i> Cuci Mobil Sekarang</a>
                                             <a href="#saran" class="btn-hero-secondary smoothScroll"><i class="fa fa-comments"></i> Beri Masukan</a>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- SECTION KEUNGGULAN (WHY CHOOSE US) -->
     <section id="keunggulan" class="section-modern bg-pattern">
          <div class="container">
               <div class="row">
                    <div class="col-md-12">
                         <div class="section-header-modern">
                              <span class="badge-sub">Keunggulan Layanan</span>
                              <h2>Mengapa Memilih Archie CarWash?</h2>
                              <p>Kami memberikan standar perawatan kendaraan terbaik dengan peralatan modern dan pelayanan yang ramah.</p>
                         </div>
                    </div>
               </div>

               <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                         <div class="feature-card">
                              <div class="feature-icon-wrapper">
                                   <i class="fa fa-shield"></i>
                              </div>
                              <h4>Bahan Sabun Premium</h4>
                              <p>Menggunakan snow foam pH seimbang yang aman melindungi lapisan cat mobil serta memberikan kilau maksimal tahan lama.</p>
                         </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                         <div class="feature-card">
                              <div class="feature-icon-wrapper">
                                   <i class="fa fa-bolt"></i>
                              </div>
                              <h4>Cepat & Kilat</h4>
                              <p>Didukung tim berpengalaman dan mesin cuci hidrolik bertekanan tinggi untuk hasil bersih tuntas tanpa membuang waktu Anda.</p>
                         </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                         <div class="feature-card">
                              <div class="feature-icon-wrapper">
                                   <i class="fa fa-calendar-check-o"></i>
                              </div>
                              <h4>Booking Antrian Online</h4>
                              <p>Daftar antrian langsung dari ponsel Anda kapan saja. Pilih jam kedatangan dan hindari antri lama di lokasi panas.</p>
                         </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                         <div class="feature-card">
                              <div class="feature-icon-wrapper">
                                   <i class="fa fa-coffee"></i>
                              </div>
                              <h4>Ruang Tunggu Nyaman</h4>
                              <p>Ruang tunggu sejuk, bersih, dilengkapi koneksi Wi-Fi gratis, dan aneka minuman segar selagi kendaraan Anda dikerjakan.</p>
                         </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- SECTION LAYANAN & DAFTAR HARGA -->
     <section id="pelayanan" class="section-modern">
          <div class="container">
               <div class="row">
                    <div class="col-md-12">
                         <div class="section-header-modern">
                              <span class="badge-sub">Pilihan Terbaik</span>
                              <h2>Paket & Tarif Cuci Mobil</h2>
                              <p>Pilih paket perawatan yang sesuai dengan kebutuhan mobil Anda dengan harga yang transparan dan terjangkau.</p>
                         </div>
                    </div>
               </div>

               <div class="row">
                    <?php
                    $q_layanan = mysql_query("SELECT * FROM jenis_cucian ORDER BY biaya ASC");
                    $no_item = 0;
                    if(mysql_num_rows($q_layanan) > 0) {
                         while($layanan = mysql_fetch_array($q_layanan)) {
                              $no_item++;
                              $is_featured = ($no_item == 2);
                    ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                         <div class="pricing-card <?= $is_featured ? 'featured' : ''; ?>">
                              <?php if($is_featured): ?>
                                   <div class="pricing-badge">Paling Favorit</div>
                              <?php endif; ?>

                              <div class="pricing-header">
                                   <div class="pricing-icon">
                                        <i class="fa <?= $no_item == 1 ? 'fa-car' : ($no_item == 2 ? 'fa-shower' : 'fa-star'); ?>"></i>
                                   </div>
                                   <h3 class="pricing-title"><?= htmlspecialchars($layanan['jenis_cucian']); ?></h3>
                                   <div class="pricing-cost">
                                        Rp <?= number_format($layanan['biaya'], 0, ',', '.'); ?>
                                        <span>/ unit</span>
                                   </div>
                              </div>

                              <ul class="pricing-features">
                                   <li><i class="fa fa-check-circle"></i> Cuci Eksterior Snow Foam</li>
                                   <li><i class="fa fa-check-circle"></i> Semir Ban & Velg Mengkilap</li>
                                   <li><i class="fa fa-check-circle"></i> Pembersihan Kaca & Wiper</li>
                                   <?php if($layanan['biaya'] >= 35000): ?>
                                        <li><i class="fa fa-check-circle"></i> Vacuum Debu Interior Mobil</li>
                                   <?php endif; ?>
                                   <?php if($layanan['biaya'] >= 45000): ?>
                                        <li><i class="fa fa-check-circle"></i> Semprot Kolong Hidrolik & Ruang Mesin</li>
                                   <?php endif; ?>
                              </ul>

                              <button type="button" class="btn-select-package" onclick="pilihPaket('<?= $layanan['id_jenis_cucian']; ?>', '<?= addslashes($layanan['jenis_cucian']); ?>', '<?= $layanan['biaya']; ?>')">
                                   <i class="fa fa-check"></i> Pilih Layanan Ini
                              </button>
                         </div>
                    </div>
                    <?php 
                         }
                    } else {
                    ?>
                    <div class="col-md-12 text-center">
                         <p>Belum ada data paket cuci.</p>
                    </div>
                    <?php } ?>
               </div>
          </div>
     </section>

     <!-- SECTION CARA ANTRI (HOW IT WORKS) -->
     <section id="cara-antri" class="section-modern bg-pattern">
          <div class="container">
               <div class="row">
                    <div class="col-md-12">
                         <div class="section-header-modern">
                              <span class="badge-sub">Mudah & Cepat</span>
                              <h2>Alur Pendaftaran Antrian</h2>
                              <p>Hanya dengan 4 langkah praktis, mobil Anda siap tampil bersih dan wangi.</p>
                         </div>
                    </div>
               </div>

               <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                         <div class="step-item">
                              <div class="step-number">1</div>
                              <h4>Isi Data Kendaraan</h4>
                              <p>Lengkapi nama, nomor handphone, nomor plat polisi, dan tipe mobil Anda.</p>
                         </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                         <div class="step-item">
                              <div class="step-number">2</div>
                              <h4>Tentukan Layanan & Jam</h4>
                              <p>Pilih paket cucian yang diinginkan serta jam rencana kedatangan Anda di bengkel.</p>
                         </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                         <div class="step-item">
                              <div class="step-number">3</div>
                              <h4>Dapatkan Nomor Antrian</h4>
                              <p>Sistem akan menerbitkan tiket struk antrian resmi secara otomatis untuk Anda bawa.</p>
                         </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                         <div class="step-item">
                              <div class="step-number">4</div>
                              <h4>Datang & Cuci Langsung</h4>
                              <p>Tiba maksimal 10 menit sebelum jam terpilih, tunjukkan nomor antrian dan langsung dikerjakan!</p>
                         </div>
                    </div>
               </div>
          </div>
     </section>

          <!-- SECTION LACAK STATUS ANTRIAN REAL-TIME -->
     <section id="lacak" class="section-modern bg-pattern">
          <div class="container">
               <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                         <div class="tracker-wrapper">
                              <div class="section-header-modern" style="margin-bottom: 25px;">
                                   <span class="badge-sub"><i class="fa fa-search"></i> Live Tracking Real-Time</span>
                                   <h2>Lacak Status Cuci Kendaraan</h2>
                                   <p>Pantau progres pencucian mobil Anda secara langsung dari mana saja tanpa harus menunggu di lokasi.</p>
                              </div>

                              <form method="GET" action="#lacak" class="tracker-search-box">
                                   <input type="text" name="lacak" class="tracker-search-input" placeholder="Masukkan Nomor Plat (Contoh: BN 1750) atau Nomor Antrian..." value="<?= isset($_GET['lacak']) ? htmlspecialchars($_GET['lacak']) : ''; ?>" required>
                                   <button type="submit" class="btn-track">
                                        <i class="fa fa-search"></i> Lacak Status Mobil
                                   </button>
                              </form>

                              <?php
                              $keyword_lacak = isset($_GET['lacak']) ? trim($_GET['lacak']) : '';
                              if(!empty($keyword_lacak)):
                                   $keyword_safe = mysqli_real_escape_string($conn, $keyword_lacak);
                                   $q_track = mysql_query("SELECT pendaftaran.*, customer.nama, customer.nomor_plat, customer.type_mobil, customer.merek_mobil, customer.no_hp, jenis_cucian.jenis_cucian, jenis_cucian.biaya 
                                                          FROM pendaftaran 
                                                          JOIN customer USING (id_customer) 
                                                          JOIN jenis_cucian USING (id_jenis_cucian) 
                                                          WHERE nomor_plat LIKE '%$keyword_safe%' OR no_antrian LIKE '%$keyword_safe%' 
                                                          ORDER BY id_pendaftaran DESC LIMIT 1");
                                   if($q_track && mysql_num_rows($q_track) > 0):
                                        $track = mysql_fetch_array($q_track);
                                        $track_status = $track['status'];
                                        $no_parts = explode('/', $track['no_antrian']);
                                        $track_no = isset($no_parts[1]) ? $no_parts[1] : $track['no_antrian'];
                              ?>
                                   <div class="tracker-result-card">
                                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;">
                                             <div>
                                                  <span style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 600;"><i class="fa fa-car"></i> Hasil Pelacakan Kendaraan</span>
                                                  <h3 style="margin: 4px 0 0; font-size: 20px; color: #0f172a; font-weight: 700;">
                                                       <?= htmlspecialchars($track['nomor_plat']); ?> 
                                                       <span style="font-size: 15px; font-weight: 500; color: #64748b;">(<?= htmlspecialchars($track['nama']); ?>)</span>
                                                  </h3>
                                             </div>
                                             <div>
                                                  <?php if($track_status == 'Lunas'): ?>
                                                       <span class="badge" style="font-size: 13px; padding: 8px 16px; border-radius: 50px; background: #10b981; color: #fff;">
                                                            <i class="fa fa-check-circle"></i> Selesai & Berkilau (Lunas)
                                                       </span>
                                                  <?php elseif($track_status == 'Dalam Pengerjaan'): ?>
                                                       <span class="badge" style="font-size: 13px; padding: 8px 16px; border-radius: 50px; background: #0284c7; color: #fff;">
                                                            <i class="fa fa-cog fa-spin"></i> Sedang Dicuci & Dikerjakan
                                                       </span>
                                                  <?php else: ?>
                                                       <span class="badge" style="font-size: 13px; padding: 8px 16px; border-radius: 50px; background: #f59e0b; color: #fff;">
                                                            <i class="fa fa-clock-o"></i> Menunggu Giliran Antrian
                                                       </span>
                                                  <?php endif; ?>
                                             </div>
                                        </div>

                                        <!-- 3-STEP PROGRESS STEPPER -->
                                        <div class="tracker-stepper">
                                             <!-- Step 1: Pendaftaran -->
                                             <div class="stepper-step <?= ($track_status == 'Pendaftaran') ? 'active' : 'completed'; ?>">
                                                  <div class="stepper-circle">
                                                       <i class="fa <?= ($track_status == 'Pendaftaran') ? 'fa-ticket' : 'fa-check'; ?>"></i>
                                                  </div>
                                                  <div class="stepper-title">1. Terdaftar</div>
                                                  <div class="stepper-desc">Antrian diterima & menunggu</div>
                                             </div>

                                             <!-- Step 2: Dalam Pengerjaan -->
                                             <div class="stepper-step <?= ($track_status == 'Dalam Pengerjaan') ? 'active' : (($track_status == 'Lunas') ? 'completed' : ''); ?>">
                                                  <div class="stepper-circle">
                                                       <i class="fa <?= ($track_status == 'Dalam Pengerjaan') ? 'fa-shower' : (($track_status == 'Lunas') ? 'fa-check' : 'fa-hourglass-start'); ?>"></i>
                                                  </div>
                                                  <div class="stepper-title">2. Sedang Dicuci</div>
                                                  <div class="stepper-desc">Pembersihan bodi & interior</div>
                                             </div>

                                             <!-- Step 3: Selesai -->
                                             <div class="stepper-step <?= ($track_status == 'Lunas') ? 'completed active' : ''; ?>">
                                                  <div class="stepper-circle">
                                                       <i class="fa fa-trophy"></i>
                                                  </div>
                                                  <div class="stepper-title">3. Selesai & Berkilau</div>
                                                  <div class="stepper-desc">Siap diambil & lunas</div>
                                             </div>
                                        </div>

                                        <!-- DETAILS GRID -->
                                        <div class="tracker-details-grid">
                                             <div class="detail-item">
                                                  <div class="detail-lbl"><i class="fa fa-ticket"></i> No. Antrian</div>
                                                  <div class="detail-val" style="color: #0284c7; font-size: 17px;">#<?= htmlspecialchars($track_no); ?></div>
                                             </div>
                                             <div class="detail-item">
                                                  <div class="detail-lbl"><i class="fa fa-shower"></i> Paket Layanan</div>
                                                  <div class="detail-val"><?= htmlspecialchars($track['jenis_cucian']); ?></div>
                                             </div>
                                             <div class="detail-item">
                                                  <div class="detail-lbl"><i class="fa fa-car"></i> Model Kendaraan</div>
                                                  <div class="detail-val"><?= htmlspecialchars($track['type_mobil']); ?><?= !empty($track['merek_mobil']) && $track['merek_mobil'] !== '-' ? ' (' . htmlspecialchars($track['merek_mobil']) . ')' : ''; ?></div>
                                             </div>
                                             <div class="detail-item">
                                                  <div class="detail-lbl"><i class="fa fa-clock-o"></i> Jam Kedatangan</div>
                                                  <div class="detail-val"><?= date('H:i', strtotime($track['jam_pendaftaran'])); ?> WIB</div>
                                             </div>
                                             <div class="detail-item">
                                                  <div class="detail-lbl"><i class="fa fa-money"></i> Total Biaya</div>
                                                  <div class="detail-val" style="color: #059669;">Rp <?= number_format($track['total_biaya'] ? $track['total_biaya'] : $track['biaya'], 0, ',', '.'); ?></div>
                                             </div>
                                             <div class="detail-item">
                                                  <div class="detail-lbl"><i class="fa fa-calendar"></i> Tanggal Booking</div>
                                                  <div class="detail-val"><?= date('d M Y', strtotime($track['tgl_pendaftaran'])); ?></div>
                                             </div>
                                        </div>

                                        <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end; flex-wrap: wrap;">
                                             <a href="laporan/struk.php?id=<?= urlencode($track['no_antrian']); ?>" target="_blank" class="btn btn-sm btn-primary" style="border-radius: 8px; padding: 10px 18px; font-weight: 600;">
                                                  <i class="fa fa-ticket"></i> Buka E-Ticket Digital
                                             </a>
                                             <a href="https://wa.me/6287706662738?text=Halo%20Archie%20CarWash,%20saya%20pemilik%20kendaraan%20<?= urlencode($track['nomor_plat']); ?>%20ingin%20menanyakan%20progres%20cucian%20saya" target="_blank" class="btn btn-sm btn-success" style="border-radius: 8px; padding: 10px 18px; font-weight: 600;">
                                                  <i class="fa fa-whatsapp"></i> Hubungi Bengkel
                                             </a>
                                        </div>
                                   </div>
                              <?php else: ?>
                                   <div class="alert alert-warning text-center" style="border-radius: 12px; margin-top: 20px; padding: 18px;">
                                        <i class="fa fa-exclamation-triangle"></i> Data antrian untuk plat nomor / kode tiket <strong>"<?= htmlspecialchars($keyword_lacak); ?>"</strong> tidak ditemukan. Pastikan nomor plat kendaraan yang Anda masukkan sudah benar.
                                   </div>
                              <?php 
                                   endif;
                              else:
                              ?>
                                   <!-- TIPS PENCARIAN -->
                                   <div style="background: #f8fafc; border-radius: 14px; padding: 22px; border: 1px dashed #cbd5e1; text-align: center; margin-top: 20px;">
                                        <p style="margin: 0; color: #64748b; font-size: 14px;">
                                             <i class="fa fa-lightbulb-o text-warning" style="font-size: 18px;"></i> Masukkan plat nomor polisi mobil Anda (misal: <strong>BN 1750</strong> atau <strong>1750</strong>) pada kolom pencarian di atas untuk memantau status pengerjaan kendaraan Anda saat ini secara real-time.
                                        </p>
                                   </div>
                              <?php endif; ?>
                         </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- FORM PENDAFTARAN ONLINE -->
     <section id="appointment" class="section-modern">
          <div class="container">
               <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                         <div class="form-card-wrapper">
                              <div class="section-header-modern" style="margin-bottom: 25px;">
                                   <span class="badge-sub"><i class="fa fa-ticket"></i> Registrasi Booking</span>
                                   <h2>Pendaftaran Antrian Online</h2>
                                   <p>Silakan isi data diri dan kendaraan Anda untuk mendapatkan slot antrian hari ini.</p>
                              </div>

                                                             <!-- LIVE QUEUE COUNTER BANNER -->
                               <?php
                               $tgl_today = date("Y-m-d");
                               $q_active = mysql_query("SELECT pendaftaran.*, customer.nomor_plat, jenis_cucian.jenis_cucian FROM pendaftaran JOIN customer USING (id_customer) JOIN jenis_cucian USING(id_jenis_cucian) WHERE tgl_pendaftaran = '$tgl_today' AND status = 'Dalam Pengerjaan' ORDER BY id_pendaftaran ASC LIMIT 1");
                               $active_wash = ($q_active && mysql_num_rows($q_active) > 0) ? mysql_fetch_array($q_active) : null;

                               $q_wait = mysql_query("SELECT COUNT(*) as jml FROM pendaftaran WHERE tgl_pendaftaran = '$tgl_today' AND status = 'Pendaftaran'");
                               $wait_count = ($q_wait) ? mysql_fetch_array($q_wait)['jml'] : 0;
                               $est_menit = ($wait_count > 0) ? ($wait_count * 20) : 5;
                               ?>
                               <div class="live-status-container">
                                    <div class="live-status-header">
                                         <h4><i class="fa fa-dashboard" style="color: #38bdf8;"></i> Status Antrian Archie CarWash Hari Ini</h4>
                                         <div class="live-pulse-badge">
                                              <span class="pulse-dot"></span> Live Real-Time
                                         </div>
                                    </div>

                                    <div class="live-stat-grid">
                                         <div class="live-stat-card">
                                              <div class="stat-label"><i class="fa fa-shower"></i> Sedang Dicuci Saat Ini</div>
                                              <div class="stat-val"><?= $active_wash ? htmlspecialchars($active_wash['nomor_plat']) : '<span style="color:#34d399; font-size:16px;">Slot Kosong (Langsung Masuk)</span>'; ?></div>
                                              <div class="stat-sub"><?= $active_wash ? htmlspecialchars($active_wash['jenis_cucian']) : 'Siap Langsung Dikerjakan'; ?></div>
                                         </div>

                                         <div class="live-stat-card">
                                              <div class="stat-label"><i class="fa fa-clock-o"></i> Antrian Menunggu</div>
                                              <div class="stat-val"><?= $wait_count; ?> Kendaraan</div>
                                              <div class="stat-sub">Dalam Antrian Menunggu</div>
                                         </div>

                                         <div class="live-stat-card">
                                              <div class="stat-label"><i class="fa fa-hourglass-half"></i> Estimasi Waktu Tunggu</div>
                                              <div class="stat-val">~<?= $est_menit; ?> Menit</div>
                                              <div class="stat-sub">Berdasarkan Jumlah Mobil</div>
                                         </div>
                                    </div>
                               </div>

                               <div class="form-badge-antrian">
                                   <div>
                                        <i class="fa fa-calendar"></i> Tanggal: <strong><?= date('d F Y', strtotime($tgl_pendaftaran)); ?></strong>
                                   </div>
                                   <div>
                                        <i class="fa fa-ticket"></i> Antrian Anda Berikutnya: <strong style="font-size: 18px; color: #0284c7;">#<?= $next; ?></strong>
                                   </div>
                              </div>

                              <!-- CONTACT FORM HERE -->
                              <form id="appointment-form" role="form" method="post" action="pages/proses_pendaftaran.php">
                                   <input type="hidden" name="id_customer" value="<?= $id_lanjut; ?>">
                                   <input type="hidden" name="next" value="<?= $next; ?>">
                                   <input type="hidden" name="no_antrian" value="<?= $no_antrian; ?>">
                                   <input type="hidden" name="tgl_pendaftaran" value="<?= $tgl_pendaftaran; ?>">
                                   <input type="hidden" name="total_biaya" id="txt2" value="0">
                                   <input type="hidden" name="layanan_tambahan" id="layanan_tambahan" value="">

                                   <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="nama"><i class="fa fa-user"></i> Nama Lengkap</label>
                                                  <input type="text" class="form-control-modern" id="nama" name="nama" placeholder="Contoh: Budi Santoso" required>
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="no_hp"><i class="fa fa-phone"></i> No. Handphone / WhatsApp</label>
                                                  <input type="tel" class="form-control-modern" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required>
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="alamat"><i class="fa fa-map-marker"></i> Alamat Domisili</label>
                                                  <input type="text" class="form-control-modern" id="alamat" name="alamat" placeholder="Contoh: Jl. Sudirman Sungailiat" required>
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="nomor_plat"><i class="fa fa-id-card"></i> Nomor Plat Kendaraan</label>
                                                  <input type="text" class="form-control-modern" id="nomor_plat" name="nomor_plat" placeholder="Contoh: BN 1234 AB" style="text-transform: uppercase;" required>
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="merek_mobil"><i class="fa fa-car"></i> Merek Kendaraan</label>
                                                  <input type="text" class="form-control-modern" id="merek_mobil" name="merek_mobil" placeholder="Contoh: Toyota / Honda / Suzuki">
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="type_mobil"><i class="fa fa-car"></i> Tipe / Model Mobil</label>
                                                  <select name="type_mobil" id="type_mobil" class="form-control-modern" required>
                                                       <option value="">-- Pilih Tipe Kendaraan --</option>
                                                       <?php
                                                       $result2 = mysql_query("SELECT * FROM type_mobil ORDER BY type_mobil ASC");
                                                       while ($row2 = mysql_fetch_array($result2)) {
                                                            echo '<option value="' . htmlspecialchars($row2['type_mobil']) . '">' . htmlspecialchars($row2['type_mobil']) . '</option>';
                                                       }
                                                       ?>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="id_jenis_cucian"><i class="fa fa-shower"></i> Jenis Cucian</label>
                                                  <?php
                                                  $result = mysql_query("SELECT * FROM jenis_cucian ORDER BY biaya ASC");
                                                  $jsArray = "var prdName = new Array();\n";
                                                  $jsName = "var prdTitle = new Array();\n";
                                                  echo '<select class="form-control-modern" name="id_jenis_cucian" id="id_jenis_cucian" onchange="updateBiaya(this.value)" required>';
                                                  echo '<option value="">-- Pilih Paket Layanan --</option>';
                                                  while ($row = mysql_fetch_array($result)) {
                                                       echo '<option value="' . $row['id_jenis_cucian'] . '">' . htmlspecialchars($row['jenis_cucian']) . ' (Rp ' . number_format($row['biaya'], 0, ',', '.') . ')</option>';
                                                       $jsArray .= "prdName['" . $row['id_jenis_cucian'] . "'] = '" . addslashes($row['biaya']) . "';\n";
                                                       $jsName .= "prdTitle['" . $row['id_jenis_cucian'] . "'] = '" . addslashes($row['jenis_cucian']) . "';\n";
                                                  }
                                                  echo '</select>';
                                                  ?>
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="jam_pendaftaran"><i class="fa fa-clock-o"></i> Rencana Jam Datang</label>
                                                  <input type="time" class="form-control-modern" id="jam_pendaftaran" name="jam_pendaftaran" min="07:30" max="18:00" required>
                                                  <small class="text-muted"><i class="fa fa-info-circle"></i> Jam Buka: 07:30 s/d 18:00 WIB</small>
                                             </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                             <div class="addon-selection-card">
                                                  <h4><i class="fa fa-plus-circle text-primary"></i> Layanan Tambahan (Opsional)</h4>
                                                  <p class="subtitle">Tingkatkan perlindungan & kilau kendaraan Anda dengan perawatan ekstra kami</p>
                                                  <div class="addon-grid">
                                                       <label class="addon-item">
                                                            <input type="checkbox" class="addon-checkbox" value="20000" data-name="Fogging Disinfektan Interior" onchange="calculateTotal()">
                                                            <div class="addon-info">
                                                                 <span class="addon-name"><i class="fa fa-shield"></i> Fogging Disinfektan Interior</span>
                                                                 <span class="addon-desc">Sterilisasi kabin anti-bakteri, jamur & bau tak sedap</span>
                                                            </div>
                                                            <div class="addon-price">+Rp 20.000</div>
                                                       </label>

                                                       <label class="addon-item">
                                                            <input type="checkbox" class="addon-checkbox" value="25000" data-name="Pembersihan Jamur Kaca" onchange="calculateTotal()">
                                                            <div class="addon-info">
                                                                 <span class="addon-name"><i class="fa fa-eye"></i> Pembersihan Jamur Kaca Depan</span>
                                                                 <span class="addon-desc">Kaca jernih optimal saat hujan & bebas noda air</span>
                                                            </div>
                                                            <div class="addon-price">+Rp 25.000</div>
                                                       </label>

                                                       <label class="addon-item">
                                                            <input type="checkbox" class="addon-checkbox" value="10000" data-name="Semir Ban Wet-Look" onchange="calculateTotal()">
                                                            <div class="addon-info">
                                                                 <span class="addon-name"><i class="fa fa-circle-o-notch"></i> Semir Ban Wet-Look Tahan Lama</span>
                                                                 <span class="addon-desc">Formula premium hitam basah mengkilap berhari-hari</span>
                                                            </div>
                                                            <div class="addon-price">+Rp 10.000</div>
                                                       </label>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                             <div class="cost-summary-box">
                                                  <div>
                                                       <div class="label-text"><i class="fa fa-tag"></i> Estimasi Total Biaya (Termasuk Add-on)</div>
                                                       <small id="selected-service-name" class="text-muted">Pilih paket layanan di atas</small>
                                                  </div>
                                                  <div class="amount-text" id="display-total-biaya">Rp 0</div>
                                             </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
                                             <button type="submit" class="btn-submit-modern" name="submit">
                                                  <i class="fa fa-paper-plane"></i> Daftar Antrian Sekarang
                                             </button>
                                        </div>
                                   </div>
                              </form>

                              <script type="text/javascript">
                                   <?php echo $jsArray; ?>
                                   <?php echo $jsName; ?>

                                   function calculateTotal() {
                                        var selectBox = document.getElementById('id_jenis_cucian');
                                        var val = selectBox ? selectBox.value : '';
                                        var biayaInput = document.getElementById('txt2');
                                        var displayBiaya = document.getElementById('display-total-biaya');
                                        var displayTitle = document.getElementById('selected-service-name');
                                        var inputAddons = document.getElementById('layanan_tambahan');

                                        var basePrice = 0;
                                        var baseTitle = '';
                                        if (val && prdName[val]) {
                                             basePrice = parseInt(prdName[val]);
                                             baseTitle = prdTitle[val] || '';
                                        }

                                        var addonTotal = 0;
                                        var selectedAddonNames = [];
                                        var checkboxes = document.querySelectorAll('.addon-checkbox:checked');
                                        checkboxes.forEach(function(cb) {
                                             addonTotal += parseInt(cb.value);
                                             selectedAddonNames.push(cb.getAttribute('data-name'));
                                        });

                                        var grandTotal = basePrice + addonTotal;
                                        biayaInput.value = grandTotal;
                                        displayBiaya.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
                                        if (inputAddons) {
                                             inputAddons.value = selectedAddonNames.join(', ');
                                        }

                                        if (basePrice > 0) {
                                             var summaryText = baseTitle;
                                             if (selectedAddonNames.length > 0) {
                                                  summaryText += ' + Add-on: ' + selectedAddonNames.join(', ');
                                             }
                                             displayTitle.innerText = summaryText;
                                        } else {
                                             if (selectedAddonNames.length > 0) {
                                                  displayTitle.innerText = 'Add-on: ' + selectedAddonNames.join(', ') + ' (Silakan pilih paket cuci utama di atas)';
                                             } else {
                                                  displayTitle.innerText = 'Pilih jenis layanan di atas';
                                             }
                                        }
                                   }

                                   function updateBiaya(val) {
                                        calculateTotal();
                                   }

                                   function pilihPaket(id, nama, biaya) {
                                        var selectBox = document.getElementById('id_jenis_cucian');
                                        if(selectBox) {
                                             selectBox.value = id;
                                             calculateTotal();
                                             $('html, body').stop().animate({
                                                  scrollTop: $('#appointment').offset().top - 70
                                             }, 800);
                                        }
                                   }
                              </script>
                         </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- SECTION KRITIK DAN SARAN -->
     <section id="saran" class="section-modern bg-pattern">
          <div class="container">
               <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                         <div class="form-card-wrapper">
                              <div class="section-header-modern" style="margin-bottom: 25px;">
                                   <span class="badge-sub"><i class="fa fa-comments"></i> Ulasan & Saran</span>
                                   <h2>Kritik dan Saran Pelanggan</h2>
                                   <p>Penilaian dan masukan Anda sangat berharga bagi kami untuk terus meningkatkan kualitas layanan Archie CarWash.</p>
                              </div>

                                                             <!-- TESTIMONI PELANGGAN ASLI -->
                               <?php
                               $q_testi = mysql_query("SELECT * FROM saran WHERE pesan != '' ORDER BY id_saran DESC LIMIT 3");
                               if($q_testi && mysql_num_rows($q_testi) > 0):
                               ?>
                               <div class="row" style="margin-bottom: 30px;">
                                    <?php while($testi = mysql_fetch_array($q_testi)): 
                                         $avg_score = round(($testi['kebersihan'] + $testi['keramahan'] + $testi['ketelitian']) / 3);
                                         $stars = ($avg_score <= 5) ? $avg_score : round($avg_score / 20);
                                         if($stars < 1) $stars = 5;
                                         if($stars > 5) $stars = 5;
                                         $initial = strtoupper(substr($testi['nama'], 0, 1));
                                    ?>
                                    <div class="col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 15px;">
                                         <div class="testimonial-card-item">
                                              <div class="testimonial-stars-list">
                                                   <?php for($i=1; $i<=5; $i++): ?>
                                                        <i class="fa <?= ($i <= $stars) ? 'fa-star' : 'fa-star-o'; ?>"></i>
                                                   <?php endfor; ?>
                                              </div>
                                              <p class="testimonial-quote">"<?= htmlspecialchars($testi['pesan']); ?>"</p>
                                              <div class="testimonial-author-box">
                                                   <div class="testimonial-avatar-circle"><?= $initial; ?></div>
                                                   <div class="testimonial-author-info">
                                                        <h5><?= htmlspecialchars($testi['nama']); ?></h5>
                                                        <span>Pelanggan Terverifikasi</span>
                                                   </div>
                                              </div>
                                         </div>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                                <?php endif; ?>

                              <form id="saran-form" role="form" method="post" action="pages/proses_saran.php">
                                   <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="saran_nama"><i class="fa fa-user"></i> Nama Anda</label>
                                                  <input type="text" class="form-control-modern" id="saran_nama" name="nama" placeholder="Nama Anda" required>
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="saran_email"><i class="fa fa-envelope"></i> Alamat Email</label>
                                                  <input type="email" class="form-control-modern" id="saran_email" name="email" placeholder="contoh@email.com" required>
                                             </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                             <div class="form-group-modern">
                                                  <label for="saran_pesan"><i class="fa fa-commenting"></i> Isi Pesan / Ulasan</label>
                                                  <textarea class="form-control-modern" id="saran_pesan" name="pesan" rows="3" style="height: auto;" placeholder="Tuliskan saran, kritik, atau pengalaman Anda di Archie CarWash..." required></textarea>
                                             </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                             <div class="star-rating-card">
                                                  <label><i class="fa fa-check text-primary"></i> Kebersihan</label>
                                                  <div class="star-rating-input">
                                                       <input type="radio" id="star_keb_5" name="kebersihan" value="100" checked><label for="star_keb_5"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_keb_4" name="kebersihan" value="80"><label for="star_keb_4"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_keb_3" name="kebersihan" value="60"><label for="star_keb_3"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_keb_2" name="kebersihan" value="40"><label for="star_keb_2"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_keb_1" name="kebersihan" value="20"><label for="star_keb_1"><i class="fa fa-star"></i></label>
                                                  </div>
                                                  <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">Pilih 1 - 5 Bintang</div>
                                             </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                             <div class="star-rating-card">
                                                  <label><i class="fa fa-smile-o text-warning"></i> Keramahan</label>
                                                  <div class="star-rating-input">
                                                       <input type="radio" id="star_ker_5" name="keramahan" value="100" checked><label for="star_ker_5"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_ker_4" name="keramahan" value="80"><label for="star_ker_4"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_ker_3" name="keramahan" value="60"><label for="star_ker_3"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_ker_2" name="keramahan" value="40"><label for="star_ker_2"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_ker_1" name="keramahan" value="20"><label for="star_ker_1"><i class="fa fa-star"></i></label>
                                                  </div>
                                                  <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">Pilih 1 - 5 Bintang</div>
                                             </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                             <div class="star-rating-card">
                                                  <label><i class="fa fa-search text-info"></i> Ketelitian</label>
                                                  <div class="star-rating-input">
                                                       <input type="radio" id="star_ket_5" name="ketelitian" value="100" checked><label for="star_ket_5"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_ket_4" name="ketelitian" value="80"><label for="star_ket_4"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_ket_3" name="ketelitian" value="60"><label for="star_ket_3"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_ket_2" name="ketelitian" value="40"><label for="star_ket_2"><i class="fa fa-star"></i></label>
                                                       <input type="radio" id="star_ket_1" name="ketelitian" value="20"><label for="star_ket_1"><i class="fa fa-star"></i></label>
                                                  </div>
                                                  <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">Pilih 1 - 5 Bintang</div>
                                             </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
                                             <button type="submit" class="btn-submit-modern" name="submit">
                                                  <i class="fa fa-send"></i> Kirim Ulasan & Saran
                                             </button>
                                        </div>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- SECTION TENTANG KAMI -->
     <section id="about" class="section-modern">
          <div class="container">
               <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                         <div class="section-header-modern" style="text-align: left; margin-bottom: 25px;">
                              <span class="badge-sub">Profil Usaha</span>
                              <h2>Tentang Archie CarWash</h2>
                              <p style="margin-left: 0; font-size: 14.5px; line-height: 1.8;">
                                   <strong>Archie CarWash</strong> adalah penyedia jasa cuci mobil profesional terdepan di Sungailiat, berlokasi strategis di Nangnung Tengah (dekat Polman Babel). Kami hadir dengan komitmen tinggi menghadirkan hasil cuci kendaraan yang bersih tuntas, kilat, wangi, dan aman untuk segala jenis cat mobil.
                              </p>
                         </div>

                         <div class="about-perk-card">
                              <div class="about-perk-icon"><i class="fa fa-check"></i></div>
                              <div class="about-perk-info">
                                   <h4>Dijamin Bersih & Higienis</h4>
                                   <p>Setiap sudut interior dan eksterior dibersihkan dengan sabun berkualitas dan lap microfiber khusus.</p>
                              </div>
                         </div>

                         <div class="about-perk-card">
                              <div class="about-perk-icon"><i class="fa fa-clock-o"></i></div>
                              <div class="about-perk-info">
                                   <h4>Pengerjaan Kilat & Tepat Waktu</h4>
                                   <p>Tenaga terlatih kami memastikan kendaraan Anda selesai sesuai jadwal tanpa mengorbankan kualitas.</p>
                              </div>
                         </div>

                         <div class="about-perk-card">
                              <div class="about-perk-icon"><i class="fa fa-heart"></i></div>
                              <div class="about-perk-info">
                                   <h4>Pelayanan Ramah & Bergaransi</h4>
                                   <p>Kami menjamin kepuasan pelanggan; jika ada bagian yang terlewat, kami bersihkan ulang seketika.</p>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                         <div class="map-card-wrapper">
                              <div class="map-card-header">
                                   <h4><i class="fa fa-map-marker text-danger"></i> Lokasi Workshop Kami</h4>
                                   <div class="map-status">
                                        <?php if ($is_bengkel_buka): ?>
                                             <span class="badge-operational-open"><span class="pulse-dot-mini"></span> Buka Sekarang</span>
                                        <?php else: ?>
                                             <span class="badge-operational-closed"><i class="fa fa-moon-o"></i> Sedang Tutup</span>
                                        <?php endif; ?>
                                   </div>
                              </div>
                              <div class="map-embed-container">
                                   <iframe 
                                        src="https://maps.google.com/maps?q=Polman+Babel+Sungailiat&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                                        width="100%" 
                                        height="280" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                   </iframe>
                              </div>
                              <div class="map-card-body">
                                   <p class="map-address-text">
                                        <i class="fa fa-compass text-primary"></i> <strong>Alamat:</strong> Nangnung Tengah (Dekat Kampus Polman Babel), Sungailiat, Bangka.
                                   </p>
                                   <div class="map-meta-row">
                                        <div><i class="fa fa-clock-o text-muted"></i> <strong>Operasional Hari Ini:</strong> 07:30 - <?= $jam_tutup_hari_ini; ?> WIB</div>
                                        <div><i class="fa fa-whatsapp text-success"></i> <strong>WhatsApp:</strong> 0877-0666-2738</div>
                                   </div>
                                   <a href="https://maps.google.com/?q=Polman+Babel+Sungailiat" target="_blank" class="btn-open-maps">
                                        <i class="fa fa-location-arrow"></i> Buka Petunjuk Arah di Google Maps
                                   </a>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- FOOTER -->
     <footer>
          <div class="container">
               <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                         <div class="footer-thumb">
                              <h4>Archie CarWash</h4>
                              <p style="color: #94a3b8; font-size: 14px; line-height: 1.8;">
                                   Jasa cuci mobil modern di Sungailiat dengan sistem pendaftaran antrian online untuk kenyamanan waktu Anda.
                              </p>
                              <div style="margin-top: 18px;">
                                   <p><i class="fa fa-map-marker"></i> Nangnung Tengah dekat Polman Babel, Sungailiat</p>
                                   <p><i class="fa fa-phone"></i> 0877-0666-2738</p>
                                   <p><i class="fa fa-envelope-o"></i> archiecarwash@gmail.com</p>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                         <div class="footer-thumb">
                              <h4>Tautan Cepat</h4>
                              <ul style="list-style: none; padding-left: 0; line-height: 2.2;">
                                   <li><a href="#home"><i class="fa fa-angle-right"></i> Beranda</a></li>
                                   <li><a href="#pelayanan"><i class="fa fa-angle-right"></i> Paket & Tarif Cuci</a></li>
                                   <li><a href="#cara-antri"><i class="fa fa-angle-right"></i> Alur Pendaftaran</a></li>
                                   <li><a href="#appointment"><i class="fa fa-angle-right"></i> Booking Antrian Online</a></li>
                                   <li><a href="#saran"><i class="fa fa-angle-right"></i> Kritik & Saran</a></li>
                                   <li><a href="login.php"><i class="fa fa-angle-right"></i> Login User / Admin</a></li>
                              </ul>
                         </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12">
                         <div class="footer-thumb">
                              <h4>Waktu Operasional</h4>
                              <p>Kami siap melayani kebutuhan cuci mobil Anda setiap hari:</p>
                              <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 10px; margin-top: 15px;">
                                   <p style="margin-bottom: 8px;"><strong>Senin - Jumat:</strong> 07:30 - 18:00 WIB</p>
                                   <p style="margin-bottom: 0;"><strong>Sabtu - Minggu:</strong> 07:30 - 17:00 WIB</p>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                         <div class="footer-bottom">
                              <p style="margin: 0;">
                                   Copyright &copy; <?= date('Y'); ?> <strong>Archie CarWash</strong>. Developed by Archie Arya Manggala. All Rights Reserved.
                              </p>
                         </div>
                    </div>
               </div>
          </div>
     </footer>

     <!-- FLOATING WHATSAPP BUTTON -->
     <a href="https://wa.me/6287706662738?text=Halo%20Archie%20CarWash,%20saya%20ingin%20bertanya%20tentang%20layanan%20cuci%20mobil" target="_blank" class="floating-wa" title="Hubungi Kami via WhatsApp">
          <i class="fa fa-whatsapp"></i>
     </a>

     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/jquery.sticky.js"></script>
     <script src="js/jquery.stellar.min.js"></script>
     <script src="js/wow.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/custom.js"></script>

</body>

</html>
