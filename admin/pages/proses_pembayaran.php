<?php 
require_once __DIR__ . '/../../config/koneksi.php'; 

$id_pendaftaran = intval($_POST['id_pendaftaran']);
$id_user = !empty($_POST['id_user']) ? intval($_POST['id_user']) : (!empty($_SESSION['id_user']) ? intval($_SESSION['id_user']) : 1);
$status = !empty($_POST['status']) ? mysqli_real_escape_string($conn, trim($_POST['status'])) : 'Lunas';
$no_nota = !empty($_POST['no_nota']) ? mysqli_real_escape_string($conn, trim($_POST['no_nota'])) : 'C001';
$tanggal = !empty($_POST['tanggal']) ? mysqli_real_escape_string($conn, trim($_POST['tanggal'])) : date("Y-m-d");
$total = !empty($_POST['total']) ? intval($_POST['total']) : 0;
$bayar = !empty($_POST['bayar']) ? intval($_POST['bayar']) : 0;
$kembali = !empty($_POST['kembali']) ? intval($_POST['kembali']) : 0;
$nama_pencuci = !empty($_POST['nama_pencuci']) ? mysqli_real_escape_string($conn, trim($_POST['nama_pencuci'])) : '-';

// Pastikan id_transaksi auto increment pada primary key
@mysqli_query($conn, "ALTER TABLE `transaksi` MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT");

$sql = "INSERT INTO `transaksi` (`id_pendaftaran`, `no_nota`, `tanggal`, `bayar`, `kembali`, `total`, `status`, `id_user`, `nama_pencuci`) VALUES ($id_pendaftaran, '$no_nota', '$tanggal', $bayar, $kembali, $total, '$status', $id_user, '$nama_pencuci')";
$hasil = mysql_query($sql);

$sql2 = "UPDATE `pendaftaran` SET `status` = 'Lunas' WHERE `id_pendaftaran` = $id_pendaftaran";
$hasil2 = mysql_query($sql2);

//see the result
if ($hasil && $hasil2) {
?>
<script language="JavaScript">
alert('Data Pembayaran Berhasil Disimpan & Status Lunas!');
document.location='index.php?p=transaksi'</script>
<?php
}else{
    $err_msg = mysql_error();
    if(empty($err_msg)) {
        $err_msg = "Gagal menyimpan data ke database";
    }
?>
<script language="JavaScript">
alert('Data Pembayaran Gagal Disimpan: <?= addslashes($err_msg); ?>');
document.location='index.php?p=tambah_pembayaran&id_pendaftaran=<?= $id_pendaftaran;?>'</script><?php }
?>
