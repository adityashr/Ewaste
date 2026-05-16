<?php

$host = "sql3.freesqldatabase.com";
$user = "sql3827095";
$pass = "wDQTmSvWIK";   // 👈 tumne jo set kiya
$db   = "sql3827095";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}
?>
