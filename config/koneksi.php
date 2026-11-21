<?php
include "mysql_mysqli.inc.php";

// Matikan exception throwing otomatis pada PHP 8.1+ untuk kompatibilitas fungsi legacy mysql_*
if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_OFF);
}

$host = "localhost";
$user = "root";
$pass = "";
$database = "db_carwash";

$conn = mysql_connect($host, $user, $pass, $database);
mysql_select_db($database, $conn);
?>
