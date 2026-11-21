<?php
@include 'config/koneksi.php';
session_start();

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = 'user'; // Default pendaftaran umum adalah user

   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      echo "<script>alert('Pendaftaran gagal! Email sudah terdaftar.');</script>";
   }else{
      if($pass != $cpass){
         echo "<script>alert('Pendaftaran gagal! Konfirmasi password tidak cocok.');</script>";
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($conn, $insert);
         echo "<script>alert('Pendaftaran berhasil! Silakan masuk.'); window.location = 'login.php';</script>";
      }
   }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Buat Akun Baru - Archie CarWash</title>

   <link rel="stylesheet" href="css/font-awesome.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" type="image/x-icon" href="images/2.png" sizes="32x32">
</head>
<body>
   
<div class="form-container">
   <form action="" method="post">
      <div class="brand-icon">
         <i class="fa fa-user-plus"></i>
      </div>
      <h3>Buat Akun Baru</h3>
      <p class="sub-title">Bergabung dengan Archie CarWash</p>

      <div class="input-group-field">
         <label for="name"><i class="fa fa-user"></i> Nama Lengkap</label>
         <input type="text" id="name" name="name" required placeholder="Masukkan nama lengkap Anda">
      </div>

      <div class="input-group-field">
         <label for="email"><i class="fa fa-envelope-o"></i> Alamat Email</label>
         <input type="email" id="email" name="email" required placeholder="Masukkan email aktif">
      </div>

      <div class="input-group-field">
         <label for="password"><i class="fa fa-lock"></i> Password</label>
         <input type="password" id="password" name="password" required placeholder="Buat kata sandi">
      </div>

      <div class="input-group-field">
         <label for="cpassword"><i class="fa fa-shield"></i> Konfirmasi Password</label>
         <input type="password" id="cpassword" name="cpassword" required placeholder="Ulangi kata sandi">
      </div>

      <input type="submit" name="submit" value="Daftar Sekarang" class="form-btn">
      
      <p class="footer-text">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
      <a href="index.php" class="back-home-link"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a>
   </form>
</div>

</body>
</html>
