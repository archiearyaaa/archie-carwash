<?php 
require_once __DIR__ . '/../../config/koneksi.php'; 

$type_mobil = mysqli_real_escape_string($conn, trim($_POST['type_mobil']));
$merek_mobil = !empty($_POST['merek_mobil']) ? mysqli_real_escape_string($conn, trim($_POST['merek_mobil'])) : '-';

@mysqli_query($conn, "ALTER TABLE `type_mobil` MODIFY `id_type_mobil` int NOT NULL AUTO_INCREMENT");

$check_col = mysql_query("SHOW COLUMNS FROM `type_mobil` LIKE 'merek_mobil'");
if ($check_col && mysql_num_rows($check_col) > 0) {
    $sql = "INSERT INTO `type_mobil` (`type_mobil`, `merek_mobil`) VALUES ('$type_mobil', '$merek_mobil')";
} else {
    $sql = "INSERT INTO `type_mobil` (`type_mobil`) VALUES ('$type_mobil')";
}

$hasil = mysql_query($sql);

//see the result
if ($hasil) {
?>
<script language="JavaScript">
alert('Data Tipe Mobil Berhasil Ditambahkan');
document.location='index.php?p=type_mobil'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data Tipe Mobil Gagal Ditambahkan: <?= addslashes($err); ?>');
document.location='index.php?p=tambah_type_mobil'</script><?php }
?>
