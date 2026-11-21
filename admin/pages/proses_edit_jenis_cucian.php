<?php 
require_once __DIR__ . '/../../config/koneksi.php'; 

$id_jenis_cucian = intval($_POST['id_jenis_cucian']);
$jenis_cucian = mysqli_real_escape_string($conn, trim($_POST['jenis_cucian']));
$biaya = intval($_POST['biaya']);

$sql2 = "UPDATE `jenis_cucian` SET `jenis_cucian` = '$jenis_cucian', `biaya` = $biaya WHERE `id_jenis_cucian` = $id_jenis_cucian";
$hasil2 = mysql_query($sql2);

//see the result
if ($hasil2) {
?>
<script language="JavaScript">
alert('Data Jenis Cucian Berhasil Diubah');
document.location='index.php?p=jenis_cucian'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data Jenis Cucian Gagal Diubah: <?= addslashes($err); ?>');
document.location='index.php?p=edit_jenis_cucian&id_jenis_cucian=<?= $id_jenis_cucian;?>'</script><?php }
?>
