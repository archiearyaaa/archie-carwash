<?php
include "../config/koneksi.php";

$id_user = $_GET['id'];
$status = $_GET['status'];
$ganti_status = ($status == '1') ? '0' : '1';

$update = mysql_query("UPDATE user SET status = '$ganti_status' WHERE id_user = '$id_user'");

if ($update){
?>
<script language="JavaScript">
alert('Status Berhasil Diubah');
document.location='index.php?p=user';
</script>
<?php
}else{
?>
<script language="JavaScript">
alert('Gagal Mengubah Status: <?= addslashes(mysql_error()); ?>');
document.location='index.php?p=user';
</script>
<?php
}
?>
