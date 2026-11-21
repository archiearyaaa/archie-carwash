<?php
require_once __DIR__ . '/../config/koneksi.php';
session_start();

$no_antrian = isset($_GET['id']) ? trim($_GET['id']) : '';
$no_parts = explode('/', $no_antrian);
$no_antri = isset($no_parts[1]) ? $no_parts[1] : (!empty($no_antrian) ? $no_antrian : '-');

$queryy = mysql_query("SELECT pendaftaran.*, customer.nama, customer.nomor_plat, customer.no_hp, customer.type_mobil, customer.merek_mobil, jenis_cucian.jenis_cucian, jenis_cucian.biaya 
                       FROM pendaftaran 
                       JOIN customer USING (id_customer) 
                       JOIN jenis_cucian USING (id_jenis_cucian) 
                       WHERE no_antrian = '$no_antrian'");
$dt = ($queryy) ? mysql_fetch_array($queryy) : null;

$nama_cust = isset($dt['nama']) ? $dt['nama'] : '-';
$plat_cust = isset($dt['nomor_plat']) ? $dt['nomor_plat'] : '-';
$hp_cust = isset($dt['no_hp']) ? $dt['no_hp'] : '';
$tipe_cust = isset($dt['type_mobil']) ? $dt['type_mobil'] : '-';
$merek_cust = !empty($dt['merek_mobil']) ? $dt['merek_mobil'] : '';
$layanan = isset($dt['jenis_cucian']) ? $dt['jenis_cucian'] : '-';
$biaya = isset($dt['total_biaya']) ? $dt['total_biaya'] : (isset($dt['biaya']) ? $dt['biaya'] : 0);
$jam = isset($dt['jam_pendaftaran']) ? date('H:i', strtotime($dt['jam_pendaftaran'])) : '-';
$tgl = isset($dt['tgl_pendaftaran']) ? date('d M Y', strtotime($dt['tgl_pendaftaran'])) : date('d M Y');
$status = isset($dt['status']) ? $dt['status'] : 'Pendaftaran';

// Jika meminta format PDF murni
if (isset($_GET['format']) && $_GET['format'] === 'pdf') {
    require "../fpdf181/fpdf.php";
    class Mypdf extends FPDF
    {
        function header()
        {
            $this->SetFont('Times', 'B', 10);
            $this->Cell(80, 15, 'Nomor Antrian', 0, 0, 'C');
            $this->ln();
            $this->Cell(80, 15, 'Archie CarWash', 0, 0, 'C');
            $this->SetFont('Times', 'B', 14);
            $this->ln();
            $this->ln();
        }
        function mycell($w, $h, $x, $t)
        {
            $height = $h / 3;
            $first  = $height + 2;
            $second = $height + $height + $height + 3;
            $len    = strlen($t);

            if ($len > 20) {
                $txt = str_split($t, 20);
                $this->SetX($x);
                $this->Cell($w, $first, $txt[0], '', '', '');
                $this->SetX($x);
                $this->Cell($w, $second, $txt[1], '', '', '');
                $this->SetX($x);
                $this->Cell($w, $h, '', 'LTRB', 0, 'C', 0);
            } else {
                $this->SetX($x);
                $this->Cell($w, $h, $t, 'LTRB', 0, 'C', 0);
            }
        }
    }

    $pdf = new Mypdf('P', 'pt', array(270.9, 137.16));
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 8);

    $x = $pdf->GetX();
    $pdf->mycell(100, 20, 20, 'Nomor Antrian', 1, 0, 'C');
    $pdf->Ln();
    $x = $pdf->GetX();
    $pdf->mycell(100, 20, 20, $no_antri, 1, 0, 'C');
    $pdf->Ln();
    $x = $pdf->GetX();
    $pdf->mycell(100, 20, 20, 'Nama Customer', 1, 0, 'C');
    $pdf->Ln();
    $x = $pdf->GetX();
    $pdf->mycell(100, 20, 20, $nama_cust, 1, 0, 'C');
    $pdf->Ln();
    $x = $pdf->GetX();
    $pdf->mycell(100, 20, 20, 'Nomor Plat', 1, 0, 'C');
    $pdf->Ln();
    $x = $pdf->GetX();
    $pdf->mycell(100, 20, 20, $plat_cust, 1, 0, 'C');
    $pdf->Ln();
    $x = $pdf->GetX();
    $pdf->mycell(100, 20, 20, 'Archie CarWash', 1, 0, 'C');
    $pdf->Ln();

    $pdf->Output();
    exit;
}

// Pesan WhatsApp format rapi
$clean_hp = preg_replace('/[^0-9]/', '', $hp_cust);
if (substr($clean_hp, 0, 1) === '0') {
    $clean_hp = '62' . substr($clean_hp, 1);
}
$addon_text = !empty($dt['layanan_tambahan']) ? "%0A➕ *Add-ons:* " . urlencode($dt['layanan_tambahan']) : "";
$wa_text = "Halo {$nama_cust}!%0A%0ABerikut rincian *Tiket Antrian Archie CarWash* Anda:%0A" .
           "🎟️ *No. Antrian:* %23{$no_antri} ({$no_antrian})%0A" .
           "🚗 *Plat Kendaraan:* {$plat_cust}%0A" .
           "✨ *Layanan:* {$layanan}" . $addon_text . "%0A" .
           "💰 *Total Biaya:* Rp " . number_format($biaya, 0, ',', '.') . "%0A" .
           "⏰ *Jam Booking:* {$jam} WIB%0A" .
           "📅 *Tanggal:* {$tgl}%0A%0A" .
           "_Silakan datang maksimal 10 menit sebelum jam kedatangan. Terima kasih!_";
