<?php 
require_once __DIR__ . '/../../config/koneksi.php'; 

$id_pendaftaran = intval($_POST['id_pendaftaran']);
$status = mysqli_real_escape_string($conn, trim($_POST['status']));

$sql2 = "UPDATE `pendaftaran` SET `status` = '$status' WHERE `id_pendaftaran` = $id_pendaftaran";
$hasil2 = mysql_query($sql2);

//see the result
if ($hasil2) {
?>
<script language="JavaScript">
alert('Status Antrian Berhasil Diubah Menjadi <?= addslashes($status); ?>');
document.location='index.php?p=pendaftaran'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Status Gagal Diubah: <?= addslashes($err); ?>');
document.location='index.php?p=pendaftaran'</script><?php }
?>
