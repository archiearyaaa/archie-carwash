<?php
@include 'config/koneksi.php';
session_start();

if(isset($_POST['submit'])){
   $login_id = mysqli_real_escape_string($conn, trim($_POST['email']));
   $raw_pass = trim($_POST['password']);
   $pass_md5 = md5($raw_pass);

   $login_success = false;
   $logged_role = '';
   $logged_name = '';

   // 1. Cek di tabel user_form (cocokkan dengan email ATAU nama/username)
   $select = "SELECT * FROM user_form WHERE (email = '$login_id' OR name = '$login_id') AND password = '$pass_md5'";
   $result = mysqli_query($conn, $select);

   // Jika password 'admin' atau '123' untuk akun admin
   if(mysqli_num_rows($result) == 0 && ($login_id == 'admin' || $login_id == 'admin@gmail.com' || $login_id == 'admin1@gmail.com')){
       $alt_pass1 = md5('admin');
       $alt_pass2 = md5('123');
       $select_admin = "SELECT * FROM user_form WHERE (email = '$login_id' OR name = '$login_id') AND (password = '$alt_pass1' OR password = '$alt_pass2')";
       $result_admin = mysqli_query($conn, $select_admin);
       if(mysqli_num_rows($result_admin) > 0){
           $result = $result_admin;
       }
   }

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_array($result);
      $login_success = true;
      $logged_role = $row['user_type'];
      $logged_name = $row['name'];
   } else {
      // 2. Cek di tabel user (jika akun admin ada di tabel user)
      $check_tbl_user = mysqli_query($conn, "SHOW TABLES LIKE 'user'");
      if(mysqli_num_rows($check_tbl_user) > 0){
         $select_user = "SELECT * FROM user WHERE (username = '$login_id' OR nama = '$login_id') AND (password = '$pass_md5' OR password = '".md5('admin')."' OR password = '".md5('123')."')";
         $result_user = mysqli_query($conn, $select_user);
         if(mysqli_num_rows($result_user) > 0){
            $row_u = mysqli_fetch_array($result_user);
            $login_success = true;
            $logged_role = 'admin';
            $logged_name = $row_u['nama'];
         }
      }

      // 3. Fallback Darurat Admin Utama
      if(!$login_success && ($login_id === 'admin' || $login_id === 'admin@gmail.com') && ($raw_pass === 'admin' || $raw_pass === '123' || $raw_pass === 'admin123')){
         // Sinkronkan akun admin ke tabel user_form
         mysqli_query($conn, "INSERT INTO user_form (name, email, password, user_type) VALUES ('admin', 'admin@gmail.com', '".md5('123')."', 'admin') ON DUPLICATE KEY UPDATE password='".md5('123')."', user_type='admin'");
         $login_success = true;
         $logged_role = 'admin';
         $logged_name = 'Admin';
      }
   }

   if($login_success){
      if($logged_role == 'admin'){
         $_SESSION['admin_name'] = $logged_name;
         $_SESSION['id_user'] = !empty($row['id']) ? intval($row['id']) : (!empty($row_u['id_user']) ? intval($row_u['id_user']) : 1);
         echo "<script>alert('Login berhasil sebagai Admin! Selamat datang.'); window.location = 'admin/index.php';</script>";
         exit;
      } else {
         $_SESSION['user_name'] = $logged_name;
         $_SESSION['id_user'] = !empty($row['id']) ? intval($row['id']) : (!empty($row_u['id_user']) ? intval($row_u['id_user']) : 1);
         echo "<script>alert('Login berhasil! Selamat datang.'); window.location = 'index.php';</script>";
         exit;
      }
   } else {
      echo "<script>alert('Login gagal! Username/Email atau Password salah.');</script>";
   }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Masuk / Login - Archie CarWash</title>

   <link rel="stylesheet" href="css/font-awesome.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" type="image/x-icon" href="images/2.png" sizes="32x32">
</head>

<body>

   <div class="form-container">
      <form action="" method="post">
         <div class="brand-icon">
            <i class="fa fa-car"></i>
         </div>
         <h3>Archie CarWash</h3>
         <p class="sub-title">Masuk ke Akun Anda</p>

         <div class="input-group-field">
            <label for="username_email"><i class="fa fa-user"></i> Username atau Email</label>
            <input type="text" id="username_email" name="email" required placeholder="Contoh: admin atau admin@gmail.com">
         </div>

         <div class="input-group-field">
            <label for="password"><i class="fa fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" required placeholder="Masukkan password Anda">
         </div>

         <input type="submit" name="submit" value="Masuk Sekarang" class="form-btn">

         <p class="footer-text">Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>
         <a href="index.php" class="back-home-link"><i class="fa fa-arrow-left"></i> Kembali ke Beranda</a>
      </form>
   </div>

</body>
</html>
