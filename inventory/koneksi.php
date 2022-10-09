<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

$conn = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    die("Gagal terhubung ke database" . mysqli_connect_error());
}
