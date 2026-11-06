<?php
include 'koneksi.php';

$kode = $_GET['kode'] ?? '';

$stmt = mysqli_prepare($conn,
    "SELECT COUNT(*) AS jumlah
     FROM transaksi_detail
     WHERE kode_barang = ?");

mysqli_stmt_bind_param($stmt, "s", $kode);
mysqli_stmt_execute($stmt);

$hasil = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($hasil['jumlah'] > 0) {
    echo "<script>
        alert('Barang masih digunakan dalam transaksi!');
        window.location='barang.php';
    </script>";
    exit;
}

$stmt = mysqli_prepare($conn,
    "DELETE FROM barang WHERE kode_barang = ?");

mysqli_stmt_bind_param($stmt, "s", $kode);
mysqli_stmt_execute($stmt);

header("Location: barang.php");
exit;
?>
