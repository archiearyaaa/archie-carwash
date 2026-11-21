<?php
require_once __DIR__ . '/../../config/koneksi.php';  

$id_pendaftaran = isset($_GET['id_pendaftaran']) ? intval($_GET['id_pendaftaran']) : 0;
$queryy = mysql_query("SELECT * FROM pendaftaran JOIN customer USING(id_customer) JOIN jenis_cucian USING (id_jenis_cucian) WHERE id_pendaftaran = '$id_pendaftaran'");
$dt = ($queryy) ? mysql_fetch_array($queryy) : null;

$id_user = !empty($_SESSION['id_user']) ? $_SESSION['id_user'] : 1;
?>

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Pembayaran</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="index.php?p=pendaftaran">Pendaftaran</a></li>
                            <li class="active">Proses Pembayaran</li>
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
                        <strong class="card-title"><i class="fa fa-credit-card"></i> Form Pembayaran Cuci Mobil</strong>
                    </div>
                    <div class="card-body">
 
                        <form action="index.php?p=proses_pembayaran" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return validatePayment();">
                            <input type="hidden" name="id_pendaftaran" value="<?= htmlspecialchars($dt['id_pendaftaran'] ?? $id_pendaftaran); ?>">
                            <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user); ?>">
                            <input type="hidden" name="status" value="Lunas">

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>No. Antrian</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($dt['no_antrian'] ?? '-'); ?>" readonly>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>Nama Customer</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($dt['nama'] ?? '-'); ?>" readonly>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>No. Plat Kendaraan</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($dt['nomor_plat'] ?? '-'); ?>" readonly>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>Tipe Mobil</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($dt['type_mobil'] ?? '-'); ?>" readonly>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>Jenis Cucian</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($dt['jenis_cucian'] ?? '-'); ?>" readonly>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>No. Nota</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <?php
                                    $sql_nota = mysql_query("SELECT no_nota FROM transaksi ORDER BY id_transaksi DESC LIMIT 1");
                                    $no_nota = "C001";
                                    if ($sql_nota && mysql_num_rows($sql_nota) > 0) {
                                        $row_nota = mysql_fetch_array($sql_nota);
                                        $last_nota = $row_nota['no_nota'];
                                        if (preg_match('/^([A-Za-z]+)(\d+)$/', $last_nota, $matches)) {
                                            $prefix = $matches[1];
                                            $number = intval($matches[2]) + 1;
                                            $no_nota = $prefix . str_pad($number, strlen($matches[2]), '0', STR_PAD_LEFT);
                                        } else {
                                            $no_nota = "C002";
                                        }
                                    }
                                    ?>
                                    <input type="text" class="form-control" id="no_nota" name="no_nota" value="<?= htmlspecialchars($no_nota); ?>" readonly>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>Tanggal Pembayaran</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="date" name="tanggal" value="<?= date("Y-m-d");?>" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>Total Biaya (Rp)</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="number" name="total" id="txt2" class="form-control" value="<?= intval($dt['total_biaya'] ?? 0); ?>" readonly>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>Uang Yang Dibayarkan (Rp) <span class="text-danger">*</span></strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="number" id="txt1" onkeyup="sum();" onchange="sum();" name="bayar" class="form-control" placeholder="Masukkan jumlah uang bayar..." required min="<?= intval($dt['total_biaya'] ?? 0); ?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>Kembalian (Rp)</strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="number" name="kembali" class="form-control" readonly id="txt3" value="0">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label class="form-control-label"><strong>Penanggung Jawab Cuci <span class="text-danger">*</span></strong></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" name="nama_pencuci" class="form-control" placeholder="Nama staf pencuci mobil..." required>
                                </div>
                            </div>
                            
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Simpan Transaksi Pembayaran</button>
                                <a href="index.php?p=pendaftaran" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function sum() {
    var txtFirst = parseInt(document.getElementById('txt1').value) || 0;
    var txtSecond = parseInt(document.getElementById('txt2').value) || 0;
    var result = txtFirst - txtSecond;
    document.getElementById('txt3').value = (result >= 0) ? result : 0;
}

function validatePayment() {
    var bayar = parseInt(document.getElementById('txt1').value) || 0;
    var total = parseInt(document.getElementById('txt2').value) || 0;
    if (bayar < total) {
        alert('Jumlah bayar tidak boleh kurang dari total biaya (Rp ' + total.toLocaleString('id-ID') + ')!');
        document.getElementById('txt1').focus();
        return false;
    }
    return true;
}
</script>
