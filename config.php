<?php
$servername = "localhost";
$username = "root"; // ganti sesuai user MySQL
$password = "";     // ganti sesuai password MySQL
$dbname = "toyota_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
