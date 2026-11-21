<?php
require_once __DIR__ . '/../../config/koneksi.php';

$id_transaksi = isset($_GET['id_transaksi']) ? intval($_GET['id_transaksi']) : 0;
$id_pendaftaran = isset($_GET['id_pendaftaran']) ? intval($_GET['id_pendaftaran']) : 0;

if ($id_transaksi > 0) {
    $sql = "SELECT transaksi.*, pendaftaran.no_antrian, pendaftaran.tgl_pendaftaran, pendaftaran.jam_pendaftaran, pendaftaran.layanan_tambahan, 
                   customer.nama, customer.nomor_plat, customer.type_mobil, customer.merek_mobil, 
                   jenis_cucian.jenis_cucian, jenis_cucian.biaya 
            FROM transaksi 
            JOIN pendaftaran USING (id_pendaftaran) 
            JOIN customer USING (id_customer) 
            JOIN jenis_cucian USING (id_jenis_cucian) 
            WHERE id_transaksi = $id_transaksi";
} else {
    $sql = "SELECT transaksi.*, pendaftaran.no_antrian, pendaftaran.tgl_pendaftaran, pendaftaran.jam_pendaftaran, pendaftaran.layanan_tambahan, 
                   customer.nama, customer.nomor_plat, customer.type_mobil, customer.merek_mobil, 
                   jenis_cucian.jenis_cucian, jenis_cucian.biaya 
            FROM transaksi 
            JOIN pendaftaran USING (id_pendaftaran) 
            JOIN customer USING (id_customer) 
            JOIN jenis_cucian USING (id_jenis_cucian) 
            WHERE id_pendaftaran = $id_pendaftaran 
            ORDER BY id_transaksi DESC LIMIT 1";
}

$query = mysql_query($sql);
$data = ($query && mysql_num_rows($query) > 0) ? mysql_fetch_array($query) : null;

if (!$data) {
    die("<div style='padding:30px; font-family:sans-serif; text-align:center;'><h3>Data transaksi tidak ditemukan!</h3><a href='../index.php?p=transaksi'>Kembali</a></div>");
}

$no_parts = explode('/', $data['no_antrian']);
$no_antri = isset($no_parts[1]) ? $no_parts[1] : $data['no_antrian'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Kasir #<?= htmlspecialchars($data['no_nota']); ?> - Archie CarWash</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .receipt-container {
            width: 100%;
            max-width: 320px; /* Standar POS Thermal 58mm-80mm */
            background: #ffffff;
            padding: 20px 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            font-size: 12.5px;
            line-height: 1.4;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 12px;
        }

        .receipt-header h2 {
            font-size: 16px;
            font-weight: 900;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        .receipt-header p {
            font-size: 11px;
            margin-bottom: 2px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .divider-double {
            border-top: 2px dashed #000;
            margin: 10px 0;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .receipt-row .label {
            color: #333;
        }

        .receipt-row .value {
            font-weight: bold;
            text-align: right;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 14px;
            font-size: 11px;
        }

        .receipt-footer p {
            margin-bottom: 3px;
        }

        .no-print-bar {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn-print {
            background: #0284c7;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-family: sans-serif;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-back {
            background: #64748b;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-family: sans-serif;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
                max-width: 100%;
                width: 100%;
                padding: 5px;
            }
            .no-print-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body onload="window.print();">

    <div class="receipt-container">
        <div class="receipt-header">
            <h2>ARCHIE CARWASH</h2>
            <p>Nangnung Tengah, Sungailiat - Bangka</p>
            <p>WA: 0877-0666-2738</p>
        </div>

        <div class="divider"></div>

        <div class="receipt-row">
            <span class="label">No. Nota</span>
            <span class="value"><?= htmlspecialchars($data['no_nota']); ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">No. Antrian</span>
            <span class="value">#<?= htmlspecialchars($no_antri); ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">Tanggal</span>
            <span class="value"><?= date('d/m/Y', strtotime($data['tanggal'])); ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">Pencuci</span>
            <span class="value"><?= htmlspecialchars($data['nama_pencuci']); ?></span>
        </div>

        <div class="divider"></div>

        <div class="receipt-row">
            <span class="label">Customer</span>
            <span class="value"><?= htmlspecialchars($data['nama']); ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">No. Plat</span>
            <span class="value"><?= htmlspecialchars($data['nomor_plat']); ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">Kendaraan</span>
            <span class="value"><?= htmlspecialchars($data['type_mobil']); ?><?= !empty($data['merek_mobil']) && $data['merek_mobil'] !== '-' ? ' (' . htmlspecialchars($data['merek_mobil']) . ')' : ''; ?></span>
        </div>

        <div class="divider"></div>

        <div style="font-weight: bold; margin-bottom: 4px;">
            <?= htmlspecialchars($data['jenis_cucian']); ?>
        </div>
        <?php if(!empty($data['layanan_tambahan'])): ?>
        <div class="receipt-row" style="font-size: 11px; color: #444; margin-bottom: 6px;">
            <span class="label">+ <?= htmlspecialchars($data['layanan_tambahan']); ?></span>
        </div>
        <?php endif; ?>
        <div class="receipt-row">
            <span class="label">Biaya Jasa</span>
            <span class="value">Rp <?= number_format($data['total'], 0, ',', '.'); ?></span>
        </div>

        <div class="divider-double"></div>

        <div class="receipt-row" style="font-size: 13.5px;">
            <span class="label"><strong>TOTAL</strong></span>
            <span class="value">Rp <?= number_format($data['total'], 0, ',', '.'); ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">Tunai Dibayar</span>
            <span class="value">Rp <?= number_format($data['bayar'], 0, ',', '.'); ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">Kembalian</span>
            <span class="value">Rp <?= number_format($data['kembali'], 0, ',', '.'); ?></span>
        </div>

        <div class="divider"></div>

        <div class="receipt-row" style="text-align: center; justify-content: center; font-size: 13px;">
            <span>*** <strong>STATUS: LUNAS</strong> ***</span>
        </div>

        <div class="receipt-footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Mobil Bersih, Mengkilap & Nyaman</p>
            <p>Simpan nota ini sebagai bukti pembayaran resmi.</p>
        </div>
    </div>

    <div class="no-print-bar">
        <button onclick="window.print();" class="btn-print"><i class="fa fa-print"></i> Cetak Struk</button>
        <a href="../index.php?p=transaksi" class="btn-back">Kembali ke Transaksi</a>
    </div>

</body>
</html>
