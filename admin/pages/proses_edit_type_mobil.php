<?php 
require_once __DIR__ . '/../../config/koneksi.php'; 

$id_type_mobil = intval($_POST['id_type_mobil']);
$type_mobil = mysqli_real_escape_string($conn, trim($_POST['type_mobil']));

$check_col = mysql_query("SHOW COLUMNS FROM `type_mobil` LIKE 'merek_mobil'");
if ($check_col && mysql_num_rows($check_col) > 0) {
    $merek_mobil = !empty($_POST['merek_mobil']) ? mysqli_real_escape_string($conn, trim($_POST['merek_mobil'])) : '-';
    $sql2 = "UPDATE `type_mobil` SET `type_mobil` = '$type_mobil', `merek_mobil` = '$merek_mobil' WHERE `id_type_mobil` = $id_type_mobil";
} else {
    $sql2 = "UPDATE `type_mobil` SET `type_mobil` = '$type_mobil' WHERE `id_type_mobil` = $id_type_mobil";
}

$hasil2 = mysql_query($sql2);

//see the result
if ($hasil2) {
?>
<script language="JavaScript">
alert('Data Tipe Mobil Berhasil Diubah');
document.location='index.php?p=type_mobil'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data Tipe Mobil Gagal Diubah: <?= addslashes($err); ?>');
document.location='index.php?p=edit_type_mobil&id_type_mobil=<?= $id_type_mobil;?>'</script><?php }
?>
