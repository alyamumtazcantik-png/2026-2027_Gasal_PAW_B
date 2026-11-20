<?php
require_once '../cek_owner.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$stmt = mysqli_prepare($koneksi,
    "DELETE FROM barang WHERE kode_barang = ?"
);

mysqli_stmt_bind_param($stmt, "s", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php");
    exit;
}

echo "Gagal menghapus barang.";
?>
