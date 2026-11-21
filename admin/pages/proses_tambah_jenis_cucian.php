<?php 
require_once __DIR__ . '/../../config/koneksi.php'; 

$jenis_cucian = mysqli_real_escape_string($conn, trim($_POST['jenis_cucian']));
$biaya = intval($_POST['biaya']);

@mysqli_query($conn, "ALTER TABLE `jenis_cucian` MODIFY `id_jenis_cucian` int NOT NULL AUTO_INCREMENT");

$sql = "INSERT INTO `jenis_cucian` (`jenis_cucian`, `biaya`) VALUES ('$jenis_cucian', $biaya)";
$hasil = mysql_query($sql);

//see the result
if ($hasil) {
?>
<script language="JavaScript">
alert('Data Jenis Cucian Berhasil Ditambahkan');
document.location='index.php?p=jenis_cucian'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data Jenis Cucian Gagal Ditambahkan: <?= addslashes($err); ?>');
document.location='index.php?p=tambah_jenis_cucian'</script><?php }
?>
