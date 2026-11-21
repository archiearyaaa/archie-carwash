<?php
require_once __DIR__ . '/../../config/koneksi.php';
$id_user = intval($_GET['id_user']);
$hasil = mysql_query("DELETE FROM `user` WHERE `id_user` = $id_user");

if ($hasil) {
?>
<script language="JavaScript">
alert('Data User Berhasil Dihapus');
document.location='index.php?p=user'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data User Gagal Dihapus: <?= addslashes($err); ?>');
document.location='index.php?p=user'</script><?php }
?>
