<?php
session_start();

unset($_SESSION['username']);
session_unset();
session_destroy();

?>
<script>document.location.href="../login.php"
</script>
<?
// include "../index.php";
?>