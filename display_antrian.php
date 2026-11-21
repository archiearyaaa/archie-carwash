<?php
require_once __DIR__ . '/config/koneksi.php';
date_default_timezone_set('Asia/Jakarta');
$tgl_today = date("Y-m-d");

// 1. Mobil yang sedang dicuci (Status = 'Dalam Pengerjaan')
$q_sedang = mysql_query("SELECT pendaftaran.*, customer.nama, customer.nomor_plat, customer.type_mobil, customer.merek_mobil, jenis_cucian.jenis_cucian 
                         FROM pendaftaran 
                         JOIN customer USING (id_customer) 
                         JOIN jenis_cucian USING (id_jenis_cucian) 
                         WHERE tgl_pendaftaran = '$tgl_today' AND status = 'Dalam Pengerjaan' 
                         ORDER BY id_pendaftaran ASC LIMIT 1");
$sedang = ($q_sedang && mysql_num_rows($q_sedang) > 0) ? mysql_fetch_array($q_sedang) : null;

// 2. Daftar antrian menunggu (Status = 'Pendaftaran')
$q_menunggu = mysql_query("SELECT pendaftaran.*, customer.nama, customer.nomor_plat, customer.type_mobil, jenis_cucian.jenis_cucian 
                           FROM pendaftaran 
                           JOIN customer USING (id_customer) 
                           JOIN jenis_cucian USING (id_jenis_cucian) 
                           WHERE tgl_pendaftaran = '$tgl_today' AND status = 'Pendaftaran' 
                           ORDER BY id_pendaftaran ASC LIMIT 4");

// 3. Antrian yang baru saja selesai hari ini (Status = 'Lunas')
$q_selesai = mysql_query("SELECT pendaftaran.*, customer.nama, customer.nomor_plat, jenis_cucian.jenis_cucian 
                          FROM pendaftaran 
                          JOIN customer USING (id_customer) 
                          JOIN jenis_cucian USING (id_jenis_cucian) 
                          WHERE tgl_pendaftaran = '$tgl_today' AND status = 'Lunas' 
                          ORDER BY id_pendaftaran DESC LIMIT 3");

// Total statistik hari ini
$q_stat = mysql_query("SELECT 
    COUNT(id_pendaftaran) as total_antrian,
    SUM(CASE WHEN status = 'Pendaftaran' THEN 1 ELSE 0 END) as total_menunggu,
    SUM(CASE WHEN status = 'Dalam Pengerjaan' THEN 1 ELSE 0 END) as total_dicuci,
    SUM(CASE WHEN status = 'Lunas' THEN 1 ELSE 0 END) as total_selesai
    FROM pendaftaran WHERE tgl_pendaftaran = '$tgl_today'");
$stat = ($q_stat) ? mysql_fetch_array($q_stat) : null;

// Nama hari dan tanggal Indonesia
$hari_array = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
$bulan_array = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
$hari_ini = $hari_array[date('w')];
$tgl_lengkap = $hari_ini . ', ' . date('j') . ' ' . $bulan_array[intval(date('n'))] . ' ' . date('Y');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian Ruang Tunggu - Archie CarWash</title>
    
    <!-- Refresh otomatis tiap 10 detik agar sinkron dengan kasir -->
    <meta http-equiv="refresh" content="10">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/2.png" sizes="32x32">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #090d16;
            color: #f8fafc;
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* TOP HEADER */
        .tv-header {
            background: linear-gradient(90deg, #0b1329 0%, #111d40 50%, #0b1329 100%);
            border-bottom: 2px solid #0284c7;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .tv-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .tv-logo-circle {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #0284c7, #00b4d8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.4);
        }

        .tv-brand-info h1 {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.5px;
            color: #ffffff;
        }

        .tv-brand-info p {
            font-size: 13px;
            color: #38bdf8;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .tv-clock-box {
            text-align: right;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .tv-date {
            font-size: 15px;
            color: #94a3b8;
            font-weight: 500;
        }

        .tv-clock {
            font-size: 32px;
            font-weight: 800;
            color: #38bdf8;
            letter-spacing: 2px;
            background: rgba(2, 132, 199, 0.15);
            padding: 4px 16px;
            border-radius: 10px;
            border: 1px solid rgba(56, 189, 248, 0.3);
            font-family: monospace;
        }

        /* MAIN CONTENT GRID */
        .tv-content {
            flex-grow: 1;
            padding: 24px 28px;
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 24px;
        }

        @media (max-width: 991px) {
            .tv-content {
                grid-template-columns: 1fr;
            }
        }

        /* HERO CARD: SEDANG DICUCI */
        .hero-wash-card {
            background: linear-gradient(145deg, #0e1e38 0%, #13274c 100%);
            border-radius: 24px;
            border: 2px solid #0284c7;
            padding: 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 40px rgba(2, 132, 199, 0.25);
            position: relative;
            overflow: hidden;
        }

        .hero-wash-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(2, 132, 199, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(2, 132, 199, 0.25);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.4);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: pulse-wash 2s infinite;
        }

        @keyframes pulse-wash {
            0% { box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.6); }
            70% { box-shadow: 0 0 0 14px rgba(2, 132, 199, 0); }
            100% { box-shadow: 0 0 0 0 rgba(2, 132, 199, 0); }
        }

        .hero-queue-number {
            font-size: 110px;
            font-weight: 900;
            line-height: 1;
            margin: 20px 0 10px;
            color: #ffffff;
            text-shadow: 0 4px 25px rgba(2, 132, 199, 0.5);
            letter-spacing: -2px;
        }

        .hero-plate-badge {
            display: inline-block;
            background: #ffffff;
            color: #0f172a;
            font-size: 42px;
            font-weight: 900;
            padding: 10px 32px;
            border-radius: 16px;
            letter-spacing: 3px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.5);
            border: 4px solid #38bdf8;
            margin-bottom: 24px;
        }

        .hero-details-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-detail-item .lbl {
            font-size: 13px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .hero-detail-item .val {
            font-size: 18px;
            font-weight: 700;
            color: #f8fafc;
        }

        /* EMPTY STATE FOR HERO */
        .hero-empty {
            text-align: center;
            padding: 60px 20px;
            margin: auto 0;
        }

        .hero-empty i {
            font-size: 70px;
            color: #10b981;
            margin-bottom: 15px;
        }

        .hero-empty h2 {
            font-size: 32px;
            font-weight: 800;
            color: #f8fafc;
        }

        .hero-empty p {
            font-size: 18px;
            color: #94a3b8;
        }

        /* SIDE PANELS */
        .side-panel-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .panel-box {
            background: #0f172a;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 22px 24px;
            flex: 1;
        }

        .panel-box-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 16px;
            font-weight: 700;
            color: #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .queue-table-tv {
            width: 100%;
        }

        .queue-table-tv tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            transition: all 0.2s ease;
        }

        .queue-table-tv tr:last-child {
            border-bottom: none;
        }

        .queue-table-tv td {
            padding: 10px 6px;
            vertical-align: middle;
        }

        .tv-queue-badge {
            background: #0284c7;
            color: #ffffff;
            font-size: 15px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 8px;
            display: inline-block;
        }

        .tv-plate-text {
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 1px;
        }

        .tv-service-text {
            font-size: 13.5px;
            color: #94a3b8;
        }

        /* FOOTER RUNNING TEXT */
        .tv-footer {
            background: #0b1329;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 28px;
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 15px;
        }

        .running-text-label {
            background: #0284c7;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .marquee-content {
            color: #e2e8f0;
            font-weight: 500;
        }

        /* TV CONTROLS */
        .tv-actions {
            position: fixed;
            top: 16px;
            right: 28px;
            z-index: 999;
            display: flex;
            gap: 8px;
        }

        .btn-tv-ctrl {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-tv-ctrl:hover {
            background: #0284c7;
            border-color: #0284c7;
        }
    </style>
</head>
<body>

    <!-- TOP TV HEADER -->
    <header class="tv-header">
        <div class="tv-brand">
            <div class="tv-logo-circle">
                <i class="fa fa-car"></i>
            </div>
            <div class="tv-brand-info">
                <h1>ARCHIE CARWASH</h1>
                <p>Layar Informasi Antrian Ruang Tunggu</p>
            </div>
        </div>

        <div class="tv-clock-box">
            <div class="tv-date"><?= $tgl_lengkap; ?></div>
            <div class="tv-clock" id="live-clock"><?= date('H:i:s'); ?></div>
            <button class="btn-tv-ctrl" onclick="toggleFullScreen();" title="Layar Penuh (F11)"><i class="fa fa-expand"></i> Fullscreen</button>
            <button class="btn-tv-ctrl" onclick="playChime();" title="Test Bell Suara"><i class="fa fa-bell"></i> Panggil</button>
            <a href="admin/index.php" class="btn-tv-ctrl" style="text-decoration:none;"><i class="fa fa-dashboard"></i> Admin</a>
        </div>
    </header>

    <!-- TV CONTENT AREA -->
    <main class="tv-content">

        <!-- KOLOM UTAMA: SEDANG DICUCI -->
        <section class="hero-wash-card">
            <?php if($sedang): 
                $no_parts = explode('/', $sedang['no_antrian']);
                $nomor_urut = isset($no_parts[1]) ? $no_parts[1] : $sedang['no_antrian'];
            ?>
                <div>
                    <div class="hero-status-pill">
                        <i class="fa fa-shower fa-spin"></i> SEDANG DICUCI SEKARANG (LOKET CUCI)
                    </div>

                    <div class="hero-queue-number">
                        #<?= htmlspecialchars($nomor_urut); ?>
                    </div>

                    <div class="hero-plate-badge">
                        <?= htmlspecialchars($sedang['nomor_plat']); ?>
                    </div>
                </div>

                <div class="hero-details-row">
                    <div class="hero-detail-item">
                        <div class="lbl"><i class="fa fa-user"></i> Nama Pemilik</div>
                        <div class="val"><?= htmlspecialchars($sedang['nama']); ?></div>
                    </div>
                    <div class="hero-detail-item">
                        <div class="lbl"><i class="fa fa-car"></i> Model Kendaraan</div>
                        <div class="val"><?= htmlspecialchars($sedang['type_mobil']); ?><?= !empty($sedang['merek_mobil']) && $sedang['merek_mobil'] !== '-' ? ' (' . htmlspecialchars($sedang['merek_mobil']) . ')' : ''; ?></div>
                    </div>
                    <div class="hero-detail-item">
                        <div class="lbl"><i class="fa fa-magic"></i> Paket Cucian</div>
                        <div class="val" style="color: #38bdf8;"><?= htmlspecialchars($sedang['jenis_cucian']); ?></div>
                    </div>
                </div>

            <?php else: ?>

                <div class="hero-empty">
                    <i class="fa fa-check-circle"></i>
                    <h2>SLOT CUCI TERSEDIA</h2>
                    <p>Tidak ada antrian pengerjaan saat ini. Kendaraan baru siap langsung dicuci tanpa menunggu!</p>
                    <span class="badge" style="background:#10b981; font-size:16px; padding:10px 24px; border-radius:50px; margin-top:15px; display:inline-block;">
                        JALUR CUCI STANDBY
                    </span>
                </div>

            <?php endif; ?>
        </section>

        <!-- KOLOM KANAN: ANTRIAN MENUNGGU & BARU SELESAI -->
        <section class="side-panel-column">

            <!-- BOX 1: MENUNGGU GILIRAN -->
            <div class="panel-box">
                <div class="panel-box-title">
                    <span><i class="fa fa-clock-o text-warning"></i> Antrian Menunggu</span>
                    <span class="badge badge-warning" style="font-size: 13px;"><?= $stat ? intval($stat['total_menunggu']) : 0; ?> Mobil</span>
                </div>

                <table class="queue-table-tv">
                    <tbody>
                        <?php 
                        if($q_menunggu && mysql_num_rows($q_menunggu) > 0): 
                            while($wait = mysql_fetch_array($q_menunggu)):
                                $wait_parts = explode('/', $wait['no_antrian']);
                                $wait_no = isset($wait_parts[1]) ? $wait_parts[1] : $wait['no_antrian'];
                        ?>
                            <tr>
                                <td width="18%">
                                    <span class="tv-queue-badge">#<?= htmlspecialchars($wait_no); ?></span>
                                </td>
                                <td width="42%">
                                    <div class="tv-plate-text"><?= htmlspecialchars($wait['nomor_plat']); ?></div>
                                    <div class="tv-service-text"><?= htmlspecialchars($wait['nama']); ?></div>
                                </td>
                                <td width="40%" class="text-right">
                                    <div style="font-size: 14px; font-weight: 600; color: #38bdf8;"><?= htmlspecialchars($wait['jenis_cucian']); ?></div>
                                    <div style="font-size: 12px; color: #94a3b8;"><?= date('H:i', strtotime($wait['jam_pendaftaran'])); ?> WIB</div>
                                </td>
                            </tr>
                        <?php 
                            endwhile;
                        else:
                        ?>
                            <tr>
                                <td colspan="3" class="text-center" style="padding: 24px; color: #64748b;">
                                    <i class="fa fa-info-circle"></i> Tidak ada antrian menunggu giliran
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- BOX 2: BARU SELESAI CUCI -->
            <div class="panel-box">
                <div class="panel-box-title">
                    <span><i class="fa fa-check-circle text-success"></i> Baru Selesai (Siap Diambil)</span>
                    <span class="badge badge-success" style="font-size: 13px;"><?= $stat ? intval($stat['total_selesai']) : 0; ?> Selesai</span>
                </div>

                <table class="queue-table-tv">
                    <tbody>
                        <?php 
                        if($q_selesai && mysql_num_rows($q_selesai) > 0): 
                            while($done = mysql_fetch_array($q_selesai)):
                                $done_parts = explode('/', $done['no_antrian']);
                                $done_no = isset($done_parts[1]) ? $done_parts[1] : $done['no_antrian'];
                        ?>
                            <tr>
                                <td width="18%">
                                    <span class="badge" style="background:#10b981; font-size:14px; padding:4px 8px;">#<?= htmlspecialchars($done_no); ?></span>
                                </td>
                                <td width="47%">
                                    <div class="tv-plate-text" style="color:#a7f3d0;"><?= htmlspecialchars($done['nomor_plat']); ?></div>
                                    <div class="tv-service-text"><?= htmlspecialchars($done['nama']); ?></div>
                                </td>
                                <td width="35%" class="text-right">
                                    <span class="badge badge-success" style="font-size:12px; padding:6px 10px; border-radius:50px;">
                                        <i class="fa fa-check"></i> LUNAS
                                    </span>
                                </td>
                            </tr>
                        <?php 
                            endwhile;
                        else:
                        ?>
                            <tr>
                                <td colspan="3" class="text-center" style="padding: 24px; color: #64748b;">
                                    <i class="fa fa-info-circle"></i> Belum ada cucian yang selesai hari ini
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </section>
    </main>

    <!-- TV FOOTER WITH RUNNING MARQUEE TEXT -->
    <footer class="tv-footer">
        <div class="running-text-label">PENGUMUMAN</div>
        <marquee class="marquee-content" scrollamount="6">
            Selamat Datang di Archie CarWash Sungailiat &bull; Alamat: Nangnung Tengah (Dekat Polman Babel) &bull; Nikmati Fasilitas Free Wi-Fi di Ruang Tunggu Ber-AC &bull; Harap periksa barang-barang berharga Anda sebelum kendaraan ditinggalkan &bull; Archie CarWash: Solusi Mobil Bersih, Kilat, Wangi & Mengkilap!
        </marquee>
    </footer>

    <script>
        // Jam digital real-time
        function updateClock() {
            var now = new Date();
            var h = String(now.getHours()).padStart(2, '0');
            var m = String(now.getMinutes()).padStart(2, '0');
            var s = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('live-clock').innerText = h + ':' + m + ':' + s;
        }
        setInterval(updateClock, 1000);

        // Toggle Fullscreen
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {});
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Web Audio API Ding-Dong Chime (Suara Bel Panggilan Antrian)
        function playChime() {
            try {
                var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                
                // Nada 1: 523.25 Hz (C5)
                var osc1 = audioCtx.createOscillator();
                var gain1 = audioCtx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(523.25, audioCtx.currentTime);
                gain1.gain.setValueAtTime(0.3, audioCtx.currentTime);
                gain1.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.8);
                osc1.connect(gain1);
                gain1.connect(audioCtx.destination);
                osc1.start(audioCtx.currentTime);
                osc1.stop(audioCtx.currentTime + 0.8);

                // Nada 2: 659.25 Hz (E5)
                var osc2 = audioCtx.createOscillator();
                var gain2 = audioCtx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(659.25, audioCtx.currentTime + 0.35);
                gain2.gain.setValueAtTime(0.4, audioCtx.currentTime + 0.35);
                gain2.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 1.2);
                osc2.connect(gain2);
                gain2.connect(audioCtx.destination);
                osc2.start(audioCtx.currentTime + 0.35);
                osc2.stop(audioCtx.currentTime + 1.2);
            } catch(e) {
                console.log("Audio not supported or blocked");
            }
        }
    </script>
</body>
</html>