$wa_url = "https://api.whatsapp.com/send?phone={$clean_hp}&text={$wa_text}";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Antrian #<?= htmlspecialchars($no_antri); ?> - Archie CarWash</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/custom-modern.css">
    <link rel="shortcut icon" type="image/x-icon" href="../images/2.png" sizes="32x32">
    <style>
        body {
            background-color: #f1f5f9;
            padding: 20px 15px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="eticket-wrapper">
        <div class="eticket-header">
            <span style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9;"><i class="fa fa-ticket"></i> E-Ticket Antrian Resmi</span>
            <h2>Archie CarWash</h2>
            <div class="eticket-number-badge">
                #<?= htmlspecialchars($no_antri); ?>
            </div>
            <div style="font-size: 13.5px; opacity: 0.95;">
                Kode Tiket: <strong><?= htmlspecialchars($no_antrian); ?></strong>
            </div>
            <div style="margin-top: 10px;">
                <?php if($status === 'Lunas'): ?>
                    <span class="badge" style="background: #10b981; color: #fff; padding: 6px 14px; border-radius: 50px;">Selesai & Lunas</span>
                <?php elseif($status === 'Dalam Pengerjaan'): ?>
                    <span class="badge" style="background: #0284c7; color: #fff; padding: 6px 14px; border-radius: 50px;">Sedang Dikerjakan</span>
                <?php else: ?>
                    <span class="badge" style="background: #f59e0b; color: #fff; padding: 6px 14px; border-radius: 50px;">Menunggu Antrian</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="eticket-body">
            <div class="eticket-row">
                <span class="lbl"><i class="fa fa-user"></i> Nama Customer</span>
                <span class="val"><?= htmlspecialchars($nama_cust); ?></span>
            </div>
            <div class="eticket-row">
                <span class="lbl"><i class="fa fa-id-card"></i> Nomor Plat</span>
                <span class="val"><span class="badge badge-dark" style="font-size: 14px;"><?= htmlspecialchars($plat_cust); ?></span></span>
            </div>
            <div class="eticket-row">
                <span class="lbl"><i class="fa fa-car"></i> Kendaraan</span>
                <span class="val"><?= htmlspecialchars($tipe_cust); ?><?= !empty($merek_cust) && $merek_cust !== '-' ? ' (' . htmlspecialchars($merek_cust) . ')' : ''; ?></span>
            </div>
            <div class="eticket-row">
                <span class="lbl"><i class="fa fa-shower"></i> Jenis Cucian</span>
                <span class="val"><?= htmlspecialchars($layanan); ?></span>
            </div>
            <?php if(!empty($dt['layanan_tambahan'])): ?>
            <div class="eticket-row">
                <span class="lbl"><i class="fa fa-plus-circle text-primary"></i> Layanan Tambahan</span>
                <span class="val" style="color: #0284c7;"><?= htmlspecialchars($dt['layanan_tambahan']); ?></span>
            </div>
            <?php endif; ?>
            <div class="eticket-row">
                <span class="lbl"><i class="fa fa-clock-o"></i> Jam Kedatangan</span>
                <span class="val"><?= htmlspecialchars($jam); ?> WIB</span>
            </div>
            <div class="eticket-row">
                <span class="lbl"><i class="fa fa-calendar"></i> Tanggal</span>
                <span class="val"><?= htmlspecialchars($tgl); ?></span>
            </div>
            <div class="eticket-row" style="background: #f8fafc; padding: 14px 12px; border-radius: 10px; border-bottom: none; margin-top: 10px;">
                <span class="lbl" style="font-weight: 600; color: #1e293b;"><i class="fa fa-money"></i> Total Biaya</span>
                <span class="val" style="font-size: 18px; color: #0284c7;">Rp <?= number_format($biaya, 0, ',', '.'); ?></span>
            </div>

            <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 10px; padding: 12px; margin-top: 20px; font-size: 12.5px; color: #92400e;">
                <i class="fa fa-info-circle"></i> <strong>Pemberitahuan:</strong> Harap tiba di bengkel cucian kami maksimal 10 menit sebelum jam kedatangan Anda. Tunjukkan tiket ini kepada staf kasir kami.
            </div>

            <div class="eticket-actions">
                <a href="<?= $wa_url; ?>" target="_blank" class="btn-eticket-wa">
                    <i class="fa fa-whatsapp" style="font-size: 20px;"></i> Bagikan Tiket ke WhatsApp Saya
                </a>

                <div class="row" style="margin: 0 -5px;">
                    <div class="col-xs-6" style="padding: 0 5px;">
                        <a href="../index.php?lacak=<?= urlencode($plat_cust); ?>#lacak" class="btn btn-primary btn-block" style="border-radius: 10px; padding: 12px 10px; font-weight: 600; font-size: 13px;">
                            <i class="fa fa-search"></i> Lacak Status Mobil
                        </a>
                    </div>
                    <div class="col-xs-6" style="padding: 0 5px;">
                        <a href="struk.php?id=<?= urlencode($no_antrian); ?>&format=pdf" target="_blank" class="btn btn-default btn-block" style="border-radius: 10px; padding: 12px 10px; font-weight: 600; font-size: 13px; border: 1px solid #cbd5e1;">
                            <i class="fa fa-print"></i> Cetak PDF
                        </a>
                    </div>
                </div>

                <a href="../index.php" class="btn btn-link btn-block" style="color: #64748b; font-size: 13.5px; margin-top: 5px;">
                    <i class="fa fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
