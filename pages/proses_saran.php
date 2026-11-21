<?php 
require_once __DIR__ . '/../config/koneksi.php'; 

$nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
$email = mysqli_real_escape_string($conn, trim($_POST['email']));
$pesan = mysqli_real_escape_string($conn, trim($_POST['pesan']));
$kebersihan = intval($_POST['kebersihan']);
$keramahan = intval($_POST['keramahan']);
$ketelitian = intval($_POST['ketelitian']);

@mysqli_query($conn, "ALTER TABLE `saran` MODIFY `id_saran` int NOT NULL AUTO_INCREMENT");

$query = "INSERT INTO `saran` (`nama`, `email`, `pesan`, `kebersihan`, `keramahan`, `ketelitian`) 
          VALUES ('$nama', '$email', '$pesan', $kebersihan, $keramahan, $ketelitian)";
$hasil = mysql_query($query);

//see the result
if ($hasil) {
?>
<script language="JavaScript">
alert('Terimakasih Atas Kritik dan Saran Yang Telah Anda Berikan!');
document.location='../index.php#saran'</script>
<?php
}else{
    $err = mysql_error();
?>
<script language="JavaScript">
alert('Kritik dan Saran Gagal Dikirim: <?= addslashes($err); ?>');
document.location='../index.php#saran'</script><?php }
?>
