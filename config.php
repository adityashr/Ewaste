<?php
$conn = mysqli_connect("mysql", "root", "1234", "ewaste_new");
// $conn = mysqli_connect("mysql", "root", "1234", "ewaste_new");

// $conn = mysqli_connect("mysql", "root", "", "ewaste_new");
// $conn = mysqli_connect("mysql", "root", "", "ewaste_new");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>