<?php
require_once '../koneksi.php';
require_once '../cek_owner.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    die("ID supplier tidak valid.");
}

$stmt = mysqli_prepare($koneksi,
    "DELETE FROM supplier WHERE id_supplier = ?"
);

if (!$stmt) {
    die("Query gagal: " . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php");
    exit;
} else {
    die("Gagal menghapus supplier: " . mysqli_stmt_error($stmt));
}
?>
