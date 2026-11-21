<?php 
require_once __DIR__ . '/../../config/koneksi.php'; 

$id_user = intval($_POST['id_user']);
$nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
$alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));
$hp = mysqli_real_escape_string($conn, trim($_POST['hp']));
$username = mysqli_real_escape_string($conn, trim($_POST['username']));

if (!empty($_POST['password'])) {
    $password = md5(trim($_POST['password']));
    $sql2 = "UPDATE `user` SET `nama` = '$nama', `alamat` = '$alamat', `hp` = '$hp', `username` = '$username', `password` = '$password' WHERE `id_user` = $id_user";
} else {
    $sql2 = "UPDATE `user` SET `nama` = '$nama', `alamat` = '$alamat', `hp` = '$hp', `username` = '$username' WHERE `id_user` = $id_user";
}

$hasil2 = mysql_query($sql2);

// Sinkronkan juga ke tabel user_form jika ada
$check_user_form = mysql_query("SHOW TABLES LIKE 'user_form'");
if ($check_user_form && mysql_num_rows($check_user_form) > 0 && !empty($_POST['password'])) {
    @mysqli_query($conn, "UPDATE `user_form` SET `password` = '$password' WHERE `name` = '$username'");
}

//see the result
if ($hasil2) {
?>
<script language="JavaScript">
alert('Data User Berhasil Diubah');
document.location='index.php?p=user'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data User Gagal Diubah: <?= addslashes($err); ?>');
document.location='index.php?p=edit_user&id_user=<?= $id_user;?>'</script><?php }
?>
