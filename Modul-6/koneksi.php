<?php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_master_detail_baru"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
