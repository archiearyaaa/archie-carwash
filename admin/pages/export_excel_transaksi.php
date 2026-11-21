<?php
require_once __DIR__ . '/../../config/koneksi.php';

$tgl_awal = !empty($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01');
$tgl_akhir = !empty($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');

// Header file excel
$filename = "Laporan_Transaksi_ArchieCarWash_" . $tgl_awal . "_sd_" . $tgl_akhir . ".xls";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

$sqll = "SELECT transaksi.*, pendaftaran.no_antrian, pendaftaran.jam_pendaftaran, 
                customer.nama, customer.no_hp, customer.nomor_plat, customer.type_mobil, customer.merek_mobil, 
                jenis_cucian.jenis_cucian 
         FROM transaksi 
         JOIN pendaftaran USING (id_pendaftaran) 
         JOIN jenis_cucian USING (id_jenis_cucian) 
         JOIN customer WHERE pendaftaran.id_customer = customer.id_customer 
         AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' 
         ORDER BY id_transaksi DESC";
$resultt = mysql_query($sqll);
$total_omset = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .title { font-size: 16pt; font-weight: bold; text-align: center; }
        .subtitle { font-size: 11pt; text-align: center; margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th { background-color: #0284c7; color: #ffffff; padding: 10px; border: 1px solid #000; font-weight: bold; text-align: center; }
        td { padding: 8px; border: 1px solid #000; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer-total { background-color: #e2e8f0; font-weight: bold; }
    </style>
</head>
<body>

    <div class="title">ARCHIE CARWASH - LAPORAN TRANSAKSI KASIR</div>
    <div class="subtitle">Periode: <?= date('d/m/Y', strtotime($tgl_awal)); ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)); ?> | Dicetak pada: <?= date('d/m/Y H:i:s'); ?> WIB</div>

    <table border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Nota</th>
                <th>No. Antrian</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Nama Customer</th>
                <th>No. Handphone</th>
                <th>No. Plat</th>
                <th>Tipe Kendaraan</th>
                <th>Jenis Cucian</th>
                <th>Penanggung Jawab</th>
                <th>Total Biaya (Rp)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if ($resultt && mysql_num_rows($resultt) > 0):
                while ($d = mysql_fetch_array($resultt)):
                    $total_omset += $d['total'];
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= $d['no_nota']; ?></td>
                <td class="text-center"><?= $d['no_antrian']; ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($d['tanggal'])); ?></td>
                <td class="text-center"><?= date('H:i', strtotime($d['jam_pendaftaran'])); ?></td>
                <td><?= $d['nama']; ?></td>
                <td style="mso-number-format:'\@';"><?= $d['no_hp']; ?></td>
                <td class="text-center"><strong><?= $d['nomor_plat']; ?></strong></td>
                <td><?= $d['type_mobil']; ?><?= !empty($d['merek_mobil']) && $d['merek_mobil'] !== '-' ? ' (' . $d['merek_mobil'] . ')' : ''; ?></td>
                <td><?= $d['jenis_cucian']; ?></td>
                <td><?= $d['nama_pencuci']; ?></td>
                <td class="text-right"><?= number_format($d['total'], 0, ',', '.'); ?></td>
                <td class="text-center"><?= $d['status']; ?></td>
            </tr>
            <?php 
                endwhile;
            else:
            ?>
            <tr>
                <td colspan="13" class="text-center">Tidak ada data transaksi pada periode tanggal ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="footer-total">
                <td colspan="11" class="text-right" style="padding: 10px; font-size: 11pt;">TOTAL PENDAPATAN :</td>
                <td class="text-right" style="padding: 10px; font-size: 11pt; color: #0284c7;">Rp <?= number_format($total_omset, 0, ',', '.'); ?></td>
                <td class="text-center">LUNAS</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
