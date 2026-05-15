<?php
$host = "sql204.infinityfree.com";
$user = "if0_41927419";
$pass = "aditya70177017";
$db   = "if0_41927419_XXX";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("DB Error: " . mysqli_connect_error());
}
?>
