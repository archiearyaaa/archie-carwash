<?php 
require_once __DIR__ . '/../../config/koneksi.php'; 

$nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
$alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));
$hp = mysqli_real_escape_string($conn, trim($_POST['hp']));
$status = 1;
$username = mysqli_real_escape_string($conn, trim($_POST['username']));
$password_raw = trim($_POST['password']);
$password = md5($password_raw);

@mysqli_query($conn, "ALTER TABLE `user` MODIFY `id_user` int NOT NULL AUTO_INCREMENT");

$sql = "INSERT INTO `user` (`username`, `password`, `nama`, `alamat`, `hp`, `status`) 
        VALUES ('$username', '$password', '$nama', '$alamat', '$hp', $status)";
$hasil = mysql_query($sql);

// Sinkronkan juga ke tabel user_form jika ada
$check_user_form = mysql_query("SHOW TABLES LIKE 'user_form'");
if ($check_user_form && mysql_num_rows($check_user_form) > 0) {
    $email_sync = $username . "@carwash.local";
    @mysqli_query($conn, "INSERT INTO `user_form` (`name`, `email`, `password`, `user_type`) VALUES ('$username', '$email_sync', '$password', 'admin') ON DUPLICATE KEY UPDATE password='$password'");
}

//see the result
if ($hasil) {
?>
<script language="JavaScript">
alert('Data User Berhasil Ditambahkan');
document.location='index.php?p=user'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Data User Gagal Ditambahkan: <?= addslashes($err); ?>');
document.location='index.php?p=tambah_user'</script><?php }
?>
