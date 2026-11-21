<?php
session_start();
include("../../config/koneksi.php");
date_default_timezone_set('Asia/Jakarta');

$tgl_awal = !empty($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01');
$tgl_akhir = !empty($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');

$sqll = "SELECT * FROM transaksi 
         JOIN pendaftaran USING (id_pendaftaran) 
         JOIN jenis_cucian USING(id_jenis_cucian) 
         JOIN customer WHERE pendaftaran.id_customer = customer.id_customer 
         AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' 
         ORDER BY id_transaksi ASC";
$resultt = mysql_query($sqll);
$total_pendapatan = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi (<?= $tgl_awal; ?> s/d <?= $tgl_akhir; ?>) - Archie CarWash</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px;
        }
        .header-kop {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header-kop h1 {
            margin: 0 0 5px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-kop p {
            margin: 2px 0;
            font-size: 13px;
            color: #555;
        }
        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title h2 {
            margin: 0 0 5px;
            font-size: 18px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th {
            background-color: #f1f5f9;
            padding: 8px 10px;
            font-size: 12.5px;
            text-align: left;
        }
        td {
            padding: 7px 10px;
            font-size: 12px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
            margin-top: 30px;
        }
        .signature-box .signature-space {
            height: 70px;
        }
        .no-print-bar {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background: #0077b6;
            color: #fff;
            padding: 8px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        @media print {
            .no-print-bar {
                display: none !important;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <span><strong>Pratinjau Cetak Laporan Transaksi</strong> (Gunakan tombol cetak atau Ctrl+P)</span>
        <button class="btn-print" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>

    <div class="header-kop">
        <h1>ARCHIE CARWASH</h1>
        <p>Jasa Cuci Mobil Profesional, Cepat, Bersih & Terpercaya</p>
        <p>Alamat: Nangnung Tengah (Dekat Polman Babel), Sungailiat - Telp/WA: 0877-0666-2738</p>
    </div>

    <div class="report-title">
        <h2>Laporan Transaksi & Pendapatan</h2>
        <p>Periode: <strong><?= date('d F Y', strtotime($tgl_awal)); ?></strong> s/d <strong><?= date('d F Y', strtotime($tgl_akhir)); ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No.</th>
                <th width="12%">No. Nota</th>
                <th width="15%">No. Antrian</th>
                <th width="12%">Tanggal</th>
                <th width="18%">Nama Pelanggan</th>
                <th width="12%">No. Plat</th>
                <th width="14%">Layanan Cuci</th>
                <th class="text-right" width="12%">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($resultt && mysql_num_rows($resultt) > 0){
                $no = 1;
                while($row = mysql_fetch_array($resultt)){
                    $total_pendapatan += $row['total'];
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><strong><?= htmlspecialchars($row['no_nota']); ?></strong></td>
                <td><?= htmlspecialchars($row['no_antrian']); ?></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['nomor_plat']); ?></td>
                <td><?= htmlspecialchars($row['jenis_cucian']); ?></td>
                <td class="text-right">Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
            </tr>
            <?php
                }
            ?>
            <tr style="background-color: #f8fafc; font-weight: bold;">
                <td colspan="7" class="text-right">TOTAL PENDAPATAN:</td>
                <td class="text-right">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></td>
            </tr>
            <?php
            } else {
            ?>
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px;">Tidak ada transaksi pada periode ini.</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="signature-box">
        <p>Sungailiat, <?= date('d F Y'); ?><br>Penanggung Jawab / Admin,</p>
        <div class="signature-space"></div>
        <p><strong>( <?= isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Archie Arya Manggala'; ?> )</strong></p>
    </div>

</body>
</html>
