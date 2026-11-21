<?php
include "../config/koneksi.php";

$tgl_hari_ini = date("Y-m-d");

// 1. Total Antrian Hari Ini
$q_today = mysql_query("SELECT COUNT(*) as total FROM pendaftaran WHERE tgl_pendaftaran = '$tgl_hari_ini'");
$d_today = mysql_fetch_array($q_today);
$total_today = $d_today['total'] ? $d_today['total'] : 0;

// 2. Antrian Menunggu (Status = 'Pendaftaran')
$q_pending = mysql_query("SELECT COUNT(*) as total FROM pendaftaran WHERE status = 'Pendaftaran'");
$d_pending = mysql_fetch_array($q_pending);
$total_pending = $d_pending['total'] ? $d_pending['total'] : 0;

// 3. Total Transaksi Selesai & Omset
$q_transaksi = mysql_query("SELECT COUNT(*) as total, SUM(total) as omset FROM transaksi");
$d_transaksi = mysql_fetch_array($q_transaksi);
$total_transaksi = $d_transaksi['total'] ? $d_transaksi['total'] : 0;
$total_omset = $d_transaksi['omset'] ? $d_transaksi['omset'] : 0;

// 4. Total Customer
$q_cust = mysql_query("SELECT COUNT(*) as total FROM customer");
$d_cust = mysql_fetch_array($q_cust);
$total_cust = $d_cust['total'] ? $d_cust['total'] : 0;
?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-6">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard Archie CarWash</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active"><i class="fa fa-dashboard"></i> Beranda / <?= date('d F Y'); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">

        <!-- Stat Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-flat-color-1" style="background: linear-gradient(135deg, #0284c7, #0369a1); border-radius: 12px; box-shadow: 0 4px 15px rgba(2, 132, 199, 0.25);">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1 text-white">
                                <i class="fa fa-calendar-check-o"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count"><?= $total_today; ?></span></div>
                                    <div class="stat-heading" style="color: #e0f2fe;">Antrian Hari Ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white" style="background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25);">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib text-white">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count"><?= $total_pending; ?></span></div>
                                    <div class="stat-heading" style="color: #fef3c7;">Menunggu Dicuci</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white" style="background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib text-white">
                                <i class="fa fa-money"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text">Rp <span class="count"><?= number_format($total_omset, 0, ',', '.'); ?></span></div>
                                    <div class="stat-heading" style="color: #d1fae5;">Total Omset Kasir</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white" style="background: linear-gradient(135deg, #6366f1, #4f46e5); border-radius: 12px; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.25);">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib text-white">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count"><?= $total_cust; ?></span></div>
                                    <div class="stat-heading" style="color: #e0e7ff;">Total Customer</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Antrian Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                        <div>
                            <strong class="card-title text-primary"><i class="fa fa-list-alt"></i> Antrian Pendaftaran Hari Ini (<?= date('d M Y'); ?>)</strong>
                        </div>
                        <div>
                            <a href="index.php?p=pendaftaran" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">
                                <i class="fa fa-external-link"></i> Kelola Pendaftaran
                            </a>
                            <a href="index.php?p=transaksi" class="btn btn-sm btn-outline-success ml-2" style="border-radius: 8px;">
                                <i class="fa fa-credit-card"></i> Kasir / Transaksi
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php
                        $sqll = "SELECT pendaftaran.*, customer.nama, customer.nomor_plat, customer.type_mobil, jenis_cucian.jenis_cucian 
                                 FROM pendaftaran 
                                 JOIN customer USING (id_customer) 
                                 JOIN jenis_cucian USING (id_jenis_cucian) 
                                 WHERE tgl_pendaftaran = '$tgl_hari_ini' 
                                 ORDER BY id_pendaftaran DESC";
                        $resultt = mysql_query($sqll);

                        if(mysql_num_rows($resultt) > 0) {
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No. Antrian</th>
                                        <th>Nama Customer</th>
                                        <th>Plat Kendaraan</th>
                                        <th>Tipe Mobil</th>
                                        <th>Layanan Cuci</th>
                                        <th>Jam Datang</th>
                                        <th>Total Biaya</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($data = mysql_fetch_array($resultt)) { ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($data['no_antrian']); ?></strong></td>
                                        <td><?= htmlspecialchars($data['nama']); ?></td>
                                        <td><span class="badge badge-dark"><?= htmlspecialchars($data['nomor_plat']); ?></span></td>
                                        <td><?= htmlspecialchars($data['type_mobil']); ?></td>
                                        <td><?= htmlspecialchars($data['jenis_cucian']); ?></td>
                                        <td><i class="fa fa-clock-o text-muted"></i> <?= htmlspecialchars($data['jam_pendaftaran']); ?></td>
                                        <td>Rp <?= number_format($data['total_biaya'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php if($data['status'] == 'Pendaftaran'): ?>
                                                <span class="badge badge-warning" style="padding: 6px 10px; font-size: 12px;">Menunggu</span>
                                            <?php else: ?>
                                                <span class="badge badge-success" style="padding: 6px 10px; font-size: 12px;"><?= htmlspecialchars($data['status']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($data['status'] == 'Pendaftaran'): ?>
                                                <a href="index.php?p=tambah_pembayaran&id_pendaftaran=<?= $data['id_pendaftaran']; ?>" class="btn btn-sm btn-primary" title="Proses Pembayaran / Selesai" style="border-radius: 6px;">
                                                    <i class="fa fa-credit-card"></i> Bayar
                                                </a>
                                            <?php else: ?>
                                                <span class="text-success"><i class="fa fa-check-circle"></i> Selesai</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } else { ?>
                            <div class="text-center py-5">
                                <i class="fa fa-inbox text-muted" style="font-size: 48px; margin-bottom: 15px;"></i>
                                <h5 class="text-muted">Belum ada pendaftaran antrian untuk hari ini.</h5>
                                <p class="text-muted">Pendaftaran baru dari halaman depan akan otomatis muncul di sini.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- .animated -->
</div><!-- .content -->
