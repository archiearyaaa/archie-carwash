<?php
require_once __DIR__ . '/../../config/koneksi.php';
$id_jenis_cucian = intval($_GET['id_jenis_cucian']);
$hasil = mysql_query("DELETE FROM `jenis_cucian` WHERE `id_jenis_cucian` = $id_jenis_cucian");

if ($hasil) {
?>
<script language="JavaScript">
alert('Data Jenis Cucian Berhasil Dihapus');
document.location='index.php?p=jenis_cucian'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data Jenis Cucian Gagal Dihapus: <?= addslashes($err); ?>');
document.location='index.php?p=jenis_cucian'</script><?php }
?>
