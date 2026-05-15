<?php
$conn = mysqli_connect("mysql","root","1234","ewaste_new");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>