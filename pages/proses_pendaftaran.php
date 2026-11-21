<?php 
require_once __DIR__ . '/../config/koneksi.php'; 

$next = !empty($_POST['next']) ? intval($_POST['next']) : 1;
$nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
$no_hp = mysqli_real_escape_string($conn, trim($_POST['no_hp']));
$alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));
$nomor_plat = mysqli_real_escape_string($conn, trim($_POST['nomor_plat']));
$type_mobil = mysqli_real_escape_string($conn, trim($_POST['type_mobil']));
$no_antrian = mysqli_real_escape_string($conn, trim($_POST['no_antrian']));
$id_jenis_cucian = intval($_POST['id_jenis_cucian']);
$total_biaya = intval($_POST['total_biaya']);
$tgl_pendaftaran = !empty($_POST['tgl_pendaftaran']) ? mysqli_real_escape_string($conn, trim($_POST['tgl_pendaftaran'])) : date("Y-m-d");
date_default_timezone_set('Asia/Jakarta');
$jam_pendaftaran = !empty($_POST['jam_pendaftaran']) ? mysqli_real_escape_string($conn, trim($_POST['jam_pendaftaran'])) : date("H:i:s");
$merek_mobil = !empty($_POST['merek_mobil']) ? mysqli_real_escape_string($conn, trim($_POST['merek_mobil'])) : '-';
$layanan_tambahan = !empty($_POST['layanan_tambahan']) ? mysqli_real_escape_string($conn, trim($_POST['layanan_tambahan'])) : '';

$cek = mysql_query("SELECT count(id_pendaftaran) as jumlah_daftar FROM pendaftaran WHERE jam_pendaftaran = '$jam_pendaftaran' AND tgl_pendaftaran = '$tgl_pendaftaran'");
$htg = ($cek) ? mysql_fetch_array($cek) : null;
$jumlahnya = isset($htg['jumlah_daftar']) ? intval($htg['jumlah_daftar']) : 0;

if($jumlahnya != 0){
?>
<script language="JavaScript">
alert('Maaf, Jam Yang Anda Inginkan Sudah Dibooking, Silahkan Pilih Jam Yang Lainnya');
document.location='../index.php'</script>
<?php 
} else {

    if($next > 30){
?>
<script language="JavaScript">
alert('Maaf, Antrian Hari Ini Sudah Penuh, Silahkan Daftar Kembali Di Hari Berikutnya');
document.location='../index.php'</script>	
<?php 
    } else {

        // Auto increment primary key guarantee
        @mysqli_query($conn, "ALTER TABLE `customer` MODIFY `id_customer` int NOT NULL AUTO_INCREMENT");
        @mysqli_query($conn, "ALTER TABLE `pendaftaran` MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT");

        $check_col = mysql_query("SHOW COLUMNS FROM `customer` LIKE 'merek_mobil'");
        if ($check_col && mysql_num_rows($check_col) > 0) {
            $queryy = "INSERT INTO `customer` (`nama`, `no_hp`, `alamat`, `nomor_plat`, `type_mobil`, `merek_mobil`) VALUES ('$nama', '$no_hp', '$alamat', '$nomor_plat', '$type_mobil', '$merek_mobil')";
        } else {
            $queryy = "INSERT INTO `customer` (`nama`, `no_hp`, `alamat`, `nomor_plat`, `type_mobil`) VALUES ('$nama', '$no_hp', '$alamat', '$nomor_plat', '$type_mobil')";
        }
        $hasill = mysql_query($queryy);
        $id_customer = mysql_insert_id();
        if(!$id_customer && !empty($_POST['id_customer'])) {
            $id_customer = intval($_POST['id_customer']);
        }

        // Cek kolom layanan_tambahan di tabel pendaftaran
        $check_addon = mysql_query("SHOW COLUMNS FROM `pendaftaran` LIKE 'layanan_tambahan'");
        if (!$check_addon || mysql_num_rows($check_addon) == 0) {
            @mysqli_query($conn, "ALTER TABLE `pendaftaran` ADD COLUMN `layanan_tambahan` varchar(200) DEFAULT '' AFTER `total_biaya`");
        }

        $has_addon_col = mysql_query("SHOW COLUMNS FROM `pendaftaran` LIKE 'layanan_tambahan'");
        if ($has_addon_col && mysql_num_rows($has_addon_col) > 0) {
            $query = "INSERT INTO `pendaftaran` (`no_antrian`, `id_customer`, `id_jenis_cucian`, `tgl_pendaftaran`, `jam_pendaftaran`, `total_biaya`, `layanan_tambahan`, `status`) VALUES ('$no_antrian', $id_customer, $id_jenis_cucian, '$tgl_pendaftaran', '$jam_pendaftaran', $total_biaya, '$layanan_tambahan', 'Pendaftaran')";
        } else {
            $query = "INSERT INTO `pendaftaran` (`no_antrian`, `id_customer`, `id_jenis_cucian`, `tgl_pendaftaran`, `jam_pendaftaran`, `total_biaya`, `status`) VALUES ('$no_antrian', $id_customer, $id_jenis_cucian, '$tgl_pendaftaran', '$jam_pendaftaran', $total_biaya, 'Pendaftaran')";
        }
        $hasil = mysql_query($query);

        if ($hasil) {
?>
<script language="JavaScript">
alert('Pendaftaran Anda Berhasil Dilakukan, Silahkan Datang Ke Cucian Kami Maksimal 10 Menit Dari Sekarang');
document.location='../laporan/struk.php?id=<?= urlencode($no_antrian); ?>'</script>
<?php
        } else {
            $err = mysql_error();
?>
<script language="JavaScript">
alert('Pendaftaran Gagal Dilakukan: <?= addslashes($err); ?>');
document.location='../index.php'</script>
<?php 
        }
    }
}
?>
