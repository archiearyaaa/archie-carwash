<?php
require_once __DIR__ . '/../../config/koneksi.php';
$id_type_mobil = intval($_GET['id_type_mobil']);
$hasil = mysql_query("DELETE FROM `type_mobil` WHERE `id_type_mobil` = $id_type_mobil");

if ($hasil) {
?>
<script language="JavaScript">
alert('Data Tipe Mobil Berhasil Dihapus');
document.location='index.php?p=type_mobil'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data Tipe Mobil Gagal Dihapus: <?= addslashes($err); ?>');
document.location='index.php?p=type_mobil'</script><?php }
?>
