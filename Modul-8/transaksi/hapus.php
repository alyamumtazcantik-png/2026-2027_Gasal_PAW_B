<?php
require_once '../cek_login.php';
include '../koneksi.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    die("ID transaksi tidak valid.");
}

mysqli_begin_transaction($koneksi);

try {

    $stmt = mysqli_prepare($koneksi,
        "SELECT id_barang, jumlah
         FROM transaksi_detail
         WHERE id_transaksi = ? FOR UPDATE"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $detail = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$detail) {
        throw new Exception("Transaksi tidak ditemukan.");
    }

    // Kembalikan stok barang
    $stmt = mysqli_prepare($koneksi,
        "UPDATE barang SET stok = stok + ?
         WHERE id_barang = ?"
    );

    mysqli_stmt_bind_param(
        $stmt, "ii",
        $detail['jumlah'],
        $detail['id_barang']
    );

    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi,
        "DELETE FROM transaksi_detail
         WHERE id_transaksi = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Hapus transaksi utama
    $stmt = mysqli_prepare($koneksi,
        "DELETE FROM transaksi
         WHERE id_transaksi = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_commit($koneksi);

    header("Location: index.php");
    exit;

} catch (Throwable $e) {

    mysqli_rollback($koneksi);

    die("Hapus gagal: " .
        htmlspecialchars($e->getMessage()));
}
?>
