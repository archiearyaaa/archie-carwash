<?php
include ("../config/koneksi.php");

$tgl_awal = !empty($_POST['tgl_awal']) ? $_POST['tgl_awal'] : (!empty($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-01'));
$tgl_akhir = !empty($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : (!empty($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d'));
?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Laporan Transaksi</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Laporan</a></li>
                            <li class="active">Rekap Transaksi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title"><i class="fa fa-filter"></i> Filter Laporan Berdasarkan Periode</strong>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row align-items-center">
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <label class="form-control-label"><strong>Dari Tanggal:</strong></label>
                                    <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>" required>
                                </div>
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <label class="form-control-label"><strong>Sampai Tanggal:</strong></label>
                                    <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>" required>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-2 d-flex align-items-end" style="gap: 8px; margin-top: 28px; flex-wrap: wrap;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                    <a href="pages/laporan_transaksi.php?tgl_awal=<?= $tgl_awal;?>&tgl_akhir=<?= $tgl_akhir;?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>
                                    <a href="pages/export_excel_transaksi.php?tgl_awal=<?= $tgl_awal;?>&tgl_akhir=<?= $tgl_akhir;?>" target="_blank" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                </div>
                            </div>
                        </form>

                        <hr>
                        <p class="text-muted"><i class="fa fa-calendar"></i> Menampilkan data transaksi dari tanggal <strong><?= date('d M Y', strtotime($tgl_awal)); ?></strong> s/d <strong><?= date('d M Y', strtotime($tgl_akhir)); ?></strong></p>

                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <?php
                              $sqll = "SELECT * FROM transaksi 
                                       JOIN pendaftaran USING (id_pendaftaran) 
                                       JOIN jenis_cucian USING(id_jenis_cucian) 
                                       JOIN customer WHERE pendaftaran.id_customer = customer.id_customer 
                                       AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                       ORDER BY id_transaksi DESC";
                              $resultt = mysql_query($sqll);
                              $total_pendapatan = 0;
                              
                              if($resultt && mysql_num_rows($resultt) > 0){
                            ?>                                            
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Nota</th>
                                        <th>No. Antrian</th>
                                        <th>Tanggal</th>
                                        <th>Nama Customer</th>
                                        <th>No. Plat</th>
                                        <th>Jenis Cucian</th>
                                        <th>Total Biaya</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                              $nomor = 1;
                              while($data = mysql_fetch_array($resultt)){
                                  $total_pendapatan += $data['total'];
                            ?>                                          
                                    <tr>
                                        <td><?= $nomor++;?></td>
                                        <td><strong><?= $data['no_nota'];?></strong></td>
                                        <td><?= $data['no_antrian'];?></td>
                                        <td><?= date('d-m-Y', strtotime($data['tanggal']));?></td>
                                        <td><?= $data['nama'];?></td>
                                        <td><span class="badge badge-dark"><?= $data['nomor_plat'];?></span></td>
                                        <td><?= $data['jenis_cucian'];?></td>
                                        <td>Rp <?= number_format($data['total'], 0, ',', '.');?></td>
                                        <td><span class="badge badge-success"><?= $data['status'];?></span></td>
                                    </tr>
                            <?php
                              }
                            ?>
                                </tbody>
                                <tfoot>
                                    <tr style="background: #f8fafc; font-weight: bold;">
                                        <td colspan="7" class="text-right">Total Pendapatan Periode Ini:</td>
                                        <td colspan="2" class="text-primary" style="font-size: 16px;">Rp <?= number_format($total_pendapatan, 0, ',', '.');?></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php
                              } else {
                            ?>
                                <div class="alert alert-info text-center py-4">
                                    <i class="fa fa-info-circle fa-2x mb-2"></i><br>
                                    Tidak ada data transaksi yang ditemukan pada rentang tanggal tersebut.
                                </div>
                            <?php
                              }
                            ?>            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->
